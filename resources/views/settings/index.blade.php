<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="w-full">
                    <h1 class="text-base font-semibold leading-6 text-gray-900 dark:text-gray-100">{{ __('Settings') }}</h1>
                    <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">{{ __('Change application settings.') }}</p>

                    @if (session('success'))
                        <div class="mt-4 bg-green-100 dark:bg-green-200 text-green-700 dark:text-green-800 p-4 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('settings.changeLanguage') }}" class="mt-6">
                        @csrf
                        <div class="mb-5">
                            <label for="language" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Language') }}</label>
                            <select name="language" id="language" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                @foreach ($languages as $key => $value)
                                    <option value="{{ $key }}" {{ Session::get('locale', App::getLocale()) == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{__('Save')}}</button>
                    </form>

                    <form method="POST" action="{{ route('settings.changeTheme') }}" class="mt-6" x-data="themeData">
                        @csrf
                        <div class="mb-5">
                            <label for="theme" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Theme') }}</label>
                            <select name="theme" id="theme" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" @change="setTheme($event.target.value)">
                                @foreach ($themes as $key => $value)
                                    <option value="{{ $key }}" {{ Session::get('theme', 'light') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="hidden"></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
