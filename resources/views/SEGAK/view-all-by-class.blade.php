<x-app-layout>
      <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('SEGAK Record For Class ' . $class_id->year . ' ' . $class_id->class_name) }} 
        </h2>
    </x-slot>

    <x-container>
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between mb-4">
                <h2 class="text-2xl font-bold mb-4">
                Segak Evaluation For Class:
                    <span
                        class="bg-purple-100 text-2xl font-bold text-purple-800  me-2 px-2.5 py-0.5 rounded-sm dark:bg-purple-900 dark:text-purple-300">
                        {{$class_id->year}} {{$class_id->class_name}} (Session {{ $session_id }})
                    </span>
                </h2>   
                 <button onclick="window.print()" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 print:hidden">
                    Print
                </button> 
            </div>
            <div class="relative overflow-x-auto print:overflow-visible">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 print:text-black print:border print:border-black">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 print:bg-white print:text-black print:border-b print:border-black">
                        <tr>
                            <th scope="col" class="px-6 py-3 print:px-1 print:py-0.5">#</th>
                            <th scope="col" class="px-6 py-3 print:px-1 print:py-0.5">Student Name</th>
                            <th scope="col" class="px-6 py-3 print:px-1 print:py-0.5">Class</th>
                            <th scope="col" class="px-6 py-3 print:px-1 print:py-0.5">Weight (kg)</th>
                            <th scope="col" class="px-6 py-3 print:px-1 print:py-0.5">Height (cm)</th>
                            <th scope="col" class="px-6 py-3 print:px-1 print:py-0.5">Step Test Score</th>
                            <th scope="col" class="px-6 py-3 print:px-1 print:py-0.5">Push Up Score</th>
                            <th scope="col" class="px-6 py-3 print:px-1 print:py-0.5">Sit Up Score</th>
                            <th scope="col" class="px-6 py-3 print:px-1 print:py-0.5">Sit & Reach Score</th>
                            <th scope="col" class="px-6 py-3 print:px-1 print:py-0.5">Gred</th>
                            <th scope="col" class="px-6 py-3 print:px-1 print:py-0.5">BMI Status</th>
                            {{-- <th scope="col" class="px-6 py-3">Action</th> --}}
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($segaks as $segak)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 print:px-1 print:py-0.5 py-4">{{ $loop->iteration }}</td>
                                <td class="px-6 print:px-1 print:py-0.5 py-4">{{ $segak->student->user->name }}</td>
                                <td class="px-6 print:px-1 print:py-0.5 py-4">{{ $segak->classroom->year . ' ' . $segak->classroom->class_name }}</td>
                                <td class="px-6 print:px-1 print:py-0.5 text-center py-4">{{ $segak->weight }}</td>
                                <td class="px-6 print:px-1 print:py-0.5 text-center py-4">{{ $segak->height }}</td>
                                <td class="px-6 print:px-1 print:py-0.5 text-center py-4">{{ $segak->step_test_score }}</td>
                                <td class="px-6 print:px-1 print:py-0.5 text-center py-4">{{ $segak->push_up_score }}</td>
                                <td class="px-6 print:px-1 print:py-0.5 text-center py-4">{{ $segak->sit_up_score }}</td>
                                <td class="px-6 print:px-1 print:py-0.5 text-center py-4">{{ $segak->sit_and_reach_score }}</td>
                                <td class="px-6 print:px-1 print:py-0.5 text-center py-4">{{ $segak->gred }}</td>
                                <td class="px-6 print:px-1 print:py-0.5 text-center py-4">{{ $segak->bmi_status }}</td>
                            </tr>
                        @empty
                            
                        @endforelse
                    </tbody>
                </table>
            </div>
           
            </div>
        </div>
    </x-container>
</x-app-layout>