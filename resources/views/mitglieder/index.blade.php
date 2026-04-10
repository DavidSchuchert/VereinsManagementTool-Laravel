@vite('resources/css/mitglieder/index.css')

@extends('layouts.app')
@section('title', 'Mitglieder')

@section('content')
    <section>
        {{-- The Livewire Component --}}
        @livewire('members-list')

        {{-- Create Popup --}}
        <x-mitglieder.create :rangarten="$rangarten" />

        {{-- Edit Popup --}}
        <x-mitglieder.edit :rangarten="$rangarten" />
    </section>

    <script>
        function Popup() {
            document.getElementById('popup').classList.toggle('createhidden');
        }

        function openEditPopup(id) {
            // Get current data from Livewire component bridge
            const mitglieder = window.getMitgliederData();
            const data = mitglieder[id];

            if (!data) {
                console.error('Mitgliedsdaten nicht gefunden für ID:', id);
                return;
            }

            // Set form values
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

            // Update file path warning
            if (data.file_path) {
                document.getElementById('file-path-warning').textContent =
                    "Du hast schon eine Datei. Möchtest du sie ersetzen?";
            } else {
                document.getElementById('file-path-warning').textContent = "";
            }

            // Show edit popup
            document.getElementById('edit-popup').classList.remove('createhidden');
        }

        function closeEditPopup() {
            document.getElementById('edit-popup').classList.add('createhidden');
        }
    </script>
@endsection
