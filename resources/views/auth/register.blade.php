<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Gestor de Gastos</title>
</head>
<body>
    <h2>Crear Cuenta</h2>

    @if ($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div>
            <label>Nombre:</label><br>
            <input type="text" name="name" value="{{ old('name') }}" require>
        </div>
        <br>
        <div>
            <label>Email:</label><br>
            <input type="text" name="email" value="{{ old('email') }}" require>
        </div>
        <br>
        <div>
            <label>Contraseña</label><br>
            <input type="password" name="password" require>
        </div>
        <br>
        <div>
            <label>Confirmar Contraseña:</label><br>
            <input type="password" name="password_confirmation" required>
        </div>
        <br>
        <button type="submit">Registrar</button>
    </form>

    <p>¿Ya tenés cuenta? <a href="{{ route('login') }}">Iniciá sesión</a></p>
</body>
</html>