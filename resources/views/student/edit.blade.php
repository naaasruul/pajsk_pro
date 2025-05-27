<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Student') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('students.update', $student) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <!-- User Information -->
                            <div class="border-b border-gray-900/10 pb-6">
                                <h2 class="text-base font-semibold leading-7">User Information</h2>
                                
                                <div class="mt-4">
                                    <x-input-label for="name" :value="__('Name')" />
                                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $student->user->name)" required autofocus />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <div class="mt-4">
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $student->user->email)" required />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Student Information -->
                            <div class="border-b border-gray-900/10 pb-6">
                                <h2 class="text-base font-semibold leading-7">Student Information</h2>
                                
                                <div class="flex flex-wrap -mx-2">
                                    <!-- New Year select -->
                                    <div class="w-full md:w-1/4 px-2 mt-4">
                                        <x-input-label for="year-select" :value="__('Year')" />
                                        <select id="year-select" name="year" class="mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                            <option value="">{{ __('Select Year') }}</option>
                                            @foreach($classroomsGrouped as $year => $classes)
                                                <option value="{{ $year }}" @if(isset($student->classroom) && $student->classroom->year == $year) selected @endif>{{ $year }}</option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('year')" class="mt-2" />
                                    </div>
    
                                    <!-- New Classroom select -->
                                    <div class="w-full md:w-3/4 px-2 mt-4">
                                        <x-input-label for="classroom-select" :value="__('Classroom')" />
                                        <select id="classroom-select" name="class_id" class="mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required disabled>
                                            <option value="">{{ __('Select Classroom') }}</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('class_id')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <x-input-label for="phone_number" :value="__('Phone Number')" />
                                    <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full" :value="old('phone_number', $student->phone_number)" required />
                                    <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                                </div>
{{-- 
                                <div class="mt-4">
                                    <x-input-label for="home_number" :value="__('Home Number')" />
                                    <x-text-input id="home_number" name="home_number" type="text" class="mt-1 block w-full" :value="old('home_number', $student->home_number)" required />
                                    <x-input-error :messages="$errors->get('home_number')" class="mt-2" />
                                </div> --}}

                                <div class="mt-4">
                                    <x-input-label for="address" :value="__('Address')" />
                                    <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $student->address)" required />
                                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center gap-4">
                            <x-primary-button>{{ __('Update') }}</x-primary-button>
                            <a href="{{ route('students.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function(){
        var classrooms = @json($classroomsGrouped);
        var yearSelect = document.getElementById('year-select');
        var classSelect = document.getElementById('classroom-select');
        var selectedClassId = "{{ old('class_id', $student->class_id) }}";

        function populateClassroomSelect(selectedYear) {
            classSelect.innerHTML = '<option value="">{{ __("Select Classroom") }}</option>';
            if(selectedYear && classrooms[selectedYear]) {
                classrooms[selectedYear].forEach(function(cls) {
                    var option = document.createElement('option');
                    option.value = cls.id;
                    option.text = cls.year + ' ' + cls.class_name;
                    if(cls.id == selectedClassId) {
                        option.selected = true;
                    }
                    classSelect.appendChild(option);
                });
                classSelect.disabled = false;
            } else {
                classSelect.disabled = true;
            }
        }

        yearSelect.addEventListener('change', function(){
            populateClassroomSelect(this.value);
        });

        // If a year is preselected, populate the classroom select on page load
        if(yearSelect.value) {
            populateClassroomSelect(yearSelect.value);
        }
    });
    </script>
</x-app-layout>