<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductionMargoum;
use App\Models\ProductionMargoumMachine;

class ProductionController extends Controller
{
    public function showProductionDataByDate(Request $request)
    {
        // Default to yesterday's date if no date is provided
            $date = $request->input('date', now()->subDay()->toDateString());

            // Fetch production data with relationships
            $productions = ProductionMargoum::with([
                'machines.articles.taille',
                'machines.articles.color'
            ])->where('creation_date', $date)->get();

        // If no data exists, return empty data
        if ($productions->isEmpty()) {
            return view('production_report', ['data' => [], 'productions' => $productions]);
        }

        $data = [];

        foreach ($productions as $production) {
            foreach ($production->machines as $machine) {
                $machineKey = $production->section . '-' . $machine->machine; // Unique key to avoid duplicates
                
                if (!isset($data[$machineKey])) {
                    $data[$machineKey] = [
                        'machine' => $machine->machine,
                        'section' => $production->section,
                        'comment' => $machine->comment,
                        'articles' => [],
                    ];
                }

                foreach ($machine->articles as $article) {
                    $data[$machineKey]['articles'][] = [
                        'employee_names' => $article->employee_name,
                        'metrage' => $article->taille->taille,
                        'couleur' => $article->color->color,
                        'quantity' => $article->quantity,
                        'total_m2' => $article->taille->coefficient_metrage * $article->quantity,
                    ];
                }
            }
        }

        $totalProduction = [
            'total_quantity' => 0,
            'total_m2' => 0,
            'employees_with_objective' => [],
        ];
        
        foreach ($data as $machineNumber => $machines) {
            foreach ($machines['articles'] as $article) {
                $totalProduction['total_quantity'] += $article['quantity'];
                $totalProduction['total_m2'] += $article['total_m2'];
        
                // Check if the employee meets their objective
                $objectiveMet = false;
                if (($article['metrage'] == '2/3' && $article['quantity'] >= 50) ||
                    ($article['metrage'] == '2/4' && $article['quantity'] >= 38) ||
                    ($article['metrage'] == '2/1.6' && $article['quantity'] >= 90) ||
                    ($article['metrage'] == '2/1.5' && $article['quantity'] >= 90)) {
                    $objectiveMet = true;
                }
        
                if ($objectiveMet) {
                    $totalProduction['employees_with_objective'] = array_merge(
                        $totalProduction['employees_with_objective'], 
                        $article['employee_names']
                    );
                }
            }
        }
        
        // Remove duplicate employee names
        $totalProduction['employees_with_objective'] = array_unique($totalProduction['employees_with_objective']);
        
        // Initialize variables to track the best machine
        $sectionSummary = [];

        foreach ($productions as $production) {
            $sectionKey = $production->section;
        
            if (!isset($sectionSummary[$sectionKey])) {
                $sectionSummary[$sectionKey] = [
                    'section' => $sectionKey,
                    'total_quantity' => 0,
                    'total_m2' => 0,
                    'machines' => [],
                ];
            }
        
            foreach ($production->machines as $machine) {
                $machineKey = $machine->machine;
        
                if (!isset($sectionSummary[$sectionKey]['machines'][$machineKey])) {
                    $sectionSummary[$sectionKey]['machines'][$machineKey] = [
                        'machine' => $machineKey,
                        'total_quantity' => 0,
                        'total_m2' => 0,
                    ];
                }
        
                foreach ($machine->articles as $article) {
                    $sectionSummary[$sectionKey]['total_quantity'] += $article->quantity;
                    $sectionSummary[$sectionKey]['total_m2'] += $article->taille->coefficient_metrage * $article->quantity;
        
                    $sectionSummary[$sectionKey]['machines'][$machineKey]['total_quantity'] += $article->quantity;
                    $sectionSummary[$sectionKey]['machines'][$machineKey]['total_m2'] += $article->taille->coefficient_metrage * $article->quantity;
                }
            }
        
            // Identify the best machine for the section
            $sectionSummary[$sectionKey]['best_machine'] = collect($sectionSummary[$sectionKey]['machines'])
                ->sortByDesc('total_quantity')
                ->first();
        }

            $summary = [];
            foreach ($data as $machineNumber => $machines) {
                foreach ($machines['articles'] as $article) {
                    $key = $machineNumber . '-' . $article['metrage'] . '-' . $article['couleur'];
                    if (!isset($summary[$key])) {
                        $summary[$key] = [
                            'machine' => $machines['machine'],
                            'metrage' => $article['metrage'],
                            'couleur' => $article['couleur'],
                            'quantity' => 0,
                            'total_m2' => 0,
                        ];
                    }
                    $summary[$key]['quantity'] += $article['quantity'];
                    $summary[$key]['total_m2'] += $article['total_m2'];
                }
            }

            // Create regrouped summary
            $regroupedSizesSummary = [];
            foreach ($summary as $item) {
                $key = $item['metrage'];
                if (!isset($regroupedSizesSummary[$key])) {
                    $regroupedSizesSummary[$key] = [
                        'metrage' => $item['metrage'],
                        'quantity' => 0,
                        'total_m2' => 0,
                    ];
                }
                $regroupedSizesSummary[$key]['quantity'] += $item['quantity'];
                $regroupedSizesSummary[$key]['total_m2'] += $item['total_m2'];
            }

        
        // Pass both data and productions to the view
        return view('production_report', compact('regroupedSizesSummary','summary','data', 'productions','totalProduction','sectionSummary'));
    }
}

