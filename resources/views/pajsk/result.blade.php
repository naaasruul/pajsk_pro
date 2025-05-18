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
                        <span class="block sm:inline">One or more assessment categories have no data recorded yet.</span>
                    </div>
                    @endif

                    @php
                        $clubCount = count(isset($assessment) && isset($assessment->club_ids) ? $assessment->club_ids : []);
                        $dataCount = count(isset($totalScores) ? $totalScores : []);
                        $missingClubIds = array_slice(isset($assessment) && isset($assessment->club_ids) ? $assessment->club_ids : [], $dataCount);
                        $missingClubNames = collect($missingClubIds)
                          ->map(fn($id) => \App\Models\Club::find($id)?->club_name)
                          ->filter()
                          ->implode(', ');
                    @endphp
                    @if($clubCount > $dataCount)
                        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4" role="alert">
                             <strong class="font-bold">Incomplete Evaluation!</strong>
                             <span class="block sm:inline">
                                 {{ $clubCount - $dataCount }} club{{ ($clubCount - $dataCount) > 1 ? 's' : '' }} missing evaluation data:
                                 {{ $missingClubNames }}.
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

                        @for($i = 0; $i < count(isset($totalScores) ? $totalScores : []); $i++)
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-6 page-break">
                            <div class="space-y-3">

                                {{-- <!-- Club Section -->
								<div class="py-2 border-b dark:border-gray-600">
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium">Club Information</span>
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-300">
										<div class="text-sm text-gray-500 dark:text-gray-400">
											<p>
                                                <?php $club = isset($club_ids) && isset($club_ids[$i]) ? \App\Models\Club::find($club_ids[$i]) : null; ?>
                                                {{ isset($club) ? $club->club_name : 'N/A' }}
                                            </p>
										</div>
                                    </div>
                                </div> --}}

                                <!-- Club Information Section -->
								<div class="py-2 border-b dark:border-gray-600">
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium">Club Score</span>
                                        <span class="text-lg">{{ $scores['club_positions']['scores'][$i] ?? 'N/A' }}/10</span>
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-300">
										<div class="text-sm text-gray-500 dark:text-gray-400">
											<p>
                                                <?php 
                                                    $clubPos = isset($scores) && isset($scores['club_positions']) && isset($scores['club_positions']['ids']) && isset($scores['club_positions']['ids'][$i]) ? 
                                                        \App\Models\ClubPosition::find($scores['club_positions']['ids'][$i]) : null;
                                                    $club = isset($club_ids) && isset($club_ids[$i]) ? \App\Models\Club::find($club_ids[$i]) : null;
                                                ?>
                                                {{ isset($club) ? $club->club_name : 'N/A' }} &bull; {{ isset($clubPos) ? $clubPos->position_name : 'N/A' }}
                                            </p>
										</div>
                                    </div>
                                </div>

                                <div class="py-2 border-b dark:border-gray-600">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <span class="font-medium">Attendance Score</span>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                <p>
                                                    Days Present: 
                                                    <?php $daysPresent = isset($scores) && isset($scores['attendance']) && isset($scores['attendance']['ids']) && isset($scores['attendance']['ids'][$i]) ? 
                                                        \App\Models\Attendance::find($scores['attendance']['ids'][$i]) : null; ?>
                                                    {{ isset($daysPresent) ? $daysPresent->attendance_count : '0' }}
                                                    days</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-lg">{{ isset($scores) && isset($scores['attendance']) && isset($scores['attendance']['scores']) && isset($scores['attendance']['scores'][$i]) ? $scores['attendance']['scores'][$i] : 'N/A' }}/40</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Involvement Section -->
                                <div class="py-2 border-b dark:border-gray-600">
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium">Involvement Score</span>
                                        <span class="text-lg">{{ isset($scores) && isset($scores['involvement']) && isset($scores['involvement']['score']) ? $scores['involvement']['score'] : 'N/A' }}/20</span>
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-300">
                                        @forelse(isset($sortedActivities) ? $sortedActivities : [] as $activity)
											<div class="text-sm text-gray-500 dark:text-gray-400">
                                                <p>{{ isset($activity->represent) ? $activity->represent : '' }} {{ isset($activity->involvement) && isset($activity->involvement->description) ? $activity->involvement->description : 'N/A' }} In {{ isset($activity->club) && isset($activity->club->club_name) ? $activity->club->club_name : 'Unknown Club' }} Peringkat {{ isset($activity->achievement) && isset($activity->achievement->achievement_name) ? $activity->achievement->achievement_name : 'N/A' }}</p>
                                            </div>
                                        @empty
                                            <p class="text-gray-500 italic">No activities recorded</p>
                                        @endforelse
                                    </div>
                                </div>
                                <!-- Placement Section -->
								<div class="py-2 border-b dark:border-gray-600">
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium">Placement Score</span>
                                        <span class="text-lg">{{ isset($scores) && isset($scores['placement']) && isset($scores['placement']['score']) ? $scores['placement']['score'] : 'N/A' }}/20</span>
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-300">
                                        @forelse(isset($sortedActivities) ? $sortedActivities : [] as $activity)
                                            @if(isset($activity->placement) && $activity->placement)
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    <p>{{ isset($activity->placement->name) ? $activity->placement->name : 'N/A' }} {{ isset($activity->represent) ? $activity->represent : '' }} {{ isset($activity->involvement) && isset($activity->involvement->description) ? $activity->involvement->description : 'N/A' }} Peringkat {{ isset($activity->achievement) && isset($activity->achievement->achievement_name) ? $activity->achievement->achievement_name : 'N/A' }}</p>
                                                </div>
                                            @endif
                                        @empty
                                            <p class="text-gray-500 italic">No placement achievements recorded</p>
                                        @endforelse
                                    </div>
                                </div>

                                <!-- Commitments Section -->
                                <div class="py-2 border-b dark:border-gray-600">
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium">Commitment Score</span>
                                        <span class="text-lg">{{ isset($scores) && isset($scores['commitments']) && isset($scores['commitments']['scores']) && isset($scores['commitments']['scores'][$i]) && isset($scores['commitments']['scores'][$i][0]) ? $scores['commitments']['scores'][$i][0] : 'N/A' }}/10</span>
                                    </div>
                                    <div class="pl-4 text-sm text-gray-500 dark:text-gray-400">
                                        @foreach(isset($scores) && isset($scores['commitments']) && isset($scores['commitments']['ids']) && isset($scores['commitments']['ids'][$i]) ? $scores['commitments']['ids'][$i] : [] as $commitmentId)
                                            <?php $commitment = \App\Models\Commitment::find($commitmentId); ?>
                                            @if(isset($commitment) && $commitment)
                                            <p>&bull; {{ $commitment->commitment_name }} ({{ $commitment->score }} points)</p>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                
								<!-- Service Contribution Section -->
                                <div class="py-2 dark:border-gray-600">
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium">Service Score</span>
                                        <span class="text-lg">{{ isset($scores) && isset($scores['services']) && isset($scores['services']['scores']) && isset($scores['services']['scores'][$i]) ? $scores['services']['scores'][$i] : 'N/A' }}/10</span>
                                    </div>
									<div class="text-sm text-gray-500 dark:text-gray-400">
										<p>
                                            <?php $service = isset($scores) && isset($scores['services']) && isset($scores['services']['ids']) && isset($scores['services']['ids'][$i]) ? 
                                                \App\Models\ServiceContribution::find($scores['services']['ids'][$i]) : null; ?>
                                            {{ isset($service) ? $service->service_name : 'N/A' }}
                                        </p>
									</div>
                                </div>

                                <!-- Total Score -->
                                <div class="flex justify-between items-center pt-4 mt-4 border-t border-gray-300 dark:border-gray-500">
                                    <div>
                                        <span class="text-xl font-bold">Total Score</span>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Overall {{ isset($club) ? $club->club_name : 'Club' }} Performance (%)</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-2xl font-bold">{{ isset($totalScores) && isset($totalScores[$i]) ? $totalScores[$i] : '0' }}/110</span>
                                        <p class="text-sm font-medium {{ isset($percentages) && isset($percentages[$i]) && $percentages[$i] >= 80 ? 'text-green-500' : 'text-yellow-500' }}">
                                            {{ isset($percentages) && isset($percentages[$i]) ? number_format($percentages[$i], 2) : '0.00' }}%
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endfor

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
                                <a href="{{ route('pajsk.generate-report', ['student' => isset($student) ? $student : '', 'assessment' => isset($assessment) ? $assessment : '']) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-green-600 dark:bg-green-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-green-800 uppercase tracking-widest hover:bg-green-500 dark:hover:bg-green-300">
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