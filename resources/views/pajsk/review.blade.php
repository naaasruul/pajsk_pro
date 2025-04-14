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
                        
                        <!-- Score Breakdown -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 mb-6">
                            <h4 class="text-lg font-medium mb-4">Score Breakdown</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span>Attendance Score:</span>
                                    <span>{{ $scores['attendance_score'] }}/40</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Position Score:</span>
                                    <span>{{ $scores['position_score'] }}/10</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Involvement Score:</span>
                                    <span>{{ $scores['involvement_score'] }}/20</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Commitment Score:</span>
                                    <span>{{ $scores['commitment_score'] }}/40</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Service Score:</span>
                                    <span>{{ $scores['service_score'] }}/10</span>
                                </div>
                                <div class="flex justify-between font-bold border-t pt-3">
                                    <span>Total Score:</span>
                                    <span>{{ $total }}/110 ({{ number_format($percentage, 2) }}%)</span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('pajsk.evaluate-student', $student) }}" 
                               class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-600 rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-500">
                                Edit Evaluation
                            </a>
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
