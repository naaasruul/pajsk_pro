<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('View All SEGAK Records by Student') }}
        </h2>

    </x-slot>

    <x-container>
        <div
            class="flex flex-col-reverse items-center print:hidden bg-white  rounded-lg shadow-sm md:flex-row  hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
            <img class="object-cover w-full rounded-t-lg h-60 md:h-auto md:w-48 md:rounded-none md:rounded-s-lg"
                src="{{ $student->user->gender == 'male' ? asset('images/boy.png') : asset('images/girl.png') }}"
                alt="">
            <div class="">
                <h5 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                    {{ $student->user->name }}
                </h5>
                <h6 class="text-lg font-semibold text-gray-700 dark:text-gray-300">
                    <span class="text-sm capitalize text-gray-500 dark:text-gray-400">
                        {{ $student->user->gender }}
                    </span>student
                </h6>
                <h6 class="text-lg font-semibold text-gray-700 dark:text-gray-300">
                    <span class="text-sm capitalize text-gray-500 dark:text-gray-400">
                        {{ $student->user->age }} years
                    </span>
                </h6>
                @if ($is_segak_valid)
                <h6 class="text-lg font-semibold text-gray-700 dark:text-gray-300">
                    <button onclick="window.print()" class="btn bg-blue-600 p-2 text-sm rounded-lg mt-5" type="button"> Generate Report </button>
                    
                </h6>    
                @endif   
            </div>
        </div>

        <div class="grid print:hidden grid-cols-1 md:grid-cols-3  gap-4 justify-center items-center mt-5">
            <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-4 flex flex-col items-center">
                <span class="text-gray-500 text-sm mb-1">Height (cm)</span>
                <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $segak->height ?? 0 }}</span>
            </div>
            <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-4 flex flex-col items-center">
                <span class="text-gray-500 text-sm mb-1">Weight (kg)</span>
                <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $segak->weight ?? 0 }}</span>
            </div>
            <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-4 flex flex-col items-center">
                <span class="text-gray-500 text-sm mb-1">BMI Status</span>
                <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $segak->bmi_status ?? 0 }}</span>
            </div>
            <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-4 flex flex-col items-center">
                <span class="text-gray-500 text-sm mb-1">Step Test Score</span>
                <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $segak->step_test_score ?? 0 }}</span>
            </div>
            <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-4 flex flex-col items-center">
                <span class="text-gray-500 text-sm mb-1">Push Up Score</span>
                <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $segak->push_up_score ?? 0 }}</span>
            </div>
            <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-4 flex flex-col items-center">
                <span class="text-gray-500 text-sm mb-1">Sit Up Score</span>
                <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $segak->sit_up_score ?? 0 }}</span>
            </div>
            <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-4 flex flex-col items-center">
                <span class="text-gray-500 text-sm mb-1">Sit & Reach Score</span>
                <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $segak->sit_and_reach_score ?? 0 }}</span>
            </div>
        </div>
    </x-container>

    {{-- PRINT SECTION --}}
    @include('SEGAK._print-by-student')
</x-app-layout>
