@extends('layouts.app')

@section('title', 'Protokolle')
@vite('resources/css/protokolle/index.css')

@section('content')
    <h1>📜 Protokolle</h1>

    <button onclick="window.location.href='{{ route('protokolle.create') }}'" class="neu-btn">
        + Neues Protokoll erstellen
    </button>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($protokolle->isNotEmpty())
        <table>
            <tbody>
                @foreach ($protokolle as $protokoll)
                    <tr onclick="toggleExtra('{{ $protokoll->id }}')">
                        <td>
                            <b>{{ $protokoll->title }}</b><br>
                            Erstellt von: {{ $protokoll->user->name }}<br>
                            Am: {{ \Carbon\Carbon::parse($protokoll->created_at)->format('d.m.Y') }}
                        </td>
                        <td>
                            <div class="extra_info">
                                <div class="extra_info_flex">
                                    <img src="{{ asset('images/edit-svgrepo-com.svg') }}" alt="bearbeiten" class="icon">
                                    <button onclick="window.location.href='{{ route('protokolle.edit', $protokoll) }}'" class="delete-btn">
                                        Bearbeiten
                                    </button>
                                </div>
                                <form action="{{ route('protokolle.destroy', $protokoll) }}" method="POST" class="extra-transaction-form">
                                    @csrf
                                    @method('DELETE')
                                    <img src="{{ asset('images/delete-svgrepo-com.svg') }}" alt="löschen" class="icon">
                                    <input type="submit" value="Löschen" class="delete-btn" onclick="return confirm('Sicher löschen?')">
                                </form>
                                <a href="{{ route('protokolle.exportSinglePdf', $protokoll) }}" class="btn btn-primary">🖨️ PDF Export</a>
                            </div>
                        </td>
                    </tr>

                    <!-- Zusatzelemente -->
                    <tr class="createhidden" id="extra-{{ $protokoll->id }}">
                        <td colspan="2" class="transactions_td">
                            <div class="timestamp">
                                <span class="timestamp-icon">📅</span>
                                <span>Erstellt am: {{ $protokoll->created_at }}</span>
                            </div>
                            <div class="timestamp">
                                <span class="timestamp-icon">✏️</span>
                                <span>Zuletzt bearbeitet am: {{ $protokoll->updated_at }}</span>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Keine Protokolle vorhanden.</p>
    @endif

    <div style="display: flex;">
        {{ $protokolle->links() }}
    </div>

    <script>
        function toggleExtra(id) {
            const extraRow = document.getElementById(`extra-${id}`);
            extraRow.classList.toggle('createhidden');
        }
    </script>
@endsection
