<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create SEGAK Record') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-2xl font-bold mb-4">
                        Segak Evaluation For Class: 
                        <span class="bg-purple-100 text-2xl font-bold text-purple-800  me-2 px-2.5 py-0.5 rounded-sm dark:bg-purple-900 dark:text-purple-300">
                            {{$class->year}} {{$class->class_name}}
                        </span>
                    </h2>

                  <div class="grid grid-cols-1 md:grid-cols-2  gap-4 justify-center items-center mt-5">
                    <div class="h-full">
                        <a href="{{ route('segak.pick-student', ['class_id' => $class->id, 'session_id' => 1]) }}"
                            class="flex flex-col h-full items-center bg-white border border-gray-200 rounded-lg shadow-sm md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                            <i class="fa-solid fa-1 text-center fa-2xl w-full rounded-t-lg h-96 md:h-auto md:w-48 md:rounded-none md:rounded-s-lg"></i>
                            <div class="flex flex-col justify-between p-4 leading-normal">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    Term 1 - SEGAK Assessment
                                </h5>
                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                                    Physical fitness assessment record for Term 1. Includes BMI, push-ups, curl-ups, and sit-and-reach tests.
                                </p>
                            </div>
                        </a>
                    </div>
                    
                    <div class="h-full">
                        <a href="{{ route('segak.pick-student', ['class_id' => $class->id, 'session_id' => 2]) }}"
                            class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow-sm md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                            <i class="fa-solid fa-2 text-center fa-2xl w-full rounded-t-lg h-96 md:h-auto md:w-48 md:rounded-none md:rounded-s-lg"></i>
                            <div class="flex flex-col justify-between p-4 leading-normal">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    Term 2 - SEGAK Assessment
                                </h5>
                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                        Updated fitness test results for Term 2. Compare progress from the previous term and track improvements.                                </p>
                            </div>
                        </a>
                    </div>

                    
                </div>
                    

                </div>
            </div>
        </div>
    </div>
@push('scripts')
    
<script>
        $(function() {
        function calcStepTestScore() {
            let steps = parseInt($('#step_test_steps').val()) || 0;
            let score = steps >= 20 ? 10 : 5;
            $('#step_test_score').val(score);
        }

        $('#step_test_steps').on('input', calcStepTestScore);
    
        // Example for push up
        function calcPushUpScore() {
            let steps = parseInt($('#push_up_steps').val()) || 0;
            let score = steps >= 15 ? 10 : 5;
            $('#push_up_score').val(score);
        }
        $('#push_up_steps').on('input', calcPushUpScore);
    
        // Example for sit up
        function calcSitUpScore() {
            let steps = parseInt($('#sit_up_steps').val()) || 0;
            let score = steps >= 10 ? 10 : 5;
            $('#sit_up_score').val(score);
        }
        $('#sit_up_steps').on('input', calcSitUpScore);
    });
    </script>
@endpush

</x-app-layout>