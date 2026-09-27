<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Categorías - Gestor de Gastos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/transactions.css') }}">
</head>
<body>

    <!--Encabezado de Página -->
    <header class="page-header">
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">← Volver al Dashboard</a>
        <h1>Mis Categorías</h1>
    </header>


    @if (session('success'))
        <p class="alert alert-success">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger"> 
            <ul style="color: red;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="card-section">
        <!-- Formulario de alta -->
        <h3 class="section-title">Nueva Categoría</h3>

        <form action="{{ route('categories.store') }}" method="POST">
            @csrf

            <div class="form-grid">
                <div class="form-group">
                    <label for="name">Nombre:</label>
                    <input class="form-control" id="name" type="text" name="name" placeholder="Ej: Supermercado" required>
                </div>
                
                <div class="form-group">
                    <label for="type">Tipo:</label>
                    <select class="form-control" id="type" name="type" required>
                        <option value="expense">Gasto</option>
                        <option value="income">Ingreso</option>
                    </select>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Guardar Categoría</button>
            </div>
        </form>
    </section>


    <!-- Listado de categorías -->

    <section class="table-section">
        <h3 class="section-title">Listado de categorias</h3>
        @if ($categories->isEmpty())
            <p>No tenés categorías creadas todavía.</p>
        @else

        <div class="table-container">
            <table class="data-table">
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
                                    <span class="badge badge-expense">Gasto</span>
                                @else
                                    <span class="badge badge-income">Ingreso</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline;" class="inline-form">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-delete" type="submit" onclick="return confirm('¿Seguro que querés eliminarla?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </section>

</body>
</html>