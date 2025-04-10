<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Co-Curriculum Activity') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('cocuriculum.store') }}" class="space-y-6">
                        @csrf

                        <div class="space-y-4">
                            <div>
                                <x-input-label for="student_id" :value="__('Student')" />
                                <select id="student_id" name="student_id" required
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="">Select Student</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                            {{ $student->user->name }} - {{ $student->class }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('student_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="no_maktab" :value="__('No Maktab')" />
                                <x-text-input id="no_maktab" name="no_maktab" type="text" class="mt-1 block w-full"
                                    :value="old('no_maktab')" required />
                                <x-input-error :messages="$errors->get('no_maktab')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="class" :value="__('Class')" />
                                <x-text-input id="class" name="class" type="text" class="mt-1 block w-full"
                                    :value="old('class')" required />
                                <x-input-error :messages="$errors->get('class')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="activity" :value="__('Activity')" />
                                <x-text-input id="activity" name="activity" type="text" class="mt-1 block w-full"
                                    :value="old('activity')" required />
                                <x-input-error :messages="$errors->get('activity')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="marks" :value="__('Marks')" />
                                <x-text-input id="marks" name="marks" type="number" class="mt-1 block w-full"
                                    :value="old('marks')" required min="0" max="100" />
                                <x-input-error :messages="$errors->get('marks')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-6 flex items-center gap-4">
                            <x-primary-button>{{ __('Save Activity') }}</x-primary-button>
                            <a href="{{ route('cocuriculum.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>