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
                        <h3 class="text-lg font-semibold mb-4">Evaluation Results for {{ $result['student']->user->name }}</h3>

                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <h4 class="font-medium text-sm text-gray-500 dark:text-gray-400 mb-2">Student Information</h4>
                                <div class="space-y-1">
                                    <p class="text-gray-900 dark:text-gray-100">Class: {{ $result['student']->classroom->year }} {{ $result['student']->classroom->class_name }}</p>
                                </div>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <h4 class="font-medium text-sm text-gray-500 dark:text-gray-400 mb-2">Assessment Date</h4>
                                <p class="text-gray-900 dark:text-gray-100">{{ $result['extraCocuricullum']->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 space-y-4 mb-6">
                            <h4 class="text-lg font-medium mb-4">Evaluation Details</h4>
                            <p><strong>Service:</strong> {{ $result['extraCocuricullum']->service->name ?? 'N/A' }}</p>
                            <p><strong>Special Award:</strong> {{ $result['extraCocuricullum']->specialAward->name ?? 'N/A' }}</p>
                            <p><strong>Community Service:</strong> {{ $result['extraCocuricullum']->communityService->name ?? 'N/A' }}</p>
                            <p><strong>Achievement (Nilam):</strong> {{ $result['extraCocuricullum']->nilam->achievement_name ?? 'N/A' }}</p>
                            <p><strong>Timms and Pisa:</strong> {{ $result['extraCocuricullum']->timmsAndPisa->name ?? 'N/A' }}</p>
                            <p><strong>Total Point:</strong> {{ $result['extraCocuricullum']->total_point }}</p>
                        </div>

                        <div class="flex justify-end space-x-2">
							<button onclick="window.print()"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-blue-800 uppercase tracking-widest hover:bg-blue-500 dark:hover:bg-blue-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9V2h12v7M6 22h12a2 2 0 002-2v-5H4v5a2 2 0 002 2zm6-17v6m-3-3h6" />
                                </svg>
                                Print
                            </button>
                            <a href="{{ route('pajsk.extra-cocuriculum.history') }}"
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
