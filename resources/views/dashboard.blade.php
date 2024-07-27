<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 flex-1 min-h-full flex flex-col">
        <div class="w-full mx-auto sm:px-6 lg:px-8 h-full flex flex-1">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex-1">
                <div class="p-6 text-gray-900 h-full flex flex-col gap-6">
                    <!--{{ __("You're logged in!") }}-->
                    <div class="flex flex-row bg-fuchsia-400 justify-between flex-1">
                        <div class="bg-red-500 w-7/12">
                            <p>Weekly stats</p>
                        </div>
                        <div class="bg-blue-500 w-4/12">
                            <p>To-do</p>
                        </div>
                    </div>
                    <div class="bg-yellow-500 flex-1">
                        <p>Latest applications</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
