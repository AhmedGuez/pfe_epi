<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\MargoumFini;
use App\Models\MargoumPremierFini;
use Carbon\Carbon;

class MargoumFiniController extends Controller
{
    public function index(Request $request)
{
    // Get the date from the request
    $date = $request->input('date');

    // Determine the date range: if no date specified, use the last three days
    if ($date) {
        $startDate = Carbon::parse($date)->startOfDay();
        $endDate = Carbon::parse($date)->endOfDay();
    } else {
        $endDate = Carbon::now()->endOfDay();
        $startDate = $endDate->copy()->subDays(2)->startOfDay();
    }

    // Filter by the date range
    $margoumFinis = MargoumPremierFini::whereBetween('creation_date', [$startDate, $endDate])
        ->with('articles.article')
        ->get();

    // Calculate the total number of pieces
    $totalPieces = $margoumFinis->flatMap(function ($margoumFini) {
        return $margoumFini->articles;
    })->sum('nombre_de_pieces_fini');

    // Return the view with the filtered results, the total, and the date
    return view('margoum_fini.index', compact('margoumFinis', 'totalPieces', 'date', 'startDate', 'endDate'));
}

}