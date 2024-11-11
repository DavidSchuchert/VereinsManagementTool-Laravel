@vite('/resources/css/alert.css')
@vite('/resources/css/search.css')

@if ($meldung)
    <div class="alert alert-info">{{ $meldung }}</div>
@endif

<form action="{{ route('inventar.index') }}" method="get" class="search-form">
    <input type="text" name="suche" id="suche" placeholder="Artikelname oder Beschreibung" value="{{ request('suche') }}">
    
    <input type="text" name="ean" placeholder="EAN" value="{{ request('ean') }}">
    <input type="text" name="lagerstandort" placeholder="Lagerstandort" value="{{ request('lagerstandort') }}">
    
    <input type="number" name="menge_von" placeholder="Menge von" value="{{ request('menge_von') }}">
    <input type="number" name="menge_bis" placeholder="Menge bis" value="{{ request('menge_bis') }}">


    <button type="submit">Filtern</button>
</form>