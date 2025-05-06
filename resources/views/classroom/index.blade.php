<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Classrooms') }}
            </h2>
            <a href="{{ route('classrooms.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                Create Classroom
            </a>
        </div>
    </x-slot>

    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Year</th>
                    <th scope="col" class="px-6 py-3">Class Name</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($classrooms as $classroom)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">{{ $classroom->year }}</td>
                        <td class="px-6 py-4">{{ $classroom->class_name }}</td>
                        <td class="px-6 py-4">{!! ($classroom->active_status == 1 ? '<span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-green-900 dark:text-green-300">Active</span>' : '<span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-yellow-900 dark:text-yellow-300">Disabled</span>') !!}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('classrooms.edit', $classroom) }}" class="mr-4 font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                            <a href="{{ route('classrooms.disable', $classroom) }}" class="font-medium {{( $classroom->active_status == 1 ? 'text-yellow-600 dark:text-yellow-500' : 'text-green-600 dark:text-green-500')}} hover:underline">{{ ($classroom->active_status == 1 ? 'Disable' : 'Enable') }}</a>
                        </td>
                    </tr>
                @empty
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td colspan="7" class="px-6 py-4 text-center">No classrooms found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            <x-paginator :paginator="$classrooms" />
        </div>
    </div>
</x-app-layout>