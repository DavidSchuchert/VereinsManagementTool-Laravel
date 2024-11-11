{{-- Edit Popup --}}

<div class="popup createhidden" id="edit-popup">
    @vite('resources/css/zahlungen/edit.css') <!-- CSS-Datei für Mitglieder -->
    <div class="create">
        <button class="close-btn" onclick="closeEditPopup()">×</button>
        <h2>Mitglied bearbeiten:</h2>
        <form id="edit-form" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="edit-mitgliedsnummer">Mitgliedsnummer:</label>
                <input type="text" name="mitgliedsnummer" id="edit-mitgliedsnummer" required>
            </div>
            <div class="form-group">
                <label for="edit-vorname">Vorname:</label>
                <input type="text" name="vorname" id="edit-vorname" required>
            </div>

            <div class="form-group">
                <label for="edit-nachname">Nachname:</label>
                <input type="text" name="nachname" id="edit-nachname" required>
            </div>

            <div class="form-group">
                <label for="edit-geburtsdatum">Geburtsdatum:</label>
                <input type="date" name="geburtsdatum" id="edit-geburtsdatum" required>
            </div>

            <div class="form-group">
                <label for="edit-plz">PLZ:</label>
                <input type="number" name="plz" id="edit-plz" required>
            </div>

            <div class="form-group">
                <label for="edit-ort">Ort:</label>
                <input type="text" name="ort" id="edit-ort" required>
            </div>

            <div class="form-group">
                <label for="edit-strasse">Straße:</label>
                <input type="text" name="strasse" id="edit-strasse" required>
            </div>

            <div class="form-group">
                <label for="edit-hausnummer">Hausnummer:</label>
                <input type="text" name="hausnummer" id="edit-hausnummer" required>
            </div>

            <div class="form-group">
                <label for="edit-telefon">Telefon:</label>
                <input type="text" name="telefon" id="edit-telefon">
            </div>

            <div class="form-group">
                <label for="edit-email">E-Mail:</label>
                <input type="email" name="email" id="edit-email" required>
            </div>

            <div class="form-group">
                <label for="edit-eintrittsdatum">Eintrittsdatum:</label>
                <input type="date" name="eintrittsdatum" id="edit-eintrittsdatum" required>
            </div>

            <div class="form-group">
                <label for="edit-austrittsdatum">Austrittsdatum:</label>
                <input type="date" name="austrittsdatum" id="edit-austrittsdatum">
            </div>

            <div class="form-group">
                <label for="edit-rang_id">Rang:</label>
                <select name="rang_id" id="edit-rang_id" required>
                    @foreach ($rangarten as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
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
