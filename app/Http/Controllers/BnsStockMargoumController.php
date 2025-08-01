<?php

namespace App\Http\Controllers;

use App\Models\BnsStockMargoum;
use Illuminate\Http\Request;

class BnsStockMargoumController extends Controller
{
    public function downloadBnsStockMargoum (BnsStockMargoum $record)
    {
        // Fetch associated articles
        $articles = $record->articles()->get(['article_id', 'nombre_de_pieces']);

        // Map articles to include additional data if necessary
        $mappedArticles = $articles->map(function ($article) {
            // You can adjust this part if you need additional information from the article model
            return [
                'code_article' => $article->article->code_article, // Assuming there's a relationship to get code_article
                'quantity' => $article->nombre_de_pieces,
            ];
        });

        // Prepare data for the view
        $data = [
            'bonSortieNumber' => $record->bon_sortie_number,
            'date' => $record->creation_date,
            'time' => $record->creation_date,
            'deliverd' => $record->deliverd, // Add this field if needed, adjust as per your model
            'createdBy' => $record->created_by,
            'articles' => $mappedArticles,
        ];

        return view('bnsStokMargoum', $data);
    }
}
