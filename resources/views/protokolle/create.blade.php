@extends('layouts.app')

@section('title', 'Neues Protokoll erstellen')
@vite('resources/css/protokolle/editor.css')

@section('content')
    <h1>📜 Neues Protokoll erstellen</h1>

    <form action="{{ route('protokolle.store') }}" method="POST" id="create-form">
        @csrf

        <div class="form-group-title">
            <input type="text" name="title" id="title" class="form-control" placeholder="Titel" required>
        </div>

        <div class="form-group">
            <div id="editor-container" style="min-height: 30vh; resize: both;"></div>
            <input type="hidden" name="content" id="hidden-editor">
        </div>

        <input type="submit" class="btn btn-success"></input>
    </form>
@endsection

@section('scripts')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let quill = new Quill('#editor-container', { theme: 'snow' });

            document.getElementById('create-form').onsubmit = function () {
                document.getElementById("hidden-editor").value = quill.root.innerHTML;
            };
        });
    </script>
@endsection
