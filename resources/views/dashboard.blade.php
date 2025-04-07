<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}

                    @hasrole('admin')
                        <p class="mt-4 text-green-500">You are an admin.</p>
                    @else
                        <p class="mt-4 text-red-500">You are not an admin.</p>
                    @endhasrole
                    @hasrole('teacher')
                        <p class="mt-4 text-blue-500">You are a teacher</p>
                    @else
                        <p class="mt-4 text-red-500">You are not a teacher</p>
                    @endhasrole
                    @hasrole('student')
                        <p class="mt-4 text-yellow-500">You are a student</p>
                    @else
                        <p class="mt-4 text-red-500">You are not a student</p>
                    @endhasrole
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
