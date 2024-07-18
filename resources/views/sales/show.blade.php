<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Sale Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="mb-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-200">{{ __('Sale Information') }}</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-600 dark:text-gray-400">{{ __('Details about the sale.') }}</p>
                    <x-validation-errors />
                </div>

                <div class="mb-6">
                    <dl>
                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">{{ __('User') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:mt-0 sm:col-span-2">{{ $sale->user->name }}</dd>
                        </div>
                        <div class="bg-white dark:bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">{{ __('Sale Date') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:mt-0 sm:col-span-2">{{ $sale->sale_date }}</dd>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">{{ __('Total Amount') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:mt-0 sm:col-span-2">{{ $sale->total_amount }}</dd>
                        </div>
                        <div class="bg-white dark:bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">{{ __('State') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:mt-0 sm:col-span-2">
                                <span class="{{ $sale->state == 'PENDING' ? 'bg-blue-100 text-blue-800 dark:bg-blue-400 dark:text-black' : ($sale->state == 'PAYED' ? 'bg-green-100 text-green-800 dark:bg-green-400 dark:text-black' : 'bg-red-100 text-red-800 dark:bg-red-400 dark:text-black' ) }} px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                                    {{ $sale->state == 'PENDING' ? __('Pending') : ($sale->state == 'PAYED' ? __('Payed') : __('Canceled')) }}
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>

                <div class="mb-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-200">{{ __('Products') }}</h3>
                    <div class="mt-5 border-t border-gray-200 dark:border-gray-700">
                        <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-600">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-300">{{ __('Product Name') }}</th>
                                <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-300">{{ __('Quantity') }}</th>
                                <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-300">{{ __('Price') }}</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($sale->saleDetails as $detail)
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-900 dark:text-gray-200">{{ $detail->product->name }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-300">{{ $detail->quantity }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-300">{{ $detail->price }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($sale->state == 'PAYED')
                    <div class="mb-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-200">{{ __('Payment Details') }}</h3>
                        <div class="mt-5 border-t border-gray-200 dark:border-gray-700">
                            <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-600">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-300">{{ __('Payment Date') }}</th>
                                    <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-300">{{ __('Amount') }}</th>
                                    <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-300">{{ __('Payment Method') }}</th>
                                </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($sale->payments as $payment)
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-900 dark:text-gray-200">{{ $payment->payment_date }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-300">{{ $payment->amount }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-300">{{ $payment->payment_method }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                <div class="mt-4">
                    <a href="{{ route('sales.index') }}" class="block rounded-md bg-red-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">{{ __('Back') }}</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
