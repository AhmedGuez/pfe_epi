<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Bon de Livraison - {{ $delivery->bnl_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @page {
            size: A4;
            margin: 10mm;
        }
        @media print {
            body {
                background: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                font-size: 12px !important;
            }
            .no-print {
                display: none !important;
            }
            #invoice {
                box-shadow: none !important;
                border: none;
                margin: 0 !important;
                padding: 0 !important;
                width: 100%;
                max-width: 100%;
            }
            /* Force flex on client/delivery info for print */
            .print\\:flex {
                display: flex !important;
            }
            /* Reduce table font size further on print */
            table {
                font-size: 0.75rem !important;
            }
            /* Avoid scroll in print, allow table to break pages nicely */
            .max-h-[450px] {
                max-height: none !important;
                overflow: visible !important;
            }
            /* Signatures flex in print */
            .signatures-print-flex {
                display: flex !important;
                flex-wrap: wrap;
                justify-content: space-between;
                align-items: center;
            }
            .signatures-print-flex > div {
                width: 48% !important;
                text-align: center !important;
                border-top: 1px solid #9ca3af;
                padding-top: 0.75rem;
            }
            .signatures-print-flex .cachet {
                width: 100% !important;
                margin-top: 0.5rem !important;
                text-align: center !important;
                font-size: 0.75rem !important;
                color: #6b7280 !important;
            }
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen p-4 print:p-0 text-sm">
    <section id="invoice" class="bg-white p-8 sm:p-10 rounded-lg shadow-md w-full max-w-4xl mx-auto print:shadow-none print:max-w-full print:p-4">

        <!-- Header with Logo -->
        <div class="flex flex-col sm:flex-row justify-between items-center border-b-2 border-gray-200 pb-6">
            <div class="flex items-center gap-4 w-full sm:w-auto mb-4 sm:mb-0">
                <img src="{{ asset('assets/logo-csp.jpg') }}" alt="Logo" class="h-24 w-auto object-contain">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold uppercase text-gray-900 tracking-wider">Bon de Livraison</h1>
                    <p class="text-sm text-gray-600 mt-1">N°: <span class="font-semibold">{{ $delivery->bnl_number }}</span></p>
                </div>
            </div>
            <div class="text-center sm:text-right text-sm">
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
                <p><strong>Heure:</strong> {{ \Carbon\Carbon::parse($time)->format('H:i') }}</p>
            </div>
        </div>

        <!-- Client, Employee or Transfer Info + Livraison Info -->
        <div class="mt-6 flex flex-col md:grid md:grid-cols-2 gap-6 text-sm print:flex print:flex-row print:gap-6">

            @if($delivery->client)
                <div class="bg-gray-50 p-5 rounded-lg border print:w-[48%]">
                    <h2 class="font-semibold text-gray-700 mb-2">Client</h2>
                    <p><span class="font-medium">Entreprise:</span> {{ $delivery->client->nom_entreprise ?? 'N/A' }}</p>
                    <p><span class="font-medium">Nom:</span> {{ $delivery->client->nom ?? 'N/A' }} {{ $delivery->client->prenom ?? '' }}</p>
                    <p><span class="font-medium">Adresse:</span> {{ $delivery->client->adresse ?? 'N/A' }}</p>
                    <p><span class="font-medium">Tél:</span> {{ $delivery->client->telephone ?? 'N/A' }}</p>
                    @if($delivery->client->matricule_fiscale)
                        <p><span class="font-medium">Matricule Fiscale:</span> {{ $delivery->client->matricule_fiscale }}</p>
                    @endif
                </div>
            @elseif($delivery->employee)
                <div class="bg-gray-50 p-5 rounded-lg border print:w-[48%]">
                    <h2 class="font-semibold text-gray-700 mb-2">Employé</h2>
                    <p><span class="font-medium">Nom complet:</span> {{ $delivery->employee->full_name ?? 'N/A' }}</p>
                    <p><span class="font-medium">Email:</span> {{ $delivery->employee->email ?? 'N/A' }}</p>
                    {{-- Add more employee details here if needed --}}
                </div>
            @elseif($delivery->type === 'transfer')
                <div class="bg-gray-50 p-5 rounded-lg border print:w-[48%]">
                    <h2 class="font-semibold text-gray-700 mb-2">Transfert de dépôt</h2>
                    <p><span class="font-medium">Depôt Source:</span> {{ $delivery->fromDepot->name ?? 'N/A' }}</p>
                    <p><span class="font-medium">Depôt Destination:</span> {{ $delivery->toDepot->name ?? 'N/A' }}</p>
                </div>
            @else
                <div class="bg-gray-50 p-5 rounded-lg border print:w-[48%]">
                    <h2 class="font-semibold text-gray-700 mb-2">Information</h2>
                    <p>Aucune information client/employee/transfer disponible.</p>
                </div>
            @endif

            <!-- Livraison Info -->
            <div class="bg-gray-50 p-5 rounded-lg border print:w-[48%]">
                <h2 class="font-semibold text-gray-700 mb-2">Livraison</h2>
                <p><span class="font-medium">Camion:</span> {{ $delivery->car_number ?? 'N/A' }}</p>
                <p><span class="font-medium">Type:</span> {{ ucfirst($delivery->type ?? 'N/A') }}</p>
                @if($delivery->employee)
                    <p><span class="font-medium">Employé:</span> {{ $delivery->employee->full_name ?? 'N/A' }}</p>
                @endif
            </div>
        </div>

        <!-- Products Table -->
        <!-- Products Table -->
<div class="mt-8 overflow-x-auto max-h-[450px] overflow-y-auto border border-gray-300 rounded print:max-h-full print:overflow-visible">
    <table class="w-full text-xs border-collapse border border-gray-300">
        <thead class="bg-gray-800 text-white uppercase text-[0.7rem]">
            <tr>
                <th class="px-2 py-1 border">Désignation</th>
                <th class="px-2 py-1 border">Code</th>
                <th class="px-2 py-1 border">Dimensions</th>
                <th class="px-2 py-1 border">Couleur</th>
                <th class="px-2 py-1 border">Quantité</th>
                @if(!$delivery->employee)
                    <th class="px-2 py-1 border">Prix U.</th>
                    <th class="px-2 py-1 border">Total</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @php
                $groupedItems = $delivery->items->groupBy(fn($item) => $item->product->code_article);
            @endphp

            @foreach($groupedItems as $codeArticle => $items)
                @php
                    $first = $items->first();
                    $product = $first->product;
                    $totalQuantity = $items->sum(fn($item) => $item->package->quantity);
                    $totalPrice = $product->prix * $totalQuantity;
                @endphp
                <tr class="even:bg-gray-50 text-[0.75rem]">
                    <td class="px-2 py-1 border text-center">{{ $product->quality }}</td>
                    <td class="px-2 py-1 border text-center">{{ $codeArticle }}</td>
                    <td class="px-2 py-1 border text-center">
                        {{ $product->largeur ?? 'N/A' }}m × {{ $product->hauteur ?? 'N/A' }}m
                    </td>
                    <td class="px-2 py-1 border text-center">{{ $product->color }}</td>
                    <td class="px-2 py-1 border text-center">{{ $totalQuantity }} Pièces</td>
                    @if(!$delivery->employee)
                        <td class="px-2 py-1 border text-right">{{ number_format($product->prix, 3) }} DT</td>
                        <td class="px-2 py-1 border text-right">{{ number_format($totalPrice, 3) }} DT</td>
                    @endif
                </tr>
            @endforeach

            @php
                $subtotal = $delivery->items->sum(fn($item) => $item->product->prix * $item->package->quantity);
                $tva = $delivery->client && $delivery->client->tva ? $subtotal * 0.19 : 0;
                $total = $subtotal + $tva;
            @endphp

            @if(!$delivery->employee)
                <tr class="bg-gray-100 font-semibold text-[0.75rem]">
                    <td colspan="5" class="px-2 py-1 text-right border">Sous-total</td>
                    <td colspan="2" class="px-2 py-1 text-right border">{{ number_format($subtotal, 3) }} DT</td>
                </tr>
                @if($delivery->client && $delivery->client->tva)
                <tr class="bg-gray-100 font-semibold text-[0.75rem]">
                    <td colspan="5" class="px-2 py-1 text-right border">TVA (19%)</td>
                    <td colspan="2" class="px-2 py-1 text-right border">{{ number_format($tva, 3) }} DT</td>
                </tr>
                @endif
                <tr class="bg-gray-800 text-white font-bold text-[0.75rem]">
                    <td colspan="5" class="px-2 py-1 text-right border">Total {{ ($delivery->client && $delivery->client->tva) ? 'TTC' : 'HT' }}</td>
                    <td colspan="2" class="px-2 py-1 text-right border">{{ number_format($total, 3) }} DT</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

<div class="flex justify-between mt-4 print:mt-2">
    <div class="flex gap-6">
        <div class="text-sm font-semibold">
            <span class="text-gray-600">Total Pièces:</span>
            <span class="ml-2">{{ $totalPieces }}</span>
        </div>
        <div class="text-sm font-semibold">
            <span class="text-gray-600">Total Colis:</span>
            <span class="ml-2">{{ $totalPackages }}</span>
        </div>
    </div>
</div>

        <!-- Signatures -->
        <div class="flex flex-wrap justify-between gap-6 w-full items-center mt-6 print:mt-8 signatures-print-flex">
            <div>
                <p class="font-medium">Signature Chauffeur</p>
                {{-- Signature line if you want: <div class="mt-3 h-12 border-b border-gray-400"></div> --}}
            </div>

            <div>
                <p class="font-medium">Signature Client</p>
                {{-- Signature line if you want --}}
            </div>

            <!-- Centered Cachet text spanning full width -->
            <div class="cachet">
                <p>Cachet de l'entreprise</p>
            </div>
        </div>

        <!-- Print Button -->
        <div class="mt-10 text-center no-print">
            <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow inline-flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd"/>
                </svg>
                Imprimer
            </button>
        </div>

         <!-- Footer -->
        <div class="mt-10 text-center text-xs text-gray-500 border-t pt-4">
            <img src="{{ asset('assets/logo-csp.jpg') }}" alt="Logo Footer" class="mx-auto h-24 opacity-60 mb-2">
            <p>Sté de Confection des Sacs Polypropylènes</p>
            <p class="mt-1">Adresse: Zone industrielle, Tunisie | Tél: +216 73 000 000 | Email: commercial@cnp.com.tn</p>
            <p class="mt-2">&copy; {{ date('Y') }} Tous droits réservés</p>
        </div>
