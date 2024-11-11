{{-- Edit Popup --}}

<div class="popup createhidden" id="edit-popup">
    @vite('resources/css/zahlungen/edit.css')
    <div class="create">
        <button class="close-btn" onclick="closeEditPopup()">×</button>
        <h2>Artikel bearbeiten:</h2>
        <form id="edit-form" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="edit-artikel">Artikelname:</label>
                <input type="text" name="artikel" id="edit-artikel" required>
            </div>

            <div class="form-group">
                <label for="edit-ean">EAN:</label>
                <input type="text" name="ean" id="edit-ean" required>
            </div>

            <div class="form-group">
                <label for="edit-menge">Menge:</label>
                <input type="number" name="menge" id="edit-menge" required>
            </div>

            <div class="form-group">
                <label for="edit-lagerstandort">Lagerstandort:</label>
                <input type="text" name="lagerstandort" id="edit-lagerstandort" required>
            </div>

            <div class="form-group">
                <label for="edit-bemerkung">Bemerkung:</label>
                <textarea name="bemerkung" id="edit-bemerkung" cols="30" rows="5" required></textarea>
            </div>

            <input type="submit" value="Speichern" class="Neu-btn">
        </form>
    </div>
</div>
