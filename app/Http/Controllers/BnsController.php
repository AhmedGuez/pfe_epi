<?php

namespace App\Http\Controllers;

use App\Models\BnsMargoum;
use App\Models\BnsMargoumArticle;
use App\Models\BnsMargoumSemiFini;
use App\Models\BnsMargoumSemiFiniArticles;
use App\Models\Commande;
use Illuminate\Http\Request;
use App\Models\Client;

class BnsController extends Controller
{
    public function downloadBnsMargoumSf(BnsMargoumSemiFini $record)
    {
        // Retrieve all articles related to the BnsMargoum record
        $articles = [];
        $commandeIds = [];

        $articleData = BnsMargoumSemiFiniArticles::where('bns_margoum_semi_fini_id', $record->id)
            ->with(['article', 'commande']) // Include both 'article' and 'commande' relationships
            ->get();

        foreach ($articleData as $data) {
            $commande = $data->commande;
            if ($commande) {
                $commandeIds[] = $commande->id;
            }

            if ($data->article) {
                $articles[] = [
                    'code_commande' => $commande ? $commande->code_commande : 'No Code !',
                    'code_article' => $data->article->code_article,
                    'quantity' => $data->nombre_de_pieces_semi_fini,
                    'nombre' => $data->nombre_de_rouleaux,
                ];
            }
        }

        // Fetch the client associated with the commande
        $client_name = 'Unknown';
        if (!empty($commandeIds)) {
            $commande = Commande::whereIn('id', $commandeIds)->with('client')->first();
            if ($commande && $commande->client) {
                $client_name = $commande->client->nom_client;
            }
        }

        // Bns Data
        $bon_sortie_number = $record->bon_sortie_number;
        $date = $record->creation_date;
        $createdBy = $record->created_by;
        $deliverd = $record->usine;

        // Format the creation date
        $created_at = strtotime($record->created_at);
        $one_hour_later = $created_at + (1 * 60 * 60); // Add one hour
        $time = date('H:i:s', $one_hour_later); // Format the result

        $clients = Client::all()->pluck('nom_client', 'id');

        // Render the view with the data
        return view('bnsMargoumSf', [
            'articles' => $articles,
            'bon_sortie_number' => $bon_sortie_number,
            'date' => $date,
            'createdBy' => $createdBy,
            'time' => $time,
            'deliverd' => $deliverd,
            'client_name' => $client_name,
            'clients' => $clients,
        ]);
    }
}
