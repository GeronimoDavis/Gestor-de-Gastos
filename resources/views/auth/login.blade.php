<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión - Gestor de Gastos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

    <main class="login-card">

        <h2 class="login-title">Iniciar Sesión</h2>

        <!-- Alertas de Error -->
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
        <form action="{{ route('login') }}" method="POST" class="login-form">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">Email:</label>
                <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required placeholder="tuemail@ejemplo.com">
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Contraseña:</label>
                <input id="password" class="form-input" type="password" name="password" required>
            </div>

            <div class="form-group form-remember">
                <label class="checkbox-label">
                    <input class="form-checkbox" type="checkbox" name="remember">
                    <span>Recordarme</span>
                </label>
            </div>

            <button class="btn btn-primary" type="submit">Ingresar</button>
        </form>

        <p class="register-link">
            ¿No tenés cuenta? <a href="{{ route('register') }}">Registrate acá</a>
        </p>
    </main>
</body>
</html>