<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande #{{ $commande->code_commande }}</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            background-color: #fff;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 20px;
            position: relative;
        }

        .header::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background-color: #2563eb;
        }

        .header h1 {
            color: #2563eb;
            font-size: 28px;
            margin: 0 0 10px 0;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header h2 {
            color: #374151;
            font-size: 18px;
            margin: 0;
            font-weight: 600;
        }

        .company-info, .client-info, .commande-details {
            margin-bottom: 25px;
            background-color: #f8fafc;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #2563eb;
        }

        .company-info h3, .client-info h3, .commande-details h3 {
            color: #2563eb;
            font-size: 14px;
            margin: 0 0 15px 0;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .info-item {
            margin-bottom: 8px;
        }

        .info-label {
            font-weight: 600;
            color: #374151;
            display: inline-block;
            min-width: 120px;
        }

        .commande-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .commande-table th {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            padding: 12px 8px;
            text-align: left;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .commande-table td {
            border: 1px solid #e5e7eb;
            padding: 10px 8px;
            background-color: #fff;
            font-size: 11px;
        }

        .commande-table tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .commande-table tbody tr:hover {
            background-color: #e0f2fe;
        }

        .total-section {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            padding: 20px;
            border-radius: 8px;
            border: 2px solid #2563eb;
            margin-top: 25px;
        }

        .total-section h3 {
            color: #2563eb;
            font-size: 16px;
            margin: 0 0 15px 0;
            font-weight: 700;
            text-align: center;
        }

        .total-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            text-align: center;
        }

        .total-item {
            padding: 10px;
            background-color: white;
            border-radius: 6px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .total-label {
            font-weight: 600;
            color: #374151;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .total-value {
            font-size: 14px;
            font-weight: 700;
            color: #2563eb;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
        }

        .footer p {
            margin: 5px 0;
        }

        .no-print {
            margin-top: 20px;
            text-align: center;
        }

        .no-print button {
            background-color: #2563eb;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            margin: 0 5px;
            transition: background-color 0.2s;
        }

        .no-print button:hover {
            background-color: #1d4ed8;
        }

        @media print {
            body {
                margin: 0;
                padding: 15px;
                font-size: 11px;
            }

            .header {
                margin-bottom: 20px;
            }

            .company-info, .client-info, .commande-details {
                margin-bottom: 15px;
                padding: 10px;
            }

            .commande-table {
                font-size: 10px;
                margin-bottom: 15px;
            }

            .commande-table th,
            .commande-table td {
                padding: 6px 4px;
            }

            .total-section {
                margin-top: 15px;
                padding: 15px;
            }

            .footer {
                margin-top: 25px;
                font-size: 9px;
            }

            .no-print {
                display: none !important;
            }

            .info-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .header h1 {
                font-size: 24px;
            }

            .header h2 {
                font-size: 16px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .total-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Commande Client</h1>
        <h2>Commande #{{ $commande->code_commande }}</h2>
    </div>

    <div class="company-info">
        <h3>Informations du Client</h3>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Nom de l'entreprise:</span>
                {{ $commande->client->nom_entreprise ?? 'N/A' }}
            </div>
            <div class="info-item">
                <span class="info-label">Adresse:</span>
                {{ $commande->client->adresse ?? 'N/A' }}
            </div>
            <div class="info-item">
                <span class="info-label">Téléphone:</span>
                {{ $commande->client->telephone ?? 'N/A' }}
            </div>
            <div class="info-item">
                <span class="info-label">Email:</span>
                {{ $commande->client->email ?? 'N/A' }}
            </div>
        </div>
    </div>

    <div class="commande-details">
        <h3>Détails de la Commande</h3>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Code Commande:</span>
                {{ $commande->code_commande }}
            </div>
            <div class="info-item">
                <span class="info-label">Date de Commande:</span>
                {{ $commande->date_commande ? \Carbon\Carbon::parse($commande->date_commande)->format('d/m/Y') : 'N/A' }}
            </div>
            <div class="info-item">
                <span class="info-label">Statut:</span>
                <span style="color: #2563eb; font-weight: 600;">{{ $commande->status->value ?? 'N/A' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Date de Création:</span>
                {{ $commande->created_at ? \Carbon\Carbon::parse($commande->created_at)->format('d/m/Y H:i') : 'N/A' }}
            </div>
        </div>
    </div>

    <div class="articles-section">
        <h3>Articles de la commande</h3>
        <table class="commande-table">
            <thead>
                <tr>
                    <th>Code Article</th>
                    <th>Nom Article</th>
                    <th>Quantité Demandée</th>
                    <th>Prix Unitaire</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($commande->commandeArticles as $article)
                    <tr>
                        <td>{{ $article->product->code_article ?? 'N/A' }}</td>
                        <td>{{ $article->product->nom ?? 'N/A' }}</td>
                        <td>{{ $article->nombre_de_pieces ?? 0 }}</td>
                        <td>{{ number_format($article->prix_unitaire ?? 0, 2) }} DT</td>
                        <td>{{ number_format(($article->nombre_de_pieces ?? 0) * ($article->prix_unitaire ?? 0), 2) }} DT</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center;">Aucun article trouvé</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="total-section">
        <h3>Récapitulatif de la Commande</h3>
        <div class="total-grid">
            <div class="total-item">
                <div class="total-label">Nombre total d'articles</div>
                <div class="total-value">{{ $commande->commandeArticles->sum('nombre_de_pieces') }}</div>
            </div>
            <div class="total-item">
                <div class="total-label">Montant total</div>
                <div class="total-value">{{ number_format($commande->commandeArticles->sum(function($article) { return ($article->nombre_de_pieces ?? 0) * ($article->prix_unitaire ?? 0); }), 2) }} DT</div>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>Document généré le {{ \Carbon\Carbon::now()->format('d/m/Y à H:i') }}</p>
        <p>Ce document est généré automatiquement par le système de gestion</p>
    </div>

    <div class="no-print" style="margin-top: 20px; text-align: center;">
        <button onclick="window.print()">Imprimer</button>
        <button onclick="window.close()">Fermer</button>
    </div>
</body>
</html> 