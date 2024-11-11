<div class="popup createhidden" id="popup">
    @vite('resources/css/zahlungen/create.css')
    <div class="create">
        <button class="close-btn" onclick="Popup()">×</button>

        <h2>Neue Transaktion hinzufügen:</h2>
        <form action="{{ route('zahlungen.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="betrag">Betrag: </label>
                <input type="number" name="betrag" id="betrag" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="datum">Rechnungsdatum:</label>
                <input type="date" name="datum" id="datum" required>
            </div>

            <div class="form-group">
                <label for="zahlungsart">Zahlungsart:</label>
                <select name="zahlungsart_id" id="zahlungsart" required>
                    @foreach ($zahlungsarten as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="rechnungsnr">Rechnungsnummer:</label>
                <input type="text" name="rechnungsnr" required>
            </div>
            <div class="form-group">
                <label for="beschreibung">Beschreibung:</label>
                <textarea name="beschreibung" id="beschreibung" cols="30" rows="10" required></textarea>
            </div>

            <div class="form-group">
                <label for="file_path">Dateipfad:</label>
                <input type="file" name="file_path" id="edit-file_path">
            </div>

            <input type="submit" value="Speichern">
        </form>
    </div>
</div>
