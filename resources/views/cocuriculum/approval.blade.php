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
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{-- {{ $activities->firstItem() + $loop->index }} --}}
                                {{ $activities->firstItem() + $loop->index }}
                            </th>
                            <td class="px-6 py-4">{{ $activity->represent }} {{ $activity->involvement->description }}
                                dalam
                                {{ $activity->club->club_name ?? 'NULL' }}, peringkat
                                {{ $activity->achievement->achievement_name }}
                            </td>
                            <td class="px-6 py-4">{{ $activity->date_start }}</td>
                            <td class="px-6 py-4">{{ $activity->createdBy->user->name }}</td>
                            <td class="px-6 py-4">
                                @if ($activity->status === 'approved')
                                    <span
                                        class="inline-flex items-center bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                        <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                                        Approved
                                    </span>
                                @elseif ($activity->status === 'pending')
                                    <span
                                        class="inline-flex items-center bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                        <span class="w-2 h-2 me-1 bg-yellow-500 rounded-full"></span>
                                        Pending
                                    </span>
                                @elseif ($activity->status === 'rejected')
                                    <span
                                        class="inline-flex items-center bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                        <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                                        Rejected
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300 text-xs font-medium px-2.5 py-0.5 rounded-full">
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
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 14 14">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                        </svg>
                                                        <span class="sr-only">Close modal</span>
                                                    </button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="p-4 md:p-5 space-y-4 text-black dark:text-white">
                                                    <div>
                                                        <ul class="flex flex-wrap text-sm font-medium text-center mb-4 text-gray-500 border-b border-gray-200 dark:border-gray-300 dark:text-gray-400"
                                                            id="tabs-{{ $activity->id }}">
                                                            <li class="me-2">
                                                                <button type="button"
                                                                    class="tab-btn-{{ $activity->id }} active text-white  inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300"
                                                                    data-tab="details-{{ $activity->id }}">Details</button>
                                                            </li>
                                                            <li class="me-2">
                                                                <button type="button"
                                                                    class="tab-btn-{{ $activity->id }} inline-block p-4 text-white rounded-t-lg hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300"
                                                                    data-tab="students-{{ $activity->id }}">Students</button>
                                                            </li>
                                                            <li class="me-2">
                                                                <button type="button"
                                                                    class="tab-btn-{{ $activity->id }} inline-block p-4 text-white rounded-t-lg hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300"
                                                                    data-tab="teachers-{{ $activity->id }}">Teachers</button>
                                                            </li>
                                                        </ul>

                                                        {{-- TIMELINE COMPONENTS --}}
                                                        <div id="details-{{ $activity->id }}"
                                                            class=" p-3 tab-content-{{ $activity->id }}">
                                                            <ol
                                                                class="relative border-s border-gray-200 dark:border-gray-600">
                                                                <li class="mb-7 ms-6">
                                                                    <span
                                                                        class="absolute flex items-center justify-center w-6 h-6 bg-white rounded-full -start-3 ring-8 ring-white dark:ring-gray-700 dark:bg-blue-700">
                                                                        <i class="fa-solid text-center fa-trophy fa-xs text-blue-800 dark:text-blue-300"></i>
                                                                    </span>
                                                                    <h3
                                                                        class="mb-1  text-lg font-semibold text-gray-900 dark:text-white">
                                                                        Activity</h3>
                                                                    <p
                                                                        class="text-base font-normal text-gray-500 dark:text-gray-400">
                                                                        {{ $activity->represent }}
                                                                        {{ $activity->involvement->description }}
                                                                        {{ __('Bagi Kelab') }}
                                                                        {{ $activity->club->club_name ?? 'Unknown' }}
                                                                        {{ __('Di Peringkat') }}
                                                                        {{ $activity->achievement->achievement_name }}</p>
                                                                </li>
                                                                <li class="ms-6 mb-7">
                                                                    <span
                                                                        class="absolute flex items-center justify-center w-6 h-6 bg-white rounded-full -start-3 ring-8 ring-white dark:ring-gray-700 dark:bg-blue-700">
                                                                        <i class="fa-solid text-center fa-calendar-week fa-xs text-blue-800 dark:text-blue-300"></i>
                                                                    </span>
                                                                    <h3
                                                                        class="mb-1 text-lg font-semibold text-gray-900 dark:text-white">
                                                                        Date</h3>
                                                                    <p
                                                                        class="text-base font-normal text-gray-500 dark:text-gray-400">
                                                                        {{ $activity->date_start }} -
                                                                        {{ $activity->date_end }}
                                                                    </p>
                                                                </li>
                                                                <li class="ms-6 ">
                                                                    <span
                                                                        class="absolute flex items-center justify-center w-6 h-6 bg-white rounded-full -start-3 ring-8 ring-white dark:ring-gray-700 dark:bg-blue-700">
                                                                        <i class="fa-solid text-center fa-clock fa-xs text-blue-800 dark:text-blue-300"></i>
                                                                    </span>
                                                                    <h3
                                                                        class="mb-1 text-lg font-semibold text-gray-900 dark:text-white">
                                                                        Time</h3>
                                                                    <p
                                                                        class="text-base font-normal text-gray-500 dark:text-gray-400">
                                                                        {{ $activity->time_start }} -
                                                                        {{ $activity->time_end }}
                                                                    </p>
                                                                </li>
                                                            </ol>


                                                        </div>
                                                        <div>
                                                            
                                                        </div>
                                                        <div id="students-{{ $activity->id }}"
                                                            class="tab-content-{{ $activity->id }} hidden">
                                                            <h4 class="font-semibold mb-2">Students List</h4>
                                                            @if ($activity->students && count($activity->students))
                                                                <div class="grid grid-cols-2 gap-4 ">
                                                                    @foreach ($activity->students as $student)
                                                                        <div
                                                                            class="flex flex-col-reverse items-start p-5 bg-white  rounded-lg shadow-sm md:flex-row  hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                                                                            {{-- <img class="object-cover rounded-t-lg h-30 md:h-auto md:w-30 md:rounded-none md:rounded-s-lg"
                                                                                src="{{ $student->user->gender == 'male' ? asset('images/boy.png') : asset('images/girl.png') }}"
                                                                                alt=""> --}}
                                                                            <div class="">
                                                                                <h5
                                                                                    class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                                                                    {{ $student->user->name }}
                                                                                </h5>
                                                                                <h6
                                                                                    class="text-lg font-semibold text-gray-700 dark:text-gray-300">
                                                                                    <span
                                                                                        class="text-sm capitalize text-gray-500 dark:text-gray-400">
                                                                                        {{ $student->user->gender }}
                                                                                    </span>
                                                                                </h6>
                                                                                <h6
                                                                                    class="text-lg font-semibold text-gray-700 dark:text-gray-300">
                                                                                    <span
                                                                                        class="text-sm capitalize text-gray-500 dark:text-gray-400">
                                                                                        {{ $student->user->age }} years
                                                                                    </span>
                                                                                </h6>

                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @else
                                                                <p>No students found for this activity.</p>
                                                            @endif
                                                        </div>
                                                        <div id="teachers-{{ $activity->id }}"
                                                            class="tab-content-{{ $activity->id }} hidden">
                                                            <h4 class="font-semibold mb-2">Teachers List</h4>
                                                            @if ($activity->teachers && count($activity->teachers))
                                                                <ul class="list-disc pl-5">
                                                                    @foreach ($activity->teachers as $teacher)
                                                                        <li>{{ $teacher->user->name }}
                                                                            ({{ $teacher->user->email ?? '' }})
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @else
                                                                <p>No teachers found for this activity.</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <p class="text-gray-500 text-end">Created By:
                                                                {{ $activity->createdBy->user->name }}</p>
                                                </div>
                                                <!-- Modal footer -->
                                                <div
                                                    class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                                                    <form action="{{ route('activity.approve', $activity->id) }}"
                                                        method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit"
                                                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Approve</button>

                                                    </form>
                                                    <form action="{{ route('activity.reject', $activity->id) }}"
                                                        method="POST" class="inline ms-3">
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
                    Showing <span
                        class="font-semibold text-gray-900 dark:text-white">{{ $activities->firstItem() ?? 0 }}-{{ $activities->lastItem() ?? 0 }}</span>
                    of
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $activities->total() }}</span>
                </span>
                {{ $activities->withQueryString()->links() }}
            </nav>
        </div>
        @stack('modals')
        @push('scripts')
            <script>
                $(() => {
                    @foreach ($activities as $activity)
                        const tabBtns{{ $activity->id }} = document.querySelectorAll('.tab-btn-{{ $activity->id }}');
                        const tabContents{{ $activity->id }} = document.querySelectorAll(
                            '.tab-content-{{ $activity->id }}');

                        tabBtns{{ $activity->id }}.forEach(btn => {

                            btn.addEventListener('click', function() {
                                tabBtns{{ $activity->id }}.forEach(b => {
                                    b.classList.remove('text-blue-700', 'bg-blue-100');
                                    b.classList.add('text-gray-700', );
                                });

                                this.classList.add('text-blue-700');
                                this.classList.remove('text-gray-700', 'bg-gray-100');
                                tabContents{{ $activity->id }}.forEach(content => {
                                    content.classList.add('hidden');
                                });
                                document.getElementById(this.dataset.tab).classList.remove('hidden');
                            });

                        });
                    @endforeach
                })
            </script>
        @endpush
    </x-container>

</x-app-layout>
