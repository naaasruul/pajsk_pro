<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Students') }}
            </h2>
            <a href="{{ route('students.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                Create Student
            </a>
        </div>
    </x-slot>

    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3">Email</th>
                    <th scope="col" class="px-6 py-3">Class</th>
                    <th scope="col" class="px-6 py-3">Phone Number</th>
                    <th scope="col" class="px-6 py-3">Home Number</th>
                    <th scope="col" class="px-6 py-3">Address</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">{{ $student->user->name }}</td>
                        <td class="px-6 py-4">{{ $student->user->email }}</td>
                        <td class="px-6 py-4">{{ $student->class }}</td>
                        <td class="px-6 py-4">{{ $student->phone_number }}</td>
                        <td class="px-6 py-4">{{ $student->home_number }}</td>
                        <td class="px-6 py-4">{{ $student->address }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('students.edit', $student) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td colspan="7" class="px-6 py-4 text-center">No students found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            <x-paginator :paginator="$students" />
        </div>
    </div>
</x-app-layout>