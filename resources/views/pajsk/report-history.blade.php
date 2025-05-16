<x-app-layout>
	<x-slot name="header">
		<div class="flex justify-between items-center">
			<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
				{{ __('PAJSK Reports History') }}
			</h2>
		</div>
	</x-slot>

	<div class="relative overflow-x-auto">
			<div class="rounded-lg dark:border-gray-700">
				<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
					<table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
						<thead class="bg-gray-50 dark:bg-gray-700">
							<tr>
								<th
									class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
									Report ID</th>
								<th
									class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
									Student</th>
								<th
									class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
									Class</th>
								<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
									GPA</th>
									<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
									CGPA</th>
								<th
									class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
									Last Updated</th>
								<th
									class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
									Actions</th>
							</tr>
						</thead>
						<tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
							@forelse($reports as $report)
							<tr>
								<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
									{{ $report->id }}
								</td>
								<td class="px-6 py-4 whitespace-nowrap">
								    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
								        {{ $report->student->user->name }}
								    </div>
								</td>
								<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
									{{ $report->classroom->year . ' ' . $report->classroom->class_name }}
								</td>
								<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
									{{ $report->gpa }}
								</td>
								<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
									{{ $report->cgpa }}
								</td>
								<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
									{{ $report->updated_at->format('d/m/Y H:i') ?? $report->created_at->format('d/m/Y H:i') }}
								</td>
								<td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
									<a href="{{ route('pajsk.show-report', ['student' => $report->student->id, 'report' => $report]) }}"
										class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
										View Details
									</a>
								</td>
							</tr>
							@empty
								<tr>
									<td colspan="10" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
										No reports found.
									</td>
								</tr>
							@endforelse
						</tbody>
					</table>
				</div>
				<div class="mt-4">
					<x-paginator :paginator="$reports" />
				</div>
			</div>
		</div>
</x-app-layout>