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
                    {{-- <h2 class="text-2xl font-bold mb-4">
                        Segak Evaluation For Class:
                        <span
                            class="bg-purple-100 text-2xl font-bold text-purple-800  me-2 px-2.5 py-0.5 rounded-sm dark:bg-purple-900 dark:text-purple-300">
                            {{$class->year}} {{$class->class_name}}
                        </span>

                        <span
                            class="bg-yellow-100 text-2xl font-bold text-yellow-800  me-2 px-2.5 py-0.5 rounded-sm dark:bg-yellow-900 dark:text-yellow-300">
                            {{ $session_id == 1 ? 'Session 1' : 'Session 2' }}
                        </span>

                    </h2> --}}
                    @if ($errors->any())
                        <div class="mb-4">
                            <div class="font-medium text-red-600">Whoops! Something went wrong.</div>
                            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('segak.store') }}" class="space-y-6">
                        @csrf

                        <input type="text" name='session' value="{{ $session_id }}">
                        <input type="text" name='classroom_id' value="{{ $class->id }}">
                        <input type="text" name='student_id' value="{{ $student_id->id }}">

                        {{-- Student Information --}}
                        <div
                            class="flex flex-col-reverse items-center bg-white  rounded-lg shadow-sm md:flex-row  hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                            <img class="object-cover w-full rounded-t-lg h-60 md:h-auto md:w-48 md:rounded-none md:rounded-s-lg"
                                src="{{ $student_id->user->gender == 'male' ? asset('images/boy.png') : asset('images/girl.png') }}"
                                alt="">
                            <div class="">
                                <h5 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    {{ $student_id->user->name }}
                                </h5>
                                <h6 class="text-lg font-semibold text-gray-700 dark:text-gray-300">
                                    <span class="text-sm capitalize text-gray-500 dark:text-gray-400">
                                        {{ $student_id->user->gender }}
                                    </span>
                                </h6>
                                <h6 class="text-lg font-semibold text-gray-700 dark:text-gray-300">
                                    <span class="text-sm capitalize text-gray-500 dark:text-gray-400">
                                        {{ $student_id->user->age }} years old
                                    </span>
                                </h6>
                            </div>

                        </div>
                        {{-- Date --}}
                        <div class="mt-4">
                            <x-input-label for="date" :value="__('Date')" />
                            <x-text-input id="date" name="date" type="date" class="mt-1 block w-full"
                                :value="old('date')" required />
                            <x-input-error :messages="$errors->get('date')" class="mt-2" />
                        </div>




                        <div class="mt-4 grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="weight" :value="__('Weight (KG)')" />
                                <x-text-input id="weight" name="weight" type="number" step="0.1"
                                    class="mt-1 block w-full" :value="0" required />
                                <x-input-error :messages="$errors->get('weight')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="height" :value="__('Height (CM)')" />
                                <x-text-input id="height" name="height" type="number" step="0.1"
                                    class="mt-1 block w-full" :value="0" required />
                                <x-input-error :messages="$errors->get('height')" class="mt-2" />
                            </div>
                        </div>

                        {{-- STEP TEST STEPS AND SCORE --}}
                        <div class="mt-4 grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="step_test_steps" :value="__('Step Test (steps)')" />
                                <x-text-input id="step_test_steps" name="step_test_steps" type="number"
                                    class="mt-1 block w-full" :value="0" required />
                                <x-input-error :messages="$errors->get('step_test_steps')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="step_test_score" :value="__('Step Test (score)')" />
                                <x-text-input id="step_test_score" name="step_test_score" type="number"
                                    class="mt-1 block w-full" :value="0" required />
                                <x-input-error :messages="$errors->get('step_test_score')" class="mt-2" />
                            </div>
                        </div>

                        {{-- PUSH UP STEPS AND SCORE --}}
                        <div class="mt-4 grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="push_up_steps" :value="__('Push Up (steps)')" />
                                <x-text-input id="push_up_steps" name="push_up_steps" type="number"
                                    class="mt-1 block w-full" :value="0" required />
                                <x-input-error :messages="$errors->get('push_up_steps')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="push_up_score" :value="__('Push Up (score)')" />
                                <x-text-input id="push_up_score" name="push_up_score" type="number"
                                    class="mt-1 block w-full" :value="0" required />
                                <x-input-error :messages="$errors->get('push_up_score')" class="mt-2" />
                            </div>
                        </div>

                        {{-- SIT UP STEPS AND SCORE --}}
                        <div class="mt-4 grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="sit_up_steps" :value="__('Sit Up (steps)')" />
                                <x-text-input id="sit_up_steps" name="sit_up_steps" type="number"
                                    class="mt-1 block w-full" :value="0" required />
                                <x-input-error :messages="$errors->get('sit_up_steps')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="sit_up_score" :value="__('Sit Up (score)')" />
                                <x-text-input id="sit_up_score" name="sit_up_score" type="number"
                                    class="mt-1 block w-full" :value="0" required />
                                <x-input-error :messages="$errors->get('sit_up_score')" class="mt-2" />
                            </div>
                        </div>

                        {{-- SIT AND REACH DISTANCE & SCORE --}}
                        <div class="mt-4 grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="sit_and_reach" :value="__('Sit and Reach (cm)')" />
                                <x-text-input id="sit_and_reach" name="sit_and_reach" type="number" step="0.1"
                                class="mt-1 block w-full" :value="0" required />
                                <x-input-error :messages="$errors->get('sit_and_reach')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="sit_and_reach_score" :value="__('Sit and Reach (Score)')" />
                                <x-text-input id="sit_and_reach_score" name="sit_and_reach_score" type="number" step="0.1" class="mt-1 block w-full" :value="0"
                                    required />
                                <x-input-error :messages="$errors->get('sit_and_reach_score')" class="mt-2" />
                            </div>
                            
                        </div>


                        <div class="mt-4 grid grid-cols-3 gap-4">
                            
                            {{-- TOTAL SCORE --}}
                            <div>
                                <x-input-label for="total_score" :value="__('Total Score')" />
                                <x-text-input id="total_score" name="total_score" type="number"
                                    class="mt-1 block w-full" :value="0" required />
                                <x-input-error :messages="$errors->get('total_score')" class="mt-2" />
                            </div>
                            
                            {{-- GRED --}}
                            <div>
                                <x-input-label for="gred" :value="__('Gred')" />
                                <x-text-input id="gred" name="gred" type="text" class="mt-1 block w-full"
                                    :value="old('gred')" required />
                                <x-input-error :messages="$errors->get('gred')" class="mt-2" />
                            </div>
                            
                            {{-- BMI STATUS --}}
                            <div>
                                <x-input-label for="bmi_status" :value="__('BMI Status')" />
                                <x-text-input id="bmi_status" name="bmi_status" type="text"
                                    class="mt-1 block w-full" :value="old('bmi_status')" required />
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
            var student_age = {{ $student_id->user->age }};
            var student_gender = `{{ $student_id->user->gender }}`.toLowerCase();
            console.log('Student Age:', student_age);
            console.log('Student Geder:', student_gender);
        </script>

        <script src="{{ asset('js/calculate-bmi.js') }}"></script>
        <script src="{{ asset('js/segak-scoring.js') }}"></script>
    @endpush

</x-app-layout>
