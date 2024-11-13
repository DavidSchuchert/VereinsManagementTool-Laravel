@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header text-center bg-primary text-white">
                <h2>Vereinslogo und -name ändern</h2>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success text-center">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="row">
                    <!-- Formular zum Hochladen des Logos -->
                    <div class="col-md-6 mb-4 border_frm">
                        <h4>Vereinslogo hochladen</h4>
                        <form action="{{ route('logo.upload') }}" method="POST" enctype="multipart/form-data" class="mt-3">
                            @csrf
                            <div class="form-group">
                                <label for="logo" class="font-weight-bold">Wähle ein Logo:</label>
                                <input type="file" name="logo" id="logo" class="form-control-file">
                            </div>
                            <button type="submit" class="btn btn-success mt-3">Logo hochladen</button>
                        </form>
                    </div>

                    <!-- Formular zum Ändern des Vereinsnamens -->
                    <div class="col-md-6 border_frm">
                        <h4>Vereinsname ändern</h4>
                        <p style="color: red"><b>Bitte Seite nach der Änderung aktualisieren.</b></p>
                        <form action="{{ route('update.app_name') }}" method="POST" class="mt-3">
                            @csrf
                            <div class="form-group">
                                <label for="app_name" class="font-weight-bold">Neuer Vereinsname:</label>
                                <input type="text" name="app_name" id="app_name" class="form-control"
                                    value="{{ config('app.name') }}" placeholder="Vereinsname eingeben">
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Vereinsname speichern</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #eef2f7;
        }

        /* Container-Styling */
        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        /* Überschriften */
        h1 {
            text-align: center;
            font-weight: bold;
            color: #343a40;
            margin-bottom: 30px;
        }

        /* Erfolgsmeldung */
        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Formularfelder */
        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            color: #495057;
        }

        input[type="file"],
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            transition: border-color 0.3s;
        }

        input[type="file"]:focus,
        input[type="text"]:focus {
            border-color: #80bdff;
            outline: none;
        }

        /* Buttons */
        button.btn {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button.btn:hover {
            background-color: #0056b3;
        }

        /* Abstände zwischen den Formularen */
        form {
            margin-top: 20px;
        }

        h2 {
            text-align: center;
            font-size: 32px !important;
            font-weight: bold !important;
            margin-bottom: 64px !important;
            color: black !important;
        }

        h4 {
            text-align: center;
            font-size: 18px !important;
            font-weight: bold !important;
            margin-bottom: 64px !important;
            color: black !important;
        }

        .border_frm {
            border: 3px solid lightgray;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
        }
    </style>
@endsection
