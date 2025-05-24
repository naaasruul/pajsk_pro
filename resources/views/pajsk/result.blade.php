<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Evaluation Review') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(isset($totalScores) && empty($totalScores))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">No Assessments!</strong>
                            <span class="block sm:inline">No club evaluations have been recorded yet.</span>
                        </div>
                    @endif

                    @php
                        $allClubs = collect($assessment->club_ids ?? [])->map(function($id) {
                            return \App\Models\Club::find($id)?->club_name;
                        })->filter();
                        
                        $assessedClubs = collect($totalScores ?? [])->filter()->keys()
                            ->map(fn($index) => $assessment->club_ids[$index])
                            ->map(fn($id) => \App\Models\Club::find($id)?->club_name)
                            ->filter();
                        
                        $pendingClubs = $allClubs->diff($assessedClubs);
                        $completedCount = $assessedClubs->count();
                        $totalCount = $allClubs->count();
                    @endphp
                    
                    @if($pendingClubs->isNotEmpty())
                        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4" role="alert">
                             <strong class="font-bold">Evaluation Progress ({{ $completedCount }}/{{ $totalCount }}):</strong>
                             <span class="block sm:inline mt-1">
                                 Pending assessments for: {{ $pendingClubs->implode(', ') }}
                             </span>
                        </div>
                    @endif

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4">Evaluation Results for {{ isset($student) && isset($student->user) ? $student->user->name : 'Student' }}</h3>
                        
						<!-- Student Info -->
						<div class="grid grid-cols-2 gap-4 mb-6">
							<div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
								<h4 class="font-medium text-sm text-gray-500 dark:text-gray-400 mb-2">Student Information</h4>
								<div class="space-y-1">
									<p class="text-gray-900 dark:text-gray-100">Class: {{ isset($year) ? $year : '' }} {{ isset($class_name) ? $class_name : '' }}</p>
								    <p class="text-sm text-gray-500 dark:text-gray-400">{{ isset($student) && isset($student->user) ? $student->user->name : 'Student' }}</p>
								</div>
							</div>
							<div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
								<h4 class="font-medium text-sm text-gray-500 dark:text-gray-400 mb-2">Assessment Date</h4>
								<p class="text-gray-900 dark:text-gray-100">Last Updated: {{ isset($assessment) && isset($assessment->updated_at) ? $assessment->updated_at->format('d/m/Y H:i') : 'N/A' }}</p>
								<p class="text-sm text-gray-500 dark:text-gray-400">Created: {{ isset($assessment) && isset($assessment->created_at) ? $assessment->created_at->format('d/m/Y H:i') : 'N/A' }}</p>
							</div>
						</div>
						
						<!-- Club and Position Info -->
						{{-- <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-6">
							<h4 class="font-medium text-sm text-gray-500 dark:text-gray-400 mb-2">Club & Position Information</h4>
							<div class="space-y-1">
								<p class="text-gray-900 dark:text-gray-100">Club: {{ isset($club) ? $club : 'N/A' }}</p>
								<p class="text-gray-900 dark:text-gray-100">Position: {{ isset($position) ? $position : 'No Position' }}</p>
							</div>
						</div> --}}

                        @if(isset($extracocuricullum) && $extracocuricullum)
                        <!-- Extra Cocu Breakdown -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-6">
                            <h4 class="text-lg font-medium mb-4">Extra-Cocurricular Points Breakdown</h4>
                            <div class="space-y-3">

                                <div class="py-2 border-b dark:border-gray-600">
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium">Service Point</span>
                                        <span class="text-lg">
                                            {{ isset($extracocuricullum->service) ? $extracocuricullum->service->point . ' pts' : 'N/A' }}
                                        </span>
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-300">
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            <p>{{ isset($extracocuricullum->service) && isset($extracocuricullum->service->name) ? $extracocuricullum->service->name : 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="py-2 border-b dark:border-gray-600">
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium">Special Award Point</span>
                                        <span class="text-lg">
                                            {{ isset($extracocuricullum->specialAward) ? $extracocuricullum->specialAward->point . ' pts' : 'N/A' }}
                                        </span>
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-300">
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            <p>{{ isset($extracocuricullum->specialAward) && isset($extracocuricullum->specialAward->name) ? $extracocuricullum->specialAward->name : 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="py-2 border-b dark:border-gray-600">
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium">Community Service Point</span>
                                        <span class="text-lg">
                                            {{ isset($extracocuricullum->communityService) ? $extracocuricullum->communityService->point . ' pts' : 'N/A' }}
                                        </span>
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-300">
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            <p>{{ isset($extracocuricullum->communityService) && isset($extracocuricullum->communityService->name) ? $extracocuricullum->communityService->name : 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="py-2 border-b dark:border-gray-600">
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium">TIMMS & PISA Point</span>
                                        <span class="text-lg">
                                            {{ isset($extracocuricullum->timmsAndPisa) ? $extracocuricullum->timmsAndPisa->point . ' pts' : 'N/A' }}
                                        </span>
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-300">
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            <p>{{ isset($extracocuricullum->timmsAndPisa) && isset($extracocuricullum->timmsAndPisa->name) ? $extracocuricullum->timmsAndPisa->name : 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="py-2 dark:border-gray-600">
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium">NILAM Point</span>
                                        <span class="text-lg">
                                            {{ isset($extracocuricullum->nilam) ? $extracocuricullum->nilam->point . ' pts' : 'N/A' }}
                                        </span>
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-300">
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            <p>                                            
                                                {{ isset($extracocuricullum->nilam) && isset($extracocuricullum->nilam->tier) && isset($extracocuricullum->nilam->achievement) ? 
                                                   $extracocuricullum->nilam->tier->name . ', ' . $extracocuricullum->nilam->achievement->achievement_name : 'N/A' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Total Points -->
                                <div class="flex justify-between items-center pt-4 mt-4 border-t border-gray-300 dark:border-gray-500">
                                    <div>
                                        <span class="text-xl font-bold">Total Points</span>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Overall Extra-Cocuricullar Performance Rating</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-2xl font-bold">{{ isset($extracocuricullum->total_point) ? $extracocuricullum->total_point : '0' }} pts</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Score Breakdown -->
                        <h4 class="text-lg font-medium mb-4">PAJSK Score Breakdown</h4>

                        @foreach($assessment->club_ids as $index => $clubId)
                            @if(isset($totalScores[$index]) && $totalScores[$index] !== null)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-6 page-break">
                                    <div class="space-y-3">

                                        <!-- Club Information Section -->
										<div class="py-2 border-b dark:border-gray-600">
                                            <div class="flex justify-between items-center">
                                                <span class="font-medium">Club Score</span>
                                                <span class="text-lg">{{ $scores['club_positions']['scores'][$index] ?? 'N/A' }}/10</span>
                                            </div>
                                            <div class="text-sm text-gray-600 dark:text-gray-300">
												<div class="text-sm text-gray-500 dark:text-gray-400">
													<p>
                                                        {{ $scores['clubs']['names'][$index] ?? 'N/A' }} &bull; {{ $scores['club_positions']['names'][$index] ?? 'N/A' }}
                                                    </p>
												</div>
                                            </div>
                                        </div>
                                        <!-- Attendance Section -->
                                        <div class="py-2 border-b dark:border-gray-600">
                                            <div class="flex justify-between items-center">
                                                <div>
                                                    <span class="font-medium">Attendance Score</span>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                                        <p>Days Present: {{ $scores['attendance']['counts'][$index] ?? '0' }} days</p>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <span class="text-lg">{{ $scores['attendance']['scores'][$index] ?? 'N/A' }}/40</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Achievement Section -->
                                        <div class="py-2 border-b dark:border-gray-600">
                                            <div class="flex justify-between items-center">
                                                <span class="font-medium">Achievement Score</span>
                                                <span class="text-lg">{{ $scores['achievement']['scores'][$index] ?? 'N/A' }}/20</span>
                                            </div>
                                            <div class="text-sm text-gray-600 dark:text-gray-300">
                                                @if(!is_null($achievement_ids[$index]))
                                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                                            <p>{{ $scores['achievement_strings'][$index] }}</p>
                                                        </div>
                                                @endif
                                            </div>
                                        </div>
                                        <!-- Placement Section -->
                                        <div class="py-2 border-b dark:border-gray-600">
                                            <div class="flex justify-between items-center">
                                                <span class="font-medium">Placement Score</span>
                                                <span class="text-lg">{{ $scores['placement']['scores'][$index] ?? 'N/A' }}/20</span>
                                            </div>
                                            <div class="text-sm text-gray-600 dark:text-gray-300">
                                                @if(!is_null($placement_ids[$index]))
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                                            <p>
                                                                {{ $scores['placement_strings'][$index] }} 
                                                            </p>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <!-- Commitments Section -->
                                        <div class="py-2 border-b dark:border-gray-600">
                                            <div class="flex justify-between items-center">
                                                <span class="font-medium">Commitment Score</span>
                                                <span class="text-lg">{{ $scores['commitments']['scores'][$index][0] ?? 'N/A' }}/10</span>
                                            </div>
                                            <div class="pl-4 text-sm text-gray-500 dark:text-gray-400">
                                                @foreach($scores['commitments']['names'][$index] ?? [] as $name)
                                                    <p>&bull; {{ $name }}</p>
                                                @endforeach
                                            </div>
                                        </div>
                                        <!-- Service Contribution Section -->
                                        <div class="py-2 dark:border-gray-600">
                                            <div class="flex justify-between items-center">
                                                <span class="font-medium">Service Contribution Score</span>
                                                <span class="text-lg">{{ $scores['service_contributions']['scores'][$index] ?? 'N/A' }}/10</span>
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                <p>{{ $scores['service_contributions']['names'][$index] ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        <!-- Total Score Section -->
                                        <div class="flex justify-between items-center pt-4 mt-4 border-t border-gray-300 dark:border-gray-500">
                                            <div>
                                                <span class="text-xl font-bold">Total Score</span>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Overall Performance (%)</p>
                                            </div>
                                            <div class="text-right">
                                                <span class="text-2xl font-bold">{{ $totalScores[$index] ?? '0' }}/110</span>
                                                <p class="text-sm font-medium {{ (isset($percentages[$index]) && $percentages[$index] >= 80) ? 'text-green-500' : 'text-yellow-500' }}">
                                                    {{ isset($percentages[$index]) ? number_format($percentages[$index], 2) : '0.00' }}%
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach


                        <!-- Action Buttons -->
                        <div class="flex justify-end space-x-2 no-print">
                            <button onclick="window.print()"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-blue-800 uppercase tracking-widest hover:bg-blue-500 dark:hover:bg-blue-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9V2h12v7M6 22h12a2 2 0 002-2v-5H4v5a2 2 0 002 2zm6-17v6m-3-3h6" />
                                </svg>
                                Print
                            </button>
                            @php
                                $existingReport = isset($assessment) ? \App\Models\PajskReport::where('pajsk_assessment_id', $assessment->id)->first() : null;
                            @endphp
                            @if(isset($existingReport) && $existingReport)
                                @hasanyrole('admin|teacher|student')
                                <a href="{{ route('pajsk.show-report', ['student' => isset($student) ? $student : '', 'report' => $existingReport]) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-green-600 dark:bg-green-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-green-800 uppercase tracking-widest hover:bg-green-500 dark:hover:bg-green-300">
                                    View Report
                                </a>
                                @endhasanyrole
                            @else
                                @hasanyrole('admin|teacher')
                                @php
                                    $scoreCount = count(array_filter($totalScores ?? [], fn($score) => !is_null($score)));
                                @endphp
                                <a href="{{ route('pajsk.generate-report', ['student' => isset($student) ? $student : '', 'assessment' => isset($assessment) ? $assessment : '']) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-green-600 dark:bg-green-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-green-800 uppercase tracking-widest hover:bg-green-500 dark:hover:bg-green-300 
                                   {{ $scoreCount < 3 ? 'opacity-50 cursor-not-allowed pointer-events-none' : '' }}">
                                    Generate Report
                                </a>
                                @endhasanyrole
                            @endif
                            <a href="{{ route('pajsk.history') }}"
                               class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white">
                                Return to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>