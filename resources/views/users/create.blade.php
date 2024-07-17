<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                @if ($errors->any())
                    <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Name') }}</label>
                        <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-gray-600 dark:text-gray-200" required>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Email') }}</label>
                        <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-gray-600 dark:text-gray-200" required>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Password') }}</label>
                        <input type="password" name="password" id="password" minlength="8" class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-gray-600 dark:text-gray-200" required>
                    </div>
                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Confirm Password') }}</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" minlength="8" class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-gray-600 dark:text-gray-200" required>
                    </div>

                    <div class="mb-4">
                        <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Role') }}</label>
                        <select name="role" id="role" class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-gray-600 dark:text-gray-200" required>
                            <option value="">{{ __('Select Role') }}</option>
                            <option value="administrador">{{ __('Administrator') }}</option>
                            <option value="cliente">{{ __('Client') }}</option>
                        </select>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button type="submit" class="inline-flex justify-center rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">{{ __('Create User') }}</button>

                        <a href="{{ route('users.index') }}" class="inline-flex justify-center rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">{{ __('Back') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
