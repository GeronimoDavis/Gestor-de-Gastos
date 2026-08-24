<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Categorías - Gestor de Gastos</title>
</head>
<body>

    <p><a href="{{ route('dashboard') }}">← Volver al Dashboard<</a></p>
    <h1>Mis Categorías</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if($errors->eny())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <!-- Formulario de alta -->
    <h3>Nueva Categoría</h3>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div>
            <label>Nombre:</label>
            <input type="text" name="name" placeholder="Ej: Supermercado" required>
        </div>
        <br>
        <div>
            <label>Tipo:</label>
            <select name="type" required>
                <option value="expense">Gasto</option>
                <option value="income">Ingreso</option>
            </select>
        </div>
        <br>
        <button type="submit">Guardar Categoría</button>
    </form>

    <hr>

    <!-- Listado de categorías -->
     <h3>Listado</h3>
    @if ($categories->isEmpty())
        <p>No tenés categorías creadas todavía.</p>
    @else

    <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>
                            @if ($category->type === 'expense')
                                <span style="color: red;">Gasto</span>
                            @else
                                <span style="color: green;">Ingreso</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('¿Seguro que querés eliminarla?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</body>
</html>