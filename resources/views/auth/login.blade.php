<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión - Gestor de Gastos</title>
</head>
<body>
    <h2>Iniciar Sesión</h2>

    @if ($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div>
            <label>Email:</label><br>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>
        <br>
        <div>
            <label>Contraseña:</label><br>
            <input type="password" name="password" required>
        </div>
        <br>
        <div>
            <label>
                <input type="checkbox" name="remember"> Recordarme
            </label>
        </div>
        <br>
        <button type="submit">Ingresar</button>
    </form>
    <p>¿No tenés cuenta? <a href="{{ route('register') }}">Registrate acá</a></p>

</body>
</html>