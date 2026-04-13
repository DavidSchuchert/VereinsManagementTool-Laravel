<section class="space-y-6">
    <header>
        <h2 class="text-lg font-bold text-gray-900">
            {{ __('Konto löschen') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Sobald Ihr Konto gelöscht wird, werden alle seine Ressourcen und Daten dauerhaft gelöscht. Bitte laden Sie alle Daten oder Informationen herunter, die Sie behalten möchten, bevor Sie Ihr Konto löschen.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-6 py-2.5"
    >{{ __('Konto löschen') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8 bg-white/95 backdrop-blur-xl rounded-2xl shadow-2xl border border-rose-100 animate-slide-up">
            @csrf
            @method('delete')

            <div class="flex items-center gap-4 mb-6">
                <div class="p-3 bg-rose-50 text-rose-600 rounded-2xl animate-pulse">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div>
                    <h2 class="text-2xl font-heading font-extrabold text-gray-900">
                        {{ __('Sind Sie sicher?') }}
                    </h2>
                    <p class="text-sm text-gray-500 italic">
                        Dieser Vorgang kann nicht rückgängig gemacht werden.
                    </p>
                </div>
            </div>

            <p class="text-sm text-gray-600 mb-8 leading-relaxed">
                {{ __('Bitte geben Sie Ihr Passwort ein, um zu bestätigen, dass Sie dieses Konto dauerhaft löschen möchten.') }}
            </p>

            <div class="space-y-4">
                <label for="password" class="block text-sm font-bold text-gray-700">Passwort bestätigen</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <input id="password" name="password" type="password"
                           class="block w-full pl-10 border-gray-200 rounded-xl focus:border-rose-500 focus:ring-rose-500 text-sm transition-all"
                           placeholder="{{ __('Passwort') }}">
                </div>
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-10 flex justify-end items-center gap-4">
                <button type="button" x-on:click="$dispatch('close')" class="text-sm font-bold text-gray-500 hover:text-gray-700">
                    {{ __('Abbrechen') }}
                </button>

                <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-rose-200 transition-all">
                    {{ __('Konto dauerhaft löschen') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
