<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bon de Livraison</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @layer utilities {
            .print-hidden {
                @apply hidden print:block;
            }
        }
    </style>
</head>

<body class="bg-gradient-to-r from-gray-100 to-gray-300 text-gray-800 flex justify-center items-center max-h-screen">
    <section id="invoice" class="bg-white p-6 sm:p-10 rounded-lg  w-full max-w-4xl">
        <!-- Header -->
        <div class="text-center border-b-2 border-gray-200 pb-4">
            <h1 class="text-2xl font-bold uppercase text-gray-900 tracking-wide">Bon de Sortie</h1>
            <p class="text-sm text-gray-500">Usine Tapis</p>
        </div>

        <!-- Invoice Information -->
        <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
            <!-- Left Section -->
            <div class="text-sm space-y-1">
                <p><span class="font-medium">Code:</span> {{ $bon_livraison_number }}</p>
                <p><span class="font-medium">Nom Client:</span> {{ $deliverd->nom_client }}</p>
            </div>
            <!-- Center Logo -->
            <div class="flex justify-center">
                <img src="{{ asset('assets/logo.svg') }}" alt="Company Logo" class="w-48 sm:w-60">
            </div>
            <!-- Right Section -->
            <div class="text-sm space-y-1 text-right">
                <p><span class="font-medium">Date de Création:</span> {{ $date }}</p>
                <p><span class="font-medium">Heure de Création:</span> {{ $time }}</p>
                <p><span class="font-medium">Matricule Camion:</span> {{ $camion }}</p>
            </div>
        </div>

        <!-- Table -->
        <div class="mt-8">
            <table class="w-full border-collapse bg-gray-800 border border-gray-300 text-sm text-center">
                <thead class=" text-white">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">Référence Article</th>
                        <th class="border border-gray-300 px-4 py-2">Quantité</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($articles as $article)
                        <tr class="odd:bg-gray-100 even:bg-white hover:bg-green-50">
                            <td class="border border-gray-300 px-4 py-2">{{ $article['code_article'] }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $article['quantity'] }} Pièces</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Signatures -->
        <div class="flex flex-col sm:flex-row justify-between gap-4 mt-8">
            <div class="border border-gray-300 rounded-lg p-4 w-full sm:w-2/5">
                <p class="font-medium">Nom Chauffeur: {{ $chauffeur }}</p>
                <p class="mt-6 font-medium">Signature:</p>
            </div>
            <div class="border border-gray-300 rounded-lg p-4 w-full sm:w-2/5">
                <p class="font-medium">Nom Magasinier: {{ $createdBy }}</p>
                <p class="mt-6 font-medium">Signature:</p>
            </div>
        </div>

        <!-- Print Button -->
        <button id="printButton" onclick="printDocument()" class="mt-6 mx-auto block bg-white text-black border border-gray-500 px-4 py-2 rounded-lg hover:bg-gray-200 print-hidden">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="inline-block w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
            </svg>
        </button>

        <!-- Footer -->
        <div class="text-center text-sm text-gray-500 mt-6">
            <p>&copy; 2025 Ste Tunisienne Industrielle des Tapis. Tous droits réservés.</p>
        </div>
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
