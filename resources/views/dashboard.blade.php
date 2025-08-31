<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1e293b, #334155);
        }
        .hover-effect:hover { 
            transform: scale(1.05);
            box-shadow: 0 10px 30px rgba(0, 195, 255, 0.4);
        }
    </style>
    <title>Margoum Reports Dashboard</title>
</head>
<body class="bg-gray-900 text-gray-300 flex items-center justify-center min-h-screen px-4">

    <!-- Main Container -->
    <div class="w-full max-w-lg bg-gray-800 text-gray-300 rounded-3xl shadow-lg p-8 space-y-8">
        
        <!-- Welcome Header -->
        <div class="text-center">
            <div class="flex items-center justify-center mb-4">
                <!-- Profile Picture Placeholder -->
                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center">
                    <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
            <h1 class="text-2xl font-extrabold text-cyan-400 tracking-wide">
                Bienvenue, M. ZROUGA
            </h1>
            <p class="text-sm text-gray-400 mt-2">Dashboard de suivi des rapports de Margoum</p>
        </div>

        <!-- Notification -->
        <div class="bg-gray-700 p-4 rounded-lg flex items-start gap-3 shadow-md">
            <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <p><span class="font-semibold text-yellow-300">De Retour !</span> Veuillez trouver ci-joint les derniers rapports pour un suivi optimal.</p>
        </div>

        <!-- Reports Section -->
        <ul class="space-y-4">
            <!-- Stock Actuel -->
            <li>
                <a href="{{ route('stock.download.pdf') }}" 
                   class="block bg-gradient-to-r from-blue-500 to-cyan-500 p-4 rounded-xl text-white font-semibold text-center shadow-md hover-effect transition-transform">
                    📦 Stock Actuel Matière Première
                </a>
            </li>
            <!-- Stock Dans l'Usine -->
            <li>
                <a href="{{ route('stocks.index') }}" 
                   class="block bg-gradient-to-r from-blue-500 to-cyan-500 p-4 rounded-xl text-white font-semibold text-center shadow-md hover-effect transition-transform">
                    🏭 Stock Margoum Dans l'Usine
                </a>
            </li>
            <!-- Stock au Dépôt -->
            {{-- <li>
                <a href="{{ route('stock.show') }}" 
                   class="block bg-gradient-to-r from-blue-500 to-cyan-500 p-4 rounded-xl text-white font-semibold text-center shadow-md hover-effect transition-transform">
                    🏢 Stock Margoum au Dépôt
                </a>
            </li> --}}
            <!-- Production Semi Fini -->
            <li>
                <a href="{{ route('production') }}" 
                   class="block bg-gradient-to-r from-blue-500 to-cyan-500 p-4 rounded-xl text-white font-semibold text-center shadow-md hover-effect transition-transform">
                    ⚙️ Rapport de Production Margoum Semi Fini
                </a>
            </li>
            <!-- Margoum Fini 1er Choix -->
            <li>
                <a href="{{ route('margoum_fini.index') }}" 
                   class="block bg-gradient-to-r from-blue-500 to-cyan-500 p-4 rounded-xl text-white font-semibold text-center shadow-md hover-effect transition-transform">
                    🏆 Rapport Margoum Fini 1er Choix
                </a>
            </li>
            <!-- Margoum Fini 2ème Choix -->
            <li>
                <a href="{{ route('margoum_fini.secondChoix') }}" 
                   class="block bg-gradient-to-r from-blue-500 to-cyan-500 p-4 rounded-xl text-white font-semibold text-center shadow-md hover-effect transition-transform">
                    🎯 Rapport Margoum Fini 2ème Choix
                </a>
            </li>
            <!-- Consommation Matière Première -->
            <li>
                <a href="{{ route('stats') }}" 
                   class="block bg-gradient-to-r from-blue-500 to-cyan-500 p-4 rounded-xl text-white font-semibold text-center shadow-md hover-effect transition-transform">
                    📊 Consommation Matière Première
                </a>
            </li>
            <!-- Suivi Rebobinage -->
            {{-- <li>
                <a href="{{ route('showStats') }}" 
                   class="block bg-gradient-to-r from-blue-500 to-cyan-500 p-4 rounded-xl text-white font-semibold text-center shadow-md hover-effect transition-transform">
                    🔄 Suivi Rebobinage
                </a>
            </li> --}}
        </ul>
    </div>

</body>
</html>
