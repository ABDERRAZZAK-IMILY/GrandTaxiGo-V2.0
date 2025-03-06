<script src="https://cdn.tailwindcss.com"></script>

<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-xl shadow-2xl">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Create your account
                </h2>
            </div>
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="mt-8 space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" class="block text-sm font-medium text-gray-700"/>
                    <x-text-input id="name" class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="block text-sm font-medium text-gray-700"/>
                    <x-text-input id="email" class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Role -->
                <div>
                    <x-input-label for="role" :value="__('Role')" class="block text-sm font-medium text-gray-700"/>
                    <select id="role" name="role" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-lg sm:text-sm" required>
                        <option value="passenger">{{ __('Passenger') }}</option>
                        <option value="driver">{{ __('Driver') }}</option>
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                </div>

                <!-- Profile Picture -->
                <div>
                    <x-input-label for="profile_picture" :value="__('Profile Picture')" class="block text-sm font-medium text-gray-700"/>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="profile_picture" class="relative cursor-pointer rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span>Upload a file</span>
                                    <x-text-input id="profile_picture" class="sr-only" type="file" name="profile_picture" accept="image/*" />
                                </label>
                            </div>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('profile_picture')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" class="block text-sm font-medium text-gray-700"/>
                    <x-text-input id="password" class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="block text-sm font-medium text-gray-700"/>
                    <x-text-input id="password_confirmation" class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between mt-6">
                    <a class="text-sm font-medium text-indigo-600 hover:text-indigo-500" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <x-primary-button class="group relative w-1/3 flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>

            <div class="container">
    <p>
        <!-- Lien de redirection vers Facebook -->
        <a href="{{ route('socialite.redirect', 'facebook') }}" class="flex items-center justify-center w-full px-4 py-2 space-x-3 text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition duration-200 mb-2">
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
        </div>
    </div>
</x-guest-layout>
