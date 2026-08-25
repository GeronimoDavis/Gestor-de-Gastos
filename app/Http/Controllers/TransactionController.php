<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request){
        //Obtenemos las transacciones del usuario logueado, cargando su categoría
        $transactions = $request->user()
            ->transactions()
            ->with('category')
            ->latest()
            ->get();

        //Necesitamos también sus categorías para llenar el <select> del formulario
        $categories = $request->user()->categories()->get();

        return view('transactions.index', compact('transactions', 'categories'));
    }
}
