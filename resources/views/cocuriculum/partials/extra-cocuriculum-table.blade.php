<table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
	<thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
		<tr>
			<th scope="col" class="px-6 py-3">Name</th>
			<th scope="col" class="px-6 py-3">Class</th>
			<th scope="col" class="px-6 py-3">Points</th>
			<th scope="col" class="px-6 py-3">Actions</th>
		</tr>
	</thead>
	<tbody>
		@forelse($students as $student)
		<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
			<td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
				{{ $student->user->name }}
			</td>
			<td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
				{{ $student->classroom->year . ' ' . $student->classroom->class_name }}
			</td>
			<td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
				{{-- keluar kan markah extra cocuriculum.. kalau 0 tulis la 0 lamak --}}
				{{ $student->extraCocuriculum->total_point ?? 0 }}
			</td>
			<td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
				@if($existingEvaluations[$student->id])
					<a href="{{ route('pajsk.extra-cocuriculum.result', ['student' => $student, 'evaluation' => $existingEvaluations[$student->id]]) }}"
						class="font-medium text-green-600 dark:text-green-500 hover:underline">
						Result
					</a>
				@else
					<a href="{{ route('pajsk.extra-cocuriculum.create', $student->id) }}" 
					   class="text-blue-600 hover:text-blue-900 dark:text-blue-500 dark:hover:text-blue-700">
						Evaluate
					</a>
				@endif
			</td>
		</tr>
		@empty
		<tr>
			<td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
				No students found in you homeroom.
			</td>
		</tr>
		@endforelse
	</tbody>
</table>