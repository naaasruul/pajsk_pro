<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Student Evaluation') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4">Evaluate: {{ $student->user->name }}</h3>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Student Class: {{ $student->class }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Club: {{ $club->club_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Position: {{ $position ? $position->position_name : 'No Position' }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Position Score: {{ $position ? $position->point : 0 }}/10</p>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('pajsk.store-evaluation', $student) }}" 
						x-data="{ 
							selectedCommitments: [],
							maxCommitments: 4,
							attendanceDays: 0,  // Track days separately
							attendanceScore: 0,
							positionScore: {{ $position ? $position->point : 0 }},
							commitmentScore: 0,
							serviceScore: 0,
							
							// Preload attendance scores from backend
							attendanceScores: {
								@foreach($attendanceScores as $attendance)
									{{ $attendance->attendance_count }}: {{ $attendance->score }},
								@endforeach
							},
							
							// Calculate score based on days
							calculateAttendanceScore(days) {
								this.attendanceDays = days;
								this.attendanceScore = this.attendanceScores[days] || 0;
								return this.attendanceScore;
							},
							
							calculateTotal() {
								return this.attendanceScore + this.positionScore + this.commitmentScore + this.serviceScore;
							},
							calculatePercentage() {
								return ((this.calculateTotal() / 110) * 100).toFixed(2);
							}
						}"
						x-init="
							// Initialize with first day selected
							$nextTick(() => {
								if ($refs.attendanceSlider) {
									$refs.attendanceSlider.value = 1;
									attendanceScore = calculateAttendanceScore(1);
								}
							});
						">
						@csrf

						<!-- Attendance Section -->
						<div class="mb-6">
							<h4 class="text-lg font-medium mb-4 border-b pb-2">Attendance [<span x-text="attendanceScore + ' Marks'"></span>]</h4>
							<div class="mb-4">
								<label for="attendance_count" class="block text-sm font-medium mb-2">Days Present</label>
								
								<div class="flex items-center gap-4">
									<!-- Slider -->
									<div class="flex-1">
										<input 
											type="range" 
											id="attendance_slider"
											x-ref="attendanceSlider"
											name="attendance_count"
											min="1" 
											max="12" 
											step="1" 
											value="1"
											x-on:input="
												$refs.attendanceInput.value = $event.target.value;
												calculateAttendanceScore($event.target.value);
											"
											class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
										>
										
										<!-- Slider Labels -->
										<div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mt-1">
											<template x-for="i in 12">
												<span 
													x-text="i" 
													:class="{ 
														'font-bold text-indigo-600 dark:text-indigo-400': i == attendanceDays,
														'opacity-50': i > attendanceDays 
													}">
												</span>
											</template>
										</div>
									</div>
									
									<!-- Input Box -->
									<div class="w-20">
										<input 
											type="number" 
											x-ref="attendanceInput"
											name="attendance_input"
											min="1" 
											max="12" 
											x-model="attendanceDays"
											x-on:change="
												if ($event.target.value > 12) $event.target.value = 12;
												if ($event.target.value < 1) $event.target.value = 1;
												$refs.attendanceSlider.value = $event.target.value;
												calculateAttendanceScore($event.target.value);
											"
											class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
										>
									</div>
								</div>
								
								{{-- <!-- Display days to points mapping -->
								<div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
									<span x-text="attendanceDays + ' day(s)'"></span> = 
									<span x-text="attendanceScore + ' point(s)'"></span>
								</div>
								 --}}
								@error('attendance_count')
									<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
								@enderror
							</div>
						</div>

                        <!-- Commitment Section -->
                        <div class="mb-6">
                            <h4 class="text-lg font-medium">Commitment [<span x-text="commitmentScore + ' Marks'"></span>]</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 pb-2 border-b mb-4">Select 4 commitments only.</p>
                            <div class="space-y-3">
                                @foreach($commitments as $commitment)
                                    <div class="flex items-start">
                                        <div class="flex items-center h-6">
                                            <input type="checkbox" name="commitments[]" value="{{ $commitment->id }}" 
                                                x-on:change="
                                                    if ($event.target.checked) {
                                                        if (selectedCommitments.length < maxCommitments) {
                                                            selectedCommitments.push($event.target.value);
                                                            commitmentScore += {{ $commitment->score }};
                                                        } else {
                                                            $event.target.checked = false;
                                                        }
                                                    } else {
                                                        selectedCommitments = selectedCommitments.filter(id => id !== $event.target.value);
                                                        commitmentScore -= {{ $commitment->score }};
                                                    }
                                                "
                                                :disabled="!selectedCommitments.includes('{{ $commitment->id }}') && selectedCommitments.length >= maxCommitments"
                                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900">
                                        </div>
                                        <div class="ml-3">
                                            <label class="text-sm font-medium">
                                                {{ $commitment->commitment_name }} ({{ $commitment->score }} points)
                                            </label>
                                            @if($commitment->description)
                                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $commitment->description }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('commitments')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Service Contribution Section -->
                        <div class="mb-6">
                            <h4 class="text-lg font-medium mb-4 border-b pb-2">Service Contribution [<span x-text="serviceScore + ' Marks'"></span>]</h4>
                            <div class="space-y-3">
                                @foreach($serviceContributions as $service)
                                    <div class="flex items-start">
                                        <div class="flex items-center h-6">
                                            <input type="radio" name="service_contribution_id" value="{{ $service->id }}"
                                                x-on:change="serviceScore = {{ $service->score }}"
                                                class="border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900">
                                        </div>
                                        <div class="ml-3">
                                            <label class="text-sm font-medium">
                                                {{ $service->service_name }} ({{ $service->score }} points)
                                            </label>
                                            @if($service->description)
                                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $service->description }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('service_contribution_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Score Summary -->
                        <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <h4 class="text-lg font-medium mb-4">Score Summary</h4>
                            <div class="space-y-2">
                                <p class="flex justify-between">
                                    <span>Attendance Score:</span>
                                    <span x-text="attendanceScore + '/40'"></span>
                                </p>
                                <p class="flex justify-between">
                                    <span>Position Score:</span>
                                    <span x-text="positionScore + '/10'"></span>
                                </p>
                                <p class="flex justify-between">
                                    <span>Involvement Score:</span>
                                    <span class="text-yellow-500">Not Implemented Yet!</span>
                                </p>
                                <p class="flex justify-between">
                                    <span>Achievement Score:</span>
                                    <span class="text-yellow-500">Not Implemented Yet!</span>
                                </p>
                                <p class="flex justify-between">
                                    <span>Commitment Score:</span>
                                    <span x-text="commitmentScore + '/10'"></span>
                                </p>
                                <p class="flex justify-between">
                                    <span>Service Contribution Score:</span>
                                    <span x-text="serviceScore + '/10'"></span>
                                </p>
                                <div class="border-t pt-2 mt-2">
                                    <p class="flex justify-between font-medium">
                                        <span>Total Score:</span>
                                        <span x-text="calculateTotal() + '/110'"></span>
                                    </p>
                                    <p class="flex justify-between text-blue-600 dark:text-blue-400 font-medium">
                                        <span>Overall Percentage:</span>
                                        <span x-text="calculatePercentage() + '%'"></span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-4">
                            <button type="button" 
                                x-on:click="
                                    selectedCommitments = [];
                                    attendanceScore = 0;
                                    commitmentScore = 0;
                                    serviceScore = 0;
                                    $refs.attendanceSelect.value = '0';
                                    document.querySelectorAll('input[name=\'commitments[]\']').forEach(el => el.checked = false);
                                    document.querySelectorAll('input[name=\'service_contribution_id\']').forEach(el => el.checked = false);
                                "
                                class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-600 rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Reset Form
                            </button>
                            
                            <a href="{{ route('pajsk.index') }}" 
                                class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                                Cancel
                            </a>
                            
                            <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Save Evaluation
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>