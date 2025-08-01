<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PackageTicketController extends Controller
{
    public function print(Package $package)
    {
        $qrCode = QrCode::size(90)
            ->format('svg')
            ->generate($package->qr_code);
    
        return view('package-label', [
            'package' => $package,
            'qrCode' => $qrCode
        ]);
    }
}
