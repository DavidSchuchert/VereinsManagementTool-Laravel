@php
    $logoPath = \App\Models\Setting::where('key', 'verein_logo')->value('value');
@endphp

@if ($logoPath)
    <img src="{{ asset('storage/' . $logoPath) }}" alt="Vereinslogo" {{ $attributes }}>
@else
    <!-- Fallback zu App-Name, falls kein Logo hochgeladen wurde -->
    {{ config('app.name') }}
@endif
