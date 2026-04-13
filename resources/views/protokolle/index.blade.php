@extends('layouts.app')

@section('title', 'Protokolle')


@section('content')
    <section class="p-6">
        @livewire('protokoll-list')
        @livewire('protokoll-form')
    </section>
@endsection
