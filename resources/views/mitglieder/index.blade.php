@vite('resources/css/mitglieder/index.css')

@extends('layouts.app')
@section('title', 'Mitglieder')

@section('content')
    <h1>Mitglieder-Datenbank</h1>
    <p>Mitgliederanzahl: <b>{{ $mitglieder->count() }}</b> davon ausgeschieden:  <b>{{ $mitglieder->whereNotNull('austrittsdatum')->count() }}</b></p>
    <x-mitglieder-such-filter-form :rangarten="$rangarten" />
    <section>
        <div class="mitglieder">
            <button onclick="Popup()" class="Neu-btn">Neues Mitglied anlegen</button>
            <a href="{{ route('mitglieder.exportPdf', request()->query()) }}"
                class="btn btn-primary export_btn">🖨️Exportieren als PDF</a>
            <div class="mitgliederliste">
                @foreach ($mitglieder as $mitglied)
                    <details>
                        <summary class="accordion_summary">{{ $mitglied->vorname }} {{ $mitglied->nachname }}</summary>
                        <div class="accordion_data">
                            <p><b>ID:</b> {{ $mitglied->mitgliedsnummer }}</p>
                            <p><b>Geburtstag:</b> {{ \Carbon\Carbon::parse($mitglied->geburtsdatum)->format('d.m.Y') }}</p>
                            <p><b>Telefon/Handy:</b> {{ $mitglied->telefon }}</p>
                            <p><b>E-Mail:</b> {{ $mitglied->email }}</p>
                            <p><b>Rang:</b> {{ $mitglied->rangart->name }}</p>
                            <p><b>Beitritt:</b> {{ \Carbon\Carbon::parse($mitglied->beitritt)->format('d.m.Y') }}</p>
                            <p><b>Austritt:</b> {{ \Carbon\Carbon::parse($mitglied->austritt)->format('d.m.Y') }}</p>
                            <p><b>Adresse:</b> {{ $mitglied->plz }}, {{ $mitglied->ort }}, {{ $mitglied->strasse }}
                                {{ $mitglied->hausnummer }}</p>
                        </div>
                        <div class="options">
                            <div class="extra_info_flex edit_mitglied"><img src="{{ asset('images/edit-svgrepo-com.svg') }}"
                                    alt="bearbeiten" class="icon"><button onclick="openEditPopup('{{ $mitglied->id }}')"
                                    class="delete-btn">
                                    Bearbeiten
                                </button></div>
                            </p>


                            @if ($mitglied->file_path)
                                <div class="extra_info_flex datei_anzeigen">
                                    <a href="{{ asset('storage/' . $mitglied->file_path) }}" target="_blank"
                                        class="delete-btn">
                                        <img src="{{ asset('images/file-svgrepo-com.svg') }}" alt="datei"
                                            class="icon">Datei anzeigen
                                    </a>
                                </div>
                            @endif
                        </div>
                    </details>
                @endforeach
            </div>
        </div>

        {{-- Create Popup --}}
        <x-mitglieder.create :rangarten="$rangarten" />

        {{-- Edit Popup --}}
        @if ($mitglieder->isNotEmpty())
            <x-mitglieder.edit :rangarten="$rangarten" :mitglied="$mitglied" />
        @endif

        {{-- Pagination --}}
        {{ $mitglieder->links() }}
    </section>

    <script>
        function Popup() {
            document.getElementById('popup').classList.toggle('createhidden');
        }


        function openEditPopup(id) {
            // Hole die aktuellen Daten der Mitglieder
            const mitglieder = @json($mitglieder->keyBy('id'));
            const data = mitglieder[id];

            // Setze die Formularwerte
            document.getElementById('edit-form').action = `/mitglieder/${id}`;
            document.getElementById('edit-mitgliedsnummer').value = data.mitgliedsnummer;
            document.getElementById('edit-vorname').value = data.vorname;
            document.getElementById('edit-nachname').value = data.nachname;
            document.getElementById('edit-geburtsdatum').value = data.geburtsdatum;
            document.getElementById('edit-plz').value = data.plz;
            document.getElementById('edit-ort').value = data.ort;
            document.getElementById('edit-strasse').value = data.strasse;
            document.getElementById('edit-hausnummer').value = data.hausnummer;
            document.getElementById('edit-telefon').value = data.telefon;
            document.getElementById('edit-email').value = data.email;
            document.getElementById('edit-eintrittsdatum').value = data.eintrittsdatum;
            document.getElementById('edit-austrittsdatum').value = data.austrittsdatum;
            document.getElementById('edit-rang_id').value = data.rang_id;

            // Überprüfen, ob file_path existiert, und den Hinweis anzeigen
            if (data.file_path) {
                document.getElementById('file-path-warning').textContent =
                    "Du hast schon eine Datei. Möchtest du sie ersetzen?";
            } else {
                document.getElementById('file-path-warning').textContent = "";
            }

            // Zeige das Bearbeitungs-Popup an
            document.getElementById('edit-popup').classList.remove('createhidden');
        }

        function closeEditPopup() {
            // Verstecke das Bearbeitungs-Popup
            document.getElementById('edit-popup').classList.add('createhidden');
        }
    </script>
@endsection
