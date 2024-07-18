<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Payment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <x-validation-errors />
                <form method="POST" action="{{ route('payments.store') }}">
                    @csrf

                    <input type="hidden" name="sale_id" value="{{ $sale->id }}">
                    <input type="hidden" name="payment_date" value="{{ now() }}">

                    <div class="mb-4">
                        <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Amount') }}</label>
                        <input type="number" name="amount" id="amount" class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-gray-600 dark:text-gray-200" value="{{ $sale->total_amount }}" readonly>
                    </div>

                    <div class="mb-4">
                        <label for="payment_method" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Payment Method') }}</label>
                        <select name="payment_method" id="payment_method" class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-gray-600 dark:text-gray-200" required>
                            <option value="">{{ __('Select Payment Method') }}</option>
                            <option value="DEBIT CARD">{{ __('DEBIT CARD') }}</option>
                            <option value="CREDIT CARD">{{ __('CREDIT CARD') }}</option>
                            <option value="CASH">{{ __('CASH') }}</option>
                            <option value="QR">{{ __('QR') }}</option>
                        </select>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button type="submit" class="inline-flex justify-center rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">{{ __('Save Payment') }}</button>

                        <a href="{{ route('sales.index') }}" class="inline-flex justify-center rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">{{ __('Back') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
