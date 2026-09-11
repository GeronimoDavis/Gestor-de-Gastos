<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Gestor de Gastos</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <!-- Cargamos Chart.js desde su CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    
    <!-- 1. Barra Superior: Filtro por Mes y Navegación -->
    <h2>Dashboard Financiero</h2>

    <from action="{{route('dashboard')}}" method="GET">
        <label for="month">Filtrar por mes:</label>
        <input type="month" id="month" name="month" value="{{$selectedMonth}}" onchange="this.form.submit()"/>
    </from>

    <hr>

    <div>
        <a href="{{route('transaction.index')}}"><button>+ Nueva Transacción</button></a>
        <a href="{{route('categories.index')}}"><button>+ Nueva Categoría</button></a>
    </div>

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

    

</body>
</html>