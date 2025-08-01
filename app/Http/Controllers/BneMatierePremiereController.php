<?php

namespace App\Http\Controllers;

use App\Models\BneMatierePremiereArticle;
use App\Models\BnsMatierePremiereArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BneMatierePremiereController extends Controller
{
    public function filterStats(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Fetch articles within the specified date range
        $articles = BnsMatierePremiereArticle::select(
                'categorie_id',
                'article_matiere_premiere_id',
                DB::raw('SUM(quantity) as total_quantity'),
                'unite'
            )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('categorie_id', 'article_matiere_premiere_id', 'unite')
            ->with(['categorie.parent', 'article']) // Ensure relationships are loaded
            ->get();

        // Filter COTTON consumption by category name
        $cottonConsumption = BnsMatierePremiereArticle::select(DB::raw('SUM(quantity) as total_quantity'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereHas('categorie', function ($query) {
                $query->where('name', 'COTTON'); // Adjust to the actual name in your database
            })
            ->value('total_quantity');

        // Filter POLYESTER PINCE consumption by category name
        $polyesterPinceConsumption = BnsMatierePremiereArticle::select(DB::raw('SUM(quantity) as total_quantity'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereHas('categorie', function ($query) {
                $query->where('name', 'POLYESTER PINCE'); // Adjust to the actual name in your database
            })
            ->value('total_quantity');

        // Get Total COTTON for the current and past months
        $currentMonthCotton = BnsMatierePremiereArticle::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->whereHas('categorie', function ($query) {
                $query->where('name', 'COTTON');
            })
            ->sum('quantity');

        $pastMonthCotton = BnsMatierePremiereArticle::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->whereHas('categorie', function ($query) {
                $query->where('name', 'COTTON');
            })
            ->sum('quantity');

        // Get Total POLYESTER PINCE for the current and past months
        $currentMonthPince = BnsMatierePremiereArticle::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->whereHas('categorie', function ($query) {
                $query->where('name', 'POLYESTER PINCE');
            })
            ->sum('quantity');

        $pastMonthPince = BnsMatierePremiereArticle::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->whereHas('categorie', function ($query) {
                $query->where('name', 'POLYESTER PINCE');
            })
            ->sum('quantity');

        return view('stats', compact(
            'articles',
            'startDate',
            'endDate',
            'cottonConsumption',
            'polyesterPinceConsumption',
            'currentMonthCotton',
            'pastMonthCotton',
            'currentMonthPince',
            'pastMonthPince'
        ));
    }
}
