<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function show($qrCode)
    {
        // Try with and without dashes since QR codes might be scanned differently
        $package = Package::with('depot', 'product')
            ->where('qr_code', $qrCode)
            ->orWhere('qr_code', str_replace('-', '', $qrCode))
            ->first();

        if (!$package) {
            return response()->json(['error' => 'Package not found'], 404);
        }

        return response()->json($package);
    }

   // In PackageController.php
public function search(Request $request)
{
    $request->validate([
        'qr' => 'required|string|min:5'
    ]);

    $partialQr = $request->input('qr');
    $packages = Package::where('qr_code', 'LIKE', '%'.$partialQr)
        ->with(['product', 'depot'])
        ->limit(5)
        ->get();

    return response()->json($packages);
}
}
