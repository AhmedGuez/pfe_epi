<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Client;
use App\Models\Commande;
use App\Models\CommandeArticle;
use Illuminate\Http\Request;

class SuiviCommande extends Controller
{
    public function downloadSuivi(Commande $record)
    {
        // Using eager loading to fetch related data in one go
        $articleData = CommandeArticle::with('article')->where('commande_id', $record->id)->get();
    
        $articles = $articleData->map(function ($data) {
            $quantite_en_m2 = $data->article->coefficient_metrage * $data->nombre_de_pieces;
    
            return [
                'code_article' => $data->article->code_article,
                'nombre_de_pieces' => $data->nombre_de_pieces,
                'nombre_de_pieces_fini' => $data->nombre_de_pieces_fini,
                'nombre_de_pieces_semi_fini' => $data->nombre_de_pieces_semi_fini,
                'nombre_de_pieces_livre' => $data->nombre_de_pieces_livre,
                'nombre_de_pieces_reste_a_livre' => $data->nombre_de_pieces_reste_a_livre,
                'rest' => $data->rest,
                'qty_transferred' => $data->qty_transferred,
                'client_transferred_to' => $data->client->nom_client ?? 'Aucun Client !',
                'quantite_en_m2' => $quantite_en_m2,
            ];
        })->toArray();
    
        // Calculate the total quantity in m²
        $total_quantite_en_m2 = array_sum(array_column($articles, 'quantite_en_m2'));

        // Bns Data
        $code_commande = $record->code_commande;
        $date_commande = $record->date_commande;
        $status = $record->status;
    
        $formatted_date = now()->format('d/m/Y'); // Current date formatted
    
        // Grab client name
        $client_name = $record->client->nom_client;
    
        return view('suiviCommande')->with([
            'articles' => $articles,
            'code_commande' => $code_commande,
            'date_commande' => $date_commande,
            'client_name' => $client_name,
            'formatted_date' => $formatted_date,
            'status' => $status,
            'total_quantite_en_m2' => $total_quantite_en_m2, // Add this line
        ]);
    }
//     public function downloadSuivi(Commande $record)
// {
//     // Using eager loading to fetch related data in one go
//     $articleData = CommandeArticle::with('article')->where('commande_id', $record->id)->get();

//     $articles = $articleData->map(function ($data) {
//         $quantite_en_m2 = $data->article->coefficient_metrage * $data->nombre_de_pieces;

//         return [
//             'code_article' => $data->article->code_article,
//             'nombre_de_pieces' => $data->nombre_de_pieces,
//             'nombre_de_pieces_fini' => $data->nombre_de_pieces_fini,
//             'nombre_de_pieces_semi_fini' => $data->nombre_de_pieces_semi_fini,
//             'nombre_de_pieces_livre' => $data->nombre_de_pieces_livre,
//             'nombre_de_pieces_reste_a_livre' => $data->nombre_de_pieces_reste_a_livre,
//             'rest' => $data->rest,
//             'qty_transferred' => $data->qty_transferred,
//             'client_transferred_to' => $data->client->nom_client ?? 'Aucun Client !',
//             'quantite_en_m2' => $quantite_en_m2,
//         ];
//     })->toArray();

//     // Calculate the total quantity in m²
//     $total_quantite_en_m2 = array_sum(array_column($articles, 'quantite_en_m2'));

//     // Calculate the total weight in kg for each component
//     $coef_m2_to_kg = 5.6 / 3.3; // 5.6 m² corresponds to 3.3 kg
//     $total_weight_kg = $total_quantite_en_m2 / $coef_m2_to_kg;

//     // Component percentages
//     $polyester_r1_percentage = 0.52;
//     $polyester_r2_percentage = 0.18;
//     $polyester_r3_percentage = 0.16;
//     $shpinger_percentage = 0.12;
//     $cotton_weight_g_per_m2 = 335; // weight per m² in grams
//     $cotton_weight_g_total = $cotton_weight_g_per_m2 * $total_quantite_en_m2 / 1000; // total weight in kg

//     // Remaining weight for Zemin in grams
//     $zemin_weight_g = $total_weight_kg * 1000 - ($total_weight_kg * $polyester_r1_percentage + $total_weight_kg * $polyester_r2_percentage + $total_weight_kg * $polyester_r3_percentage + $total_weight_kg * $shpinger_percentage + $cotton_weight_g_total);

//     // Calculated weights in kg
//     $polyester_r1_kg = $total_weight_kg * $polyester_r1_percentage;
//     $polyester_r2_kg = $total_weight_kg * $polyester_r2_percentage;
//     $polyester_r3_kg = $total_weight_kg * $polyester_r3_percentage;
//     $shpinger_kg = $total_weight_kg * $shpinger_percentage;
//     $cotton_kg = $cotton_weight_g_total / 1000;
//     $zemin_kg = $zemin_weight_g / 1000;

//     // Bns Data
//     $code_commande = $record->code_commande;
//     $date_commande = $record->date_commande;
//     $status = $record->status;

//     $formatted_date = now()->format('d/m/Y'); // Current date formatted

//     // Grab client name
//     $client_name = $record->client->nom_client;

//     return view('suiviCommande')->with([
//         'articles' => $articles,
//         'code_commande' => $code_commande,
//         'date_commande' => $date_commande,
//         'client_name' => $client_name,
//         'formatted_date' => $formatted_date,
//         'status' => $status,
//         'total_quantite_en_m2' => $total_quantite_en_m2,
//         'total_weight_kg' => $total_weight_kg,
//         'polyester_r1_kg' => $polyester_r1_kg,
//         'polyester_r2_kg' => $polyester_r2_kg,
//         'polyester_r3_kg' => $polyester_r3_kg,
//         'shpinger_kg' => $shpinger_kg,
//         'cotton_kg' => $cotton_kg,
//         'zemin_kg' => $zemin_kg,
//     ]);
// }


    
    
}
