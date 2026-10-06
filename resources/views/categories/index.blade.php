<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Categorías - Gestor de Gastos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="page-container">
        <header class="page-header">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">← Volver al Dashboard</a>
            <h1 class="page-title">Mis Categorías</h1>
        </header>

        @if (session('success'))
            <div class="alert alert-success animate-slide-in">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger animate-slide-in">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="card mb-lg">
            <h3 class="section-title">Nueva Categoría</h3>

            <form action="{{ route('categories.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-2 gap-md">
                    <div class="form-group">
                        <label for="name" class="form-label">Nombre</label>
                        <input class="form-input" id="name" type="text" name="name" placeholder="Ej: Supermercado" required>
                    </div>

                    <div class="form-group">
                        <label for="type" class="form-label">Tipo</label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="expense">Gasto</option>
                            <option value="income">Ingreso</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end mt-md">
                    <button type="submit" class="btn btn-primary">Guardar Categoría</button>
                </div>
            </form>
        </section>

        <section class="card">
            <h3 class="section-title">Listado de Categorías</h3>

            @if ($categories->isEmpty())
                <p class="text-muted">No tenés categorías creadas todavía.</p>
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
                                            <span class="badge badge-danger">Gasto</span>
                                        @else
                                            <span class="badge badge-success">Ingreso</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline;">
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
    </div>
</body>
</html>
