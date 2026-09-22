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

    <hr>

    <div class="cards-container">
        <div class="card">
            <h3>Ingresos del mes</h3>
            <p class="card-value income">${{number_format($totalIncome, 2)}}</p>
        </div>

        <div class="card">
            <h3>Gastos del Mes</h3>
            <p class="card-value expense">${{ number_format($totalExpense, 2) }}</p>
        </div>

        <div class="card">
            <h3>Balance Neto</h3>
            <p class="card-value {{ $netBalance >= 0 ? 'positive' : 'negative' }}">
                ${{ number_format($netBalance, 2) }}
            </p>
        </div>
    </div>

    <hr>

    <div class="lista-container">
        <div class="list-column">
            <h3>Top 5 gastos mas Grandes</h3>
            @if($topExpenses->isEmpty())
                <p>No hay gastos registrados en este mes.</p>
            @else
                <ul>
                    @foreach($topExpenses as $expense)
                    <li>
                        <strong>${{ number_format($expense->amount, 2) }}</strong> - 
                        {{ $expense->category->name ?? 'Sin categoría' }}
                        <small>({{ $expense->transaction_date }})</small>
                    </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="list-column">
            <h3>Gastos por Categoría</h3>
            @if($expensesByCategory->isEmpty())
                <p>No hay datos para mostrar.</p>
            @else
                <ul>
                    @foreach($expensesByCategory as $item)
                        <li>
                            <strong>{{ $item->category->name ?? 'Sin categoría' }}:</strong> 
                            ${{ number_format($item->total, 2) }}
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <hr>

    <div class="chart-container">
        <h3 class="chart-title">Distribucion de gastos</h3>
        @if($expensesByCategory->isEmpty())
            <p class="no-data-text">No hay datos suficientes para graficar este mes.</p>
        @else
            <canvas id="expensesChart"></canvas> <!--Imprime el elemento <canvas> funciona como un "pizarrón en blanco" donde JavaScript puede dibujar formas dinámicas-->
        @endif
    </div>
    
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