<x-guest-layout>
    <div class="max-w-md p-8 mx-auto mt-10 bg-white border rounded-lg shadow-md">
        <h2 class="mb-6 text-2xl font-bold text-center text-gray-700">Criar conta</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900">{{ __('Nome') }}</label>
                <div class="flex items-center">
                    <i class="mr-2 fa-solid fa-user"></i>
                    <x-text-input id="name" class="block w-full mt-1" type="text" name="name"
                        :value="old('name')" required autofocus autocomplete="name" />
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mb-4">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">{{ __('Email') }}</label>
                <div class="flex items-center">
                    <i class="mr-2 fa-solid fa-envelope"></i>
                    <x-text-input id="email" class="block w-full mt-1" type="email" name="email"
                        :value="old('email')" required autocomplete="username" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900">{{ __('Senha') }}</label>
                <div class="flex items-center">
                    <i class="mr-2 fa-solid fa-lock"></i>
                    <x-text-input id="password" class="block w-full mt-1" type="password" name="password" required
                        autocomplete="new-password" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <label for="password_confirmation"
                    class="block mb-2 text-sm font-medium text-gray-900">{{ __('Confirmar Senha') }}</label>
                <div class="flex items-center">
                    <i class="mr-2 fa-solid fa-lock"></i>
                    <x-text-input id="password_confirmation" class="block w-full mt-1" type="password"
                        name="password_confirmation" required autocomplete="new-password" />
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('login') }}">
                    {{ __('Já está cadastrado?') }}
                </a>

                <x-primary-button class="ms-4">
                    <i class="mr-2 fa-solid fa-check"></i>
                    {{ __('
                    Cadastre-se') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
