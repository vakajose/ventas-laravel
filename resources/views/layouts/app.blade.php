<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ theme: '{{ $theme }}' }" :class="{ 'dark': theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches) }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('themeData', () => ({
                    theme: '{{ $theme }}',
                    init() {
                        this.applyTheme();
                        this.observeSystemThemeChange();
                    },
                    setTheme(theme) {
                        this.theme = theme;
                        this.applyTheme();
                        axios.post('{{ route('settings.changeTheme') }}', { theme: theme })
                            .then(response => console.log(response.data))
                            .catch(error => console.error(error));
                    },
                    applyTheme() {
                        if (this.theme === 'system') {
                            this.applySystemTheme();
                        } else {
                            document.documentElement.classList.toggle('dark', this.theme === 'dark');
                        }
                    },
                    applySystemTheme() {
                        const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                        document.documentElement.classList.toggle('dark', systemPrefersDark);
                    },
                    observeSystemThemeChange() {
                        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
                            if (this.theme === 'system') {
                                this.applySystemTheme();
                            }
                        });
                    },
                    themeClass() {
                        return {
                            'dark': this.theme === 'dark' || (this.theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)
                        };
                    }
                }));
            });
        </script>
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
            <footer class="bg-white dark:bg-gray-800 shadow sm:rounded-lg mt-8 p-4 flex justify-between items-center">
                <div class="text-left text-gray-500 dark:text-gray-400">
                    @if(config('settings.show_total_visits'))
                        <span>{{ __('Total Visits:') }} {{ $visitCount }}</span>
                    @else
                        <span>{{ __('Visits:') }} {{ $visitCount }}</span>
                    @endif
                </div>
                <div class="text-right text-gray-500 dark:text-gray-400">
                    <span>{{ now()->format('d-m-Y H:i:s') }}</span>
                </div>
            </footer>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
