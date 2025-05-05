<x-app-layout>
	<x-slot name="header">
		<div class="flex justify-between items-center">
			<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
				{{ __('Extra-Cocuricculum Evaluations History') }}
			</h2>
		</div>
	</x-slot>

	<x-container>
		{{-- <x-club-overview :clubName='$club->club_name' :clubCategory=' $club->category'></x-club-overview> --}}

		<form method="GET" action="{{ route('pajsk.extra-cocuriculum.history') }}" class="mb-4 grid grid-cols-4 gap-4">
			{{-- Search input (2/4) --}}
			{{-- <div class="col-span-4 sm:col-span-2">
				<input type="text" name="search" value="{{ request('search') }}" placeholder="Search..."
					class="w-full p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" />
			</div> --}}

			<div class="col-span-4 sm:col-span-3 relative">
				<label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
				<div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
					<svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
						fill="none" viewBox="0 0 20 20">
						<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
							d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
					</svg>
				</div>
				<input type="text" name="search" id="default-search" value="{{ request('search') }}"
					class="w-full p-2 ps-10 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
					placeholder="Search..." />
			</div>
			
			{{-- Year filter (1/4) --}}
			<div class="col-span-4 sm:col-span-1">
				<select name="year_filter" onchange="this.form.submit()"
					class="w-full p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
					<option value="">All Years</option>
					@for ($i = 1; $i <= 6; $i++)
						<option value="{{ $i }}" {{ request('year_filter') == "$i" ? 'selected' : '' }}>{{ $i }}</option>
					@endfor
				</select>
			</div>
		
			{{-- Club filter (1/4) --}}
			{{-- <div class="col-span-4 sm:col-span-1">
				<select name="club_filter" onchange="this.form.submit()"
					class="w-full p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
					<option value="">All Clubs</option>
					@foreach($clubs as $clubItem)
						<option value="{{ $clubItem->id }}" {{ request('club_filter') == $clubItem->id ? 'selected' : '' }}>
							{{ $clubItem->club_name }}
						</option>
					@endforeach
				</select>
			</div> --}}
		</form>
		

		<div class="relative overflow-x-auto">
			<div class="rounded-lg dark:border-gray-700">
				<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
					<table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
						<thead class="bg-gray-50 dark:bg-gray-700">
							<tr>
								<th
									class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
									Year</th>
								<th
									class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
									Student</th>
								<th
									class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
									Class</th>
								<th
									class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
									Date</th>
								<th
									class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
									Total Point</th>
								{{-- <th
									class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
									Percentage</th> --}}
								<th
									class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
									Actions</th>
							</tr>
						</thead>
						<tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
								@forelse($evaluations as $evaluation)
								<tr>
									<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
										{{ $evaluation->classroom->year }}
									</td>
									<td class="px-6 py-4 whitespace-nowrap">
										<div class="text-sm font-medium text-gray-900 dark:text-gray-100">
											{{ $evaluation->student->user->name }}
										</div>
									</td>
									<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
										{{ $evaluation->classroom->year . ' ' . $evaluation->classroom->class_name }}
									</td>
									<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
										{{ $evaluation->created_at->format('d/m/Y H:i') }}
									</td>
									<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
										{{ $evaluation->total_point }}
									</td>
									{{-- <td class="px-6 py-4 whitespace-nowrap text-sm">
										<span
											class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $evaluation->percentage >= 80 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
											{{ number_format($evaluation->percentage, 2) }}%
										</span>
									</td> --}}
									<td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
										<a href="{{ route('pajsk.extra-cocuriculum.result', ['student' => $evaluation->student, 'evaluation' => $evaluation]) }}"
											class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
											View Details
										</a>
									</td>
								</tr>
								@empty
								<tr>
									<td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
										No evaluations found.
									</td>
								</tr>
								@endforelse
						</tbody>
					</table>
				</div>
				<div class="mt-4">
					<x-paginator :paginator="$evaluations" />
				</div>
			</div>
		</div>
	</x-container>


</x-app-layout>