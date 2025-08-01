<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Bobine;
use App\Models\Client;
use App\Models\Commande;
use App\Models\CommandeArticle;
use App\Models\StockMatierePremiere;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class DownloadCommande extends Controller
{ 

    public function downloadCommande (Commande $record)
    {
        $articles = [];

        $articleData = CommandeArticle::where('commande_id', $record->id)->get();
        foreach ($articleData as $data) {
            $article = Article::find($data->article_id);
            $articles[] = [
                'code_article' => $article->code_article,
                'nombre_de_pieces' => $data->nombre_de_pieces,
            ];
        } 

        //Bns Data
        $code_commande = $record->code_commande;
        $date_commande = $record->date_commande;

        $date = date_create(); // Create a date object (current date and time)
        $formatted_date = date_format($date, "d/m/Y");

        $client_id = $record->client_id;
        $client = Client::find($client_id);
        $client_name = $client->nom_client;

        return view('commande')->with(
            [
                'articles' => $articles,
                'code_commande' => $code_commande,
                'date_commande' => $date_commande,
                'client_name' => $client_name,
                'formatted_date' => $formatted_date,

            ]
        );
    }


    public function downloadJrCommande (Commande $record)
    {
        $articles = [];

        $articleData = CommandeArticle::where('commande_id', $record->id)->get();
        foreach ($articleData as $data) {
            $article = Article::find($data->article_id);
            $articles[] = [
                'code_article' => $article->code_article,
                'nombre_de_pieces' => $data->nombre_de_pieces,
            ];
           
        } 

        //Bns Data
        $code_commande = $record->code_commande;
        $date_commande = $record->date_commande;

        $date = date_create(); // Create a date object (current date and time)
        $formatted_date = date_format($date, "d/m/Y");

        $client_id = $record->client_id;
        $client = Client::find($client_id);
        $client_name = $client->nom_client;

        return view('Jrcommande')->with(
            [
                'articles' => $articles,
                'code_commande' => $code_commande,
                'date_commande' => $date_commande,
                'client_name' => $client_name,
                'formatted_date' => $formatted_date,

            ]
        );
    }


    public function downloadList()
{
    $code_bobines = StockMatierePremiere::join('categories', 'stock_matiere_premieres.categorie_id', '=', 'categories.id')
        ->whereIn('categories.name', ['POLYESTER COULEUR'])
        ->get();
        
    return view('listBobine', compact('code_bobines'));
}


public function downloadDesign($design)
{
    $data = Media::where('model_id', $design)->firstOrFail();

    $content = Storage::disk('public')->path($data->id . '/' . $data->file_name);

    return response()->download($content);
}

public function downloadfile($demande)
{
    $data = Media::where('model_id', $demande)->firstOrFail();

    $content = Storage::disk('public')->path($data->id . '/' . $data->file_name);

    return response()->download($content);
}

public function downloadquestionaire($questionaire)
{
    $data = Media::where('model_id', $questionaire)->firstOrFail();

    $content = Storage::disk('public')->path($data->id . '/' . $data->file_name);

    return response()->download($content);
}


}
