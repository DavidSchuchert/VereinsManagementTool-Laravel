@vite('/resources/css/alert.css')
@vite('/resources/css/search.css')

@if ($meldung)
    <div class="alert alert-info">{{ $meldung }}</div>
@endif

<form action="{{ route('mitglieder.index') }}" method="get" class="search-form">
    <input type="text" name="suche" id="suche" placeholder="Vorname oder Nachname" value="{{ request('suche') }}">
    <div class="date-placeholder">
        <input type="date" name="geburtsdatum_von" id="geburtsdatum_von" value="{{ request('geburtsdatum_von') }}">
        <label for="geburtsdatum_von" class="placeholder-label">Geburtsdatum von</label>
    </div>

    <div class="date-placeholder">
        <input type="date" name="geburtsdatum_bis" id="geburtsdatum_bis" value="{{ request('geburtsdatum_bis') }}">
        <label for="geburtsdatum_bis" class="placeholder-label">Geburtsdatum bis</label>
    </div>
    <input type="text" name="plz" placeholder="PLZ" value="{{ request('plz') }}">
    <input type="text" name="ort" placeholder="Ort" value="{{ request('ort') }}" size="8">
    <input type="text" name="strasse" placeholder="Straße" value="{{ request('strasse') }}">
    <select name="rang_id" id="rang_id">
        <option value="">Alle Ränge</option>
        @foreach ($rangarten as $id => $name)
            <option value="{{ $id }}" {{ request('rang_id') == $id ? 'selected' : '' }}>
                {{ $name }}
            </option>
        @endforeach
    </select>
    <div class="date-placeholder">
        <input type="date" name="eintritt_von" id="eintritt_von" value="{{ request('eintritt_von') }}">
        <label for="eintritt_von" class="placeholder-label">Eintritt von</label>
    </div>

    <div class="date-placeholder">
        <input type="date" name="eintritt_bis" id="eintritt_bis" value="{{ request('eintritt_bis') }}">
        <label for="eintritt_bis" class="placeholder-label">Eintritt bis</label>
    </div>

    <input type="text" name="mitgliedsnummer" placeholder="Mitgliedsnummer"
        value="{{ request('mitgliedsnummer') }}">

    <select name="ausgetreten" id="ausgetreten">
        <option value="">Ausgetreten</option>
        <option value="ja" {{ request('ausgetreten') === 'ja' ? 'selected' : '' }}>Ja</option>
        <option value="nein" {{ request('ausgetreten') === 'nein' ? 'selected' : '' }}>Nein</option>
    </select>

    <button type="submit">Filtern</button>
</form>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Nur Elemente innerhalb der .search-form
        const searchForm = document.querySelector('.search-form');

        if (searchForm) {
            const dateInputs = searchForm.querySelectorAll('input[type="date"]');

            dateInputs.forEach(input => {
                // Überprüfe beim Laden der Seite, ob ein Wert vorhanden ist
                if (input.value) {
                    input.style.color = "black"; // Text bleibt schwarz, wenn ein Datum vorhanden ist
                    input.nextElementSibling.classList.add('hidden');
                } else {
                    input.style.color = "white"; // Text ist weiß, wenn kein Datum vorhanden ist
                }

                // Bei Fokus: Textfarbe schwarz und Label ausblenden
                input.addEventListener('focus', function() {
                    this.style.color = "black"; // Text wird schwarz
                    this.nextElementSibling.classList.add('hidden'); // Label ausblenden
                });

                // Bei Verlust des Fokus: Nur wenn das Feld leer ist, Textfarbe weiß und Label anzeigen
                input.addEventListener('blur', function() {
                    if (!this.value) {
                        this.style.color =
                            "white"; // Text wieder weiß, wenn kein Datum ausgewählt ist
                        this.nextElementSibling.classList.remove(
                            'hidden'); // Label wieder anzeigen
                    } else {
                        this.style.color =
                            "black"; // Text bleibt schwarz, wenn ein Datum vorhanden ist
                    }
                });

                // Bei Eingabe oder Änderung des Datums
                input.addEventListener('change', function() {
                    if (this.value) {
                        this.style.color =
                            "black"; // Text bleibt schwarz, wenn ein Datum eingegeben wurde
                        this.nextElementSibling.classList.add('hidden');
                    } else {
                        this.style.color =
                            "white"; // Text wird weiß, wenn kein Datum eingegeben wurde
                        this.nextElementSibling.classList.remove('hidden');
                    }
                });
            });
        }
    });
</script>
