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
                    @if(empty($totalScores))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">No Assessments!</strong>
                        <span class="block sm:inline">One or more assessment categories have no data recorded yet.</span>
                    </div>
                    @endif

                    @php
                        $clubCount = count($assessment->club_ids ?? []);
                        $dataCount = count($totalScores);
                        $missingClubIds = array_slice($assessment->club_ids ?? [], $dataCount);
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
                        <h3 class="text-lg font-semibold mb-4">Evaluation Results for {{ $student->user->name }}</h3>
                        
						<!-- Student Info -->
						<div class="grid grid-cols-2 gap-4 mb-6">
							<div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
								<h4 class="font-medium text-sm text-gray-500 dark:text-gray-400 mb-2">Student Information</h4>
								<div class="space-y-1">
									<p class="text-gray-900 dark:text-gray-100">Class: {{ $year . ' ' . $class_name  }}</p>
								    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $student->user->name }}</p>
								</div>
							</div>
							<div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
								<h4 class="font-medium text-sm text-gray-500 dark:text-gray-400 mb-2">Assessment Date</h4>
								<p class="text-gray-900 dark:text-gray-100">Last Updated: {{ $assessment->updated_at->format('d/m/Y H:i') }}</p>
								<p class="text-sm text-gray-500 dark:text-gray-400">Created: {{ $assessment->created_at->format('d/m/Y H:i') }}</p>
							</div>
						</div>
						
						<!-- Club and Position Info -->
						{{-- <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-6">
							<h4 class="font-medium text-sm text-gray-500 dark:text-gray-400 mb-2">Club & Position Information</h4>
							<div class="space-y-1">
								<p class="text-gray-900 dark:text-gray-100">Club: {{ $club }}</p>
								<p class="text-gray-900 dark:text-gray-100">Position: {{ $position ? $position : 'No Position' }}</p>
							</div>
						</div> --}}

                        @if($extracocuricullum)
                        <!-- Extra Cocu Breakdown -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-6">
                            <h4 class="text-lg font-medium mb-4">Extra-Cocurricular Points Breakdown</h4>
                            <div class="space-y-3">

                                <div class="py-2 border-b dark:border-gray-600">
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium">Service Point</span>
                                        <span class="text-lg">
                                            {{ $extracocuricullum->service ? $extracocuricullum->service->point . ' pts' : 'N/A' }}
                                        </span>
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-300">
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            <p>{{ $extracocuricullum->service->name ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="py-2 border-b dark:border-gray-600">
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium">Special Award Point</span>
                                        <span class="text-lg">
                                            {{ $extracocuricullum->specialAward ? $extracocuricullum->specialAward->point . ' pts' : 'N/A' }}
                                        </span>
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-300">
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            <p>{{ $extracocuricullum->specialAward->name ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="py-2 border-b dark:border-gray-600">
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium">Community Service Point</span>
                                        <span class="text-lg">
                                            {{ $extracocuricullum->communityService ? $extracocuricullum->communityService->point . ' pts' : 'N/A' }}
                                        </span>
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-300">
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            <p>{{ $extracocuricullum->communityService->name ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="py-2 border-b dark:border-gray-600">
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium">TIMMS & PISA Point</span>
                                        <span class="text-lg">
                                            {{ $extracocuricullum->timmsAndPisa ? $extracocuricullum->timmsAndPisa->point . ' pts' : 'N/A' }}
                                        </span>
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-300">
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            <p>{{ $extracocuricullum->timmsAndPisa->name ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="py-2 dark:border-gray-600">
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium">NILAM Point</span>
                                        <span class="text-lg">
                                            {{ $extracocuricullum->nilam ? $extracocuricullum->nilam->point . ' pts' : 'N/A' }}
                                        </span>
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-300">
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            <p>                                            
                                                {{ $extracocuricullum->nilam ? $extracocuricullum->nilam->tier->name . ', ' . $extracocuricullum->nilam->achievement->achievement_name : 'N/A' }}
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
                                        <span class="text-2xl font-bold">{{ $extracocuricullum->total_point }} pts</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Score Breakdown -->
                        <h4 class="text-lg font-medium mb-4">PAJSK Score Breakdown</h4>

                        @for($i = 0; $i < count($totalScores); $i++)
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
                                                <?php $club = \App\Models\Club::find($club_ids[$i]); ?>
                                                {{ $club->club_name }}
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
                                                    $clubPos = \App\Models\ClubPosition::find($scores['club_positions']['ids'][$i]);
                                                    $club = \App\Models\Club::find($club_ids[$i]);
                                                ?>
                                                {{ $club->club_name }} &bull; {{ $clubPos->position_name }}
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
                                                    <?php $daysPresent = \App\Models\Attendance::find($scores['attendance']['ids'][$i]); ?>
                                                    {{ $daysPresent->attendance_count }}
                                                    days</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-lg">{{ $scores['attendance']['scores'][$i] ?? 'N/A' }}/40</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Involvement Section -->
                                <div class="py-2 border-b dark:border-gray-600">
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium">Involvement Score</span>
                                        <span class="text-lg">{{ $scores['involvement']['score'] }}/20</span>
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-300">
                                        @forelse($sortedActivities as $activity)  <!-- replaced iteration variable -->
											<div class="text-sm text-gray-500 dark:text-gray-400">
                                                <p>{{ $activity->represent }} {{ $activity->involvement->description }} In {{ $activity->club->club_name ?? 'Unknown Club' }} Peringkat {{ $activity->achievement->achievement_name }}</p>
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
                                        <span class="text-lg">{{ $scores['placement']['score'] }}/20</span>
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-300">
                                        @forelse($sortedActivities as $activity)  <!-- replaced iteration variable -->
                                            @if($activity->placement)
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    <p>{{ $activity->placement->name }} {{ $activity->represent }} {{ $activity->involvement->description }} Peringkat {{ $activity->achievement->achievement_name }}</p>
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
                                        <span class="text-lg">{{ $scores['commitments']['scores'][$i][0] ?? 'N/A' }}/10</span>
                                    </div>
                                    <div class="pl-4 text-sm text-gray-500 dark:text-gray-400">
                                        @foreach($scores['commitments']['ids'][$i] as $commitmentId)
                                            <?php $commitment = \App\Models\Commitment::find($commitmentId); ?>
                                            @if($commitment)
                                            <p>&bull; {{ $commitment->commitment_name }} ({{ $commitment->score }} points)</p>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                
								<!-- Service Contribution Section -->
                                <div class="py-2 dark:border-gray-600">
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium">Service Score</span>
                                        <span class="text-lg">{{ $scores['services']['scores'][$i] }}/10</span>
                                    </div>
									<div class="text-sm text-gray-500 dark:text-gray-400">
										<p>
                                            <?php $service = \App\Models\ServiceContribution::find($scores['services']['ids'][$i]); ?>
                                            {{ $service->service_name }}
                                        </p>
									</div>
                                </div>

                                <!-- Total Score -->
                                <div class="flex justify-between items-center pt-4 mt-4 border-t border-gray-300 dark:border-gray-500">
                                    <div>
                                        <span class="text-xl font-bold">Total Score</span>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Overall {{ $club->club_name }} Performance (%)</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-2xl font-bold">{{ $totalScores[$i] }}/110</span>
                                        <p class="text-sm font-medium {{ $percentages[$i] >= 80 ? 'text-green-500' : 'text-yellow-500' }}">
                                            {{ number_format($percentages[$i], 2) }}%
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
                            <a href="{{ route('pajsk.report', ['student' => $student, 'assessment' => $assessment]) }}" 
                               class="inline-flex items-center px-4 py-2 bg-green-600 dark:bg-green-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-green-800 uppercase tracking-widest hover:bg-green-500 dark:hover:bg-green-300">
                                Generate Report
                            </a>
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
