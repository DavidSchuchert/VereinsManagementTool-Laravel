@extends('layouts.app')
@section('title', 'Profil bearbeiten')

@section('content')
    <div class="edit-profile-form">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Profile') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

            </div>
        </div>
    </div>
    <style>
        .edit-profile-form {
            display: flex;
            justify-content: center;
        }

        body {
            display:flex !important;
            justify-content: center !important;
            flex-direction: column !important;
            align-items: center !important;
        }
    </style>
@endsection
