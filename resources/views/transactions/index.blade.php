<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Transacciones - Gestor de Gastos</title>
</head>
<body>  

 <a href="{{ route('dashboard') }}"><button>← Volver al Dashboard</button></a>
    <h1>Registrar Transacciones</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <!--Formulario para crear transacciones -->

    <form action="{{route('transaction.store')}}" method="POST">
        @csrf
        <div>
            <label>Categoria:</label>
            <select name="category_id" required>
                <option value="">Selecciona una categoria</option>
                @foreach ($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
        </div>
        <br>
        <div>
            <label>Monto</label>
            <input type="number" name="amount" />
        </div>
        <br>
        <div>
            <label>Fecha:</label>
            <input type="date" name="transaction_date" value="{{ date('Y-m-d') }}" required />
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
        <div>
            <label>Descripcion</label>
            <input type="text" name="description" placeholder="Ej: Compras del mes"/>
        </div>
        <br>
        <button type="submit">Guardar transaccion</button>
    </form>
    <br>

     <!--Ver transacciones -->
    <h1>Mis Transacciones</h1>
     <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>Categoria</th>
            <th>Monto</th>
            <th>Tipo</th>
            <th>Descripcion</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
     <tbody>
        @foreach ($transactions as $transaction)
            <td>{{ $transaction->category->name }}</td>
            <td>{{ $transaction->amount }}</td>
            <td>
                @if ($transaction->type === 'expense')
                    <span style="color: red;">Gasto</span>
                @else
                    <span style="color: green;">Ingreso</span>
                @endif   
            </td>
            <td>{{$transaction->description}}</td>
            <td>{{$transaction->transaction_date}}</td>
             <td>
                <form action="{{ route('transaction.destroy', $transaction) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('¿Seguro que querés eliminarla?')">Eliminar</button>
                </form>
            </td>
        @endforeach
     </tbody>
</table>

</body>
</html>