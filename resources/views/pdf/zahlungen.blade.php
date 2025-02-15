<!DOCTYPE html>
<html>

<head>
    <title>Zahlungen PDF</title>
    <style>
        /* Allgemeine Stile */
        @page {
            size: A4 landscape;
            /* Querformat setzen */
            margin: 15mm;
        }


        body {
            font-family: Arial, sans-serif;
            color: #333;
            width. 100%;
        }

        h2 {
            text-align: center;
            color: #444;
        }

        /* Tabellenstil */
        table {
            width: 100% !important;
            border-collapse: collapse;
            margin-top: 20px;
            table-layout: auto;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 3px;
            text-align: left;
            word-wrap: break-word;
        }

        th {
            background-color: #f4f4f4;
            color: #333;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Anpassung der Beträge */
        td:last-child {
            font-weight: bold;
        }

        .positive {
            background-color: lightgreen;
        }

        .negative {
            background-color: lightcoral;
        }

        /* Datumsbereich Stil */
        .date-range {
            text-align: center;
            margin-top: 10px;
            font-style: italic;
            color: #666;
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

    <h2>Gefilterte Zahlungen</h2>

    <!-- Anzeige des Datumsbereichs -->
    <div class="date-range">
        <p>Zeitraum: {{ $zahlungen->min('datum') }} bis {{ $zahlungen->max('datum') }}</p>
        <p>Gesamtbetrag: {{ number_format($zahlungen->sum('betrag'), 2, ',', '.') }} €</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Beschreibung</th>
                <th>Rechnungsnr</th>
                <th>Datum</th>
                <th>Zahlungsart</th>
                <th>Typ</th>
                <th>Betrag</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($zahlungen as $zahlung)
                <tr>
                    <td>{{ $zahlung->beschreibung }}</td>
                    <td>{{ $zahlung->rechnungsnr }}</td>
                    <td>{{ $zahlung->datum }}</td>
                    <td>{{ $zahlung->zahlungsart->name }}</td>
                    <td class="{{ $zahlung->typ == 'Einnahme' ? 'positive' : 'negative' }}">{{ $zahlung->typ }}</td>
                    <td class="{{ $zahlung->typ == 'Einnahme' ? 'positive' : 'negative' }}">
                        {{ number_format($zahlung->betrag, 2, ',', '.') }} €
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
