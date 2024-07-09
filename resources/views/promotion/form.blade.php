<div class="space-y-6">

    <div class="mb-5">
        <label for="product_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Product') }}</label>
        <select name="product_id" id="product_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
            <option value="">{{__('Select a Product')}}</option>
            @foreach($products as $product)
                <option value="{{ $product->id }}" {{ old('product_id', $promotion->product_id ?? '') == $product->id ? 'selected' : '' }}>{{ $product->code }} -> {{ $product->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-5">
        <label for="discount_percentage" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{__('Discount Percentage')}}</label>
        <input type="number" step="0.01" min="0" max="100" name="discount_percentage" id="discount_percentage" value="{{ old('discount_percentage', $promotion->discount_percentage ?? '') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
    </div>

    <div class="mb-5">
        <label for="start_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Start Date') }}</label>
        <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $promotion->start_date ?? '') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
    </div>

    <div class="mb-5">
        <label for="end_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('End Date') }}</label>
        <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $promotion->end_date ?? '') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
    </div>

    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        {{__('Save')}}</button>

</div>
