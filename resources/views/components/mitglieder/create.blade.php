<div class="popup createhidden" id="popup">
    @vite('resources/css/zahlungen/create.css')
    <div class="create">
        <button class="close-btn" onclick="Popup()">×</button>

        <h2>Neues Mitglied hinzufügen:</h2>
        <form action="{{ route('mitglieder.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="mitgliedsnummer">Mitgliedsnummer:</label>
                <input type="text" name="mitgliedsnummer" id="mitgliedsnummer" required>
            </div>
            <div class="form-group">
                <label for="vorname">Vorname:</label>
                <input type="text" name="vorname" id="vorname" required>
            </div>

            <div class="form-group">
                <label for="nachname">Nachname:</label>
                <input type="text" name="nachname" id="nachname" required>
            </div>

            <div class="form-group">
                <label for="geburtsdatum">Geburtsdatum:</label>
                <input type="date" name="geburtsdatum" id="geburtsdatum" required>
            </div>

            <div class="form-group">
                <label for="plz">PLZ:</label>
                <input type="number" name="plz" id="plz" required>
            </div>

            <div class="form-group">
                <label for="ort">Ort:</label>
                <input type="text" name="ort" id="ort" required>
            </div>

            <div class="form-group">
                <label for="strasse">Straße:</label>
                <input type="text" name="strasse" id="strasse" required>
            </div>

            <div class="form-group">
                <label for="hausnummer">Hausnummer:</label>
                <input type="text" name="hausnummer" id="hausnummer" required>
            </div>

            <div class="form-group">
                <label for="telefon">Telefon:</label>
                <input type="text" name="telefon" id="telefon">
            </div>

            <div class="form-group">
                <label for="email">E-Mail:</label>
                <input type="email" name="email" id="email" required>
            </div>

            <div class="form-group">
                <label for="eintrittsdatum">Eintrittsdatum:</label>
                <input type="date" name="eintrittsdatum" id="eintrittsdatum" required>
            </div>

            <div class="form-group">
                <label for="austrittsdatum">Austrittsdatum:</label>
                <input type="date" name="austrittsdatum" id="austrittsdatum">
            </div>

            <div class="form-group">
                <label for="rang_id">Rang:</label>
                <select name="rang_id" id="rang_id" required>
                    @foreach ($rangarten as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="file_path">Dateipfad:</label>
                <input type="file" name="file_path" id="file_path">
            </div>

            <input type="submit" value="Speichern">
        </form>
    </div>
</div>