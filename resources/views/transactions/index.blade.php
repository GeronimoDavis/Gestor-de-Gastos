<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transacciones - Gestor de Gastos</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="page-container">
        <header class="page-header">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">← Volver al Dashboard</a>
            <h1 class="page-title">Gestor de Gastos - Transacciones</h1>
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
            <h3 class="section-title">Registrar Transacción</h3>
            <form action="{{ route('transaction.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-2 gap-md">
                    <div class="form-group">
                        <label for="category_id" class="form-label">Categoría</label>
                        <select id="category_id" name="category_id" class="form-select" required>
                            <option value="">Selecciona una categoría</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="amount" class="form-label">Monto ($)</label>
                        <input type="number" id="amount" name="amount" step="0.01" placeholder="0.00" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label for="transaction_date" class="form-label">Fecha</label>
                        <input type="date" id="transaction_date" name="transaction_date" value="{{ date('Y-m-d') }}" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label for="type" class="form-label">Tipo</label>
                        <select id="type" name="type" class="form-select" required>
                            <option value="expense">Gasto</option>
                            <option value="income">Ingreso</option>
                        </select>
                    </div>

                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label for="description" class="form-label">Descripción</label>
                        <input type="text" id="description" name="description" placeholder="Ej: Compras del mes" class="form-input">
                    </div>
                </div>

                <div class="flex justify-end mt-md">
                    <button type="submit" class="btn btn-primary">Guardar Transacción</button>
                </div>
            </form>
        </section>

        <section class="card">
            <h3 class="section-title">Mis Transacciones</h3>

            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Categoría</th>
                            <th>Monto</th>
                            <th>Tipo</th>
                            <th>Descripción</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->category->name }}</td>
                                <td class="font-bold">${{ number_format($transaction->amount, 2) }}</td>
                                <td>
                                    @if ($transaction->type === 'expense')
                                        <span class="badge badge-danger">Gasto</span>
                                    @else
                                        <span class="badge badge-success">Ingreso</span>
                                    @endif
                                </td>
                                <td>{{ $transaction->description ?? '-' }}</td>
                                <td>{{ $transaction->transaction_date }}</td>
                                <td>
                                    <form action="{{ route('transaction.destroy', $transaction) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete" onclick="return confirm('¿Seguro que querés eliminarla?')">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No hay transacciones registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</body>
</html>
