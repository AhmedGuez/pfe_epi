<?php

namespace App\Http\Controllers\Stat;

use App\Http\Controllers\Controller;
use App\Models\StockMatierePremiere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockStatsController extends Controller
{
    public function quantityOverTime(Request $request)
    {
        // Get start and end dates from the request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Query to get the total quantity of raw materials by date with optional date filters
        $query = StockMatierePremiere::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date', 'asc');

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        $quantityOverTime = $query->get();

        return view('raw_materials.quantity_over_time', compact('quantityOverTime', 'startDate', 'endDate'));
    }
}
