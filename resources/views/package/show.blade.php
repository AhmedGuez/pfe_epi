<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Étiquette d'Impression</title>
    <style>
        @page {
            size: 8cm 5cm;
            margin: 0;
        }

        @media print {
            body {
                margin: 0;
                background: white;
            }

            #print-button {
                display: none;
            }
        }

        body {
            background-color: #f4f4f4;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .label {
            width: 8cm;
            height: 5cm;
            padding: 8px;
            font-size: 10px;
            background: white;
            border: 1px solid #333;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .header,
        .footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .details {
            line-height: 1.3;
            flex: 1;
        }

        .details strong {
            display: inline-block;
            width: 70px;
            font-weight: 600;
        }

        .barcode {
            width: 70%;
            height: 30px;
            margin-top: 2px;
        }

        .qr {
            width: 90px;
            height: 90px;
            margin-top: 4px;
        }

        .date {
            font-size: 8px;
            text-align: right;
            margin-bottom: 4px;
        }

        .footer-note {
            font-size: 8px;
            margin-top: 4px;
            text-align: left;
        }

        #print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 8px 12px;
            background-color: #2c2c2c;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            z-index: 9999;
            font-size: 14px;
        }

        #print-button:hover {
            background-color: #000;
        }
    </style>
</head>
<body>

    <button id="print-button" onclick="window.print()">🖨️ Imprimer</button>

    <div class="label">
        <div class="header">
            <div class="details">
                <strong>Qualité :</strong> {{ $qrData['quality'] ?? 'NA' }}<br>
                <strong>Référence :</strong> {{ $qrData['design_code'] ?? 'NA' }}<br>
                <strong>Couleur :</strong> {{ $qrData['color'] ?? 'NA' }}<br>
                <strong>Taille :</strong> {{ $qrData['size'] ?? 'NA' }}<br>
                <strong>Quantité :</strong> {{ $package->quantity ?? 'NA' }}<br>
                <strong>Commande :</strong> {{ $qrData['order'] ?? 'NA' }}
            </div>
            <div style="text-align: right;">
                <div class="date">{{ now()->format('y.m.d') }}</div>
                <img src="{{ $qrCode }}" alt="QR Code" class="qr">
            </div>
        </div>

        <div class="footer">
            <div style="flex: 1;">
                <img 
                    src="https://barcode.tec-it.com/barcode.ashx?data={{ $record->ean ?? '6191739805470' }}&code=EAN13&translate-esc=true" 
                    alt="Code-barres" class="barcode">
                <div class="footer-note">
                    Sté de Confection des Sacs Polypropylènes
                </div>
            </div>
        </div>
    </div>

</body>
</html>
