@extends('layouts.app')

@section('title', 'Protokolle')

@section('content')
    <h1>📜 Protokolle</h1>

    <a href="{{ route('protokolle.create') }}" class="btn btn-success">Neues Protokoll erstellen</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Titel</th>
                <th>Erstellt von</th>
                <th>Erstellt am</th>
                <th>Aktionen</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($protokolle as $protokoll)
                <tr>
                    <td>{{ $protokoll->title }}</td>
                    <td>{{ $protokoll->user->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($protokoll->created_at)->format('d.m.Y') }}</td>
                    <td>
                        <a href="{{ route('protokolle.edit', $protokoll) }}" class="btn btn-warning">Bearbeiten</a>
                        <form action="{{ route('protokolle.destroy', $protokoll) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" onclick="return confirm('Sicher löschen?')">Löschen</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $protokolle->links() }}
@endsection
