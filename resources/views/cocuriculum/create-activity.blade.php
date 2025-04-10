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
                        <select id="represent"
                        name="represent"
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
                    <select id="involvement"
                    name="involvement"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @foreach ( $involvementTypes as $involvementType )
                    <option value="Menghadiri" selected>{{ $involvementType->description }}</option>
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
                        <option value="Menghadiri" selected>{{ $club->club_name }}</option>
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
                        <option value="Menghadiri" selected>{{ $achievementType->achievement_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Step 2: Teachers List -->
            <div class="step-content hidden" data-step="2">
                <div class="mt-6">
                    <x-input-label for="teacher_id" :value="__('Select Teacher')" />
                    <select id="teacher_id" name="teacher_id"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">Select a Teacher</option>
                        @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                        @endforeach
                    </select>
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

    </script>
    @endpush
</x-app-layout>