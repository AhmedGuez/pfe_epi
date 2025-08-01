<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function details(Transactions $transaction)
    {
        return view('transactions.details', [
            'transaction' => $transaction,
        ]);
    }
}
