
@extends('layouts.app')
@section('title', 'Inventar')

@section('content')
    <section class="p-6">
        {{-- The Livewire Inventar List --}}
        @livewire('inventar-list')

        {{-- The Livewire Inventar Form (Modal) --}}
        @livewire('inventar-form')
    </section>
@endsection
