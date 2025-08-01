<?php
namespace App\Http\Controllers;

use App\Models\SousTraitance;
use Illuminate\Http\Request;

class SousTraitanceController extends Controller
{
    public function showSousTraitanceDetails(SousTraitance $record)
    {
        $articles = $record->articles()->with(['refFringe', 'fringeContact'])->get()->map(function ($article) {
            return [
                'chef_de_group' => $article->chef_de_group,
                'qty' => $article->qty,
                'ref_fringe' => $article->refFringe->ref ?? 'N/A', // Adjust based on RefFringe columns
                'fringe_contact' => $article->fringeContact->full_name ?? 'N/A', // Adjust based on FringeContact columns
                'contact_number' => $article->fringeContact->phone_number ?? 'N/A', // Adjust based on FringeContact columns
            ];
        });
        
        // dd($record->articles()->with(['refFringe', 'fringeContact'])->get());
        

        return view('sous_traitance.index', [
            'record' => $record,
            'articles' => $articles,
        ]);
    }
}


