  {{-- Edit Popup --}}

  <div class="popup createhidden" id="edit-popup">
    @vite('resources/css/zahlungen/edit.css')
    <div class="create">
        <button class="close-btn" onclick="closeEditPopup()">×</button>
        <h2>Transaktion bearbeiten:</h2>
        <form id="edit-form" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="edit-betrag">Betrag: </label>
                <input type="number" name="betrag" id="edit-betrag" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="edit-datum">Rechnungsdatum:</label>
                <input type="date" name="datum" id="edit-datum" required>
            </div>
            <div class="form-group">
                <label for="edit-zahlungsart">Zahlungsart:</label>
                <select name="zahlungsart_id" id="edit-zahlungsart" required>
                    @foreach ($zahlungsarten as $id => $name)
                        <option value="{{ $id }}"
                            {{ $zahlung->zahlungsart_id == $id ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="edit-rechnungsnr">Rechnungsnummer:</label>
                <input type="text" name="rechnungsnr" id="edit-rechnungsnr">
            </div>
            <div class="form-group">
                <label for="edit-beschreibung">Beschreibung:</label>
                <textarea name="beschreibung" id="edit-beschreibung" cols="30" rows="10" required></textarea>
            </div>
            <div class="form-group">
                <label for="edit-file_path">Dateipfad:</label>
                <p id="file-path-warning" style="color: red; font-weight: bold;"></p>
                <!-- Leerer Hinweis, wird von JavaScript befüllt -->
                <input type="file" name="file_path" id="edit-file_path">
            </div>
            <input type="submit" value="Speichern" class="Neu-btn">
        </form>
    </div>
</div>