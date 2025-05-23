<x-app-layout>
	<x-slot name="header">
		<div class="flex justify-between items-center">
			<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
				{{ $club->club_name }}
			</h2>
			<a href="{{ route('club.add-student') }}"
				class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
				Add New Student
			</a>
		</div>
	</x-slot>

	<x-container>
		
		<x-club-overview :clubName="$club->club_name ?? 'No Club'" :clubCategory="$club->category ?? ''">
			<x-card title="{{ $genderCounts['male'] ?? 0 }}" content="Male" />
			<x-card title="{{ $genderCounts['female'] ?? 0 }}" content="Female" />
			<x-card title="{{ count($studentsWithPositions) }}" content="Total" />
		</x-club-overview>

		<div class="relative overflow-x-auto">
			<div class=" rounded-lg dark:border-gray-700">
				<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
					@if($club)
					<div class="relative overflow-x-auto">
						@include('club.partials.club-table')
					</div>
	
					<div class="mt-4 flex justify-between items-center">
						<div class="text-sm text-gray-600 dark:text-gray-400">
							<x-paginator :paginator="$students" />
						</div>
					</div>
					@else
					<div class="text-center py-8">
						<p class="text-gray-500 dark:text-gray-400">You are not assigned to any club yet. Please contact the
							administrator.</p>
					</div>
					@endif
				</div>
			</div>
		</div>
	</x-container>
	
</x-app-layout>