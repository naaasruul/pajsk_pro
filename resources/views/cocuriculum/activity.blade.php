<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Activity') }}
            </h2>
            <a href="{{ route('activity.create') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                {{ __('Request New Activity') }}
            </a>
        </div>
    </x-slot>



    {{-- TABLE TO SHOW ACTIVITIES --}}
    <x-container>
        {{-- <h3 class="text-2xl font-bold dark:text-white mt-6">Students in {{ $activity->club_name }}</h3> --}}
        <h2 class="text-4xl font-extrabold dark:text-white">My Activities</h2>


        <div class="relative z-0 overflow-x-auto my-4">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">#</th>
                        <th scope="col" class="px-6 py-3">Activity Name</th>
                        <th scope="col" class="px-6 py-3">Category</th>
                        <th scope="col" class="px-6 py-3">Date</th>
                        <th scope="col" class="px-6 py-3">Placement</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activities as $activity)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $activities->firstItem() + $loop->index }}
                            </th>
                            <td class="px-6 py-4">{{ $activity->represent }} {{ $activity->involvement->description }}
                                dalam {{ $activity->club->club_name ?? 'NULL' }}
                                {{ $activity->achievement->achievement_name }}</td>
                            <td class="px-6 py-4">{{ $activity->category }}</td>
                            <td class="px-6 py-4">{{ $activity->date_start }}</td>
                            <td class="px-6 py-4">
                                {{ $activity->placement->name ?? 'No Placement' }}
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $activity->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $activity->status == 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $activity->status == 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($activity->status ?? 'pending') }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('activity.edit', $activity) }}"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ $activity->status == 'approved' ? 'Assign Placement' : 'Edit' }}</a>
                                @if ($activity->status != 'approved')
                                    
                                    <form action="{{ route('activity.destroy', $activity) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="font-medium text-red-600 dark:text-red-500 hover:underline ms-3">Remove</button>
                                    </form>
                                @endif

                            </td>
                        </tr>
                    @empty
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <td colspan="7" class="px-6 py-4 text-center">No activities found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>


            <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between pt-4"
                aria-label="Table navigation">
                <span
                    class="text-sm font-normal text-gray-500 dark:text-gray-400 mb-4 md:mb-0 block w-full md:inline md:w-auto">
                    Showing <span
                        class="font-semibold text-gray-900 dark:text-white">{{ $activities->firstItem() ?? 0 }}-{{ $activities->lastItem() ?? 0 }}</span>
                    of
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $activities->total() }}</span>
                </span>
                {{ $activities->withQueryString()->links() }}
            </nav>
        </div>
    </x-container>

</x-app-layout>
