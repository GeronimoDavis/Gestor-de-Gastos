<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //mostrar lisat de categorias del usuario
    public function index(Request $request){
        //user es un metodo de request el cual busca en la session el id del user y 
        //hace una subconsulta para traer los datos del usuario con el que crea una instancia de User y la devuelve para poder usar categories()
        $categories = $request->user()->categories()->latest()->get();

        return view('categories.index', compact('categories'));
    }

    // Guardar una nueva categoría
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'type' => 'required|in:expense,income',
        ]);

        // Guardamos asociando automáticamente al usuario autenticado
        $request->user()->categories()->create($validated);

        return back()->with('success', 'Categoría creada con éxito.');
    }
}
