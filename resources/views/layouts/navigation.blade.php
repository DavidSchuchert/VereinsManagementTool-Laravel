@vite('resources/css/header.css')

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 headercustom">
        <div class="flex justify-between h-16 headercustom-inlay">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:flex navlinks">
                    {{-- Dashboard Link --}}
                    <x-nav-link :href="route('home')" :class="request()->routeIs('home') ? 'active' : ''">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <!-- Zahlungen Link -->
                    <x-nav-link :href="route('zahlungen.index')" :class="request()->routeIs('zahlungen.index') ? 'active' : ''">
                        {{ __('Zahlungen') }}
                    </x-nav-link>
                    <!-- Mitglieder Link -->
                    <x-nav-link :href="route('mitglieder.index')" :class="request()->routeIs('mitglieder.index') ? 'active' : ''">
                        {{ __('Mitglieder') }}
                    </x-nav-link>
                    <!-- Inventar Link -->
                    <x-nav-link :href="route('inventar.index')" :class="request()->routeIs('inventar.index') ? 'active' : ''">
                        {{ __('Inventar') }}
                    </x-nav-link>
                    <!-- Setup Link -->
                    <x-nav-link :href="route('setup.index')" :class="request()->routeIs('setup.index') ? 'active' : ''">
                        {{ __('Einstellungen') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition duration-150 ease-in-out header_button">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                style="color: black !important;">
                                {{ __('Ausloggen') }}
                            </x-dropdown-link>
                        </form>
                        <x-dropdown-link :href="route('profile.edit')" style="color: black !important;">
                            {{ __('Profil bearbeiten') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('users.create')" style="color: black !important;">
                            {{ __('Benutzer erstellen') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('users.index')" style="color: black !important;">
                            {{ __('Benutzer ansehen') }}
                        </x-dropdown-link>

                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger Button for Mobile Menu -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('zahlungen.index')" :active="request()->routeIs('zahlungen.index')">
                {{ __('Zahlungen') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('mitglieder.index')" :active="request()->routeIs('mitglieder.index')">
                {{ __('Mitglieder') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('inventar.index')" :active="request()->routeIs('inventar.index')">
                {{ __('Inventar') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('setup.index')" :active="request()->routeIs('setup.index')">
                {{ __('Einstellungen') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                        style="color: black !important;">
                        {{ __('Ausloggen') }}
                    </x-responsive-nav-link>
                </form>

                <!-- Additional Links for Mobile -->
                <x-responsive-nav-link :href="route('profile.edit')" style="color: black !important;">
                    {{ __('Profil bearbeiten') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('users.create')" style="color: black !important;">
                    {{ __('Benutzer erstellen') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('users.index')" style="color: black !important;">
                    {{ __('Benutzer ansehen') }}
                </x-responsive-nav-link>
            </div>
        </div>
    </div>

</nav>
