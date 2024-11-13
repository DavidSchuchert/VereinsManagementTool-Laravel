@vite('resources/css/zahlungen/index.css')

@extends('layouts.app')
@section('title', 'Zahlungen')

@section('content')
    <h1>Transaktions-Datenbank</h1>
    <div class="transaction_sum 
@if ($summe >= 0) positiv
@else
    negativ @endif
">Aktueller Stand:
        {{ $summe }} €
    </div>
    <button onclick="Popup()" class="Neu-btn">Neuen artikel erstellen</button>

    <p>Transaktionsanzahl: <b>{{ $zahlungen->count() }}</b>
    <x-such-filter-form :zahlungsarten="$zahlungsarten" :meldung="$meldung" />

    <a href="{{ route('zahlungen.exportPdf', request()->query()) }}" class="btn btn-primary export_btn">🖨️Exportieren als PDF</a>


    {{-- Tabelle --}}
    @if ($zahlungen)
        <table>
            <tbody>
                @foreach ($zahlungen as $zahlung)
                    <tr onclick="toggleExtra('{{ $zahlung->id }}')">
                        <td>
                            <b>{{ $zahlung->beschreibung }}</b><br>
                            R.-Nr.: {{ $zahlung->rechnungsnr }}
                            Datum: {{ $zahlung->datum }}
                        </td>
                        <td>
                            @if ($zahlung->typ == 'Einnahme')
                                <b style="color: green">
                                @else
                                    <b style="color: red">
                            @endif
                            {{ $zahlung->betrag }} € </b><br>
                            {{ $zahlung->zahlungsart->name }}
                        </td>
                    </tr>

                    <!-- Zusatzelemente -->
                    <tr class="createhidden" id="extra-{{ $zahlung->id }}">
                        <td colspan="2" class="transactions_td">
                            <div class="timestamp">
                                <span class="timestamp-icon">📅</span>
                                <span>Erstellt am: 2024-11-05 09:39:20</span>
                            </div>
                            <div class="timestamp">
                                <span class="timestamp-icon">✏️</span>
                                <span>Zuletzt bearbeitet am: 2024-11-05 09:39:20</span>
                            </div>
                            <div class="extra_info">
                                <div class="extra_info_flex"><img src="{{ asset('images/edit-svgrepo-com.svg') }}"
                                        alt="bearbeiten" class="icon"><button
                                        onclick="openEditPopup('{{ $zahlung->id }}')" class="delete-btn">
                                        Bearbeiten
                                    </button></div>
                                <form action="{{ route('zahlungen.destroy', $zahlung->id) }}" method="POST"
                                    class="extra-transaction-form">
                                    @csrf
                                    @method('DELETE')
                                    <img src="{{ asset('images/delete-svgrepo-com.svg') }}" alt="löschen" class="icon">
                                    <input type="submit" value="Löschen" class="delete-btn">
                                </form>
                                @if ($zahlung->file_path)
                                    <div class="extra_info_flex">
                                        <img src="{{ asset('images/file-svgrepo-com.svg') }}" alt="datei"
                                            class="icon"> <a href="{{ asset('storage/' . $zahlung->file_path) }}"
                                            target="_blank" class="delete-btn">Datei
                                            anzeigen</a>
                                    </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        Keine Zahlungen
    @endif


    {{-- Create Popup --}}
    <x-zahlungen.create :zahlungsarten="$zahlungsarten" />

    {{-- Edit Popup --}}
    @if ($zahlungen->isNotEmpty())
        <x-zahlungen.edit :zahlungsarten="$zahlungsarten" :zahlung="$zahlung" />
    @endif

    {{-- Pagination --}}
    {{ $zahlungen->links() }}

    {{-- Js --}}
    <script>
        function Popup() {
            document.getElementById('popup').classList.toggle('createhidden');
        }

        function toggleExtra(id) {
            const extraRow = document.getElementById(`extra-${id}`);
            extraRow.classList.toggle('createhidden');
        }

        function openEditPopup(id) {
            // Hole die aktuellen Daten der Zahlung
            const zahlung = @json($zahlungen->keyBy('id'));
            const data = zahlung[id];

            // Setze die Formularwerte
            document.getElementById('edit-form').action = `/zahlungen/${id}`;
            document.getElementById('edit-betrag').value = data.betrag;
            document.getElementById('edit-datum').value = data.datum;
            document.getElementById('edit-zahlungsart').value = data.zahlungsart_id;
            document.getElementById('edit-beschreibung').value = data.beschreibung;
            document.getElementById('edit-rechnungsnr').value = data.rechnungsnr;

            // Überprüfen, ob file_path existiert, und den Hinweis anzeigen
            if (data.file_path) {
                document.getElementById('file-path-warning').textContent =
                    "Du hast schon eine Datei. Möchtest du sie ersetzen?";
            } else {
                document.getElementById('file-path-warning').textContent = "";
            }

            document.getElementById('edit-popup').classList.remove('createhidden');
        }

        function closeEditPopup() {
            document.getElementById('edit-popup').classList.add('createhidden');
        }
    </script>
@endsection
