<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
			{{ __('Add Student') }}
		</h2>
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
				<div class="p-6 text-gray-900 dark:text-gray-100">
					<h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">
                        Add Student to {{ $club->club_name }}
                    </h2>

                    <!-- Dependent selects: Year, Class, Student -->
                    <div class="mb-6 space-y-4">
						<div class="flex flex-wrap -mx-2">
							<div class="w-full md:w-1/4 px-2 mt-4">
								<x-input-label for="year-select" :value="__('Year')" />
								<select id="year-select" class="mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
									<option value="">{{ __('Select Year') }}</option>
									@foreach($groupedStudents as $year => $classes)
										<option value="{{ $year }}">{{ $year }}</option>
									@endforeach
								</select>
							</div>
							<div class="w-full md:w-3/4 px-2 mt-4">
								<x-input-label for="class-select" :value="__('Class')" />
								<select data-tooltip-target="select-year-tooltip" data-tooltip-placement="bottom" id="class-select" class="mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed" disabled>
									<option value="">{{ __('Select Class') }}</option>
								</select>
								<div id="select-year-tooltip" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
									Select Year First
									<div class="tooltip-arrow" data-popper-arrow></div>
								</div>
							</div>
						</div>
                        <div>
                            <x-input-label for="student-select" :value="__('Student')" />
                            <select data-tooltip-target="select-yearclass-tooltip" data-tooltip-placement="bottom" name="student_id" id="student-select" class="mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed" disabled>
                                <option value="">{{ __('Select Student') }}</option>
                            </select>
                            @error('student_id')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
							<div id="select-yearclass-tooltip" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
								Select Year and Class First
								<div class="tooltip-arrow" data-popper-arrow></div>
							</div>
                        </div>
                    </div>

                    <!-- Position select remains unchanged -->
					<form method="POST" action="{{ route('club.store-student') }}">
						@csrf
                        <!-- Hidden field to store selected student -->
                        <input type="hidden" name="student_id" id="selected-student">
						<div class="mb-6">
							<x-input-label for="position_id" :value="__('Position')" />
							<select name="position_id" id="position_id" class="mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
								<option value="">{{ __('Select a position') }}</option>
								@foreach($positions as $position)
									<option value="{{ $position->id }}">
                                        {{ $position->position_name }} ({{ $position->point }} points)
									</option>
								@endforeach
							</select>
							@error('position_id')
								<p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
							@enderror
						</div>

						<div class="flex items-center justify-end gap-4">
							<a href="{{ route('club.index') }}"
								class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
								Cancel
							</a>
							<button type="submit"
								class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
								Add Student
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script>
        document.addEventListener('DOMContentLoaded', function(){
            var groupedData = @json($groupedStudents);
            var yearSelect = document.getElementById('year-select');
            var classSelect = document.getElementById('class-select');
            var studentSelect = document.getElementById('student-select');
            var hiddenStudent = document.getElementById('selected-student');
            var yearTooltip = document.getElementById('select-year-tooltip');
            var yearclassTooltip = document.getElementById('select-yearclass-tooltip');

            // Populate class select based on selected year
            yearSelect.addEventListener('change', function(){
                var selectedYear = this.value;
                classSelect.innerHTML = '<option value="">{{ __("Select Class") }}</option>';
                studentSelect.innerHTML = '<option value="">{{ __("Select Student") }}</option>';
                hiddenStudent.value = '';
                if(selectedYear && groupedData[selectedYear]) {
                    var classes = groupedData[selectedYear];
                    for (var className in classes) {
                        var option = document.createElement('option');
                        option.value = className;
                        option.text = className;
                        classSelect.appendChild(option);
                    }
                    classSelect.disabled = false;
					classSelect.classList.remove('cursor-not-allowed');
					if(yearTooltip) {
						yearTooltip.classList.add('hidden');
					}

                    studentSelect.disabled = true;
					studentSelect.classList.add('cursor-not-allowed');
					if(yearclassTooltip) {
						yearclassTooltip.classList.remove('hidden');
					}
                } else {
                    classSelect.disabled = true;
					classSelect.classList.add('cursor-not-allowed');
					if(yearTooltip) {
						yearTooltip.classList.remove('hidden');
					}

                    studentSelect.disabled = true;
					studentSelect.classList.add('cursor-not-allowed');
					if(yearclassTooltip) {
						yearclassTooltip.classList.remove('hidden');
					}
                }
            });

            // Populate student select based on selected class
            classSelect.addEventListener('change', function(){
                var selectedYear = yearSelect.value;
                var selectedClass = this.value;
                studentSelect.innerHTML = '<option value="">{{ __("Select Student") }}</option>';
                hiddenStudent.value = '';
                if(selectedYear && selectedClass && groupedData[selectedYear][selectedClass]) {
                    var students = groupedData[selectedYear][selectedClass];
                    students.forEach(function(student){
                        var option = document.createElement('option');
                        option.value = student.id;
                        option.text = student.user.name;
                        studentSelect.appendChild(option);
                    });
                    studentSelect.disabled = false;
					studentSelect.classList.remove('cursor-not-allowed');
					if(yearclassTooltip) {
						yearclassTooltip.classList.add('hidden');
					}
                } else {
                    studentSelect.disabled = true;
					studentSelect.classList.add('cursor-not-allowed');
					if(yearclassTooltip) {
						yearclassTooltip.classList.remove('hidden');
					}
                }
            });

            // When a student is selected, update hidden input
            studentSelect.addEventListener('change', function(){
                hiddenStudent.value = this.value;
            });
        });
	</script>
</x-app-layout>