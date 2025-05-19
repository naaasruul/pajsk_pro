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
                                <p class="text-sm text-gray-600 dark:text-gray-400">Class: {{ $student->classroom->year . ' ' . $student->classroom->class_name }}
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Club: {{ $club->club_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Position: {{ $position ?
                                    $position->position_name : 'No Position' }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Position Score: {{ $position ?
                                    $position->point : 0 }}/10</p>
                            </div>
                        </div>
                    </div>

                    <form x-ref="form" method="POST" action="{{ route('pajsk.store-evaluation', $student) }}" 
                    x-data="{
                        selectedCommitments: JSON.parse(localStorage.getItem('selectedCommitments') || '[]'),
                        maxCommitments: 4,
                        attendanceDays: parseInt(localStorage.getItem('attendanceDays')) || 1,
                        attendanceScore: 0,
                        positionScore: {{ $position ? $position->point : 0 }},
                        commitmentScore: parseFloat(localStorage.getItem('commitmentScore')) || 0,
                        serviceScore: parseFloat(localStorage.getItem('serviceScore')) || 0,
                        achievementScore: {{ $highestAchievementScore }},
                        placementScore: {{ $highestPlacementScore }},
                        attendanceScores: {
                            @foreach($attendanceScores as $attendance)
                                {{ $attendance->attendance_count }}: {{ $attendance->score }},
                            @endforeach
                        },
                        selectedAttendanceId: localStorage.getItem('selectedAttendanceId') || null,
                        selectedPositionId: localStorage.getItem('selectedPositionId') || {{ $position ? $position->id : 'null' }},
                        selectedAchievementId: localStorage.getItem('selectedAchievementId') || {{ $highestAchievementId }},  
                        selectedAchievementActivityId: localStorage.getItem('selectedAchievementActivityId') || {{ $highestAchievementActivityId }},  
                        selectedPlacementId: localStorage.getItem('selectedPlacementId') || {{ $highestPlacementId }},
                        selectedPlacementActivityId: localStorage.getItem('selectedPlacementActivityId') || {{ $highestPlacementActivityId }},
                        selectedCommitmentIds: JSON.parse(localStorage.getItem('selectedCommitmentIds') || '[]'),
                        selectedServiceId: localStorage.getItem('selectedServiceId') || null,
                        
                        calculateAttendanceScore(days) {
                            this.attendanceDays = days;
                            this.attendanceScore = this.attendanceScores[days] || 0;
                            localStorage.setItem('attendanceDays', days);
                            return this.attendanceScore;
                        },
                        updateCommitments() {
                           localStorage.setItem('selectedCommitments', JSON.stringify(this.selectedCommitments));
                           localStorage.setItem('commitmentScore', this.commitmentScore);
                        },
                        updateServiceScore(score) {
                           this.serviceScore = score;
                           localStorage.setItem('serviceScore', score);
                        },
                        calculateTotal() {
                           return this.attendanceScore + this.positionScore + this.achievementScore + this.placementScore + this.commitmentScore + this.serviceScore;
                        },
                        calculatePercentage() {
                           return ((this.calculateTotal() / 110) * 100).toFixed(2);
                        },
                        initializeForm() {
                            // Initialize hidden inputs with current selection values
                            this.$refs.attendanceIdInput.value = this.selectedAttendanceId ?? 1;
                            this.$refs.positionIdInput.value = this.selectedPositionId;
                            this.$refs.achievementIdInput.value = this.selectedAchievementId;
                            this.$refs.achievementActivityIdInput.value = this.selectedAchievementActivityId;
                            this.$refs.placementIdInput.value = this.selectedPlacementId;
                            this.$refs.placementActivityIdInput.value = this.selectedPlacementActivityId;
                            this.$refs.commitmentIdsInput.value = JSON.stringify(this.selectedCommitmentIds);
                            this.$refs.serviceIdInput.value = this.selectedServiceId;
                        },
                        updateAttendanceId(days) {
                            // Get attendance record ID based on days
                            this.selectedAttendanceId = this.attendanceScores[days] ? days : null;
                            this.$refs.attendanceIdInput.value = this.selectedAttendanceId;
                            localStorage.setItem('selectedAttendanceId', this.selectedAttendanceId);
                        },
                        updateCommitmentIds() {
                            this.$refs.commitmentIdsInput.value = JSON.stringify(this.selectedCommitments);
                            localStorage.setItem('selectedCommitmentIds', JSON.stringify(this.selectedCommitments));
                        },
                        updateServiceId(serviceId) {
                            this.selectedServiceId = serviceId;
                            this.$refs.serviceIdInput.value = serviceId;
                            localStorage.setItem('selectedServiceId', serviceId);
                        },
                        resetStorage() {
                            localStorage.removeItem('attendanceDays');
                            localStorage.removeItem('selectedCommitments');
                            localStorage.removeItem('commitmentScore');
                            localStorage.removeItem('serviceScore');
                            localStorage.removeItem('selectedAttendanceId');
                            localStorage.removeItem('selectedPositionId');
                            localStorage.removeItem('selectedAchievementId');
                            localStorage.removeItem('selectedAchievementActivityId');
                            localStorage.removeItem('selectedPlacementId');
                            localStorage.removeItem('selectedPlacementActivityId');
                            localStorage.removeItem('selectedCommitmentIds');
                            localStorage.removeItem('selectedServiceId');
                        }
                    }" 
                    x-init="$nextTick(() => {
                        if ($refs.attendanceSlider) {
                             $refs.attendanceSlider.value = attendanceDays;
                             $refs.attendanceInput.value = attendanceDays;
                             attendanceScore = calculateAttendanceScore(attendanceDays);
                        }
                        initializeForm();
                    })">
                        @csrf

                        <!-- Hidden Inputs for IDs -->
                        <p class="hidden">attendance id</p>
                        <input type="hidden" class="flex justify-between p-2 bg-gray-100 rounded dark:bg-gray-600" name="attendance_id" x-ref="attendanceIdInput">
                        <p class="hidden">club position id</p>
                        <input type="hidden" class="flex justify-between p-2 bg-gray-100 rounded dark:bg-gray-600" name="position_id" x-ref="positionIdInput">
                        <p class="hidden">achievement id</p>
                        <input type="hidden" class="flex justify-between p-2 bg-gray-100 rounded dark:bg-gray-600" name="achievement_id" x-ref="achievementIdInput">
                        <p class="hidden">achievement activity id</p>
                        <input type="hidden" class="flex justify-between p-2 bg-gray-100 rounded dark:bg-gray-600" name="achievement_activity_id" x-ref="achievementActivityIdInput">
                        <p class="hidden">placement id</p>
                        <input type="hidden" class="flex justify-between p-2 bg-gray-100 rounded dark:bg-gray-600" name="placement_id" x-ref="placementIdInput">
                        <p class="hidden">placement activity id</p>
                        <input type="hidden" class="flex justify-between p-2 bg-gray-100 rounded dark:bg-gray-600" name="placement_activity_id" x-ref="placementActivityIdInput">
                        <p class="hidden">commitments id</p>
                        <input type="hidden" class="flex justify-between p-2 bg-gray-100 rounded dark:bg-gray-600" name="commitment_ids" x-ref="commitmentIdsInput">
                        <p class="hidden">service contributions id</p>
                        <input type="hidden" class="flex justify-between p-2 bg-gray-100 rounded dark:bg-gray-600" name="service_id" x-ref="serviceIdInput">

                        <!-- Attendance Section -->
                        <div class="mb-6">
                            <h4 class="text-lg font-medium mb-4 border-b pb-2">Attendance [<span
                                    x-text="attendanceScore + ' Marks'"></span>]</h4>
                            <div class="mb-4">
                                <label for="attendance_count" class="block text-sm font-medium mb-2">Days
                                    Present</label>
                                <div class="flex items-center gap-4">
                                    <!-- Slider -->
                                    <div class="flex-1">
                                        <input type="range" id="attendance_slider" x-ref="attendanceSlider"
                                            name="attendance" min="1" max="12" step="1" value="1" x-on:input="
                                    $refs.attendanceInput.value = $event.target.value;
                                    calculateAttendanceScore($event.target.value);
                                    updateAttendanceId($event.target.value);
                                " class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700">

                                        <!-- Slider Labels -->
                                        <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            <template x-for="i in 12">
                                                <span x-text="i" :class="{
														'font-bold text-indigo-600 dark:text-indigo-400': i == attendanceDays,
														'opacity-50': i > attendanceDays 
													}">
                                                </span>
                                            </template>
                                        </div>
                                    </div>

                                    <!-- Input Box -->
                                    <div class="w-20">
                                        <!-- Add a hidden input for the attendance ID -->
                                        <input type="hidden" name="attendance" :value="attendanceDays">
                                        <input type="number" x-ref="attendanceInput" min="1" max="12" x-model="attendanceDays" x-on:change="
												if ($event.target.value > 12) $event.target.value = 12;
												if ($event.target.value < 1) $event.target.value = 1;
												$refs.attendanceSlider.value = $event.target.value;
												calculateAttendanceScore($event.target.value);
											" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                </div>

                                @error('attendance_count')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Involvement section -->
                        @php
                            // Force filter by authenticated teacher club only for involvement stage
                            $involvementActivities = $clubActivities;
                        @endphp
                        <div class="space-y-2 mb-6">
                            <h4 class="text-lg font-medium mb-4 border-b pb-2">Involvement Stage [{{ $highestAchievementScore }} Marks]</h4>
                            <div class="space-y-2">
                                @forelse($involvementActivities as $activity)
                                    @if(isset($activity->involvement))
                                        <div class="flex justify-between p-2 bg-gray-100 rounded dark:bg-gray-600">
                                            <span>
                                                {{ $activity->represent }} {{ $activity->involvement->description }} in {{ $activity->club->club_name ?? 'N/A' }}, Peringkat {{ $activity->achievement->achievement_name ?? 'N/A' }}
                                            </span>
                                        </div>
                                    @endif
                                @empty
                                    <p class="text-gray-500">No activities recorded</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Placement section -->
                        @php
                            // Force filter by authenticated teacher club only for placement stage
                            $placementActivities = $clubActivities->filter(fn($a) => isset($a->placement));
                        @endphp
                        <div class="space-y-2 mb-6">
                            <h4 class="text-lg font-medium mb-4 border-b pb-2">Placement Stage [{{ $highestPlacementScore }} Marks]</h4>
                            <div class="space-y-2">
                                @forelse($placementActivities as $activity)
                                    <div class="flex justify-between p-2 bg-gray-100 rounded dark:bg-gray-600">
                                        <span>
                                            {{ $activity->represent }} {{ $activity->involvement->description ?? '' }} in {{ $activity->club->club_name ?? 'N/A' }},
                                            @if(isset($activity->placement))
                                                {{ $activity->placement->name }} Peringkat {{ $activity->achievement->achievement_name ?? 'N/A' }}
                                            @else
                                                No Placement
                                            @endif
                                        </span>
                                    </div>
                                @empty
                                    <p class="text-gray-500">No activities recorded</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Commitment Section -->
                        <div class="mb-6">
                            <h4 class="text-lg font-medium">Commitment [<span x-text="commitmentScore + ' Marks'"></span>]</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 pb-2 border-b mb-4">Select 4 commitments
                                only.</p>
                            <div class="space-y-3">
                                @foreach($commitments as $commitment)
                                <div class="flex items-start">
                                    <div class="flex items-center h-6">
                                        <input type="checkbox" id="commitment-{{ $commitment->id }}" 
                                name="commitments[]" 
                                value="{{ $commitment->id }}"
                                x-on:change="
                                    if ($event.target.checked) {
                                        if (selectedCommitments.length < maxCommitments) {
                                            selectedCommitments.push('{{ $commitment->id }}');
                                            commitmentScore += {{ $commitment->score }};
                                        } else {
                                            $event.target.checked = false;
                                        }
                                    } else {
                                        selectedCommitments = selectedCommitments.filter(id => id !== '{{ $commitment->id }}');
                                        commitmentScore -= {{ $commitment->score }};
                                    }
                                    updateCommitments();
                                    updateCommitmentIds();
                                "
                                            :checked="selectedCommitments.includes('{{ $commitment->id }}')"
                                            :disabled="!selectedCommitments.includes('{{ $commitment->id }}') && selectedCommitments.length >= maxCommitments"
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900">
                                    </div>
                                    <div class="ml-3">
                                        <label for="commitment-{{ $commitment->id }}" class="text-sm font-medium cursor-pointer">
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
                                            <input type="radio" id="service_contribution_id-{{ $service->id }}" name="service_contribution_id" value="{{ $service->id }}"
                                                x-on:change="
                                                    updateServiceScore({{ $service->score }});
                                                    updateServiceId($event.target.value);
                                                "
                                                class="border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900">
                                        </div>
                                        <div class="ml-3">
                                            <label for="service_contribution_id-{{ $service->id }}" class="text-sm font-medium cursor-pointer">
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
                                    <span>Achievement Score:</span>
                                    <span>{{ $highestAchievementScore }}/20</span>
                                </p>
                                <p class="flex justify-between">
                                    <span>Placement Score:</span>
                                    <span>{{ $highestPlacementScore }}/20</span>
                                </p>
                                <p class="flex justify-between">
                                    <span>Commitment Score:</span>
                                    <span x-text="commitmentScore + '/10'"></span>
                                </p>
                                <p class="flex justify-between">
                                    <span>Service Score:</span>
                                    <span x-text="serviceScore + '/10'"></span>
                                </p>
                                <p class="flex justify-between font-semibold">
                                    <span>Total Score:</span>
                                    <span x-text="calculateTotal() + '/110'"></span>
                                </p>
                                <p class="flex justify-between font-semibold">
                                    <span>Percentage:</span>
                                    <span x-text="calculatePercentage() + '%'"></span>
                                </p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end space-x-4">
                            <button type="reset" x-on:click="
                                attendanceDays = 1;
                                attendanceScore = calculateAttendanceScore(1);
                                selectedCommitments = [];
                                commitmentScore = 0;
                                serviceScore = 0;
                                $refs.attendanceSlider.value = 1;
                                $refs.attendanceInput.value = 1;
                                $refs.form.querySelectorAll('input[type=checkbox]').forEach(cb => cb.checked = false);
                                $refs.form.querySelectorAll('input[type=radio]').forEach(rb => rb.checked = false);
                                resetStorage();
                            " class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-600 rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Reset Form
                            </button>

                            <a href="{{ route('pajsk.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                                Cancel
                            </a>

                            <button type="button"
                                x-on:click="
                                    if (attendanceDays < 1) {
                                        alert('Please select attendance days');
                                        return;
                                    }
                                    if (selectedCommitments.length !== 4) {
                                        alert('Please select exactly 4 commitments');
                                        return;
                                    }
                                    if (!$refs.form.querySelector('input[name=service_contribution_id]:checked')) {
                                        alert('Please select a service contribution');
                                        return;
                                    }
                                    if (confirm('Are you sure you want to save this evaluation?')) {
                                        resetStorage();
                                        $refs.form.submit();
                                    }
                                "
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