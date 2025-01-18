@extends('layouts.app')

@section('title', 'Protokoll bearbeiten')
@vite('resources/css/protokolle/editor.css')

@section('content')
    <h1>📜 Protokoll bearbeiten</h1>

    <form action="{{ route('protokolle.update', $protokoll) }}" method="POST" id="edit-form">
        @csrf
        @method('PUT')

        <div class="form-group-title">
            <input type="text" name="title" id="title" class="form-control" value="{{ $protokoll->title }}" required>
        </div>

        <div class="form-group">
            <div id="editor-container" style="min-height: 30vh; resize: both;"></div>
            <input type="hidden" name="content" id="hidden-editor">
        </div>

        <input type="submit" class="btn btn-success" value="Speichern">
    </form>
@endsection

@section('scripts')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let quill = new Quill('#editor-container', { theme: 'snow' });

            // Setze den aktuellen Inhalt in den Editor
            quill.root.innerHTML = `{!! addslashes($protokoll->content) !!}`;

            document.getElementById('edit-form').onsubmit = function () {
                document.getElementById("hidden-editor").value = quill.root.innerHTML;
            };
        });
    </script>
@endsection
