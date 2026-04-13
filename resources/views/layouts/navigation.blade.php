<nav x-data="{ open: false }" class="bg-white/80 backdrop-blur-xl border-b border-gray-200/60 sticky top-0 z-40 shadow-sm transition-all duration-300">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 transition-all duration-300">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center mr-8">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                        @php
                            $logoPath = \App\Models\Setting::where('key', 'verein_logo')->value('value');
                        @endphp

                        @if($logoPath)
                            <div class="w-10 h-10 rounded-xl overflow-hidden shadow-md group-hover:shadow-lg group-hover:-translate-y-0.5 transition-all duration-300 bg-white p-1">
                                <img src="{{ asset('storage/' . $logoPath) }}" alt="Logo" class="w-full h-full object-contain">
                            </div>
                        @else
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-accent-500 to-indigo-600 flex items-center justify-center text-white font-heading font-bold text-xl shadow-md group-hover:shadow-lg group-hover:-translate-y-0.5 transition-all duration-300">
                                {{ substr(config('app.name', 'V'), 0, 1) }}
                            </div>
                        @endif
                        
                        <span class="font-heading font-bold text-xl text-gray-900 tracking-tight hidden md:block group-hover:text-accent-600 transition-colors uppercase">
                            {{ config('app.name', 'VereinsManager') }}
                        </span>
                    </a>
                </div>

                <!-- Navigation Links (Desktop) -->
                <div class="hidden space-x-1 lg:flex items-center ml-4">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="px-3 py-2 rounded-lg transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-accent-50 text-accent-700 font-medium' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        Übersicht
                    </x-nav-link>
                    <x-nav-link :href="route('mitglieder.index')" :active="request()->routeIs('mitglieder.*')" class="px-3 py-2 rounded-lg transition-all duration-200 {{ request()->routeIs('mitglieder.*') ? 'bg-accent-50 text-accent-700 font-medium' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        Mitglieder
                    </x-nav-link>
                    <x-nav-link :href="route('zahlungen.index')" :active="request()->routeIs('zahlungen.*')" class="px-3 py-2 rounded-lg transition-all duration-200 {{ request()->routeIs('zahlungen.*') ? 'bg-accent-50 text-accent-700 font-medium' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        Zahlungen
                    </x-nav-link>
                    <x-nav-link :href="route('inventar.index')" :active="request()->routeIs('inventar.*')" class="px-3 py-2 rounded-lg transition-all duration-200 {{ request()->routeIs('inventar.*') ? 'bg-accent-50 text-accent-700 font-medium' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        Inventar
                    </x-nav-link>
                    
                    {{-- More Dropdown for Desktop --}}
                    <div class="relative flex items-center ml-2" x-data="{ appsOpen: false }">
                        <button x-on:click="appsOpen = !appsOpen" x-on:click.away="appsOpen = false" 
                                class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('dokumente.*') || request()->routeIs('protokolle.*') ? 'bg-accent-50 text-accent-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                            Apps
                            <svg class="h-4 w-4 transition-transform duration-200" :class="{'rotate-180': appsOpen}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="appsOpen" 
                             x-cloak
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-2"
                             class="absolute left-0 top-full mt-2 w-56 rounded-2xl shadow-glass bg-white/95 backdrop-blur-xl border border-gray-100 overflow-hidden z-50 p-2">
                            <div class="space-y-1">
                                <a href="{{ route('protokolle.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm rounded-xl text-gray-700 hover:bg-accent-50 hover:text-accent-700 transition-colors">
                                    <div class="p-1.5 bg-indigo-100 text-indigo-600 rounded-lg">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-medium">Protokolle</span>
                                        <span class="text-xs text-gray-500">Sitzungen & Mitschriften</span>
                                    </div>
                                </a>

                                <a href="{{ route('dokumente.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm rounded-xl text-gray-700 hover:bg-accent-50 hover:text-accent-700 transition-colors">
                                    <div class="p-1.5 bg-emerald-100 text-emerald-600 rounded-lg">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-medium">Dokumente</span>
                                        <span class="text-xs text-gray-500">Ablage & Archiv</span>
                                    </div>
                                </a>
                                <div class="h-px bg-gray-100 my-1 mx-2"></div>
                                <a href="{{ route('import-export.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm rounded-xl text-gray-600 hover:bg-gray-100 transition-colors">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                                    Import / Export
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings Dropdown (Desktop) -->
            <div class="hidden lg:flex lg:items-center lg:ml-6 gap-3">
                <a href="{{ route('setup.index') }}" class="p-2 text-gray-400 hover:text-gray-900 hover:bg-gray-100 rounded-xl transition-all" title="Einstellungen">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </a>
                
                <x-dropdown align="right" width="56">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 p-1.5 pr-3 border border-gray-200 rounded-full bg-white hover:border-gray-300 hover:shadow-sm focus:outline-none transition-all duration-200 group">
                            <div class="w-7 h-7 rounded-full bg-brand-800 text-white flex items-center justify-center text-xs font-bold font-heading">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">{{ Auth::user()->name }}</span>
                            <svg class="h-4 w-4 text-gray-400 group-hover:text-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="p-1">
                            <div class="px-3 py-2 text-xs text-gray-500 uppercase tracking-wider font-semibold">Account</div>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-lg transition-colors">
                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                Mein Profil
                            </a>
                            <a href="{{ route('users.index') }}" class="flex items-center gap-2 px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-lg transition-colors">
                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                Benutzerverwaltung
                            </a>
                            <div class="h-px bg-gray-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center gap-2 w-full text-left px-3 py-2 text-sm text-rose-600 hover:bg-rose-50 hover:text-rose-700 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    Sicher abmelden
                                </button>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="-mr-2 flex items-center lg:hidden">
                <button @click="open = ! open" class="p-2 rounded-xl text-gray-500 hover:text-gray-900 hover:bg-gray-100 focus:outline-none transition duration-200">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="lg:hidden bg-white border-b border-gray-200 absolute w-full shadow-lg z-50">
        <div class="px-4 pt-2 pb-4 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="rounded-xl">Übersicht</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('mitglieder.index')" :active="request()->routeIs('mitglieder.*')" class="rounded-xl">Mitglieder</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('zahlungen.index')" :active="request()->routeIs('zahlungen.*')" class="rounded-xl">Zahlungen</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('inventar.index')" :active="request()->routeIs('inventar.*')" class="rounded-xl">Inventar</x-responsive-nav-link>
            
            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider pt-4 pb-1 px-4">Apps & Tools</div>
            <x-responsive-nav-link :href="route('protokolle.index')" :active="request()->routeIs('protokolle.*')" class="rounded-xl">Protokolle</x-responsive-nav-link>

            <x-responsive-nav-link :href="route('dokumente.index')" :active="request()->routeIs('dokumente.*')" class="rounded-xl">Dokumente</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('import-export.index')" :active="request()->routeIs('import-export.*')" class="rounded-xl">Import/Export</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('setup.index')" :active="request()->routeIs('setup.*')" class="rounded-xl">Einstellungen</x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-4 border-t border-gray-100 bg-gray-50/50">
            <div class="px-6 flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-brand-800 text-white flex items-center justify-center font-bold font-heading">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <div class="font-medium text-base text-gray-900">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="px-4 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="rounded-xl">Profil</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('users.index')" class="rounded-xl">Benutzerverwaltung</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-rose-600 hover:bg-rose-50 rounded-xl">
                        Abmelden
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
