@extends('layouts.app')
@section('title', 'Mitglieder')

@section('content')
    <section class="p-6">
        {{-- The Livewire Members List --}}
        @livewire('members-list')

        {{-- The Livewire Members Form (Slide-over) --}}
        @livewire('members-form')

        {{-- Member Detail View --}}
        @livewire('member-detail')
    </section>
@endsection
