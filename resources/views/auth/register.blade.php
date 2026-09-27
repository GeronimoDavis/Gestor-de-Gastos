<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Gestor de Gastos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

    <main class="login-card">
        <h2 class="register-title">Crear Cuenta</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

         <!-- Formulario -->
        <form action="{{ route('register') }}" method="POST" class="register-form">
            @csrf
            <div class="form-group">
                <label class="form-label" for="name">Nombre:</label><br>
                <input class="form-input" id="name" type="text" name="name" value="{{ old('name') }}" require>
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Email:</label><br>
                <input class="form-input" id="email" type="text" name="email" value="{{ old('email') }}" require>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Contraseña</label><br>
                <input class="form-input" id="password" type="password" name="password" require>
            </div>

            <div class="form-group">
                <label class="form-label" for="password_confirmation">Confirmar Contraseña:</label><br>
                <input class="form-input" id="password_confirmation" type="password" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn btn-primary">Registrar</button>
        </form>

        <p class="login-link">¿Ya tenés cuenta? <a href="{{ route('login') }}">Iniciá sesión</a></p>
    </main>
</body>
</html>