<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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

        //clonamos la consulta de rango de fechas para no modificarla y calculamos gatos, ingresos y hacemos el balance
        $totalIncome = (clone $baseQuery)->where('type', 'income')->sum('amount');   
        $totalExpense = (clone $baseQuery)->where('type', 'expense')->sum('amount');//sum tambien ejecuta la consulta
        
        $netBalance = $totalIncome - $totalExpense;

        //clonamos la consulta y traemos las categorias en las que mas se gasto
        $topExpenses = (clone $baseQuery)->where('type', 'expense')
        ->with('category')
        ->orderByDesc('amount')
        ->take(5)
        ->get();

        //Gastos agrupados por categoría (ordenados de mayor a menor gasto)
        $expensesByCategory = (clone $baseQuery)
            ->where('type', 'expense')
            ->select('category_id', DB::raw('SUM(amount) as total'))//usamos el facade DB y el metodo raw de la clase real con el alias 'db'(DatabaseManager) guardada en el Service Container
            ->groupBy('category_id')
            ->with('category')
            ->orderByDesc('total')
            ->get();

        //Preparar arreglos simples para pasárselos al gráfico ya que Chart.js no sabe leer colecciones de PHP ni objetos anidados
        $chartLabels = $expensesByCategory->map(fn($item) => $item->category->name ?? 'Sin categoría');
        $chartData = $expensesByCategory->pluck('total');

        return view('dashboard', compact(
            'selectedMonth',
            'totalIncome',
            'totalExpense',
            'netBalance',
            'topExpenses',
            'expensesByCategory',
            'chartLabels',
            'chartData'
        ));





    }

}
