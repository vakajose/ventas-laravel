<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create') }} {{ __('Inventory') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="w-full">
                    <x-validation-errors />
                    <form method="POST" action="{{ route('inventories.store') }}" id="inventoryForm">
                        @csrf
                        <div class="mb-5">
                            <label for="type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{__('Type')}}</label>
                            <select name="type" id="type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                <option value="add">{{ __('Add Products') }}</option>
                                <option value="remove">{{ __('Remove Products') }}</option>
                            </select>
                        </div>

                        <div class="mb-5">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Inventory Details') }}</label>
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600" id="inventoryDetailsTable">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">{{__('Product')}}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">{{__('Quantity')}}</th>
                                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">{{__('Actions')}}</span></th>
                                </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600" id="inventoryDetailsBody">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <select name="products[0][product_id]" class="product-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                            <option value="">{{ __('Select Product') }}</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->stock_quantity }}">{{ $product->code }} - {{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="number" name="products[0][quantity]" min="1" class="quantity-input bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 stock-info"></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button type="button" class="remove-row text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">{{__('Remove Row')}}</button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <button type="button" class="add-row mt-4 bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-500">{{ __('Add Row') }}</button>
                        </div>


                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{__('Save')}}</button>

                        <a type="button" href="{{ route('inventories.index') }}" class="rounded-md bg-red-600 px-5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">{{__('Back')}}</a>



                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let rowIndex = 1;

            document.querySelector('.add-row').addEventListener('click', function () {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">
                        <select name="products[${rowIndex}][product_id]" class="product-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="">{{ __('Select Product') }}</option>
                            @foreach($products as $product)
                <option value="{{ $product->id }}" data-stock="{{ $product->stock_quantity }}">{{ $product->code }} - {{ $product->name }}</option>
                            @endforeach
                </select>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <input type="number" name="products[${rowIndex}][quantity]" min="1" class="quantity-input bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <span class="text-xs text-gray-500 dark:text-gray-400 stock-info"></span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button type="button" class="remove-row text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">{{__('Remove Row')}}</button>
                    </td>
                `;
                document.querySelector('#inventoryDetailsBody').appendChild(row);
                rowIndex++;
                updateEventListeners();
            });

            function updateEventListeners() {
                document.querySelectorAll('.remove-row').forEach(button => {
                    button.removeEventListener('click', removeRow);
                    button.addEventListener('click', removeRow);
                });

                document.querySelectorAll('.product-select').forEach(select => {
                    select.removeEventListener('change', updateStockInfo);
                    select.addEventListener('change', updateStockInfo);
                });

                document.querySelectorAll('.quantity-input').forEach(input => {
                    input.removeEventListener('input', validateQuantity);
                    input.addEventListener('input', validateQuantity);
                });
            }

            function removeRow(event) {
                event.target.closest('tr').remove();
            }

            function updateStockInfo(event) {
                const stockInfo = event.target.closest('tr').querySelector('.stock-info');
                const selectedOption = event.target.selectedOptions[0];
                const stockQuantity = selectedOption.dataset.stock;
                stockInfo.textContent = `Stock: ${stockQuantity}`;
            }

            function validateQuantity(event) {
                const input = event.target;
                const stockInfo = input.closest('tr').querySelector('.stock-info');
                const stockQuantity = parseInt(stockInfo.textContent.replace('Stock: ', ''));
                const type = document.querySelector('#type').value;
                if (type === 'remove' && parseInt(input.value) > stockQuantity) {
                    input.setCustomValidity('The quantity exceeds the current stock.');
                } else {
                    input.setCustomValidity('');
                }
            }

            updateEventListeners();
        });
    </script>
</x-app-layout>
