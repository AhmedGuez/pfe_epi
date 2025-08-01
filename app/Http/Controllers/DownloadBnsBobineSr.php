<?php

namespace App\Http\Controllers;

use App\Models\BonSortieBobineSr;
use App\Models\BonSortieBobineSrArticle;
use Illuminate\Http\Request;

class DownloadBnsBobineSr extends Controller
{
    public function downloadBnsBobineSr(BonSortieBobineSr $record)
    {
        $articles = BonSortieBobineSrArticle::where('bon_sortie_bobine_sr_id', $record->id)
                    ->with('articleMatierePremiere')
                    ->get()
                    ->map(function ($data) {
                        return [
                            'code_article' => $data->articleMatierePremiere->name,
                            'quantity' => $data->quantity,
                        ];
                    })
                    ->toArray();

        //Bns Data
        $bonSortieNumber = $record->bon_sortie_number;
        $date = $record->creation_date;
        $deliverd = $record->usine;
        $createdBy = $record->created_by;

        $created_at = strtotime($record->created_at);
        $one_hour_later = $created_at + (1 * 60 * 60);
        $time = date('H:i:s', $one_hour_later);

        return view('bonSortieBobineSr')->with([
            'articles' => $articles,
            'bonSortieNumber' => $bonSortieNumber,
            'date' => $date,
            'createdBy' => $createdBy,
            'deliverd' => $deliverd,
            'time' => $time,
        ]);
    }
}
