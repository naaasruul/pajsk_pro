<x-app-layout>
	<x-slot name="header">
		<div class="flex justify-between items-center">
			<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
				{{ __('PAJSK Evaluations History') }}
			</h2>
		</div>
	</x-slot>

	<div class="relative overflow-x-auto">
		<div class="p-4 border-2 border-gray-200 rounded-lg dark:border-gray-700">
			<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
				<div class="mb-6">
					<h2 class="text-2xl font-semibold text-gray-800 dark:text-white">{{ $club->club_name }}</h2>
					<p class="text-gray-600 dark:text-gray-400">Category: {{ $club->category }}</p>
					<p class="text-gray-600 dark:text-gray-400">Advisor: {{ $teacher->user->name }}</p>
				</div>
				<table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
					<thead class="bg-gray-50 dark:bg-gray-700">
						<tr>
							<th
								class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
								Student</th>
							<th
								class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
								Date</th>
							<th
								class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
								Total Score</th>
							<th
								class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
								Percentage</th>
							<th
								class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
								Actions</th>
						</tr>
					</thead>
					<tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
						@foreach($evaluations as $evaluation)
						<tr>
							<td class="px-6 py-4 whitespace-nowrap">
								<div class="text-sm font-medium text-gray-900 dark:text-gray-100">
									{{ $evaluation->student->user->name }}
								</div>
								<div class="text-sm text-gray-500 dark:text-gray-400">
									{{ $evaluation->student->class }}
								</div>
							</td>
							<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
								{{ $evaluation->created_at->format('d/m/Y H:i') }}
							</td>
							<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
								{{ $evaluation->total_score }}/110
							</td>
							<td class="px-6 py-4 whitespace-nowrap text-sm">
								<span
									class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $evaluation->percentage >= 80 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
									{{ number_format($evaluation->percentage, 2) }}%
								</span>
							</td>
							<td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
								<a href="{{ route('pajsk.review', ['student' => $evaluation->student, 'evaluation' => $evaluation]) }}"
									class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
									View Details
								</a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="mt-4">
				<x-paginator :paginator="$evaluations"/>
			</div>
		</div>
	</div>
</x-app-layout>