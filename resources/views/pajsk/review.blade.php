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
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4">Evaluation Results for {{ $student->user->name }}</h3>
                        
						<!-- Student Info -->
						<div class="grid grid-cols-2 gap-4 mb-6">
							<div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
								<h4 class="font-medium text-sm text-gray-500 dark:text-gray-400 mb-2">Student Information</h4>
								<div class="space-y-1">
									<p class="text-gray-900 dark:text-gray-100">Class: {{ $student->class }}</p>
								</div>
							</div>
							<div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
								<h4 class="font-medium text-sm text-gray-500 dark:text-gray-400 mb-2">Assessment Date</h4>
								<p class="text-gray-900 dark:text-gray-100">{{ $assessment->created_at->format('d/m/Y H:i') }}</p>
							</div>
						</div>
						
						<!-- Club and Position Info -->
						<div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-6">
							<h4 class="font-medium text-sm text-gray-500 dark:text-gray-400 mb-2">Club & Position Information</h4>
							<div class="space-y-1">
								<p class="text-gray-900 dark:text-gray-100">Club: {{ $student->current_club->club_name }}</p>
								<p class="text-gray-900 dark:text-gray-100">Position: {{ $student->current_position ? $student->current_position->position_name : 'No Position' }}</p>
							</div>
						</div>
                        
                        <!-- Score Breakdown -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 mb-6">
                            <h4 class="text-lg font-medium mb-4">Score Breakdown</h4>
                            <div class="space-y-3">
                                <div class="py-2 border-b dark:border-gray-600">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <span class="font-medium">Attendance Score</span>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                <p>Days Present: {{ $attendance->attendance_count }} days</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-lg">{{ $scores['attendance_score'] }}/40</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Position Section -->
								<div class="py-2 border-b dark:border-gray-600">
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium">Position Score</span>
                                        <span class="text-lg">{{ $scores['position_score'] }}/10</span>
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-300">
										<div class="text-sm text-gray-500 dark:text-gray-400">
											<p>{{ $student->current_position ? $student->current_position->position_name : 'No Position' }}</p>
										</div>
                                    </div>
                                </div>
                                
                                <!-- Involvement Section -->
                                <div class="py-2 border-b dark:border-gray-600">
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium">Involvement Score</span>
                                        <span class="text-lg">{{ $scores['involvement_score'] }}/20</span>
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-300">
                                        @forelse($student->activities as $activity)
											<div class="text-sm text-gray-500 dark:text-gray-400">
                                                <p>{{ $activity->represent }} {{ $activity->involvement->description }} In {{ $activity->club->club_name ?? 'Unknown Club' }} 
                                                    ({{ $activity->achievement->achievement_name }})</p>
                                            </div>
                                        @empty
                                            <p class="text-gray-500 italic">No activities recorded</p>
                                        @endforelse
                                    </div>
                                </div>

								<div class="py-2 border-b dark:border-gray-600">
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium">Placement Score</span>
                                        <span class="text-lg">{{ $scores['placement_score'] }}/20</span>
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-300">
                                        @forelse($student->activities as $activity)
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
                                        <span class="text-lg">{{ $scores['commitment_score'] }}/10</span>
                                    </div>
                                    <div class="pl-4 text-sm text-gray-500 dark:text-gray-400">
                                        @foreach($commitments as $commitment)
                                            <p>&bull; {{ $commitment->commitment_name }} ({{ $commitment->score }} points)</p>
                                        @endforeach
                                    </div>
                                </div>
                                
								<!-- Service Contribution Section -->
                                <div class="py-2 dark:border-gray-600">
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium">Service Score</span>
                                        <span class="text-lg">{{ $scores['service_score'] }}/10</span>
                                    </div>
									<div class="text-sm text-gray-500 dark:text-gray-400">
										<p>{{ $service->service_name }}</p>
									</div>
                                </div>

                                <!-- Total Score -->
                                <div class="flex justify-between items-center pt-4 mt-4 border-t border-gray-300 dark:border-gray-500">
                                    <div>
                                        <span class="text-xl font-bold">Total Score</span>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Overall Performance Rating</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-2xl font-bold">{{ $total }}/110</span>
                                        <p class="text-sm font-medium {{ $percentage >= 80 ? 'text-green-500' : 'text-yellow-500' }}">
                                            {{ number_format($percentage, 2) }}%
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('pajsk.index') }}"
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
