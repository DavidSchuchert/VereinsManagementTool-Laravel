@vite('resources/css/inventar/index.css')
@extends('layouts.app')
@section('title', 'Inventar')

@section('content')
    <h1>Inventar-Datenbank</h1>

    <button onclick="Popup()" class="Neu-btn">Neuen artikel erstellen</button>
    <p>Artikelanzahl: <b>{{ $inventar->count() }}</b>
    <x-inventar-such-filter-form />
    <a href="{{ route('inventar.exportPdf', request()->query()) }}" class="btn btn-primary export_btn">🖨️Exportieren als PDF</a>
    <table border="1">
        <tr class="trhead">
            <th>Artikel</th>
            <th>Menge</th>
        </tr>

        @foreach ($inventar as $artikel)
            <!-- Beispiel eines Inventareintrags -->
            <tr onclick="toggleDetails({{ $artikel->id }})">
                <td><b>{{ $artikel->artikel }}</b><br>EAN: {{ $artikel->ean }}</td>
                <td>{{ $artikel->menge }}</td>
            </tr>
            <tr class="custom-hidden" id="details_{{ $artikel->id }}">
                <td colspan="3" class="inventory_extra_details">
                    <div class="extra_info_inventory">
                        <div class="extra_info_text">
                            <p><b>Bemerkungen:</b> {{ $artikel->bemerkung }}</p>
                            <p><b>Lagerstandort:</b> {{ $artikel->lagerstandort }}</p>
                        </div>
                        <div class="options">
                            <div class="extra_info_flex"><img src="{{ asset('images/edit-svgrepo-com.svg') }}"
                                    alt="bearbeiten" class="icon"><button onclick="openEditPopup('{{ $artikel->id }}')"
                                    class="delete-btn">
                                    Bearbeiten
                                </button></div>
                            <form action="{{ route('inventar.destroy', $artikel->id) }}" method="POST"
                                class="extra-transaction-form">
                                @csrf
                                @method('DELETE')
                                <img src="{{ asset('images/delete-svgrepo-com.svg') }}" alt="löschen" class="icon">
                                <input type="submit" value="Löschen" class="delete-btn">
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
    </table>

    <x-inventar.create />
    <x-inventar.edit />
    <script>
        function toggleDetails(id) {
            const details = document.getElementById('details_' + id);
            details.classList.toggle('custom-hidden');
        }

        function Popup() {
            document.getElementById('popup').classList.toggle('createhidden');
        }

        function openEditPopup(id) {
            // Hole die aktuellen Daten des Inventars
            const inventar = @json($inventar->keyBy('id'));
            const data = inventar[id];

            // Setze die Formularwerte
            document.getElementById('edit-form').action = `/inventar/${id}`;
            document.getElementById('edit-artikel').value = data.artikel;
            document.getElementById('edit-ean').value = data.ean;
            document.getElementById('edit-menge').value = data.menge;
            document.getElementById('edit-lagerstandort').value = data.lagerstandort;
            document.getElementById('edit-bemerkung').value = data.bemerkung;

            document.getElementById('edit-popup').classList.remove('createhidden');
        }

        function closeEditPopup() {
            document.getElementById('edit-popup').classList.add('createhidden');
        }
    </script>
@endsection
