<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Gestor de Gastos</title>
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

    
</body>
</html>