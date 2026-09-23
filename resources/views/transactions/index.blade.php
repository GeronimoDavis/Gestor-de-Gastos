<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transacciones - Gestor de Gastos</title>
    <link rel="stylesheet" href="{{ asset('css/transactions.css') }}">
</head>
<body>  

<div class="page-header">
    <!--Encabezado de Página -->
    <header class="page-header">
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">← Volver al Dashboard</a>
        <h1>Gestor de Gastos - Transacciones</h1>
    </header>
   
    <!-- Alertas de Estado -->
    @if (session('success'))
       <div class="alert alert-success">
                {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

   <!-- Formulario para Crear Transacciones -->
    <section class="card-section">

        <h3 class="section-title">Registrar Transacción</h3>
        <form action="{{route('transaction.store')}}" method="POST">
            @csrf

            <div class="form-grid">
                <div class="form-group">
                    <label for="category_id">Categoría:</label>
                    <select id="category_id" name="category_id" class="form-control" required>
                        <option value="">Selecciona una categoria</option>
                        @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="amount">Monto ($):</label>
                    <input type="number" id="amount" name="amount" step="0.01" placeholder="0.00" class="form-control" required />
                </div>

                <div class="form-group">
                    <label for="transaction_date">Fecha:</label>
                    <input type="date" id="transaction_date" name="transaction_date" value="{{ date('Y-m-d') }}" class="form-control" required />
                </div>

                <div class="form-group">
                   <label for="type">Tipo:</label>
                    <select id="type" name="type" class="form-control" required>
                        <option value="expense">Gasto</option>
                        <option value="income">Ingreso</option>
                    </select>
                </div>

                <div class="form-group full-width">
                    <label for="description">Descripción:</label>
                    <input type="text" id="description" name="description" placeholder="Ej: Compras del mes" class="form-control" />
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Guardar Transacción</button>
            </div>
        </form>
    </section>

     <!-- 4. Tabla de Transacciones -->
    <section class="table-section">
        <h1 class="section-title">Mis Transacciones</h1>

        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Categoria</th>
                        <th>Monto</th>
                        <th>Tipo</th>
                        <th>Descripcion</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->category->name }}</td>
                        <td class="amount-cell">${{ number_format($transaction->amount, 2) }}</td>
                        <td>
                            @if ($transaction->type === 'expense')
                                <span class="badge badge-expense">Gasto</span>
                            @else
                                <span class="badge badge-income">Ingreso</span>
                            @endif   
                        </td>
                        <td>{{ $transaction->description ?? '-' }}</td>
                        <td>{{ $transaction->transaction_date }}</td>
                        <td>
                            <form action="{{ route('transaction.destroy', $transaction) }}" method="POST" class="inline-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete" onclick="return confirm('¿Seguro que querés eliminarla?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

</div>

</body>
</html>