<!DOCTYPE html>
<html>

<head>
    <title>Inventar PDF</title>
    <style>
        /* Allgemeine Stile */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            color: #444;
        }

        /* Tabellenstil */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: left;
            font-size: 10px;
        }

        th {
            background-color: #f4f4f4;
            color: #333;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Spaltenbreite anpassen */
        th:nth-child(1),
        td:nth-child(1) {
            width: 100px;
        }

        /* EAN */
        th:nth-child(2),
        td:nth-child(2) {
            width: 100px;
        }

        /* Menge */
        th:nth-child(3),
        td:nth-child(3) {
            width: 50px;
        }

        /* Lagerstandort */
        th:nth-child(4),
        td:nth-child(4) {
            width: 150px;
        }

        /* Text umbrechen */
        td {
            white-space: normal;
            word-wrap: break-word;
        }

        /* Erstellungsdatum Stil */
        .creation-date {
            text-align: right;
            font-size: 12px;
            color: #999;
        }
    </style>
</head>

<body>
    <div class="creation-date">
        <p>Erstellt am: {{ date('d.m.Y H:i:s') }}</p>
    </div>

    <h2>Inventarliste</h2>

    <table>
        <thead>
            <tr>
                <th>Artikel</th>
                <th>EAN</th>
                <th>Menge</th>
                <th>Lagerstandort</th>
                <th>Bemerkung</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inventar as $item)
                <tr>
                    <td>{{ $item->artikel }}</td>
                    <td>{{ $item->ean }}</td>
                    <td>{{ $item->menge }}</td>
                    <td>{{ $item->lagerstandort }}</td>
                    <td>{{ $item->bemerkung }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
