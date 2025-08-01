<?php

namespace App\Http\Controllers;

use App\Models\ArivageMatierePremiere;
use Illuminate\Http\Request;

class ArivageController extends Controller
{
    public function index()
    {
        // Fetch the latest arrivages
        $latestArrivages = ArivageMatierePremiere::with(['articles.article', 'articles.categorie'])
            ->orderBy('creation_date', 'desc')
            ->take(10)
            ->get();

        // Pass the latest arrivages to the view
        return view('arivages.index', compact('latestArrivages'));
    }
}
