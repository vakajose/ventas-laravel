<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Sales') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="w-full">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-base font-semibold leading-6 text-gray-900 dark:text-gray-100">{{ __('Sale List') }}</h1>
                            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">{{ __('A list of all the sales') }}</p>
                            @if ($errors->any())
                                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            <a type="button" href="{{ route('sales.create') }}" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">{{ __('Add new') }}</a>
                        </div>
                    </div>

                    <div class="flow-root">
                        <div class="mt-8 overflow-x-auto">
                            <div class="inline-block min-w-full py-2 align-middle">
                                <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-600">
                                    <thead class="bg-gray-50 dark:bg-gray-800">
                                    <tr>
                                        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('No') }}</th>
                                        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('User') }}</th>
                                        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('Sale Date') }}</th>
                                        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('Total Products') }}</th>
                                        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('Total Cost') }}</th>
                                        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('State') }}</th>
                                        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('Actions') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-700 divide-y divide-gray-200 dark:divide-gray-600">
                                    @foreach ($sales as $sale)
                                        <tr>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900 dark:text-gray-200">{{ ++$i }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-300">{{ $sale->user->name }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-300">{{ $sale->sale_date }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-300">{{ $sale->saleDetails->sum('quantity') }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-300">{{ $sale->total_amount }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm">
                                                <span class="{{ $sale->state == 'PENDING' ? 'bg-blue-100 text-blue-800 dark:bg-blue-400 dark:text-black' : ($sale->state == 'PAYED' ? 'bg-green-100 text-green-800 dark:bg-green-400 dark:text-black' : 'bg-red-100 text-red-800 dark:bg-red-400 dark:text-black' ) }} px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                                                    {{$sale->state == 'PENDING' ? __('Pending') : ($sale->state == 'PAYED' ? __('Payed') : __('Canceled'))}}
                                                </span>
                                            </td>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-center">
                                                <a href="{{ route('sales.show', $sale->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-100">{{ __('View Details') }}</a>
                                                @if($sale->state == 'PENDING')
                                                    <a href="{{ route('payments.create', ['sale_id' => $sale->id]) }}" class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-100 ml-2">{{ __('Pay') }}</a>
                                                    <form action="{{ route('sales.cancel', $sale->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="button" onclick="confirmCancel(this)" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-100 ml-2">{{ __('Cancel') }}</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                <div class="mt-4 px-4">
                                    {{ $sales->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function confirmCancel(button) {
            if (confirm('{{ __('Are you sure you want to cancel this sale?') }}')) {
                button.closest('form').submit();
            }
        }
    </script>
</x-app-layout>
