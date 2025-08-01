<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\DeliveryItems;
use App\Models\Package;
use App\Models\StockMovement;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View; 
use Illuminate\Support\Str;

class DeliveryController extends Controller
{
    public function scanPackage(Request $request)
    {
        $request->validate(['qr_code' => 'required|string']);
        
        $package = Package::where('qr_code', $request->qr_code)
            ->where('status', '!=', 'delivered')
            ->firstOrFail();

        return response()->json([
            'id' => $package->id,
            'product_code' => $package->product->code,
            'quantity' => $package->quantity,
            'batch_number' => $package->batch_number,
            'status' => 'scanned'
        ]);
    }

        public function removePackage(Package $package)
        {
            if ($package->status === 'delivered') {
                abort(400, 'Cannot remove delivered package');
            }
            
            return response()->json(['message' => 'Package removed']);
        }
      public function store(Request $request)
{
    $request->validate([
        'type' => 'required|in:client,transfer,employee',
        'client_id' => 'required_if:type,client|nullable|exists:clients,id',
        'employee_id' => 'required_if:type,employee|nullable|exists:employees,id',
        'from_depot_id' => 'required|exists:depots,id',
        'to_depot_id' => 'required_if:type,transfer|nullable|exists:depots,id',
        'delivery_date' => 'required|date',
        'car_number' => 'required|string',
        'packages' => 'required|array|min:1',
        'packages.*' => 'string|exists:packages,qr_code',
    ]);

    // Generate BNL number
    $lastId = Delivery::max('id') ?? 0;
    $bnlNumber = 'BNL-' . ($lastId + 1);

    DB::beginTransaction();
    try {
        $delivery = Delivery::create([
            'bnl_number' => $bnlNumber,
            'type' => $request->type,
            'client_id' => $request->type === 'client' ? $request->client_id : null,
            'employee_id' => $request->type === 'employee' ? $request->employee_id : null,
            'from_depot_id' => $request->from_depot_id,
            'to_depot_id' => $request->type === 'transfer' ? $request->to_depot_id : null,
            'car_number' => $request->car_number,
            'delivery_date' => $request->delivery_date,
            'status' => 'Draft',
        ]);

        foreach ($request->packages as $qrCode) {
            $package = Package::where('qr_code', $qrCode)->first();
            
            DeliveryItems::create([
                'delivery_id' => $delivery->id,
                'package_id' => $package->id,
                'product_id' => $package->product_id,
                'quantity' => $package->quantity,
            ]);
        }

        DB::commit();
        return response()->json(['message' => 'Delivery created!'], 201);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['error' => $e->getMessage()], 500);
    }
}



            public function show($qrCode)
        {
            $package = Package::with('depot', 'product')
                            ->where('qr_code', $qrCode)
                            ->firstOrFail();

            return response()->json($package);
        }
public function print(Delivery $delivery)
{
    $articles = $delivery->items->groupBy('product.code_article')->map(function ($items, $code) {
        $firstItem = $items->first();
        return [
            'code_article' => $code,
            'designation' => $firstItem->product->designation ?? 'N/A',
            'quantity' => $items->sum('quantity'),
            'unit_price' => $firstItem->product->prix ?? 0,
            'color' => $firstItem->product->color ?? 'N/A',
            'quality' => $firstItem->product->quality ?? 'N/A',
            'dimensions' => ($firstItem->product->largeur ?? false) && ($firstItem->product->hauteur ?? false) 
                ? $firstItem->product->largeur.'m × '.$firstItem->product->hauteur.'m' 
                : 'N/A'
        ];
    })->values();

    $subtotal = $articles->sum(function($article) {
        return $article['unit_price'] * $article['quantity'];
    });
    
    $tvaRate = ($delivery->client && $delivery->client->tva) ? 0.19 : 0;
    $tva = $subtotal * $tvaRate;
    $total = $subtotal + $tva;
    
    // Calculate total pieces and packages
    $totalPieces = $delivery->items->sum('quantity');
    $totalPackages = $delivery->items->count();

    return view('print.delivery', [
        'delivery' => $delivery,
        'articles' => $articles,
        'bon_livraison_number' => 'BON-' . str_pad($delivery->id, 5, '0', STR_PAD_LEFT),
        'date' => $delivery->delivery_date,
        'time' => $delivery->created_at,
        'chauffeur' => '_________',
        'createdBy' => optional($delivery->deliveredBy)->name ?? '_________',
        'subtotal' => $subtotal,
        'tva' => $tva,
        'total' => $total,
        'totalPieces' => $totalPieces,
        'totalPackages' => $totalPackages
    ]);
}

public function update(Request $request, Delivery $delivery)
{
    $validated = $request->validate([
        'type' => 'required|in:client,transfer,employee',
        'client_id' => 'required_if:type,client|nullable|exists:clients,id',
        'employee_id' => 'required_if:type,employee|nullable|exists:employees,id',
        'from_depot_id' => 'required|exists:depots,id',
        'to_depot_id' => 'required_if:type,transfer|nullable|exists:depots,id',
        'delivery_date' => 'required|date',
        'car_number' => 'nullable|string|max:255',
        'packages' => 'required|array|min:1',
        'packages.*' => 'exists:packages,qr_code',
    ]);

    try {
        DB::transaction(function () use ($validated, $delivery) {
            $delivery->update([
                'type' => $validated['type'],
                'client_id' => $validated['type'] === 'client' ? $validated['client_id'] : null,
                'employee_id' => $validated['type'] === 'employee' ? $validated['employee_id'] : null,
                'from_depot_id' => $validated['from_depot_id'],
                'to_depot_id' => $validated['type'] === 'transfer' ? $validated['to_depot_id'] : null,
                'delivery_date' => $validated['delivery_date'],
                'car_number' => $validated['car_number'],
                'status' => 'Draft'
            ]);

            $existingPackageIds = $delivery->items()->pluck('package_id')->toArray();
            $newPackages = Package::whereIn('qr_code', $validated['packages'])->pluck('id')->toArray();

            $packagesToRemove = array_diff($existingPackageIds, $newPackages);
            $packagesToAdd = array_diff($newPackages, $existingPackageIds);

            $delivery->items()->whereIn('package_id', $packagesToRemove)->delete();

            $deliveryItems = [];
            foreach ($packagesToAdd as $packageId) {
                $package = Package::find($packageId);
                $deliveryItems[] = [
                    'package_id' => $packageId,
                    'product_id' => $package->product_id,
                    'quantity' => $package->quantity,
                ];
            }

            $delivery->items()->createMany($deliveryItems);
        });

        // 🔁 Return full updated packages with relations
        $updatedPackages = Package::with(['product', 'depot'])
            ->whereIn('qr_code', $validated['packages'])
            ->get();

        return response()->json([
            'message' => 'Delivery updated successfully',
            'packages' => $updatedPackages,
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Failed to update delivery',
            'details' => $e->getMessage()
        ], 500);
    }
}
public function edit(Delivery $delivery)
{
    $scannedPackages = Package::with(['product', 'depot'])
        ->whereIn('id', $delivery->items()->pluck('package_id'))
        ->get();

    return view('filament.pages.deliveries.edit', compact('delivery', 'scannedPackages'));
}


}
