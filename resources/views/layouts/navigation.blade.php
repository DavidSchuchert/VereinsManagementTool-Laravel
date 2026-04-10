<nav x-data="{ open: false }" class="bg-brand-700 border-b border-brand-800 sticky top-0 z-40 shadow-soft">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-white" />
                    </a>
                </div>

                <!-- Navigation Links (Desktop) -->
                <div class="hidden space-x-4 lg:flex lg:ml-10 items-center">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')" class="text-white hover:text-brand-200">
                        Übersicht
                    </x-nav-link>
                    <x-nav-link :href="route('mitglieder.index')" :active="request()->routeIs('mitglieder.*')" class="text-white hover:text-brand-200">
                        Mitglieder
                    </x-nav-link>
                    <x-nav-link :href="route('zahlungen.index')" :active="request()->routeIs('zahlungen.*')" class="text-white hover:text-brand-200">
                        Zahlungen
                    </x-nav-link>
                    <x-nav-link :href="route('inventar.index')" :active="request()->routeIs('inventar.*')" class="text-white hover:text-brand-200">
                        Inventar
                    </x-nav-link>
                    <x-nav-link :href="route('protokolle.index')" :active="request()->routeIs('protokolle.*')" class="text-white hover:text-brand-200">
                        Protokolle
                    </x-nav-link>
                    
                    {{-- More Dropdown for Desktop --}}
                    <div class="relative flex items-center" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-brand-100 hover:text-white transition ease-in-out duration-150">
                            Mehr
                            <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="open" x-transition class="absolute left-0 mt-36 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                            <div class="py-1">
                                <a href="{{ route('events.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Veranstaltungen</a>
                                <a href="{{ route('dokumente.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dokumente</a>
                                <a href="{{ route('import-export.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Import/Export</a>
                                <div class="border-t border-gray-100"></div>
                                <a href="{{ route('setup.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Einstellungen</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings Dropdown (Desktop) -->
            <div class="hidden lg:flex lg:items-center lg:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-brand-100 bg-brand-800 hover:text-white hover:bg-brand-900 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">Profil</x-dropdown-link>
                        <x-dropdown-link :href="route('users.index')">Benutzerverwaltung</x-dropdown-link>
                        <div class="border-t border-gray-100"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                Abmelden
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="-mr-2 flex items-center lg:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-brand-200 hover:text-white hover:bg-brand-800 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden bg-brand-800 border-t border-brand-900">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')" class="text-white hover:bg-brand-700">Übersicht</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('mitglieder.index')" :active="request()->routeIs('mitglieder.*')" class="text-white hover:bg-brand-700">Mitglieder</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('zahlungen.index')" :active="request()->routeIs('zahlungen.*')" class="text-white hover:bg-brand-700">Zahlungen</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('inventar.index')" :active="request()->routeIs('inventar.*')" class="text-white hover:bg-brand-700">Inventar</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('events.index')" :active="request()->routeIs('events.*')" class="text-white hover:bg-brand-700">Veranstaltungen</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('dokumente.index')" :active="request()->routeIs('dokumente.*')" class="text-white hover:bg-brand-700">Dokumente</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('import-export.index')" :active="request()->routeIs('import-export.*')" class="text-white hover:bg-brand-700">Import/Export</x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-brand-900">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-brand-300">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-brand-100 hover:bg-brand-700">Profil</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('users.index')" class="text-brand-100 hover:bg-brand-700">Benutzerverwaltung</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('setup.index')" class="text-brand-100 hover:bg-brand-700">Einstellungen</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-brand-100 hover:bg-brand-700">
                        Abmelden
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
