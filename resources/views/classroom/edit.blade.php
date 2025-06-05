<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Classroom') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div x-data="{
                        old_year: '{{ $classroom->year }}',
                        old_class_name: '{{ $classroom->class_name }}',
                        year: '{{ old('year', $classroom->year) }}',
                        class_name: '{{ old('class_name', $classroom->class_name) }}'
                    }">
                        <form method="POST" action="{{ route('classrooms.update', $classroom) }}" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <div class="space-y-6">
                                <!-- Class Information -->
                                <div class="border-b border-gray-900/10 pb-6">
                                    <h2 class="text-base font-semibold leading-7">Class Information</h2>

                                    <div class="flex flex-wrap -mx-2">
                                        <div class="w-full md:w-1/4 px-2 mt-4">
                                            <x-input-label for="year" :value="__('Year')" />
                                            <select x-model="year" id="year" name="year"
                                                class="mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                required>
                                                <option value="">--</option>
                                                @for ($i = 1; $i <= 6; $i++) <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                            </select>
                                            <x-input-error :messages="$errors->get('year')" class="mt-2" />
                                        </div>

                                        <div class="w-full md:w-3/4 px-2 mt-4">
                                            <x-input-label for="class_name" :value="__('Classroom Name')" />
                                            <x-text-input x-model="class_name" id="class_name" name="class_name"
                                                type="text" class="mt-2 block w-full"
                                                :value="old('class_name', $classroom->class_name)" required />
                                            <x-input-error :messages="$errors->get('class_name')" class="mt-2" />
                                        </div>

                                        {{-- <div class="w-full md:w-1/4 px-2 mt-4">
                                            <x-input-label for="teachers" :value="__('Assign Teacher')" />
                                            <select x-model="teacher" id="teacher" name="teacher"
                                                class="mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                required>
                                                <option value="">--</option>
                                                @foreach ($teachers as $teacher)
                                                    <option value="{{ $teacher->id }}">{{ $teacher->user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div> --}}
                                    </div>

                                    <!-- Live Preview Message -->
                                    <div x-show="year && class_name && (year != old_year || class_name != old_class_name)"
                                        class="mt-4 text-sm text-blue-700 dark:text-blue-300">
                                        <span
                                            x-text="`${old_year} ${old_class_name} will be updated to ${year} ${class_name}`"></span>
                                    </div>

                                </div>
                            </div>

                            <div class="mt-6 flex items-center gap-4">
                                <x-primary-button>{{ __('Update') }}</x-primary-button>
                                <a href="{{ route('classrooms.index') }}"
                                    class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    {{ __('Cancel') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>