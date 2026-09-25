<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión - Gestor de Gastos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    @if ($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <h2 >Iniciar Sesión</h2>

    <section class="login-container">
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="login-form">
                <div>
                    <label class="form-label">Email:</label><br>
                    <input class="form-input" type="email" name="email" value="{{ old('email') }}" required>
                </div>
                <br>
                <div>
                    <label class="form-label">Contraseña:</label><br>
                    <input class="form-input" type="password" name="password" required>
                </div>
                <br>
                <div>
                    <label>
                        <input class="form-checkbox" type="checkbox" name="remember"> Recordarme
                    </label>
                </div>
                <br>
                <button class="btn btn-primary" type="submit">Ingresar</button>
            </div>
        </form>
    </section>
    <p>¿No tenés cuenta? <a href="{{ route('register') }}">Registrate acá</a></p>

</body>
</html>