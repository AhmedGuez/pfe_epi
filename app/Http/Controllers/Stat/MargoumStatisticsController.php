<?php

namespace App\Http\Controllers\Stat;

use App\Http\Controllers\Controller;
use App\Models\BnsMargoum;
use App\Models\BnsMargoumArticle;
use App\Models\Commande;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MargoumStatisticsController extends Controller
{
//     public function index()
//     {
//         // Retrieve data for the bar chart
//         $data = BnsMargoum::all()->pluck('nombre_de_rouleaux', 'id');

//         // Prepare data for Chart.js
//         $labels = $data->keys()->toJson();
//         $values = $data->values()->toJson();

//         return view('raw_materials.margoum_statistics', compact('labels', 'values'));
//     }

public function ordersOverTime(Request $request)
{
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    $query = Commande::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total_orders'))
        ->groupBy('date')
        ->orderBy('date');

    if ($startDate) {
        $query->whereDate('created_at', '>=', $startDate);
    }

    if ($endDate) {
        $query->whereDate('created_at', '<=', $endDate);
    }

    $ordersOverTime = $query->get();

    // Prepare data for chart
    $dates = [];
    $orderCounts = [];

    foreach ($ordersOverTime as $order) {
        $dates[] = $order->date;
        $orderCounts[] = $order->total_orders;
    }

    return view('raw_materials.margoum_statistics', compact('dates', 'orderCounts', 'startDate', 'endDate'));
}
}