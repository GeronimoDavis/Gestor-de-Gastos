<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Gestor de Gastos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <!-- Cargamos Chart.js desde su CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <header class="main-header">
        <h1>Bienvenido, {{ Auth::user()->name }}</h1>
        <div class="header-top">
            <!-- 1. Barra Superior: Filtro por Mes y Navegación -->
            <h2>Dashboard Financiero</h2>

            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-logout">Desloguearse</button>
            </form>
        </div>
        
        <div class="header-controls">
            <form action="{{route('dashboard')}}" method="GET" class="filter-form">
                <label for="month">Filtrar por mes:</label>
                <input type="month" id="month" name="month" value="{{$selectedMonth}}" onchange="this.form.submit()"/>
            </form>

             <div class="actions-bar">
                <a href="{{route('transaction.index')}}" class="btn btn-primary">+ Nueva Transacción</a>
                <a href="{{route('categories.index')}}" class="btn btn-secondary">+ Nueva Categoría</a>
            </div>
        </div>
    </header>


    <section class="cards-container">

        <div class="cards-container">
            <div class="card card-income">
                <span class="card-title">Ingresos del Mes</span>
                <p class="card-value income">${{number_format($totalIncome, 2)}}</p>
            </div>

            <div class="card card-expense">
                <span class="card-title">Gastos del Mes</span>
                <p class="card-value expense">${{ number_format($totalExpense, 2) }}</p>
            </div>

            <div class="card card-balance">
                <span class="card-title">Balance Neto</span>
                <p class="card-value {{ $netBalance >= 0 ? 'positive' : 'negative' }}">
                    ${{ number_format($netBalance, 2) }}
                </p>
            </div>
        </div>
    </section>

    <section class="lists-container">
        <!-- Lista A: Top 5 Gastos Más Grandes -->
            <div class="list-card">
                <h3 class="list-title">Top 5 gastos mas Grandes</h3>
                @if($topExpenses->isEmpty())
                    <p class="empty-state">No hay gastos registrados en este mes.</p>
                @else
                    <ul class="data-list">
                        @foreach($topExpenses as $expense)
                        <li class="data-item">
                           <div class="item-info">
                                <span class="item-category">{{ $expense->category->name ?? 'Sin categoría' }}</span>
                                <small class="item-date">{{ $expense->transaction_date }}</small>
                            </div>
                            <span class="item-amount text-expense">
                                -${{ number_format($expense->amount, 2) }}
                            </span>
                        </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <!-- Lista B: Gastos Agrupados por Categoría -->
            <div class="list-card">
                <h3 class="list-title">Gastos por Categoría</h3>
                @if($expensesByCategory->isEmpty())
                    <p class="empty-state">No hay datos para mostrar.</p>
                @else
                    <ul class="data-list">
                        @foreach($expensesByCategory as $item)
                            <li class="data-item">
                                <span class="item-category">{{ $item->category->name ?? 'Sin categoría' }}</span>
                                <span class="item-amount">
                                    ${{ number_format($item->total, 2) }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
    </section>

    <section class="chart-section">
        <h3 class="list-title text-center">Distribucion de gastos</h3>
        @if($expensesByCategory->isEmpty())
            <p class="empty-state text-center">No hay datos suficientes para graficar este mes.</p>
        @else
            <div class="chart-container">
                <canvas id="expensesChart"></canvas>
            </div> <!--Imprime el elemento <canvas> funciona como un "pizarrón en blanco" donde JavaScript puede dibujar formas dinámicas-->
        @endif
    </section>
    
    <script>
        //trasformamos en arrays(json) JS nativos
        const chartLabels = JSON.parse('@json($chartLabels)');
        const chartData = JSON.parse('@json($chartData)');
        if (chartLabels.length > 0) {
            const ctx = document.getElementById('expensesChart').getContext('2d');//busca el canvas y activa el contexto de dibujo en 2 dimensiones
            new Chart(ctx, {
                type: 'doughnut',//tipo de grafico
                data: {
                    labels: chartLabels,// Nombres de las categorías
                    datasets: [{
                        label: 'Gasto Total ($)',// Montos numéricos: [1500, 450] (se vinculan por posición con 'labels')
                        data: chartData,
                        borderWidth: 1
                    }]
                },
                // OPCIONES DE DISEÑO Y COMPORTAMIENTO
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'// Muestra las referencias de colores (la leyenda) abajo del gráfico
                        }
                    }
                }
            });
        }
    </script>  
</body>
</html>