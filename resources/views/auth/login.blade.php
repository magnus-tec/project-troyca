<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="" :status="session('status')" />
    <form method="POST" action="{{ route('login') }}" class="mt-8">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <x-input-label class="block text-white text-sm font-bold mb-2" for="email" :value="__('Correo')" />
            <x-text-input id="email"
                class="input-3d block mt-1 w-full border border-blue-400 rounded py-2 px-3
                text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-600"
                type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-6">
            <x-input-label class="block text-white text-sm font-bold mb-2" for="password" :value="__('Contraseña')" />
            <x-text-input id="password"
                class="input-3d block mt-1 w-full border border-blue-400 rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-600"
                type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mb-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="form-checkbox text-blue-300" name="remember">
                <span class="ml-2 text-white">{{ __('Recuerdame') }}</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-sm text-blue-200 hover:text-white" href="{{ route('password.request') }}">
                    {{ __('Olvidaste tu contraseña?') }}
                </a>
            @endif
        </div>
        <div class=" mb-4">
            <div class="w-full">
                <x-primary-button style="display: inline;"
                    class="button-3d w-full text-center   bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-600">
                    {{ __('Login') }}
                </x-primary-button>
            </div>
        </div>

    </form>
</x-guest-layout>
