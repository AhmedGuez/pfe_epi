<?php

namespace App\Http\Controllers;

use App\Models\BnsMatierePremiereArticle;
use App\Models\Category;
use App\Models\CommandeArticle;
use App\Models\StockMargoum;
use App\Models\StockMargoumArticle;
use App\Models\StockMatierePremiere;
use Illuminate\Http\Request;

class StockController extends Controller
{
    // public function stock(Request $request) {
    //     // Initialize the query
    //     $stocksQuery = StockMatierePremiere::with('categorie');

    //     // Apply category filter if provided
    //     if ($request->has('category_id') && $request->category_id != '') {
    //         $stocksQuery->where('categorie_id', $request->category_id);  // Use the correct column name here
    //     }

    //     // Execute the query to get the stocks
    //     $stocks = $stocksQuery->get();

    //     // Get all categories
    //     $categories = Category::all();

    //     // Get the current date
    //     $date = date('Y-m-d');

    //     // Return the view with the stocks data
    //     return view('stockActuel', compact('stocks', 'date', 'categories'));
    // }

    public function Stock()
    {
        // Fetch stocks with related data
        $stocks = StockMatierePremiere::with(['article.category.parent.parent', 'category.parent'])->get();
        
        // Filter Margoum stocks
        $margoumStocks = $stocks->filter(function ($item) {
            $category = $item->category;
            return $category->name == 'MARGOUM' || 
                   ($category->parent && $category->parent->name == 'MARGOUM') || 
                   ($category->parent && $category->parent->parent && $category->parent->parent->name == 'MARGOUM');
        });
    
        // Group stocks hierarchically
        $groupedStocks = $this->groupStocks($margoumStocks);
        
        // Calculate consumption metrics
        $consumptionMetrics = $this->calculateConsumptionMetrics();
        
        // Calculate stock status
        $stockStatus = $this->calculateStockStatus($groupedStocks, $consumptionMetrics);
        
        return view('stockActuel', array_merge([
            'groupedStocks' => $groupedStocks,
            'date' => now()->format('Y-m-d')
        ], $consumptionMetrics, $stockStatus));
    }
    
    private function groupStocks($stocks)
    {
        return $stocks->groupBy(function ($item) {
            $category = $item->category;
            if ($category->parent && $category->parent->parent) {
                return $category->parent->parent->name;
            }
            return $category->parent ? $category->parent->name : 'N/A';
        })->map(function ($group) {
            return $group->groupBy(function ($item) {
                return $item->category->parent ? $item->category->parent->name : $item->category->name;
            })->map(function ($subGroup) {
                return $subGroup->groupBy('category.name');
            });
        });
    }

    private function calculateConsumptionMetrics(string $estimationMode = 'weighted')
{
    $metrics = [
        'daily' => [],
        'weekly' => [],
        'monthly' => [],
        'averages' => [],        // weighted or daily depending on mode
        'rawAverages' => [],     // keep real weighted avg in case needed
    ];

    $categories = ['COTTON', 'POLYESTER PINCE'];

    foreach ($categories as $categoryName) {
        $category = Category::where('name', $categoryName)->first();
        if (!$category) continue;

        $categoryId = $category->id;

        // --- Accurate Daily (7 jours)
        $dailyData = BnsMatierePremiereArticle::where('categorie_id', $categoryId)
            ->whereHas('bnsMatierePremiere', function ($q) {
                $q->where('creation_date', '>=', now()->subDays(7));
            })
            ->join('bns_matiere_premieres', 'bns_matiere_premiere_articles.bns_matiere_premiere_id', '=', 'bns_matiere_premieres.id')
            ->selectRaw('DATE(bns_matiere_premieres.creation_date) as date, SUM(quantity) as total')
            ->groupBy('date')
            ->get();

        $dailyTotal = $dailyData->sum('total');
        $daysCount = max($dailyData->count(), 1); // Avoid division by zero
        $daily = $dailyTotal / $daysCount;

        // --- Weekly (28 jours)
        $weeklyTotal = BnsMatierePremiereArticle::where('categorie_id', $categoryId)
            ->whereHas('bnsMatierePremiere', fn($q) => $q->where('creation_date', '>=', now()->subWeeks(4)))
            ->sum('quantity');
        $weekly = $weeklyTotal / 28;

        // --- Monthly (3 mois = ~90 jours)
        $monthlyTotal = BnsMatierePremiereArticle::where('categorie_id', $categoryId)
            ->whereHas('bnsMatierePremiere', fn($q) => $q->where('creation_date', '>=', now()->subMonths(3)))
            ->sum('quantity');
        $monthly = $monthlyTotal / 90;

        // Weighted average: 50% recent, 30% mid, 20% long-term
        $weightedAvg = ($daily * 0.5) + ($weekly * 0.3) + ($monthly * 0.2);

        // Choose which avg to use for estimation
        $finalAvg = $estimationMode === 'daily' ? $daily : $weightedAvg;

        $metrics['daily'][$categoryName] = round($daily, 2);
        $metrics['weekly'][$categoryName] = round($weekly * 7, 2);    // show weekly total
        $metrics['monthly'][$categoryName] = round($monthly * 30, 2); // show monthly total
        $metrics['averages'][$categoryName] = round($finalAvg, 2);
        $metrics['rawAverages'][$categoryName] = round($weightedAvg, 2);
    }

    return $metrics;
}


    private function calculateStockStatus($groupedStocks, $metrics)
{
    $alerts = [];
    $daysRemaining = [];
    $stockValues = [];

    foreach ($groupedStocks as $parent => $childGroups) {
        foreach ($childGroups as $child => $grandchildGroups) {
            foreach ($grandchildGroups as $grandchild => $stocks) {
                $totalStock = $stocks->sum('quantity');
                $stockValues[$grandchild] = $totalStock;

                // Check if we have consumption data
                if (isset($metrics['averages'][$grandchild])) {
                    $avgConsumption = $metrics['averages'][$grandchild];

                    if ($totalStock <= 0) {
                        $daysInStock = 0; // No stock = 0 days remaining
                    } elseif ($avgConsumption > 0) {
                        $daysInStock = $totalStock / $avgConsumption;
                    } else {
                        $daysInStock = INF; // No consumption = unlimited stock
                    }

                    $daysRemaining[$grandchild] = $daysInStock;

                    // Alert only if < 5 days of stock
                    if ($daysInStock < 5) {
                        $alerts[] = [
                            'category' => $grandchild,
                            'days' => floor($daysInStock),
                            'stock' => $totalStock,
                            'consumption' => $avgConsumption,
                        ];
                    }
                } else {
                    // No consumption data, assume unknown
                    $daysRemaining[$grandchild] = null;
                }
            }
        }
    }

    return compact('alerts', 'daysRemaining', 'stockValues');
}


    
    public function StockTapis()
    {
        // Fetch the stocks along with their related categories and articles
        $stocks = StockMatierePremiere::with(['article.category.parent.parent', 'category.parent'])->get();
        
        // Filter to include only stocks in the MARGOUM category
        $margoumStocks = $stocks->filter(function ($item) {
            return $item->category->name == 'TAPIS' || 
                   ($item->category->parent && $item->category->parent->name == 'TAPIS') || 
                   ($item->category->parent && $item->category->parent->parent && $item->category->parent->parent->name == 'TAPIS');
        });
    
        // Group by parent category, child category, and grandchild category if applicable
        $groupedStocks = $margoumStocks->groupBy(function ($item) {
            return $item->category->parent && $item->category->parent->parent 
                ? $item->category->parent->parent->name 
                : ($item->category->parent ? $item->category->parent->name : 'N/A');
        })->map(function ($group) {
            return $group->groupBy(function ($item) {
                return $item->category->parent 
                    ? $item->category->parent->name 
                    : $item->category->name;
            })->map(function ($subGroup) {
                return $subGroup->groupBy('category.name');
            });
        });
    
      
        return view('stockActuel_tapis', compact('groupedStocks'));
    }
    

    public function showStock()
{
    // Fetch all entries from the StockMargoumArticle table with related article and stock details
    $stockMargoumArticles = StockMargoum::get();
    // dd($stockMargoumArticles);
    
    return view('stock.show', compact('stockMargoumArticles'));
}

    
    
}

    
    


