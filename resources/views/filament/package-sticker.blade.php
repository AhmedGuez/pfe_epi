<!DOCTYPE html>
<html lang="fr">
<head>
    <style>
@import url('https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap');
</style>
    <meta charset="UTF-8">
    <title>Étiquette Produit</title>
    <style>
         @page {
            size: 90mm 60mm;
            margin: 0;
        }
        
        body {
            margin: 0;
            padding: 0;
            width: 80mm;
            height: 60mm;
            font-family: "Oswald", sans-serif;
            font-optical-sizing: auto;
            font-weight: <weight>;
            font-style: normal;
            font-size: 14px;
        }
        
        .label {
            width: 100%;
            height: 100%;
            padding: 2mm;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /*
         * Header section containing product details and QR code, arranged horizontally.
         */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-grow: 1; /* Allows header to take available space */
        }

        /*
         * Styling for the product details section. Line height is adjusted for better spacing.
         */
        .details {
            line-height: 1.6; /* Adjusted line height for compactness */
            flex-grow: 1; /* Allows details to take available space */
            font-size: 14px;
        }

        /*
         * Styling for strong tags within details, ensuring consistent width for labels.
         */
        .details strong {
            width: 38mm; /* Adjusted width for labels */
            font-weight: bold;
        }

        /*
         * Container for the QR code, aligned to the right.
         */
        .qr-container {
            text-align: right;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            justify-content: flex-start;
        }

        /*
         * Styling for QR code image/SVG, ensuring it fits the label.
         */
        .qr-container img,
        .qr-container svg {
            width: 32mm !important; /* Adjusted QR code size */
            height: 32mm !important; /* Adjusted QR code size */
            margin-top: 1mm; /* Small margin to separate from date */
        }

        /*
         * Styling for the date above the QR code.
         */
        .qr-container .date-text {
            font-size: 7.5pt; /* Adjusted font size for date */
            margin-bottom: 0.5mm; /* Reduced margin */
        }

        /*
         * Styling for the barcode image.
         */
        .barcode {
            width: 28mm; /* Adjusted barcode width slightly for better fit with larger text */
            height: auto;
            margin-top: -8px; /* Adjusted negative margin to pull it closer to the details */
            display: block; /* Ensures barcode is on its own line */
            margin-left: 0; /* Center barcode horizontally */
            margin-right: auto; /* Center barcode horizontally */
        }

        /*
         * Styling for the barcode number text.
         */
        .barcode-text {
            text-align: start; /* Center the barcode number */
            font-size: 12px; /* Adjusted font size for barcode number */
            margin-top: 0.5mm;
             margin-left: 2; /* Small margin above the text */
        }

        /*
         * Footer styling for company information.
         */
        .footer {
            font-size: 12px; /* Adjusted footer font size */
            text-align: center;
            margin-top: 1mm; /* Small margin above the footer */
            clear: both; /* Ensures footer is below floated/flexed elements */
        }

        /*
         * Print-specific styles to ensure only the label is visible when printing.
         */
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            .label {
                page-break-after: always;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="label">
        <div class="header">
            <div class="details gap-1 mb-3">
                <div><strong>Qualité :</strong> {{ $package->product->quality }}</div>
                <div><strong>Référence :</strong> <br> <span style="font-size:18px;font-weight:bold;">{{ $package->product->code_article }}</span> </div>
                <div><strong>Couleur :</strong> {{ $package->product->color }}</div>
                <div><strong>Taille :</strong> {{ $package->product->largeur }} x {{ $package->product->hauteur }}</div>
                <div><strong>Quantité :</strong> {{ $package->quantity }}</div>
            </div>
            <div class="qr-container">
                <div class="qr-code-text">
                  <strong> #{{ substr($package->qr_code, -5) }}</strong> 
                </div>
                <div class="date-text">
                    {{-- Date: {{ $package->created_at->format('d.m.Y') }} --}}
                </div>
                {!! $qrCode !!}
            </div>
            
        </div>
        <?php
        // PHP code to generate the barcode (assuming Picqer\Barcode is available in the Laravel environment)
        use Picqer\Barcode\BarcodeGeneratorPNG;
        $generator = new BarcodeGeneratorPNG();
        $code = '6191739805470'; // Example barcode number
        $barcode = base64_encode($generator->getBarcode($code, $generator::TYPE_EAN_13));
        ?>
        <div>
            <img src="data:image/png;base64,{{ $barcode }}"
                 alt="Code-barres"
                 class="barcode" style="margin-top: 3px">
            <div class="barcode-text">{{ $code }}</div>
            <div class="footer">
                &copy; {{ date('Y') }} Sté de Confection des Sacs Polypropylènes<br>
            </div>
        </div>
    </div>

    <script>
    window.onload = () => {
        window.print();
        setTimeout(() => window.close(), 1000); // Closes the tab 1 second after print
    };
</script>

</body>

</html>
