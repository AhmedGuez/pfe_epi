<?php

namespace App\Http\Controllers;

use App\Models\MargoumSecondFini;
use Illuminate\Http\Request;

class Margoum2emeFiniController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
        $margoumFinis = MargoumSecondFini::whereDate('creation_date', $date)
            ->with(['margoumSecondFiniArticles.article'])
            ->get();

        return view('margoum_fini.secondChoix', compact('margoumFinis', 'date'));
    }
}

