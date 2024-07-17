<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Sale') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
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
                <form method="POST" action="{{ route('sales.store') }}">
                    @csrf

                    <input type="hidden" name="sale_date" value="{{ now() }}">

                    <table class="min-w-full leading-normal">
                        <thead>
                        <tr>
                            <th class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('Product') }}</th>
                            <th class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('Stock') }}</th>
                            <th class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('Quantity') }}</th>
                            <th class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('Unit Price') }}</th>
                            <th class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('Total') }}</th>
                            <th class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('Actions') }}</th>
                        </tr>
                        </thead>
                        <tbody id="product-rows" class="bg-white dark:bg-gray-700 divide-y divide-gray-200 dark:divide-gray-600">
                        <tr>
                            <td>
                                <select name="products[0][id]" class="product-select dark:bg-gray-600 dark:text-gray-200" required>
                                    <option value="">{{ __('Select Product') }}</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->stock_quantity }}">
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="stock-info dark:text-gray-200">0</td>
                            <td>
                                <input type="number" name="products[0][quantity]" class="quantity-input dark:bg-gray-600 dark:text-gray-200" min="1" required>
                            </td>
                            <td class="unit-price dark:text-gray-200">0.00</td>
                            <td class="total-price dark:text-gray-200">0.00</td>
                            <td>
                                <button type="button" class="remove-row text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-100">{{ __('Remove Row') }}</button>
                            </td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="4" class="text-right py-3 pl-4 pr-3 text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('Total') }}</td>
                            <td class="total-price-summary dark:text-gray-200">0.00</td>
                            <td></td>
                        </tr>
                        </tfoot>
                    </table>

                    <button type="button" id="add-product-row" class="mt-4 bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-500">{{ __('Add Product') }}</button>

                    <button type="submit" class="text-white bg-green-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">{{__('Save Sale')}}</button>

                    <a type="button" href="{{ route('sales.index') }}" class="rounded-md bg-red-600  px-5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">{{__('Back')}}</a>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const productTemplate = document.querySelector('#product-rows tr').cloneNode(true);
            const productRows = document.querySelector('#product-rows');
            let productIndex = 1;

            document.querySelector('#add-product-row').addEventListener('click', function () {
                const newRow = productTemplate.cloneNode(true);
                newRow.querySelectorAll('select, input').forEach(input => {
                    input.name = input.name.replace('[0]', `[${productIndex}]`);
                });
                productRows.appendChild(newRow);
                updateEventListeners();
                productIndex++;
            });

            function updateEventListeners() {
                document.querySelectorAll('.remove-row').forEach(button => {
                    button.removeEventListener('click', removeRow);
                    button.addEventListener('click', removeRow);
                });

                document.querySelectorAll('.product-select').forEach(select => {
                    select.removeEventListener('change', updateRowInfo);
                    select.addEventListener('change', updateRowInfo);
                });

                document.querySelectorAll('.quantity-input').forEach(input => {
                    input.removeEventListener('input', validateAndCalculate);
                    input.addEventListener('input', validateAndCalculate);
                });
            }

            function removeRow(event) {
                event.target.closest('tr').remove();
                calculateTotalCost();
            }

            function updateRowInfo(event) {
                const row = event.target.closest('tr');
                const selectedOption = event.target.selectedOptions[0];
                const stockQuantity = selectedOption.dataset.stock;
                const price = selectedOption.dataset.price;

                row.querySelector('.stock-info').textContent = stockQuantity;
                row.querySelector('.unit-price').textContent = parseFloat(price).toFixed(2);
                calculateRowTotal(row);
                calculateTotalCost();
            }

            function validateAndCalculate(event) {
                const input = event.target;
                const row = input.closest('tr');
                const stockInfo = row.querySelector('.stock-info');
                const stockQuantity = parseInt(stockInfo.textContent);

                if (parseInt(input.value) > stockQuantity) {
                    input.setCustomValidity('{{ __('The quantity exceeds the current stock.') }}');
                } else {
                    input.setCustomValidity('');
                }
                calculateRowTotal(row);
                calculateTotalCost();
            }

            function calculateRowTotal(row) {
                const quantity = row.querySelector('.quantity-input').value;
                const price = row.querySelector('.unit-price').textContent;
                const total = quantity * price;
                row.querySelector('.total-price').textContent = total.toFixed(2);
            }

            function calculateTotalCost() {
                let totalCost = 0;
                document.querySelectorAll('#product-rows tr').forEach(row => {
                    const total = parseFloat(row.querySelector('.total-price').textContent);
                    totalCost += total;
                });
                document.querySelector('.total-price-summary').textContent = totalCost.toFixed(2);
            }

            updateEventListeners();
        });
    </script>
</x-app-layout>
