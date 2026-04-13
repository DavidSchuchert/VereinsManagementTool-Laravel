@extends('layouts.app')

@section('title', 'System-Setup & Stammdaten')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 animate-fade-in" x-data="{ activeTab: 'system' }">
    {{-- Header --}}
    <div class="mb-10">
        <h1 class="text-3xl font-heading font-extrabold text-gray-900 tracking-tight">Einstellungen & Stammdaten</h1>
        <p class="mt-2 text-lg text-gray-600">Verwalten Sie hier die Grundkonfiguration Ihres VereinsManagers.</p>
    </div>

    {{-- Tabs Navigation --}}
    <div class="flex flex-wrap items-center gap-2 mb-8 bg-gray-100/50 p-1.5 rounded-2xl border border-gray-200/50 backdrop-blur-sm w-fit">
        <button 
            @click="activeTab = 'system'" 
            :class="activeTab === 'system' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
            class="px-5 py-2 rounded-xl text-sm font-bold transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            System
        </button>
        <button 
            @click="activeTab = 'ranks'" 
            :class="activeTab === 'ranks' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
            class="px-5 py-2 rounded-xl text-sm font-bold transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            Mitglieder-Ränge
        </button>
        <button 
            @click="activeTab = 'categories'" 
            :class="activeTab === 'categories' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
            class="px-5 py-2 rounded-xl text-sm font-bold transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            Inventar-Kategorien
        </button>
        <button 
            @click="activeTab = 'payment-types'" 
            :class="activeTab === 'payment-types' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
            class="px-5 py-2 rounded-xl text-sm font-bold transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
            Zahlungsarten
        </button>
        <button 
            @click="activeTab = 'locations'" 
            :class="activeTab === 'locations' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
            class="px-5 py-2 rounded-xl text-sm font-bold transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Standorte
        </button>
    </div>

    {{-- Tabs Content --}}
    <div class="space-y-8 animate-slide-up">
        {{-- Tab: System --}}
        <div x-show="activeTab === 'system'" x-cloak>
            @livewire('settings-manager')
        </div>

        {{-- Tab: Ränge --}}
        <div x-show="activeTab === 'ranks'" x-cloak>
            @livewire('lookup-manager', ['type' => 'rangart', 'title' => 'RangART'])
        </div>

        {{-- Tab: Kategorien --}}
        <div x-show="activeTab === 'categories'" x-cloak>
            @livewire('lookup-manager', ['type' => 'category', 'title' => 'Kategorie', 'extraData' => ['type' => 'inventar']])
        </div>

        {{-- Tab: Zahlungsarten --}}
        <div x-show="activeTab === 'payment-types'" x-cloak>
            @livewire('lookup-manager', ['type' => 'zahlungsart', 'title' => 'Zahlungsart'])
        </div>

        {{-- Tab: Standorte --}}
        <div x-show="activeTab === 'locations'" x-cloak>
            @livewire('lookup-manager', ['type' => 'category', 'title' => 'Standort', 'extraData' => ['type' => 'location']])
        </div>
    </div>
    
    <div class="mt-16 text-center text-[10px] text-gray-400 uppercase font-black tracking-widest border-t border-gray-100 pt-8">
        <p>v2 &bull; Created by David Schuchert &bull; {{ date('Y') }}</p>
    </div>
</div>
@endsection
