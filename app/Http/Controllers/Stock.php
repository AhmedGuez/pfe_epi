<?php

namespace App\Http\Controllers;

use App\Models\Depot;
use App\Models\Product;
use App\Models\StockMargoumFini;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Stock extends Controller
{
    public function index()
    {
        $depots = Depot::all();

        // Optional: collect unique dimensions (as strings like "2.00 x 3.00")
        $dimensions = Product::select('largeur', 'hauteur')
            ->distinct()
            ->get()
            ->map(fn($p) => number_format($p->largeur, 2) . ' x ' . number_format($p->hauteur, 2))
            ->unique()
            ->values();

        $stocks = Product::all()->map(function ($product) use ($depots) {
            $stockPerDepot = [];
            $total = 0;

            foreach ($depots as $depot) {
                $in = StockMovement::where('product_id', $product->id)
                    ->where('depot_id', $depot->id)
                    ->where('type', 'IN')
                    ->sum('quantity');

                $out = StockMovement::where('product_id', $product->id)
                    ->where('depot_id', $depot->id)
                    ->where('type', 'OUT')
                    ->sum('quantity');

                $stock = $in - $out;
                $stockPerDepot[$depot->id] = $stock;
                $total += $stock;
            }

            return [
                'code_article' => $product->code_article,
                'dimension' => number_format($product->largeur, 2) . ' x ' . number_format($product->hauteur, 2),
                'depots' => $stockPerDepot,
                'total' => $total,
            ];
        })->filter(fn($item) => $item['total'] > 0)->values();

        return view('stock_margoum.index', [
            'stocks' => $stocks,
            'dimensions' => $dimensions,
            'depots' => $depots,
        ]);
    }
}
