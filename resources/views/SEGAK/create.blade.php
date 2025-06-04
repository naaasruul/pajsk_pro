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

                        <span class="bg-yellow-100 text-2xl font-bold text-yellow-800  me-2 px-2.5 py-0.5 rounded-sm dark:bg-yellow-900 dark:text-yellow-300">
                            {{ $session_id == 1 ? 'Session 1' : 'Session 2' }}
                        </span> 
                        
                    </h2>
                    <form method="POST" action="{{ route('segak.store') }}"
                        class="space-y-6">
                        @csrf

                        <input type="hidden" name='session_id' value="{{ $session_id }}">
                        <input type="hidden" name='class_id' value="{{ $class->id }}">

                        {{-- Date --}}
                        <div class="mt-4">
                            <x-input-label for="date" :value="__('Date')" />
                            <x-text-input id="date" name="date" type="date" class="mt-1 block w-full" :value="old('date')" required />
                            <x-input-error :messages="$errors->get('date')" class="mt-2" />
                        </div>
                        
                        {{--  --}}
                        <div class="mt-4">
                            <x-input-label for="student_name" :value="__('Student Name')" />
                            <x-text-input id="student_name" name="student_name" type="text" class="mt-1 block w-full" :value="old('student_name')" required placeholder="Student Name" />
                            <x-input-error :messages="$errors->get('student_name')" class="mt-2" />
                        </div>

                        <div class="mt-4 grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="weight" :value="__('Weight (KG)')" />
                                <x-text-input id="weight" name="weight" type="number" step="0.1" class="mt-1 block w-full" :value="old('weight')" required />
                                <x-input-error :messages="$errors->get('weight')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="height" :value="__('Height (CM)')" />
                                <x-text-input id="height" name="height" type="number" step="0.1" class="mt-1 block w-full" :value="old('height')" required />
                                <x-input-error :messages="$errors->get('height')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-4 grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="step_test_steps" :value="__('Step Test (steps)')" />
                                <x-text-input id="step_test_steps" name="step_test_steps" type="number" class="mt-1 block w-full" :value="old('step_test_steps')" required />
                                <x-input-error :messages="$errors->get('step_test_steps')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="step_test_score" :value="__('Step Test (score)')" />
                                <x-text-input id="step_test_score" name="step_test_score" type="number" class="mt-1 block w-full" :value="old('step_test_score')" required />
                                <x-input-error :messages="$errors->get('step_test_score')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-4 grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="push_up_steps" :value="__('Push Up (steps)')" />
                                <x-text-input id="push_up_steps" name="push_up_steps" type="number" class="mt-1 block w-full" :value="old('push_up_steps')" required />
                                <x-input-error :messages="$errors->get('push_up_steps')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="push_up_score" :value="__('Push Up (score)')" />
                                <x-text-input id="push_up_score" name="push_up_score" type="number" class="mt-1 block w-full" :value="old('push_up_score')" required />
                                <x-input-error :messages="$errors->get('push_up_score')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-4 grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="sit_up_steps" :value="__('Sit Up (steps)')" />
                                <x-text-input id="sit_up_steps" name="sit_up_steps" type="number" class="mt-1 block w-full" :value="old('sit_up_steps')" required />
                                <x-input-error :messages="$errors->get('sit_up_steps')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="sit_up_score" :value="__('Sit Up (score)')" />
                                <x-text-input id="sit_up_score" name="sit_up_score" type="number" class="mt-1 block w-full" :value="old('sit_up_score')" required />
                                <x-input-error :messages="$errors->get('sit_up_score')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="sit_and_reach" :value="__('Sit and Reach (cm)')" />
                            <x-text-input id="sit_and_reach" name="sit_and_reach" type="number" step="0.1" class="mt-1 block w-full" :value="old('sit_and_reach')" required />
                            <x-input-error :messages="$errors->get('sit_and_reach')" class="mt-2" />
                        </div>

                        <div class="mt-4 grid grid-cols-3 gap-4">
                            <div>
                                <x-input-label for="total_score" :value="__('Total Score')" />
                                <x-text-input id="total_score" name="total_score" type="number" class="mt-1 block w-full" :value="old('total_score')" required />
                                <x-input-error :messages="$errors->get('total_score')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="gred" :value="__('Gred')" />
                                <x-text-input id="gred" name="gred" type="text" class="mt-1 block w-full" :value="old('gred')" required />
                                <x-input-error :messages="$errors->get('gred')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="bmi_status" :value="__('BMI Status')" />
                                <x-text-input id="bmi_status" name="bmi_status" type="text" class="mt-1 block w-full" :value="old('bmi_status')" required />
                                <x-input-error :messages="$errors->get('bmi_status')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save SEGAK</button>
                        </div>
                    </form>
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