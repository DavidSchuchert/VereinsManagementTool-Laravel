<!DOCTYPE html>
<html>

<head>
    <title>Mitglieder PDF</title>
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
            width: 50px;
        }

        /* Mitgliedsnummer */
        th:nth-child(5),
        td:nth-child(5) {
            width: 40px;
        }

        /* PLZ */
        th:nth-child(8),
        td:nth-child(8) {
            width: 40px;
        }

        /* Hausnummer */
        th:nth-child(11),
        td:nth-child(11) {
            width: 80px;
        }

        /* Eintrittsdatum */
        th:nth-child(12),
        td:nth-child(12) {
            width: 80px;
        }

        /* Austrittsdatum */

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

    <h2>Mitgliederliste</h2>

    <table>
        <thead>
            <tr>
                <th>Mitgliedsnummer</th>
                <th>Vorname</th>
                <th>Nachname</th>
                <th>Geburtsdatum</th>
                <th>Adresse</th>
                <th>Telefon</th>
                <th>E-Mail</th>
                <th>Eintrittsdatum</th>
                <th>Austrittsdatum</th>
                <th>Rang</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mitglieder as $mitglied)
                <tr>
                    <td>{{ $mitglied->mitgliedsnummer }}</td>
                    <td>{{ $mitglied->vorname }}</td>
                    <td>{{ $mitglied->nachname }}</td>
                    <td>{{ $mitglied->geburtsdatum }}</td>
                    <td>{{ $mitglied->plz }}, {{ $mitglied->ort }}, {{ $mitglied->strasse }} {{ $mitglied->hausnummer }}
                    </td>
                    <td>{{ $mitglied->telefon }}</td>
                    <td>{{ $mitglied->email }}</td>
                    <td>{{ $mitglied->eintrittsdatum }}</td>
                    <td>{{ $mitglied->austrittsdatum }}</td>
                    <td>{{ $mitglied->rangart->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
