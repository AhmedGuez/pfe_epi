<?php

namespace App\Http\Controllers\Stat;

use App\Http\Controllers\Controller;
use App\Models\BneMatierePremiere;
use App\Models\BneMatierePremiereArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RawMaterialStatsController extends Controller
{
    public function factoryQuantity(Request $request)
    {
        // Get the date filters from the request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Query to get article quantities by category within the date range
        $articleQuantitiesByCategory = BneMatierePremiereArticle::join('bne_matiere_premieres', 'bne_matiere_premiere_articles.bne_matiere_premiere_id', '=', 'bne_matiere_premieres.id')
            ->join('categories', 'bne_matiere_premiere_articles.categorie_id', '=', 'categories.id')
            ->select('categories.name as category', 'bne_matiere_premiere_articles.code_article', DB::raw('SUM(bne_matiere_premiere_articles.quantity) as total_quantity'))
            ->when($startDate, function ($query, $startDate) {
                return $query->whereDate('bne_matiere_premieres.creation_date', '>=', $startDate);
            })
            ->when($endDate, function ($query, $endDate) {
                return $query->whereDate('bne_matiere_premieres.creation_date', '<=', $endDate);
            })
            ->groupBy('categories.name', 'bne_matiere_premiere_articles.code_article')
            ->get();

        return view('raw_materials.factory_quantity', compact( 'articleQuantitiesByCategory', 'startDate', 'endDate'));
    }


    
}
