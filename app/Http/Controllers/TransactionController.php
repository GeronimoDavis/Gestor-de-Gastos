<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index(Request $request){
        //Obtenemos las transacciones del usuario logueado, cargando su categoría buscando en el modelos de transacctions 
        //el metodo llamado exactamente 'category' con with y mete en el objeto transacciones el objeto categoria
        $transactions = $request->user()
            ->transactions()
            ->with('category')
            ->latest()
            ->get();

        //Necesitamos también sus categorías para llenar el <select> del formulario
        $categories = $request->user()->categories()->get();

        return view('transactions.index', compact('transactions', 'categories'));
    }

    public function store(Request $request){
        
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|gt:0',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string|max:250',
            'type' => 'required|in:expense,income',
        ]);

        $request->user()->transactions()->create($validated);

        return back()->with('success', 'Transaccion creada con éxito.');
    }

    public function destroy(Request $request, Transaction $transaction){
        if($transaction->user_id !== $request->user()->id){
            abort(403);
        }

        $transaction->delete();

        return back()->with('success', 'Transacción eliminada.');
    }
}
