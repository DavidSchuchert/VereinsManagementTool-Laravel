<!DOCTYPE html>
<html>

<head>
    <title>Protokoll PDF</title>
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

        th, td {
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

        /* HTML-Formatierung für QuillJS-Inhalt */
        .content {
            border: 1px solid #ddd;
            padding: 10px;
            font-size: 12px;
            line-height: 1.6;
            background-color: #fff;
        }

        /* Stile für QuillJS */
        .ql-align-right {
            text-align: right;
        }

        .ql-align-center {
            text-align: center;
        }

        .ql-align-justify {
            text-align: justify;
        }

        .ql-bold {
            font-weight: bold;
        }

        .ql-italic {
            font-style: italic;
        }

        .ql-underline {
            text-decoration: underline;
        }

        .ql-strike {
            text-decoration: line-through;
        }

        blockquote {
            border-left: 3px solid #ccc;
            margin: 10px 0;
            padding-left: 10px;
            color: #666;
        }

        pre {
            background-color: #f4f4f4;
            padding: 10px;
            font-family: "Courier New", monospace;
        }

        ul {
            padding-left: 20px;
        }

        ol {
            padding-left: 20px;
        }

    </style>
</head>

<body>
    <h2>Protokoll: {{ $protokoll->title }}</h2>

    <p><strong>Erstellt von:</strong> {{ $protokoll->user->name }}</p>
    <p><strong>Datum:</strong> {{ \Carbon\Carbon::parse($protokoll->created_at)->format('d.m.Y') }}</p>

    <hr>

    <h3>Inhalt</h3>
    <div class="content">
        {!! $protokoll->content !!}
    </div>
</body>

</html>
