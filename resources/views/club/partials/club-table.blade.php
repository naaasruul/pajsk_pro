<table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
	<thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
		<tr>
			<th scope="col" class="px-6 py-3">Name</th>
			<th scope="col" class="px-6 py-3">Class</th>
			<th scope="col" class="px-6 py-3">Position</th>
			<th scope="col" class="px-6 py-3">Points</th>
			<th scope="col" class="px-6 py-3">Actions</th>
		</tr>
	</thead>
	<tbody>
		@forelse($studentsWithPositions as $student)
		<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
			<td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
				{{ $student['user']['name'] }}
			</td>
			<td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $student['user']['student']['class'] }}</td>
			<td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $student['position_name'] }}</td>
			<td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
				{{ $student['position_name'] !== 'No Position' ?
				($positions->where('position_name', $student['position_name'])->first()->point ?? 0)
				: 0 }}
			</td>
			<td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
				<form action="{{ route('club.remove-student', $student['id']) }}" method="POST"
					class="inline">
					@csrf
					@method('DELETE')
					<button type="submit"
						class="font-medium text-red-600 dark:text-red-500 hover:underline"
						onclick="return confirm('Are you sure you want to remove this student from the club?')">
						Remove
					</button>
				</form>
				<a href="{{ route('club.edit-student', $student['id']) }}"
					class="font-medium text-blue-600 dark:text-blue-500 hover:underline ml-2">
					Edit Position
				</a>
			</td>
		</tr>
		@empty
		<tr>
			<td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
				No students registered in this club.
			</td>
		</tr>
		@endforelse
	</tbody>
</table>