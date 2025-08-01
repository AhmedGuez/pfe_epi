<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\BnlMargoum;
use App\Models\BnlMargoumArticle;
use Illuminate\Http\Request;

class BnlController extends Controller
{
    public function downloadBnl(BnlMargoum $record)
    {
        $articles = [];
        $articleData = BnlMargoumArticle::where('bnl_margoum_id', $record->id)
            ->with(['stockMargoumFini.article']) // Eager load stock and its article
            ->get();
    
        foreach ($articleData as $data) {
            if ($data->stockMargoumFini && $data->stockMargoumFini->article) {
                $articles[] = [
                    'code_article' => $data->stockMargoumFini->article->code_article,
                    'quantity' => $data->nombre_de_pieces_livre,
                ];
            }
        }

        // Bnl Data
        $bon_livraison_number = $record->bon_livraison_number;
        $date = $record->creation_date;
        $createdBy = $record->created_by;
        $deliverd = $record->client;
        $chauffeur = $record->chauffeur;
        $matricule = $record->camion;

        // Format the creation date
        $created_at = strtotime($record->created_at);
        $one_hour_later = $created_at + (1 * 60 * 60); // Add one hour
        $time = date('H:i:s', $one_hour_later); // Format the result

        // Render the view with the data
        return view('bonDeLivraison', [
            'articles' => $articles,
            'bon_livraison_number' => $bon_livraison_number,
            'date' => $date,
            'createdBy' => $createdBy,
            'deliverd' => $deliverd,
            'time' => $time,
            'chauffeur' => $chauffeur,
            'camion' => $matricule
        ]);
    }
}
