<?php

namespace App\Http\Controllers;

use App\Models\BnsDechet;
use Illuminate\Http\Request;

class BnsDechetController extends Controller
{
    public function downloadBonSortie(BnsDechet $record)
    {
        // Fetch associated articles with the type name
        $articles = $record->articles()
            ->join('dechet_types', 'bns_dechet_articles.dechet_type_id', '=', 'dechet_types.id')
            ->get([
                'dechet_types.name as type', // Fetch type name from dechet_types table
                'bns_dechet_articles.prix_par_kg',
                'bns_dechet_articles.qty',
                'bns_dechet_articles.total',
            ]);

        // Fetch associated DechetContact
        $contact = $record->contact; // Assuming 'contact' is the relationship name in BnsDechet model

        // Map articles to format data for the view
        $mappedArticles = $articles->map(function ($article) {
            return [
                'type' => $article->type,
                'prixParKg' => $article->prix_par_kg,
                'quantite' => $article->qty,
                'total' => $article->total,
            ];
        });

        // Prepare data for the view
        $data = [
            'bonSortieNumber' => $record->bon_sortie_number,
            'matriclule' => $record->matriclule,
            'creationDate' => $record->creation_date,
            'createdBy' => $record->created_by,
            'prixTotal' => $record->prix_total,
            'remise' => $record->remise,
            'credit' => $record->credit,
            'old_credit' => $record->old_credit,
            'netPayer' => $record->net_payer,
            'resteAPayer' => $record->reste_a_payer,
            'contactFullName' => $contact->full_name ?? 'N/A', // Fallback to 'N/A' if contact is null
            'contactPhone' => $contact->phone_number ?? 'N/A', // Fallback to 'N/A' if contact is null
            'articles' => $mappedArticles,
        ];

        return view('bnsDechet.downloadBonSortie', $data);
    }
}
