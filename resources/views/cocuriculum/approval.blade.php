<x-app-layout>
    <x-slot name='header'>
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Activity Applications') }}
            </h2>
            {{-- <a href="{{ route('activity.create') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                {{ __('Request New Activity') }}
            </a> --}}
        </div>
    </x-slot>
     <!-- Success Message -->
     @if (session('success'))
     <div class="mb-4 text-sm text-green-600 dark:text-green-400">
         {{ session('success') }}
     </div>
 @endif

 <!-- Error Message -->
 @if (session('error'))
     <div class="mb-4 text-sm text-red-600 dark:text-red-400">
         {{ session('error') }}
     </div>
 @endif
    {{-- TABLE TO SHOW ACTIVITIES --}}
    <x-container>
        <h2 class="text-4xl font-extrabold dark:text-white">
            Applications for Approval
        </h2>
   

        <div class="relative z-0 overflow-x-auto my-6 ">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">#</th>
                        <th scope="col" class="px-6 py-3">Activity Name</th>
                        {{-- BORANG ASAS --}}
                        {{-- BORANG Mo1/Mo2 --}}
                        {{-- BORANG KEBENARAN IBU BAPA --}}
                        {{-- SIJIL PENGHARGAAN --}}
                        {{-- NO BORANG --}}
                        {{-- DATE --}}
                        <th scope="col" class="px-6 py-3">Date</th>
                        <th scope="col" class="px-6 py-3">Created By</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3"></th>
                        {{-- EDIT --}}
                        {{-- LAPOR PENCAPAIAN (UPDATE PLACEMENT) --}}
                        {{-- DELETE) --}}
                    </tr>
                </thead>
                <tbody>
                    @forelse($activities as $activity)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{-- {{ $activities->firstItem() + $loop->index }} --}}
                            {{ $activities->firstItem() + $loop->index }}
                        </th>
                        <td class="px-6 py-4">{{ $activity->represent }} {{ $activity->involvement->description }} dalam
                            {{ $activity->club->club_name ?? 'NULL' }}, peringkat {{ $activity->achievement->achievement_name}}
                        </td>
                        <td class="px-6 py-4">{{ $activity->date_start }}</td>
                        <td class="px-6 py-4">{{ $activity->createdBy->user->name }}</td>
                        <td class="px-6 py-4">
                            @if ($activity->status === 'approved')
                                <span class="inline-flex items-center bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                                    Approved
                                </span>
                            @elseif ($activity->status === 'pending')
                                <span class="inline-flex items-center bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    <span class="w-2 h-2 me-1 bg-yellow-500 rounded-full"></span>
                                    Pending
                                </span>
                            @elseif ($activity->status === 'rejected')
                                <span class="inline-flex items-center bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                                    Rejected
                                </span>
                            @else
                                <span class="inline-flex items-center bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    <span class="w-2 h-2 me-1 bg-gray-500 rounded-full"></span>
                                    Unknown
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <!-- Modal toggle -->
                            <button data-modal-target="modal-activity-{{ $activity->id }}"
                                data-modal-toggle="modal-activity-{{ $activity->id }}"
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline ms-3"
                                type="button">
                                View Details
                            </button>
                            @push('modals')
                            <!-- Main modal -->
                            <div id="modal-activity-{{ $activity->id }}" tabindex="-1" aria-hidden="true"
                                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-2xl max-h-full">
                                    <!-- Modal content -->
                                    <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                                        <!-- Modal header -->
                                        <div
                                            class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                Activity Details
                                            </h3>
                                            <button type="button"
                                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                data-modal-hide="modal-activity-{{ $activity->id }}">
                                                <svg class="w-3 h-3" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="p-4 md:p-5 space-y-4 text-black dark:text-white">
                                            <p><strong>Activity Name:</strong> {{ $activity->represent }}</p>
                                            <p><strong>Involvement:</strong> {{ $activity->involvement->description }}
                                            </p>
                                            <p><strong>Club:</strong> {{ $activity->club->club_name ?? 'No Club' }}</p>
                                            <p><strong>Achievement:</strong> {{ $activity->achievement->achievement_name
                                                }}</p>
                                            <p><strong>Date Start:</strong> {{ $activity->date_start }}</p>
                                            <p><strong>Date End:</strong> {{ $activity->date_end }}</p>
                                            <p><strong>Time Start:</strong> {{ $activity->time_start }}</p>
                                            <p><strong>Time End:</strong> {{ $activity->time_end }}</p>
                                            <p><strong>Created By:</strong> {{ $activity->createdBy->user->name  }}</p>
                                        </div>
                                        <!-- Modal footer -->
                                        <div
                                            class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                                            <form action="{{ route('activity.approve', $activity->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Approve</button>
                                            </form>
                                            <form action="{{ route('activity.reject', $activity->id) }}" method="POST"
                                                class="inline ms-3">
                                                @csrf
                                                <button type="submit"
                                                    class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-red-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Reject</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endpush

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
                    Showing <span class="font-semibold text-gray-900 dark:text-white">{{ $activities->firstItem() ?? 0
                        }}-{{ $activities->lastItem() ?? 0 }}</span> of
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $activities->total() }}</span>
                </span>
                {{ $activities->withQueryString()->links() }}
            </nav>
        </div>
        @stack('modals')

    </x-container>

</x-app-layout>