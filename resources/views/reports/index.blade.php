<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Reports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Sales Report by Date') }}
                        </h3>
                        <canvas id="salesDateChart" width="400" height="200"></canvas>
                    </div>
                </div>
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Sales Report by Product') }}
                        </h3>
                        <canvas id="salesProductChart" width="400" height="200"></canvas>
                    </div>
                </div>
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Top Selling Products') }}
                        </h3>
                        <canvas id="topProductsChart" width="400" height="200"></canvas>
                    </div>
                </div>
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Top 10 Most Visited Pages') }}
                        </h3>
                        <canvas id="topPagesChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const isDarkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            const backgroundColors = isDarkMode
                ? ['rgba(54, 162, 235, 0.2)', 'rgba(255, 99, 132, 0.2)', 'rgba(255, 206, 86, 0.2)', 'rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)']
                : ['rgba(54, 162, 235, 0.5)', 'rgba(255, 99, 132, 0.5)', 'rgba(255, 206, 86, 0.5)', 'rgba(75, 192, 192, 0.5)', 'rgba(153, 102, 255, 0.5)', 'rgba(255, 159, 64, 0.5)'];

            const borderColors = ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)', 'rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)'];

            // Sales Report by Date
            var salesDateCtx = document.getElementById('salesDateChart').getContext('2d');
            var salesDateChart = new Chart(salesDateCtx, {
                type: 'bar',
                data: {
                    labels: @json($salesDateLabels),
                    datasets: [{
                        label: '{{ __("Sales") }}',
                        data: @json($salesDateData),
                        backgroundColor: backgroundColors[0],
                        borderColor: borderColors[0],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Sales Report by Product
            var salesProductCtx = document.getElementById('salesProductChart').getContext('2d');
            var salesProductChart = new Chart(salesProductCtx, {
                type: 'bar',
                data: {
                    labels: @json($salesProductLabels),
                    datasets: [{
                        label: '{{ __("Sales") }}',
                        data: @json($salesProductData),
                        backgroundColor: backgroundColors[1],
                        borderColor: borderColors[1],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Top Selling Products
            var topProductsCtx = document.getElementById('topProductsChart').getContext('2d');
            var topProductsChart = new Chart(topProductsCtx, {
                type: 'pie',
                data: {
                    labels: @json($topProductsLabels),
                    datasets: [{
                        label: '{{ __("Top Selling Products") }}',
                        data: @json($topProductsData),
                        backgroundColor: backgroundColors,
                        borderColor: borderColors,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                }
            });

            // Top 10 Most Visited Pages
            var topPagesCtx = document.getElementById('topPagesChart').getContext('2d');
            var topPagesChart = new Chart(topPagesCtx, {
                type: 'bar',
                data: {
                    labels: @json($topPagesLabels),
                    datasets: [{
                        label: '{{ __("Visits") }}',
                        data: @json($topPagesData),
                        backgroundColor: backgroundColors[2],
                        borderColor: borderColors[2],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
