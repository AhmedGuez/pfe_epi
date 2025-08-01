<?php
namespace App\Http\Controllers;

use App\Models\Package; // Your package model
use Illuminate\Http\Request;

class PackageInfoController extends Controller
{
   public function show($qrCode)
{
    $normalized = str_replace('-', '', $qrCode);

    $package = Package::with(['product', 'depot'])
        ->where('qr_code', $qrCode)
        ->orWhere('qr_code', $normalized)
        ->first();

    if (!$package) {
        return response()->json(['error' => 'Package not found'], 404);
    }

    return response()->json([
        'qr_code' => $package->qr_code,
        'quantity' => $package->quantity,
        'product' => $package->product,
        'depot' => $package->depot,
        'last_movement_date' => optional($package->updated_at)->toDateTimeString(),
    ]);
}

}
