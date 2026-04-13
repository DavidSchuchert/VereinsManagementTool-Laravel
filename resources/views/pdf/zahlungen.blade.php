<!DOCTYPE html>
<html>

<head>
    <title>Zahlungen PDF</title>
    <style>
        /* Allgemeine Stile */
        @page {
            size: A4 landscape;
            margin: 15mm;
        }

        body {
            font-family: Arial, sans-serif;
            color: #333;
            font-size: 11px;
            line-height: 1.4;
        }

        .header-table {
            width: 100%;
            border: none;
            margin-bottom: 20px;
        }

        .logo {
            max-height: 60px;
            max-width: 200px;
        }

        .club-name {
            font-size: 20px;
            font-weight: bold;
            color: #1a1a1a;
            text-align: right;
        }

        h2 {
            text-align: center;
            color: #444;
            margin-top: 0;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }

        /* Tabellenstil */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #e2e8f0;
            padding: 8px 6px;
            text-align: left;
        }

        th {
            background-color: #f8fafc;
            color: #475569;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9px;
        }

        .amount {
            text-align: right;
            font-family: "Courier New", Courier, monospace;
            font-weight: bold;
        }

        .positive { color: #059669; }
        .negative { color: #dc2626; }

        /* Zusammenfassung */
        .summary-box {
            margin-top: 30px;
            width: 300px;
            float: right;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
        }

        .summary-row {
            padding: 8px;
            border-bottom: 1px solid #e2e8f0;
        }

        .summary-row.total {
            background-color: #f1f5f9;
            font-size: 13px;
        }

        .label { font-weight: bold; }
        .val { float: right; font-weight: bold; }

        /* Footer & Unterschrift */
        .footer-info {
            margin-top: 40px;
            font-size: 9px;
            color: #64748b;
            clear: both;
        }

        .signature-section {
            margin-top: 60px;
            width: 100%;
        }

        .signature-box {
            width: 45%;
            float: left;
            border-top: 1px solid #333;
            padding-top: 5px;
            margin-right: 5%;
            font-size: 10px;
        }
    </style>
</head>

<body>
    {{-- Header mit Logo --}}
    <table class="header-table">
        <tr>
            <td>
                @php
                    $logoPath = \App\Models\Setting::where('key', 'verein_logo')->value('value');
                @endphp
                @if($logoPath && file_exists(storage_path('app/public/' . $logoPath)))
                    <img src="{{ storage_path('app/public/' . $logoPath) }}" class="logo">
                @endif
            </td>
            <td class="club-name">
                {{ config('app.name') }}<br>
                <span style="font-size: 10px; font-weight: normal; color: #666;">Kassenbericht / Finanzjournal</span>
            </td>
        </tr>
    </table>

    <h2>Finanz-Transaktionen</h2>

    <div style="margin-bottom: 10px;">
        <span style="font-weight: bold;">Export-Zeitraum:</span> 
        {{ $zahlungen->min('datum') ? \Carbon\Carbon::parse($zahlungen->min('datum'))->format('d.m.Y') : '...' }} bis 
        {{ $zahlungen->max('datum') ? \Carbon\Carbon::parse($zahlungen->max('datum'))->format('d.m.Y') : '...' }}
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 10%;">Datum</th>
                <th style="width: 30%;">Beschreibung</th>
                <th style="width: 12%;">Rechnungsnr.</th>
                <th style="width: 13%;">Zahlungsart</th>
                <th style="width: 10%;">Erfasser</th>
                <th style="width: 5%; text-align: center;">Beleg</th>
                <th style="width: 20%; text-align: right;">Betrag</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($zahlungen as $zahlung)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($zahlung->datum)->format('d.m.Y') }}</td>
                    <td>{{ $zahlung->beschreibung }}</td>
                    <td>{{ $zahlung->rechnungsnr ?: '-' }}</td>
                    <td>{{ $zahlung->zahlungsart->name }}</td>
                    <td>{{ $zahlung->user->name ?? 'System' }}</td>
                    <td style="text-align: center;">{{ $zahlung->file_path ? 'Ja' : 'Nein' }}</td>
                    <td class="amount {{ $zahlung->typ == 'Einnahme' ? 'positive' : 'negative' }}">
                        {{ $zahlung->typ == 'Einnahme' ? '+' : '-' }} {{ number_format($zahlung->betrag, 2, ',', '.') }} €
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary-box">
        <div class="summary-row">
            <span class="label">Gesamteinnahmen:</span>
            <span class="val positive">+ {{ number_format($totalEinnahmen, 2, ',', '.') }} €</span>
        </div>
        <div class="summary-row">
            <span class="label">Gesamtausgaben:</span>
            <span class="val negative">- {{ number_format($totalAusgaben, 2, ',', '.') }} €</span>
        </div>
        <div class="summary-row total">
            <span class="label">Ergebnis (Bilanz):</span>
            <span class="val {{ $bilanz >= 0 ? 'positive' : 'negative' }}">
                {{ number_format($bilanz, 2, ',', '.') }} €
            </span>
        </div>
    </div>

    <div class="footer-info">
        Bericht erstellt am: {{ date('d.m.Y H:i:s') }} von {{ $exporteur }}
    </div>

    <div class="signature-section">
        <div class="signature-box">
            Ort, Datum, Unterschrift Kassenwart
        </div>
        <div class="signature-box">
            Ort, Datum, Unterschrift Kassenprüfer
        </div>
    </div>

    <script type="text/php">
        if ( isset($pdf) ) {
            $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
            $size = 8;
            $y = $pdf->get_height() - 25;
            $x = $pdf->get_width() - 110;
            $pdf->page_text($x, $y, "Seite {PAGE_NUM} von {PAGE_COUNT}", $font, $size, array(0.4, 0.4, 0.4));
        }
    </script>
</body>

</html>
