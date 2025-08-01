<?php

namespace App\Http\Controllers;

use App\Models\ArticleMatierePremiere;
use App\Models\BnsResteBobine;
use App\Models\BnsResteBobineArticle;
use App\Models\Category;
use Illuminate\Http\Request;

class BnsRetourBobineController extends Controller
{
    public function downloadBnsResteBobine (BnsResteBobine $record)
    {
        // Article Data From Bns ID
        $articles = [];

        $articleData = BnsResteBobineArticle::where('bns_reste_bobine_id', $record->id)->get();
        foreach ($articleData as $data) {
            $category = Category::find($data->categorie_id);
            $articleMatierePremiere = ArticleMatierePremiere::find($data->article_matiere_premiere_id);

            // Prepare category hierarchy
            $categoryHierarchy = $this->getCategoryHierarchy($category);

            $articles[] = [
                'categories' => $categoryHierarchy,
                'code_article' => $articleMatierePremiere ? $articleMatierePremiere->name : 'Unknown Article',
                'quantity' => $data->quantity,
                'unite' => $data->unite,
            ];
        }
        

        // Bns Data
        $bonSortieNumber = $record->bon_sortie_number;
        $date = $record->creation_date;
        $deliverd = $record->usine;
        $createdBy = $record->created_by;

        // Format creation time
        $created_at = strtotime($record->created_at);
        $one_hour_later = $created_at + (1 * 60 * 60);
        $time = date('H:i:s', $one_hour_later);

        return view('bnsResteBobine')->with([
            'articles' => $articles,
            'bonSortieNumber' => $bonSortieNumber,
            'date' => $date,
            'createdBy' => $createdBy,
            'deliverd' => $deliverd,
            'time' => $time,
        ]);
    }

    private function getCategoryHierarchy($category)
    {
        $hierarchy = [];

        while ($category) {
            $hierarchy[] = $category->name;
            $category = $category->parent;
        }

        return array_reverse($hierarchy);
    }
}
