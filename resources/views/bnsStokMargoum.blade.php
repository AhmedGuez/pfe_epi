<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bon de Sortie Margoum </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to right, #f8f9fa, #e0e0e0);
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        #invoice {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            max-width: 90%;
            width: 1200px;
            margin: 20px auto;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        h1 {
            color: #009879;
            margin-bottom: 20px;
            font-weight: 700;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .table thead th {
            background-color: #009879;
            color: #ffffff;
            text-align: center;
            border-bottom: 2px solid #007a5e;
        }

        .table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }

        .table tbody tr:hover {
            background-color: #e0f7fa;
            transition: background-color 0.3s;
        }

        .table tbody tr:last-of-type {
            border-bottom: 2px solid #009879;
        }

        .table tbody td {
            text-align: center;
            padding: 12px;
            border: 1px solid #dddddd;
        }

        .table {
            margin-top: 20px;
        }

        .fw-medium {
            font-weight: 500;
        }

        .signature-table th, .signature-table td {
            border: none;
            padding: 12px;
            vertical-align: middle;
        }

        .signature-block {
            margin-top: 40px;
            text-align: center;
        }

        .signature-section {
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin-top: 20px;
        }

        .signature-box {
            width: 45%;
            padding: 20px;
            border: 1px solid #009879;
            border-radius: 5px;
            text-align: center;
        }

        .signature-box span {
            display: block;
            margin-top: 10px;
            /* border-bottom: 1px solid #000; */
        }

        .logo {
            width: 350px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .info-section p {
            margin: 0;
            padding: 0.5rem 0;
        }

        .info-section span {
            display: block;
        }

        .bg-light-custom {
            background-color: #f7f7f7;
        }

        .text-primary-custom {
            color: #009879;
        }

        @media (max-width: 768px) {
            .d-md-flex {
                display: block !important;
            }

            .signature-section {
                flex-direction: column;
                gap: 20px;
            }

            .signature-box {
                width: 80%;
            }
        }

        /* New Additions */
      

        .button-print {
            background-color: #009879;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 20px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .button-print:hover {
            background-color: #007a5e;
            transition: background-color 0.3s;
        }

        .table thead th, .table tbody td {
            transition: background-color 0.3s;
        }

        .header, .footer {
            background-color: #009879;
            color: white;
            padding: 10px 0;
            text-align: center;
        }

        .footer {
            margin-top: 40px;
        }

        .content-wrapper {
            padding: 30px;
            border: 2px solid #ddd;
            border-radius: 10px;
            margin-top: 20px;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <section id="invoice" class="gradient-border">
        <div class="header">
            <h1 style="color: white; padding:5px 20px;">Bon De Sortie Margoum Au Stock</h1>
        </div>
        <div class="px-5 pt-5 content-wrapper">
            <div class=" justify-content-between align-items-center d-flex mb-5">
                <div class= "info-section " style="font-size: 16px">
                    <p><span class="fw-medium">Code :</span> {{$bonSortieNumber}}</p>
                    <p><span class="fw-medium">Date de Création :</span> {{$date}}</p>
                </div>
                <div>
                    <img width="250" src="{{ asset('assets/logo-csp.jpg') }}" alt="CSP Logo" class="logo object-contain">
                </div>
                <div class= "info-section " style="font-size: 16px">
                    <p><span class="fw-medium">Heure de Création :</span> {{$time}}</p>
                </div>
               
            </div>
            

            <div class="py-1">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Code Article</th>
                            <th>Quantité</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($articles as $article)
                            <tr>
                                <td>{{ $article['code_article'] }}</td>
                                <td>{{ $article['quantity'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        
            </div>

            <div class="signature-block">
                <div class="signature-section">
                    <div class="signature-box text-start">
                        <span class="fw-medium mb-4">Commande reçu par :</span>
                        <span></span>
                        <strong>Signature :</strong>
                        <span></span>
                    </div>
                    <div class="signature-box text-start">
                        <span class="fw-medium mb-4">Nom Magasinier : {{$createdBy}}</span>
                        <span></span>
                        <strong >Signature :</strong>
                        <span></span>
                    </div>
                </div>
            </div>

            <button class="button-print" id="printButton" onclick="printDocument()">
                <span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                  </svg>
                  </span>
                <span>Imprimé</span></button>
        </div>
        <div class="footer">
            <p>&copy; 2024 Ste Tunisienne Industrielle des Tapis. All rights reserved.</p>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>

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
