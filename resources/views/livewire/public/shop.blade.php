<div>
    <div class="bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
            <div class="border-b border-gray-200 pb-10">
                <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white">Shop All</h1>
                <p class="mt-4 text-base text-gray-500">Checkout out the latest collection.</p>
            </div>

            <div class="pt-12 grid grid-cols-1 gap-x-8 gap-y-10 lg:grid-cols-4">
                <!-- Filters -->
                <form class="hidden lg:block">
                    <h3 class="sr-only">Categories</h3>
                    <ul role="list" class="text-sm font-medium text-gray-900 dark:text-gray-200 space-y-4 pb-6 border-b border-gray-200">
                        <li><a href="#" class="theme-primary">All Products</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-gray-900">Clothing</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-gray-900">Electronics</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-gray-900">Accessories</a></li>
                    </ul>
                </form>

                <!-- Product Grid -->
                <div class="lg:col-span-3">
                    <div class="border-4 border-dashed border-gray-200 rounded-lg h-96 lg:h-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-4">
                         @foreach(range(1, 6) as $i)
                            <div class="group relative bg-white dark:bg-gray-700 rounded-lg shadow overflow-hidden h-fit">
                                <div class="w-full min-h-60 bg-gray-200 aspect-w-1 aspect-h-1 rounded-md overflow-hidden group-hover:opacity-75 lg:h-60 lg:aspect-none">
                                    <div class="w-full h-full bg-gray-300 flex items-center justify-center text-gray-500">Image {{ $i }}</div>
                                </div>
                                <div class="mt-4 flex justify-between p-4">
                                    <div>
                                        <h3 class="text-sm text-gray-700 dark:text-gray-200">
                                            <a href="#">
                                                <span aria-hidden="true" class="absolute inset-0"></span>
                                                Product {{ $i }}
                                            </a>
                                        </h3>
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Category</p>
                                    </div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">$50</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
