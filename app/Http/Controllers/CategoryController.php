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
}
