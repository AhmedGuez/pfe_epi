<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bon de Sortie</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-gray-100 via-gray-200 to-gray-300 flex justify-center items-center max-h-screen">

    <section id="invoice" class="bg-white p-8 rounded-xl w-[800px] max-w-screen-xl mx-4 animate__animated animate__fadeIn ">

        <div class=" text-center">
            <h1 class="text-2xl font-semibold uppercase tracking-wide mr-16">Bon De Sortie Matiére Premiére</h1>
            <h6 class="text-sm mr-16 mb-16"></h6>
        </div>

        <div class="flex justify-between items-center mb-6">
            <div class="text-xs space-y-2">
                <p><span class="font-medium">Code : </span>{{ $bonSortieNumber }}</p>
                <p><span class="font-medium">Livré à : </span>{{ $deliverd }}</p>
            </div>
            <div>
                <img src="{{ asset('assets/logo-csp.jpg') }}" alt="Company Logo" class="w-60 mx-auto">
            </div>
            <div class="text-xs space-y-2">
                <p><span class="font-medium">Date de Création :</span> {{ $date }}</p>
                <p><span class="font-medium">Heure de Création :</span> {{ $time }}</p>
            </div>
        </div>

        <div class="py-4">
            <table class="table-auto w-full text-center text-xs">
                <thead>
                    <tr class="">
                        <th class="border bg-gray-900 border-gray-300 px-4 py-2 text-white">Catégories</th>
                        <th class="border bg-gray-900 border-gray-300 px-4 py-2 text-white">Code Article</th>
                        <th class="border bg-gray-900 border-gray-300 px-4 py-2 text-white">Quantité</th>
                        <th class="border bg-gray-900 border-gray-300 px-4 py-2 text-white">Unité</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($articles as $article)
                    <tr class="bg-gray-50 hover:bg-teal-50 transition-all">
                        <td class="border border-gray-300 px-4 py-2">
                            @foreach($article['categories'] as $category)
                                {{ $category }} @if (!$loop->last) / @endif
                            @endforeach
                        </td>
                        <td class="border border-gray-300 px-4 py-2">{{ $article['code_article'] }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $article['quantity'] }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $article['unite'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex justify-between mt-8 text-xs">
            <div class="border border-gray-300 rounded-lg p-6 w-2/5 text-start">
                <p class="font-medium">Nom Résponsable : {{ $createdBy }}</p>
                <p class="mt-6 font-medium">Signature :</p>
            </div>
            <div class="border border-gray-300 rounded-lg p-6 w-2/5 text-start">
                <p class="font-medium">Commande reçu par :</p>
                <p class="mt-6 font-medium">Signature :</p>
            </div>
            
        </div>

        <button id="printButton" onclick="printDocument()" class="mt-6 mx-auto block bg-gray-100 text-gray-900 px-4 py-2 rounded-lg border-2 border-gray-500 hover:bg-gray-200">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="inline-block w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
            </svg>
        </button>

        <div class="text-center text-sm text-gray-500 mt-8 font-semibold">
            <p>&copy; 2025 Sté de Confection des Sacs Polypropylènes. All rights reserved.</p>
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
