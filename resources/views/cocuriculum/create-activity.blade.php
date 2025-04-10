<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Request New Activity') }}
        </h2>
    </x-slot>

    <x-container>
        <h2 class="text-4xl font-extrabold dark:text-white">Activity Applications</h2>
        <p class="my-2 text-lg text-gray-500">Please fill out the form below to submit a new activity application.
            Ensure all required fields are completed accurately to avoid delays in processing your request.
        </p>

        <div class="mt-5">
            <!-- Stepper -->
            <ol id="stepper"
                class="flex items-center w-full text-sm font-medium text-center text-gray-500 dark:text-gray-400 sm:text-base">
                <x-step-item step="1" label="Activity Details" :active="true" />
                <x-step-item step="2" label="Teachers List" :active="false" />
                <x-step-item step="3" label="Students List" :active="false" />
                <x-step-item step="4" label="Submission" :active="false" />
            </ol>
        </div>

        <!-- Form -->
        <form id="activity-form" method="POST" action="{{ route('activity.store') }}">
            @csrf

            <!-- Step 1: Activity Details -->
            <div class="step-content" data-step="1">

                {{-- COLUMN 1 --}}
                <div class="mt-6">
                    <label for="represent" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select
                        an option</label>
                    <select id="represent" name="represent"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="Menghadiri" selected>Menghadiri</option>
                        <option value="Menerima Anugerah Cemerlang">Menerima Anugerah Cemerlang</option>
                        <option value="Menyertai">Menyertai</option>
                        <option value="Mewakili Daerah dalam">Mewakili Daerah dalam</option>
                    </select>
                </div>

                {{-- COLUMN 2 --}}
                <div class="mt-6">
                    <label for="represent" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Select Involvement Type
                    </label>
                    <select id="involvement" name="involvement"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @foreach ( $involvementTypes as $involvementType )
                        <option value="{{ $involvementType->id }}" selected>{{ $involvementType->description }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- COLUMN 3 --}}
                <div class="mt-6">
                    <label for="represent" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Select Club
                    </label>
                    <select id="club" name="club"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @foreach ( $clubs as $club )
                        <option value="{{ $club->id }}" selected>{{ $club->club_name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- COLUMN 4 --}}
                <div class="mt-6">
                    <label for="represent" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Select Achievement Stage
                    </label>
                    <select id="club" name="club"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @foreach ( $achievementTypes as $achievementType )
                        <option value="{{ $achievementType->id }}" selected>{{ $achievementType->achievement_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Step 2: Teachers List -->
            <div class="step-content hidden" data-step="2">


                <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-6">
                    <div
                        class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-transparent ">
                        <div>
                            {{-- <button id="dropdownActionButton" data-dropdown-toggle="dropdownAction"
                                class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                type="button">
                                <span class="sr-only">Action button</span>
                                Action
                                <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                            <!-- Dropdown menu -->
                            <div id="dropdownAction"
                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700 dark:divide-gray-600">
                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="dropdownActionButton">
                                    <li>
                                        <a href="#"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Reward</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Promote</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Activate
                                            account</a>
                                    </li>
                                </ul>
                                <div class="py-1">
                                    <a href="#"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete
                                        User</a>
                                </div>
                            </div> --}}
                        </div>
                        <label for="table-search" class="sr-only">Search</label>
                        <div class="relative">
                            <div
                                class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>
                            <input type="text" id="teacher-search"
                                class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Search for users">
                        </div>
                    </div>
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="p-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-all-search" type="checkbox"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="checkbox-all-search" class="sr-only">checkbox</label>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Phone Number
                                </th>
                              
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teachers as $teacher)
                            <tr
                                class="child-tr bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="w-4 p-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-table-search-{{ $teacher->id }}" type="checkbox"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                    </div>
                                </td>
                                <th scope="row"
                                    class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                    <img class="w-10 h-10 rounded-full" src="/docs/images/people/profile-picture-1.jpg"
                                        alt="Jese image">
                                    <div class="ps-3">
                                        <div class="text-base font-semibold">{{ $teacher->user->name }}</div>
                                        <div class="font-normal text-gray-500">{{ $teacher->user->email }}</div>
                                    </div>
                                </th>
                                <td class="px-6 py-4">
                                    {{ $teacher->phone_number }}
                                </td>
                                <td class="px-6 py-4">
                                    <button type="button" data-teacher-id="{{ $teacher->id }}" class="assign-leader-btn font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                        Assign Leader
                                    </button>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                        
                    </table>
                    <nav aria-label="Page navigation example" class="flex items-center justify-end py-4 px-4">
                        <ul class="inline-flex -space-x-px text-base h-10" id="pagination-buttons">
                          <li>
                            <a href="#" class="flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Previous</a>
                          </li>
                        </ul>
                      </nav>
                    {{-- <div class="my-4 px-3" ></div> --}}
                </div>

            </div>

            <!-- Step 3: Students List -->
            <div class="step-content hidden" data-step="3">
                <div class="mt-6">
                    <x-input-label for="student_ids" :value="__('Select Students')" />
                    <select id="student_ids" name="student_ids[]" multiple
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @foreach($students as $student)
                        <option value="{{ $student->id }}">{{ $student->user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Step 4: Submission -->
            <div class="step-content hidden" data-step="4">
                <div class="mt-6">
                    <p class="text-lg text-gray-700 dark:text-gray-300">Review your details and click "Submit" to
                        complete the process.</p>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="mt-6 flex justify-between">
                <button type="button" id="prev-button"
                    class="text-white hidden bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Previous</button>
                <button type="button" id="next-button"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Next</button>
                <button type="button" id="submit-button"
                    class="text-white hidden bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Submit</button>
            </div>
        </form>
    </x-container>

    @push('scripts')
    <script src="{{ asset('js/activity-stepper.js') }}"></script>
    <script src="{{ asset('js/add-teacher-list.js') }}"></script>

  
  

    @endpush
</x-app-layout>