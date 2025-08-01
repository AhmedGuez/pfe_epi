<?php
namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Commande;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    public function index(Request $request)
    {
        $query = Commande::query();

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->input('date'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('client_id')) {
            $query->where('client_id', $request->input('client_id'));
        }

        $commandes = $query->orderBy('created_at', 'desc')->paginate(5);
        $clients = Client::all()->pluck('nom_client', 'id');

        return view('commandes.index', compact('commandes', 'clients'));
    }
}
