<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request){
        //obtenemos el mes seleccionado del request o usar el mes actual por defecto (Año-mes)
        $selectedMonth = $request->input('month', now()->format('Y-m'));

        // Definir la fecha de inicio y fin del mes elegido y lo convierte en una instancia de la clase Carbon
        //ademas de concatenamos "-01" para formar una fecha completa válida
        $startDate = Carbon::parse($selectedMonth . '-01')->startOfMonth();//Ajusta la fecha al primer segundo del mes
        $endDate  = Carbon::parse($selectedMonth . '-01')->endOfMonth();//Ajusta la fecha al primer segundo del mes y resuelve si el mes tiene 28, 30 o 31 días
        
        //traemos al usuario logeado
        $user = $request->user();

        //hacemos pero no ejecutamos(->get()) la query para filtrar transacciones del usuario por el rango del mes
        $baseQuery = $user->transactions()
            ->whereBetween('transaction_date', [$startDate,$endDate]);



    }

}
