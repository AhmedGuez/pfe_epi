<?php

namespace App\Http\Controllers\Stat;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuiviStockRebobinageStatsController extends Controller
{
    public function showStats(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::today()->subWeek()->toDateString());
        $endDate = $request->input('end_date', Carbon::today()->toDateString());

        $sections = $this->getSectionsByQuantity($startDate, $endDate);

        // Best Section of the Day
        $bestSectionOfTheDay = $sections->first();
    
        // Other sections
        $otherSections = $sections->slice(1);

        // Best Section of the Day
        $bestSectionOfTheDay = $this->getBestSectionOfTheDay($startDate, $endDate);

        // Best Ouvrier of the Month
        $bestOuvrierOfTheMonth = $this->getBestOuvrierOfTheMonth($startDate, $endDate);

        // Most Frequent Article Code
        $mostFrequentArticleCode = $this->getMostFrequentArticleCode($startDate, $endDate);

        return view('raw_materials.suivi_stock_rebobinage_stats', compact('bestSectionOfTheDay', 'otherSections', 'bestOuvrierOfTheMonth', 'mostFrequentArticleCode'));
    }

    private function getSectionsByQuantity($startDate, $endDate)
{
    return DB::table('suivi_stock_rebobinages')
        ->join('suivi_stock_rebobinage_articles', 'suivi_stock_rebobinages.id', '=', 'suivi_stock_rebobinage_articles.suivi_stock_rebobinage_id')
        ->select('suivi_stock_rebobinages.section', DB::raw('SUM(suivi_stock_rebobinage_articles.quantity) as total_quantity'))
        ->whereBetween('suivi_stock_rebobinages.creation_date', [$startDate, $endDate])
        ->groupBy('suivi_stock_rebobinages.section')
        ->orderByDesc('total_quantity')
        ->get();
}

    private function getBestSectionOfTheDay($startDate, $endDate)
    {
        return DB::table('suivi_stock_rebobinages')
            ->join('suivi_stock_rebobinage_articles', 'suivi_stock_rebobinages.id', '=', 'suivi_stock_rebobinage_articles.suivi_stock_rebobinage_id')
            ->select('suivi_stock_rebobinages.section', DB::raw('SUM(suivi_stock_rebobinage_articles.quantity) as total_quantity'))
            ->whereBetween('suivi_stock_rebobinages.creation_date', [$startDate, $endDate])
            ->groupBy('suivi_stock_rebobinages.section')
            ->orderByDesc('total_quantity')
            ->first();
    }

    private function getBestOuvrierOfTheMonth($startDate, $endDate)
    {
        return DB::table('suivi_stock_rebobinages')
            ->join('suivi_stock_rebobinage_articles', 'suivi_stock_rebobinages.id', '=', 'suivi_stock_rebobinage_articles.suivi_stock_rebobinage_id')
            ->select('suivi_stock_rebobinages.ouvrier', DB::raw('SUM(suivi_stock_rebobinage_articles.quantity) as total_quantity'))
            ->whereBetween('suivi_stock_rebobinages.creation_date', [$startDate, $endDate])
            ->groupBy('suivi_stock_rebobinages.ouvrier')
            ->orderByDesc('total_quantity')
            ->first();
    }

    private function getMostFrequentArticleCode($startDate, $endDate)
    {
        return DB::table('suivi_stock_rebobinage_articles')
            ->join('suivi_stock_rebobinages', 'suivi_stock_rebobinages.id', '=', 'suivi_stock_rebobinage_articles.suivi_stock_rebobinage_id')
            ->select('suivi_stock_rebobinage_articles.article_matiere_premiere_id', DB::raw('SUM(suivi_stock_rebobinage_articles.quantity) as total_quantity'))
            ->whereBetween('suivi_stock_rebobinages.creation_date', [$startDate, $endDate])
            ->groupBy('suivi_stock_rebobinage_articles.article_matiere_premiere_id')
            ->orderByDesc('total_quantity')
            ->first();
    }
    
}
