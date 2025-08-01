<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class PackageStickerController extends Controller
{
   public function print(Package $package)
{
    $qrCode = QrCode::size(120)->generate($package->qr_code); // Adjust size if needed
    return view('filament.package-sticker', [
        'package' => $package,
        'qrCode' => $qrCode,
    ]);
}
}
