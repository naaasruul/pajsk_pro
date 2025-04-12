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
                    <label for="involvement" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Select Involvement Type
                    </label>
                    <select id="involvement" name="involvement"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @foreach ( $involvementTypes as $involvementType )
                        <option value="{{ $involvementType->id }}" selected>{{ $involvementType->description }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- COLUMN 6 Activity Date Start --}}
                <div class="flex ">
                    <div class="mt-6 w-1/2">
                        <label for="involvement" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Start Date of Trip
                        </label>
                        <div class="relative max-w-sm">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                               <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                  <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                </svg>
                            </div>
                            <input id="date-start" datepicker datepicker-format="yyyy-mm-dd"  type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                          </div>
                    </div>

                    <div class="mt-6 w-1/2">
                        <label for="involvement" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Start Time of Trip
                        </label>
                        <div class="relative max-w-sm">
                            <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <input type="time" id="time-start" class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" min="09:00" max="18:00" value="00:00" required />
                        </div>
                    </div>
                </div>

                {{-- COLUMN 6 Activity Date End --}}
                <div class="flex ">
                    <div class="mt-6 w-1/2">
                        <label for="involvement" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            End Date of Trip
                        </label>
                        <div class="relative max-w-sm">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                               <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                  <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                </svg>
                            </div>
                            <input id="date-end" datepicker datepicker-format="yyyy-mm-dd"  type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                          </div>
                    </div>

                    <div class="mt-6 w-1/2">
                        <label for="involvement" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            End Time of Trip
                        </label>
                        <div class="relative max-w-sm">
                            <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <input type="time" id="time-end" class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" min="09:00" max="18:00" value="00:00" required />
                        </div>
                    </div>
                </div>

                {{-- COLUMN 3 --}}
                <div class="mt-6">
                    <label for="club" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
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
                    <select id="achievement" name="achievement"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @foreach ( $achievementTypes as $achievementType )
                        <option value="{{ $achievementType->id }}" selected>{{ $achievementType->achievement_name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                

                {{-- COLUMN 6 Activity Category --}}
                <div class="mt-6">
                    <label for="represent" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Select Activity Category
                    </label>
                    <select id="category" name="category"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="Badan Beruniform" selected>Badan Beruniform</option>
                        <option value="Kelab & Persatuan">Kelab & Persatuan</option>
                        <option value="Sukan & Permainan">Sukan & Permainan</option>
                    </select>
                </div>

                {{-- COLUMN 5 Activity Address --}}
                <div class="mt-6">
                    <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Actitivity Address
                    </label>
                    <textarea id="address" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Activity address here..."></textarea>
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
                                class="teacher-tr bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
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
                                    <button type="button" data-teacher-id="{{ $teacher->id }}"
                                        class="assign-leader-btn font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                        Assign Leader
                                    </button>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>

                    </table>
                    <nav aria-label="Page navigation example" class="flex items-center justify-end py-4 px-4">
                        <ul class="inline-flex -space-x-px text-base h-10" id="pagination-buttons-teacher">
                            <li>
                                <a href="#"
                                    class="flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Previous</a>
                            </li>
                        </ul>
                    </nav>
                    {{-- <div class="my-4 px-3"></div> --}}
                </div>

            </div>

            <!-- Step 3: Students List -->
            <div class="step-content hidden" data-step="3">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-6">
                    <div
                        class="flex items-center justify-end flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-transparent">
                        <div>
                            <label for="student-search" class="sr-only">Search</label>
                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                    </svg>
                                </div>
                                <input type="text" id="student-search"
                                    class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Search for students">
                            </div>
                        </div>
                    </div>
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="p-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-all-students" type="checkbox"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="checkbox-all-students" class="sr-only">checkbox</label>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3">Name</th>
                                <th scope="col" class="px-6 py-3">Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                            <tr
                                class="student-tr bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="w-4 p-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-student-{{ $student->id }}" type="checkbox"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="checkbox-student-{{ $student->id }}"
                                            class="sr-only">checkbox</label>
                                    </div>
                                </td>
                                <th scope="row"
                                    class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                    <div class="ps-3">
                                        <div class="text-base font-semibold">{{ $student->user->name }}</div>
                                        <div class="font-normal text-gray-500">{{ $student->user->email }}</div>
                                    </div>
                                </th>
                                <td class="px-6 py-4">{{ $student->user->email }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <nav aria-label="Page navigation example" class="flex items-center justify-end py-4 px-4">
                        <ul class="inline-flex -space-x-px text-base h-10" id="pagination-buttons-student">
                            <li>
                                <a href="#"
                                    class="flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Previous</a>
                            </li>
                        </ul>
                    </nav>
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
    <script src="{{ asset('js/add-teachers-list.js') }}"></script>
    <script src="{{ asset('js/add-students-list.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('#submit-button').on('click', function () {
                // Collect data from the form
                console.log(`Represent: ${$('#represent').val()}`);
                console.log(`Achievement Placement ID: ${$('#achievement').val()}`);
                console.log(`Involvement ID: ${$('#involvement').val()}`);
                console.log($('#achievement').val());
                console.log($('#involvement').val());
                
                let formData = {
                    represent: $('#represent').val(),
                    achievement_id: $('#achievement').val(),
                    involvement_id: $('#involvement').val(),
                    club_id: $('#club').val(),
                    activity_place: $('#address').val(), // Collect the address from the textarea
                    category: $('#category').val(), // Collect the category dynamically
                    datetime_start: $('#date-start').val(), // Collect the start date
                    time_start: $('#time-start').val(), // Collect the start time
                    datetime_end: $('#date-end').val(), // Collect the end date
                    time_end: $('#time-end').val(), // Collect the end time
                    teachers: [],
                    students: [],
                    _token: '{{ csrf_token() }}' // Include CSRF token
                };
                
                // Collect selected teachers
                $('.teacher-tr input[type="checkbox"]:checked').each(function () {
                    formData.teachers.push($(this).attr('id').replace('checkbox-table-search-', ''));
                });
                
                // Collect selected students
                $('.student-tr input[type="checkbox"]:checked').each(function () {
                    formData.students.push($(this).attr('id').replace('checkbox-student-', ''));
                });
    
                // Collect selected teachers
                $('.teacher-tr input[type="checkbox"]:checked').each(function () {
                    formData.teachers.push($(this).attr('id').replace('checkbox-table-search-', ''));
                });
    
                // Collect selected students
                $('.student-tr input[type="checkbox"]:checked').each(function () {
                    formData.students.push($(this).attr('id').replace('checkbox-student-', ''));
                });
    
                // Send data to the API
                $.ajax({
                    url: '{{ route('activity.store') }}', // API endpoint
                    method: 'POST',
                    data: formData,
                    success: function (response) {
                                            // Display success message
                    alert(response.message || 'Activity submitted successfully!');

                        // Optionally, redirect or reset the form
                        window.location.href = '{{ route('activity.index') }}';
                    },
                    error: function (xhr) {
                        // Handle validation errors or other errors
                    if (xhr.status === 422) {
                        // Validation errors
                        let errors = xhr.responseJSON.errors;
                        let errorMessages = Object.values(errors).map(errorArray => errorArray.join(', ')).join('\n');
                        alert('Validation Errors:\n' + errorMessages);
                    } else {
                        // Other errors
                        alert('An error occurred: ' + (xhr.responseJSON.message || xhr.statusText));
                    }
                    }
                });
            });
        });
    </script>



    @endpush
</x-app-layout>