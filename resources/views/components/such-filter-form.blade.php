@vite('/resources/css/alert.css')
@vite('/resources/css/search.css')


@if ($meldung)
    <div class="alert alert-info">{{ $meldung }}</div>
@endif

<form action="{{ route('zahlungen.index') }}" method="get" class="search-form">
    <input type="text" name="suche" id="suche" placeholder="Beschreibung" value="{{ request('suche') }}">
    <div class="date-placeholder">
        <input type="date" name="datum_von" id="datum_von" value="{{ request('datum_von') }}">
        <label for="datum_von" class="placeholder-label">Datum von</label>
    </div>

    <div class="date-placeholder">
        <input type="date" name="datum_bis" id="datum_bis" value="{{ request('datum_bis') }}">
        <label for="datum_bis" class="placeholder-label">Datum bis</label>
    </div>
    <select name="zahlungsart_id" id="zahlungsart">
        <option value="">Alle Zahlungsarten</option>
        @foreach ($zahlungsarten as $id => $name)
            <option value="{{ $id }}" {{ request('zahlungsart_id') == $id ? 'selected' : '' }}>
                {{ $name }}
            </option>
        @endforeach
    </select>
    <input type="number" step="0.01" name="betrag_von" placeholder="Betrag von" value="{{ request('betrag_von') }}">
    <input type="number" step="0.01" name="betrag_bis" placeholder="Betrag bis" value="{{ request('betrag_bis') }}">
    <input type="text" name="rechnungsnummer" placeholder="Rechnungsnummer"
        value="{{ request('rechnungsnummer') }}">
    <button type="submit">Filtern</button>
</form>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Elemente innerhalb der .search-form
        const searchForm = document.querySelector('.search-form');

        if (searchForm) {
            const dateInputs = searchForm.querySelectorAll('input[type="date"]');

            dateInputs.forEach(input => {
                // Überprüfe beim Laden der Seite, ob ein Wert vorhanden ist
                if (input.value) {
                    input.style.color = "black"; // Text bleibt schwarz, wenn ein Datum vorhanden ist
                    input.nextElementSibling.classList.add('custom-hidden'); // Label ausblenden
                } else {
                    input.style.color = "white"; // Text ist weiß, wenn kein Datum vorhanden ist
                }

                // Bei Fokus: Textfarbe schwarz und Label ausblenden
                input.addEventListener('focus', function() {
                    this.style.color = "black"; // Text wird schwarz
                    const label = this.nextElementSibling;
                    if (label && label.classList.contains('placeholder-label')) {
                        label.classList.add('custom-hidden'); // Label ausblenden
                    }
                });

                // Bei Verlust des Fokus: Nur wenn das Feld leer ist, Textfarbe weiß und Label anzeigen
                input.addEventListener('blur', function() {
                    if (!this.value) {
                        this.style.color =
                        "white"; // Text wieder weiß, wenn kein Datum ausgewählt ist
                        const label = this.nextElementSibling;
                        if (label && label.classList.contains('placeholder-label')) {
                            label.classList.remove('custom-hidden'); // Label wieder anzeigen
                        }
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
                        const label = this.nextElementSibling;
                        if (label && label.classList.contains('placeholder-label')) {
                            label.classList.add('custom-hidden'); // Label ausblenden
                        }
                    } else {
                        this.style.color =
                        "white"; // Text wird weiß, wenn kein Datum eingegeben wurde
                        const label = this.nextElementSibling;
                        if (label && label.classList.contains('placeholder-label')) {
                            label.classList.remove('custom-hidden'); // Label wieder anzeigen
                        }
                    }
                });
            });
        }
    });
</script>
