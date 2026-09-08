<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Gestor de Gastos</title>
    <!-- Cargamos Chart.js desde su CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        .flex-container { display: flex; gap: 20px; margin-top: 20px; }
        .card { border: 1px solid #ccc; padding: 15px; border-radius: 8px; flex: 1; }
        .net-positive { color: green; }
        .net-negative { color: red; }
    </style>
</head>
<body>
    <h1>Bienvenido, {{ Auth::user()->name }}!</h1>
    <p>Has iniciado sesión correctamente.</p>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Cerrar Sesión</button>
    </form>
    <br>
    <a href="{{route('transaction.index')}}"><button>Registrar una Transaccion</button></a>
</body>
</html>