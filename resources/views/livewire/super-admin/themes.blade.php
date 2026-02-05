<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Theme Manager') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
                 <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Current Active Theme</h3>
                 <p class="text-sm text-gray-500">ID: {{ $activeThemeId }}</p>
                 <div class="mt-2">
                     <a href="{{ route('home') }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">Preview Website &rarr;</a>
                 </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($themes as $id => $theme)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-2 {{ $activeThemeId === $id ? 'border-green-500' : 'border-transparent' }}">
                    <div class="h-32 w-full" style="background-color: {{ $theme['colors']['bg'] }}; display: flex; align-items: center; justify-content: center;">
                         <div style="background-color: {{ $theme['colors']['primary'] }}; width: 60px; height: 60px; border-radius: 50%;"></div>
                         <div class="ml-4" style="color: {{ $theme['colors']['text'] }}; font-family: {{ $theme['font'] }};">
                             Preview
                         </div>
                    </div>

                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex justify-between items-center mb-4">
                             <h3 class="text-lg font-bold">{{ $theme['name'] }}</h3>
                             @if($activeThemeId === $id)
                                <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">Active</span>
                             @endif
                        </div>

                        <div class="space-y-2 text-sm text-gray-500 mb-6">
                            <div class="flex items-center">
                                <span class="w-20">Font:</span>
                                <span class="font-medium">{{ $theme['font'] }}</span>
                            </div>
                            <div class="flex items-center">
                                <span class="w-20">Layout:</span>
                                <span class="font-medium">{{ ucfirst($theme['layout']) }}</span>
                            </div>
                        </div>

                        <button wire:click="activateTheme('{{ $id }}')"
                                class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 {{ $activeThemeId === $id ? 'bg-green-600 hover:bg-green-700' : 'bg-gray-800 dark:bg-gray-200 dark:text-gray-800' }}">
                            {{ $activeThemeId === $id ? 'Active' : 'Activate' }}
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
