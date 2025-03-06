<script src="https://cdn.tailwindcss.com"></script>
<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

    

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <div class="container  mt-5">
	<p>
		<!-- Lien de redirection vers Facebook -->
        <a href="{{ route('socialite.redirect', 'facebook') }}" class="flex items-center justify-center w-full px-4 py-2 space-x-3 text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition duration-200">
            <svg class="w-5 h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
            </svg>
            <span>Continue with Facebook</span>
        </a>

          <!-- Lien de redirection vers Google -->
          <a href="{{ route('socialite.redirect', 'google') }}" class="flex items-center justify-center w-full px-4 py-2 space-x-3 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 transition duration-200">
            <svg class="w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M23.766 12.277c0-.82-.07-1.64-.22-2.437H12.24v4.606h6.482c-.28 1.486-1.13 2.749-2.406 3.589v2.97h3.897c2.28-2.087 3.593-5.164 3.593-8.728z" fill="#4285F4"/>
                <path d="M12.24 24c3.259 0 5.99-1.057 7.983-2.895l-3.897-2.97c-1.08.721-2.46 1.145-4.086 1.145-3.142 0-5.8-2.086-6.75-4.885H1.497v3.07C3.517 21.294 7.577 24 12.24 24z" fill="#34A853"/>
                <path d="M5.49 14.395c-.242-.72-.38-1.49-.38-2.283 0-.794.138-1.563.38-2.282V6.76H1.497A11.86 11.86 0 000 12.112c0 1.915.45 3.729 1.497 5.353l3.993-3.07z" fill="#FBBC05"/>
                <path d="M12.24 4.845c1.77 0 3.361.613 4.609 1.804l3.458-3.417C18.205 1.28 15.474 0 12.24 0 7.577 0 3.517 2.706 1.497 6.76l3.993 3.07c.95-2.799 3.608-4.985 6.75-4.985z" fill="#EA4335"/>
            </svg>
            <span>Continue with Google</span>
        </a>
	</p>
</div>
</x-guest-layout>
