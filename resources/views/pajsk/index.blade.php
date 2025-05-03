<x-app-layout>
	<x-slot name="header">
		<div class="flex justify-between items-center">
			<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
				{{ __('PAJSK Evaluation') }}
			</h2>
		</div>
	</x-slot>
	<x-container>
		<x-club-overview :clubName='$club->club_name' :clubCategory=' $club->category'></x-club-overview>

		@if($club)

		<div class="relative overflow-x-auto">
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
						<td class="px-6 py-4">{{ $student['user']['classroom']['year'] }} {{ $student['user']['classroom']['class_name'] }}</td>
						<td class="px-6 py-4">{{ $student['position_name'] }}</td>
						<td class="px-6 py-4">
							{{ $student['position_name'] !== 'No Position' ?
							($positions->where('position_name', $student['position_name'])->first()->point ?? 0)
							: 0 }}
						</td>
						<td class="px-6 py-4 space-x-3">
							<a href="{{ route('pajsk.evaluate-student', $student['id']) }}"
								class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
								Evaluate
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
		</div>

		<div class="mt-4">
			<x-paginator :paginator="$students" />
		</div>
		@else
		<div class="text-center py-8">
			<p class="text-gray-500 dark:text-gray-400">You are not assigned to any club yet. Please contact the
				administrator.</p>
		</div>
		@endif
	</x-container>

</x-app-layout>