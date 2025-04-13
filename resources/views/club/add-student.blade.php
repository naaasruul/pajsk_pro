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
					<h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">Add Student to {{
						$club->club_name }}</h2>

					<form method="POST" action="{{ route('club.store-student') }}">
						@csrf

						<div class="mb-6">
							<label for="student_id"
								class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Student</label>
							<select name="student_id" id="student_id"
								class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
								<option value="">Select a student</option>
								@foreach($availableStudents as $student)
								<option value="{{ $student->id }}">{{ $student->user->name }} - {{ $student->class }}
								</option>
								@endforeach
							</select>
							@error('student_id')
							<p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
							@enderror
						</div>

						<div class="mb-6">
							<label for="position_id"
								class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Position</label>
							<select name="position_id" id="position_id"
								class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
								<option value="">Select a position</option>
								@foreach($positions as $position)
								<option value="{{ $position->id }}">{{ $position->position_name }} ({{ $position->point
									}} points)</option>
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
								class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
								Add Student
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</x-app-layout>