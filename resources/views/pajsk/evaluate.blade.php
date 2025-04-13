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
                            attendanceDays: 0,
                            attendanceScore: 0,
                            positionScore: {{ $position ? $position->point : 0 }},
                            commitmentScore: 0,
                            serviceScore: 0,
                            
                            attendanceScores: {
                                @foreach($attendanceScores as $attendance)
                                    {{ $attendance->attendance_count }}: {{ $attendance->score }},
                                @endforeach
                            },
                            
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
                            $nextTick(() => {
                                if ($refs.attendanceSlider) {
                                    $refs.attendanceSlider.value = 1;
                                    attendanceScore = calculateAttendanceScore(1);
                                }
                            });">
                        @csrf
                        
                        <!-- Attendance with slider -->
                        <div class="space-y-2">
                            <h4 class="text-lg font-medium">Attendance (40 marks)</h4>
                            <input type="range" min="1" max="100" step="1" x-ref="attendanceSlider" x-on:input="attendanceScore = calculateAttendanceScore($event.target.value)" class="w-full">
                            <p class="text-sm text-gray-600 dark:text-gray-400">Days: <span x-text="attendanceDays"></span></p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Score: <span x-text="attendanceScore"></span>/40</p>
                        </div>

                        <!-- Involvement section -->
                        <div class="space-y-2">
                            <h4 class="text-lg font-medium">Involvement Stage (20 marks)</h4>
                            <div class="p-4 bg-gray-50 rounded-lg dark:bg-gray-700">
                                <p class="mb-2 text-lg">Current Score: {{ $involvementScore }}/20</p>
                                <div class="space-y-2">
                                    <h5 class="font-medium">Activities:</h5>
                                    @forelse($student->activities as $activity)
                                        <div class="flex justify-between p-2 bg-gray-100 rounded dark:bg-gray-600">
                                            <span>{{ $activity->represent }}</span>
                                            <span>Level {{ $activity->involvement->type ?? 'N/A' }}</span>
                                        </div>
                                    @empty
                                        <p class="text-gray-500">No activities recorded</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- Commitments section -->
                        <div class="space-y-2">
                            <h4 class="text-lg font-medium">Commitment (10 marks)</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Select 4 commitments.</p>
                            <div class="grid grid-cols-2 gap-4">
                                @foreach($commitments as $commitment)
                                    <label class="flex items-center space-x-3 p-2 bg-gray-50 rounded dark:bg-gray-700">
                                        <input type="checkbox" name="commitments[]" value="{{ $commitment->id }}" 
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <span>{{ $commitment->commitment_name }} ({{ $commitment->score }} marks)</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Service Contributions -->
                        <div class="space-y-2">
                            <h4 class="text-lg font-medium">Service Contributions (10 marks)</h4>
                            <select name="service_contribution" required 
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                <option value="">Select contribution</option>
                                @foreach($serviceContributions as $contribution)
                                    <option value="{{ $contribution->id }}">
                                        {{ $contribution->contribution_name }} ({{ $contribution->score }} marks)
                                    </option>
                                @endforeach
                            </select>
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
                                    <span>Commitment Score:</span>
                                    <span x-text="commitmentScore + '/40'"></span>
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
                            <button type="button" 
                                x-on:click="/* reset logic */"
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