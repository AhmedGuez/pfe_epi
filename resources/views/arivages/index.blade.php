<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latest Arrivages</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f3f4f6;
            font-family: 'Arial', sans-serif;
        }
        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
        .article-details {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-5 px-4">
        <h2 class="mb-4 text-center font-bold text-2xl text-gray-800">Latest Arrivages</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border-2 border-gray-800 shadow-lg rounded-lg">
                <thead>
                    <tr class="bg-gray-800 text-gray-800 text-sm leading-normal border-2 border-gray-800">
                        <th class="py-3 px-4 border-2 border-gray-800">Creation Date</th>
                        <th class="py-3 px-4 border-2 border-gray-800">Articles</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light border-2 border-gray-800">
                    @foreach($latestArrivages as $arrivage)
                        <tr class="border-2 border-gray-800 hover:bg-gray-100">
                            <td class="py-3 px-4 border-2 border-gray-800 text-xs font-bold text-center">{{ $arrivage->creation_date}}</td>
                            <td class="py-3 px-4 border-2 border-gray-800">
                                @foreach($arrivage->articles as $article)
                                    <div class="article-details">
                                        <table>
                                            <tr>
                                                <th>Category Level</th>
                                                <th>Name</th>
                                            </tr>
                                            <tr>
                                                <td>Parent</td>
                                                <td>{{ $article->categorie->parent->parent->name ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Child</td>
                                                <td>{{ $article->categorie->parent->name ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Grandchild</td>
                                                <td>{{ $article->categorie->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Article</td>
                                                <td>{{ $article->article->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Quantity</td>
                                                <td>{{ $article->quantity }} {{ $article->unite }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.js"></script>
</body>
</html>
