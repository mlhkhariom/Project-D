<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Store Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <!-- Sales -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Total Sales</div>
                    <div class="text-2xl font-bold">$0.00</div>
                    <div class="text-xs text-green-500 mt-2">+0% from last month</div>
                </div>

                <!-- Orders -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Total Orders</div>
                    <div class="text-2xl font-bold">0</div>
                    <div class="text-xs text-green-500 mt-2">+0% from last month</div>
                </div>

                <!-- Customers -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">New Customers</div>
                    <div class="text-2xl font-bold">0</div>
                    <div class="text-xs text-green-500 mt-2">+0% from last month</div>
                </div>

                <!-- Products -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Total Products</div>
                    <div class="text-2xl font-bold">0</div>
                    <div class="text-xs text-gray-400 mt-2">Active</div>
                </div>
            </div>

             <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Recent Orders</h3>
                <div class="text-gray-500 text-sm">No orders found.</div>
            </div>
        </div>
    </div>
</div>
