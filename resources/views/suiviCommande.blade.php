<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Suivi Commande - {{ $code_commande }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @layer utilities {
            .print-hidden {
                @apply hidden print:block;
            }
        }
    </style>
</head>

<body class="bg-gradient-to-r from-gray-100 to-gray-300 text-gray-800 flex justify-center items-center min-h-screen">
    <section id="invoice" class="bg-white p-6 sm:p-10 rounded-lg w-full max-w-6xl my-8">
        <!-- Header -->
        <div class="text-center border-b-2 border-gray-200 pb-4">
            <h1 class="text-3xl font-bold uppercase text-gray-900 tracking-wide">Suivi Commande</h1>
            <p class="text-sm text-gray-500">Usine csp - Suivi de Production</p>
        </div>

        <!-- Commande Information -->
        <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
            <!-- Left Section -->
            <div class="text-sm space-y-1">
                <p><span class="font-medium">Code Commande:</span> {{ $code_commande }}</p>
                <p><span class="font-medium">Client:</span> {{ $client_name }}</p>
                <p><span class="font-medium">Status:</span> 
                    <span class="px-2 py-1 rounded text-xs font-medium 
                        @if($status->value === 'en_cours') bg-yellow-100 text-yellow-800
                        @elseif($status->value === 'termine') bg-green-100 text-green-800
                        @elseif($status->value === 'annule') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $status->value)) }}
                    </span>
                </p>
            </div>
            <!-- Center Logo -->
            <div class="flex justify-center">
                <img src="{{ asset('assets/logo-csp.jpg') }}" alt="CSP Logo" class="w-48 sm:w-60 object-contain">
            </div>
            <!-- Right Section -->
            <div class="text-sm space-y-1 text-right">
                <p><span class="font-medium">Date Commande:</span> {{ $date_commande ? $date_commande->format('d/m/Y') : 'N/A' }}</p>
                <p><span class="font-medium">Date Génération:</span> {{ $formatted_date }}</p>
            </div>
        </div>

        <!-- Articles Table -->
        <div class="mt-8">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Détail des Articles</h2>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse bg-gray-800 border border-gray-300 text-sm text-center">
                    <thead class="text-white">
                        <tr>
                            <th class="border border-gray-300 px-4 py-2">Code Article</th>
                            <th class="border border-gray-300 px-4 py-2">Pieces Commandées</th>
                            <th class="border border-gray-300 px-4 py-2">Pieces Fini</th>
                            <th class="border border-gray-300 px-4 py-2">Pieces Semi-Fini</th>
                            <th class="border border-gray-300 px-4 py-2">Pieces Livrées</th>
                            <th class="border border-gray-300 px-4 py-2">Reste à Livrer</th>
                            <th class="border border-gray-300 px-4 py-2">Reste</th>
                            <th class="border border-gray-300 px-4 py-2">Transféré</th>
                            <th class="border border-gray-300 px-4 py-2">Client Transféré</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($articles as $article)
                            <tr class="odd:bg-gray-100 even:bg-white hover:bg-green-50">
                                <td class="border border-gray-300 px-4 py-2 font-medium">{{ $article['code_article'] }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $article['nombre_de_pieces'] ?? 0 }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $article['nombre_de_pieces_fini'] ?? 0 }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $article['nombre_de_pieces_semi_fini'] ?? 0 }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $article['nombre_de_pieces_livre'] ?? 0 }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $article['nombre_de_pieces_reste_a_livre'] ?? 0 }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $article['rest'] ?? 0 }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $article['qty_transferred'] ?? 0 }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $article['client_transferred_to'] ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Summary Section -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Production Summary -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold mb-3 text-gray-800">Résumé Production</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span>Status Commande:</span>
                        <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $status->value)) }}</span>
                    </div>
                </div>
            </div>

            <!-- Client Information -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold mb-3 text-gray-800">Informations Client</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span>Nom Client:</span>
                        <span class="font-medium">{{ $client_name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Code Commande:</span>
                        <span class="font-medium">{{ $code_commande }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Print Button -->
        <button id="printButton" onclick="printDocument()" class="mt-6 mx-auto block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 print-hidden transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="inline-block w-5 h-5 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
            </svg>
            Imprimer le Suivi
        </button>

       
    </section>

    <script>
        function printDocument() {
            const printButton = document.getElementById('printButton');
            printButton.style.display = 'none';
            window.print();
            printButton.style.display = 'block';
        }
    </script>
</body>

</html> 