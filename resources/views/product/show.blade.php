<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $product->name ?? __('Show') . " " . __('Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="w-full">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-base font-semibold leading-6 text-gray-900 dark:text-gray-100">{{__('Details of') . ' ' .__('Product') }}
                                .</h1>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            <a type="button" href="{{ route('products.index') }}"
                               class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">{{__('Back')}}</a>
                        </div>
                    </div>

                    <div class="flow-root">
                        <div class="mt-8 overflow-x-auto">
                            <div class="inline-block min-w-full py-2 align-middle">
                                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                        <tr>
                                            <td class="px-4 py-4 text-sm font-medium text-gray-900 dark:text-gray-200">{{ __('Code') }}</td>
                                            <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $product->code }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-4 text-sm font-medium text-gray-900 dark:text-gray-200">{{ __('Name') }}</td>
                                            <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $product->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-4 text-sm font-medium text-gray-900 dark:text-gray-200">{{ __('Description') }}</td>
                                            <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $product->description }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-4 text-sm font-medium text-gray-900 dark:text-gray-200">{{ __('Price') }}</td>
                                            <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $product->price }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-4 text-sm font-medium text-gray-900 dark:text-gray-200">{{ __('Stock Quantity') }}</td>
                                            <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $product->stock_quantity }}</td>
                                        </tr>
                                        <tr class="bg-yellow-100 dark:bg-yellow-700">
                                            <td class="px-4 py-4 text-sm font-bold text-gray-900 dark:text-gray-100">{{ __('Total Reservations') }}</td>
                                            <td class="px-4 py-4 text-sm font-bold text-gray-900 dark:text-gray-100">{{ $product->reservationDetails->sum('reserved_quantity') }}</td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-200">{{ __('Promotions') }}</h2>
                        <div class="overflow-x-auto mt-4">
                            <div class="inline-block min-w-full py-2 align-middle">
                                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                                        <thead class="bg-gray-50 dark:bg-gray-800">
                                        <tr>
                                            <th scope="col"
                                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('Discount Percentage') }}</th>
                                            <th scope="col"
                                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('Start Date') }}</th>
                                            <th scope="col"
                                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('End Date') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody
                                            class="bg-white dark:bg-gray-700 divide-y divide-gray-200 dark:divide-gray-600">
                                        @foreach($product->promotions as $promotion)
                                            <tr>
                                                <td class="whitespace-nowrap px-3 py-4 text-lg text-center">
                                                <span
                                                    class="bg-green-100 text-green-800 dark:bg-green-400 dark:text-black px-2 inline-flex text-md leading-5 font-semibold rounded-full">
                                                    {{ $promotion->discount_percentage }}%
                                                </span>
                                                </td>
                                                <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $promotion->start_date }}</td>
                                                <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $promotion->end_date }}</td>
                                            </tr>
                                        @endforeach
                                        @if($product->promotions->isEmpty())
                                            <tr>
                                                <td colspan="3"
                                                    class="px-4 py-4 text-sm text-center text-gray-700 dark:text-gray-300">{{ __('No Promotions Available') }}</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
