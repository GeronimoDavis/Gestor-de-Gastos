<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Gestor de Gastos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="page-container">
        @if (session('success'))
            <div class="alert alert-success animate-slide-in">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger animate-slide-in">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <header class="dashboard-header animate-fade-in">
            <div class="flex justify-between items-center flex-wrap gap-md">
                <div>
                    <h1 class="dashboard-title">Bienvenido, {{ Auth::user()->name }}</h1>
                    <p class="dashboard-subtitle">Dashboard Financiero</p>
                </div>
                <div class="flex gap-sm items-center">
                    <button id="theme-toggle" class="btn btn-secondary" type="button" aria-label="Cambiar tema">
                        <span id="theme-icon">🌙</span>
                    </button>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-logout">Desloguearse</button>
                    </form>
                </div>
            </div>

            <div class="flex justify-between items-center flex-wrap gap-md mt-lg" style="border-top: 1px solid var(--color-border); padding-top: var(--space-lg);">
                <form action="{{ route('dashboard') }}" method="GET" class="flex items-center gap-sm">
                    <label for="month" class="form-label mb-0">Filtrar por mes:</label>
                    <input class="form-input" type="month" id="month" name="month" value="{{ $selectedMonth }}" onchange="this.form.submit()" style="width: auto;">
                </form>

                <div class="flex gap-sm">
                    <a href="{{ route('transaction.index') }}" class="btn btn-primary">+ Nueva Transacción</a>
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary">+ Nueva Categoría</a>
                </div>
            </div>
        </header>

        <section class="stats-grid">
            <div class="stat-card stat-card-success">
                <div class="stat-label">Ingresos del Mes</div>
                <div class="stat-value text-success">${{ number_format($totalIncome, 2) }}</div>
            </div>

            <div class="stat-card stat-card-danger">
                <div class="stat-label">Gastos del Mes</div>
                <div class="stat-value text-danger">${{ number_format($totalExpense, 2) }}</div>
            </div>

            <div class="stat-card stat-card-primary">
                <div class="stat-label">Balance Neto</div>
                <div class="stat-value {{ $netBalance >= 0 ? 'text-success' : 'text-danger' }}">
                    ${{ number_format($netBalance, 2) }}
                </div>
            </div>
        </section>

        <section class="grid grid-cols-2 mb-lg">
            <div class="card">
                <h3 class="section-title">Top 5 Gastos Más Grandes</h3>
                @if($topExpenses->isEmpty())
                    <p class="text-muted">No hay gastos registrados en este mes.</p>
                @else
                    <ul class="data-list">
                        @foreach($topExpenses as $expense)
                            <li class="data-item">
                                <div>
                                    <span class="font-semibold">{{ $expense->category->name ?? 'Sin categoría' }}</span>
                                    <small class="text-muted">{{ $expense->transaction_date }}</small>
                                </div>
                                <span class="font-bold text-danger">
                                    -${{ number_format($expense->amount, 2) }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div class="card">
                <h3 class="section-title">Gastos por Categoría</h3>
                @if($expensesByCategory->isEmpty())
                    <p class="text-muted">No hay datos para mostrar.</p>
                @else
                    <ul class="data-list">
                        @foreach($expensesByCategory as $item)
                            <li class="data-item">
                                <span>{{ $item->category->name ?? 'Sin categoría' }}</span>
                                <span class="font-bold">
                                    ${{ number_format($item->total, 2) }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </section>

        <section class="card">
            <h3 class="section-title text-center">Distribución de Gastos</h3>
            @if($expensesByCategory->isEmpty())
                <p class="text-muted text-center">No hay datos suficientes para graficar este mes.</p>
            @else
                <div class="chart-container">
                    <canvas id="expensesChart"></canvas>
                </div>
            @endif
        </section>
    </div>

    <script>
        // Toggle de tema oscuro/claro
        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const html = document.documentElement;

        // Cargar tema guardado
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            html.classList.remove('light', 'dark');
            html.classList.add(savedTheme);
            updateThemeIcon(savedTheme);
        }

        themeToggle.addEventListener('click', () => {
            const isDark = html.classList.toggle('dark');
            const isLight = html.classList.toggle('light');

            // Si no hay ninguna clase, usar preferencia del sistema
            if (!isDark && !isLight) {
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                html.classList.add(prefersDark ? 'dark' : 'light');
            }

            const currentTheme = html.classList.contains('dark') ? 'dark' : 'light';
            localStorage.setItem('theme', currentTheme);
            updateThemeIcon(currentTheme);
        });

        function updateThemeIcon(theme) {
            themeIcon.textContent = theme === 'dark' ? '☀️' : '🌙';
        }

        // Gráfico
        const chartLabels = JSON.parse('@json($chartLabels)');
        const chartData = JSON.parse('@json($chartData)');
        if (chartLabels.length > 0) {
            const ctx = document.getElementById('expensesChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Gasto Total ($)',
                        data: chartData,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }
    </script>
</body>
</html>
