<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Teacher Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                {{-- PROFILE TEACHER --}}

                {{-- Numbers of applications --}}
                <div class="grid w-100  lg:grid-cols-2">
                    <x-card title="3" content="My Students" />
                    <x-card title="3" content="Applications" />
                </div>


                {{-- <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Your Information</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</p>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ auth()->user()->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</p>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ auth()->user()->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone Number</p>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{
                                    auth()->user()->teacher->phone_number }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Address</p>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ auth()->user()->teacher->address }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
        
    </div>
</x-app-layout>