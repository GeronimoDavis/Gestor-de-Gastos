<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Transacciones - Gestor de Gastos</title>
</head>
<body>  

 <p><a href="{{ route('dashboard') }}">← Volver al Dashboard<</a></p>
    <h1>Mis Transacciones</h1>

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


</body>
</html>