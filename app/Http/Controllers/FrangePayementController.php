<?php

namespace App\Http\Controllers;

use App\Models\FrangePayement;
use App\Models\RefFringe;
use Illuminate\Http\Request;

class FrangePayementController extends Controller
{
    public function downloadFrangePayement(FrangePayement $record)
    {
        // Fetch associated articles with relationships
        $articles = $record->articles()
            ->with(['refFringe', 'contact']) // Ensure relationships are loaded
            ->get([
                'ref_fringe_id', 
                'fringe_contact_id', 
                'approved_qty', 
                'rejected_qty', 
                'montant_payer', 
                'reste_a_payer', 
                'payment_status'
            ]);

        // Map articles to format data for the view
        $mappedArticles = $articles->map(function ($article) {
            return [
                'refFringe' => $article->refFringe->ref ?? 'N/A', // Ensure ref exists
                'contactName' => $article->contact->full_name ?? 'N/A', // Contact's full name
                'contactPhone' => $article->contact->phone_number ?? 'N/A', // Contact's phone number
                'prixParKg' => $article->contact->prix_par_kg ?? 'N/A', // Contact's price per kg
                'approvedQty' => $article->approved_qty,
                'rejectedQty' => $article->rejected_qty,
                'montantPayer' => $article->montant_payer,
                'resteAPayer' => $article->reste_a_payer,
                'paymentStatus' => ucfirst(str_replace('_', ' ', $article->payment_status)), // Format payment status
            ];
        });

        // Prepare data for the view
        $data = [
            'payementDate' => $record->payement_date,
            'totalAmount' => $record->total_amount,
            'paidAmount' => $record->paid_amount,
            'status' => $record->status ? 'Validé' : 'Non Validé',
            'articles' => $mappedArticles,
        ];

        return view('frangePayementDownload', $data);
    }
}
