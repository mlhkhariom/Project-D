<div>
    <!-- Hero Section -->
    <div class="relative bg-white dark:bg-gray-800 overflow-hidden mb-12 rounded-lg shadow-xl">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-white dark:bg-gray-800 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                <svg class="hidden lg:block absolute right-0 inset-y-0 h-full w-48 text-white dark:text-gray-800 transform translate-x-1/2" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                    <polygon points="50,0 100,0 50,100 0,100" />
                </svg>

                <div class="relative pt-6 px-4 sm:px-6 lg:px-8"></div>

                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white sm:text-5xl md:text-6xl">
                            <span class="block xl:inline">Welcome to</span>
                            <span class="block theme-primary xl:inline">{{ config('app.name') }}</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            Discover our premium collection of products. Quality you can trust, prices you'll love.
                        </p>
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                            <div class="rounded-md shadow">
                                <a href="{{ route('shop') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white theme-bg-primary hover:opacity-90 md:py-4 md:text-lg">
                                    Shop Now
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="https://images.unsplash.com/photo-1556740758-90de374c12ad?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1350&q=80" alt="Shopping">
        </div>
    </div>

    <!-- Featured Products -->
    <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
        <h2 class="text-2xl font-extrabold tracking-tight text-gray-900 dark:text-gray-100 mb-6">Featured Products</h2>

        <div class="grid grid-cols-1 gap-y-10 sm:grid-cols-2 gap-x-6 lg:grid-cols-4 xl:gap-x-8">
            @foreach([1, 2, 3, 4] as $product)
            <div class="group relative bg-white dark:bg-gray-700 rounded-lg shadow overflow-hidden">
                <div class="w-full min-h-80 bg-gray-200 aspect-w-1 aspect-h-1 rounded-md overflow-hidden group-hover:opacity-75 lg:h-80 lg:aspect-none">
                    <img src="https://tailwindui.com/img/ecommerce-images/product-page-01-related-product-01.jpg" alt="Product Image" class="w-full h-full object-center object-cover lg:w-full lg:h-full">
                </div>
                <div class="mt-4 flex justify-between p-4">
                    <div>
                        <h3 class="text-sm text-gray-700 dark:text-gray-200">
                            <a href="#">
                                <span aria-hidden="true" class="absolute inset-0"></span>
                                Basic Tee
                            </a>
                        </h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Black</p>
                    </div>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">$35</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
