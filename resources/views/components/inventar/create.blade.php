<div class="popup createhidden" id="popup">
    @vite('resources/css/zahlungen/create.css')
    <div class="create">
        <button class="close-btn" onclick="Popup()">×</button>

        <h2>Neuen Artikel hinzufügen:</h2>
        <form action="{{ route('inventar.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="artikel">Artikelname:</label>
                <input type="text" name="artikel" id="artikel" required>
            </div>

            <div class="form-group">
                <label for="ean">EAN:</label>
                <input type="text" name="ean" id="ean" required>
            </div>

            <div class="form-group">
                <label for="menge">Menge:</label>
                <input type="number" name="menge" id="menge" required>
            </div>

            <div class="form-group">
                <label for="lagerstandort">Lagerstandort:</label>
                <input type="text" name="lagerstandort" id="lagerstandort" required>
            </div>

            <div class="form-group">
                <label for="bemerkung">Bemerkung:</label>
                <textarea name="bemerkung" id="bemerkung" cols="30" rows="5" required></textarea>
            </div>

            <input type="submit" value="Speichern">
        </form>
    </div>
</div>
