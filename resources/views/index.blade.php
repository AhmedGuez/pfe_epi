<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1e293b, #334155);
        }
        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 195, 255, 0.2);
        }
    </style>
</head>

<body class="min-h-screen bg-gray-900 text-gray-200 flex flex-col">
    <!-- Main Container -->
    <div class="container mx-auto p-6 flex-grow">
        <!-- Logo Section -->
        <div class="flex justify-center mb-12">
            <img src="{{ asset('assets/logo-csp.jpg') }}" alt="CSP Logo" class="h-24 w-auto object-contain">
        </div>

        <!-- Cards Section -->
        <div class="grid gap-8 sm:grid-cols-1 md:grid-cols-2">
            <!-- Margoum Section -->
            <div class="bg-gray-800 hover-card p-8 rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                <h2 class="text-xl font-bold mb-4 text-teal-400">Usine Margoum</h2>
                <p class="text-gray-300 mb-6 leading-relaxed">
                    Accédez à tous les rapports et statistiques pour l'Usine Margoum. Découvrez des informations sur la production, les stocks et les indicateurs de performance.
                </p>
                <a href="{{ route('dashboard') }}"
                    class="inline-block bg-teal-500 hover:bg-teal-600 text-white font-bold py-2 px-6 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-teal-300 transition">
                    Explorez Usine Margoum
                </a>
            </div>

            <!-- Tapis Section -->
            <div class="bg-gray-800 hover-card p-8 rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                <h2 class="text-xl font-bold mb-4 text-purple-400">Usine Tapis</h2>
                <p class="text-gray-300 mb-6 leading-relaxed">
                    Accédez à tous les rapports et statistiques pour l'Usine Tapis. Explorez des données détaillées sur les opérations, les stocks et les mesures d'efficacité.
                </p>
                <a href="{{ route('dashboard.tapis') }}"
                    class="inline-block bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-6 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-purple-300 transition">
                    Explorez Usine Tapis
                </a>
            </div>
        </div>
    </div>

    <!-- Footer Section -->
    <footer class="bg-gray-800 text-gray-400 text-center py-6">
        <p>&copy; 2025 STIT Company. Tous droits réservés.</p>
    </footer>
</body>

</html>
