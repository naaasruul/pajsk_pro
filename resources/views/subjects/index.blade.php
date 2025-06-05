<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Subjects') }}
            </h2>
            <a href="{{ route('subject.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                Create Subject
            </a>
        </div>
    </x-slot>

    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">#</th>
                    <th scope="col" class="px-6 py-3">Subject Name</th>
                    <th scope="col" class="px-6 py-3">Subject Code</th>
                    <th scope="col" class="px-6 py-3">Teachers</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subjects as $subject)
                        @php
                            $assignedTeacherIds = $subject->teachers->pluck('id')->toArray();
                            
                            $assignedTeacherIds = \DB::table('classroom_subject_teacher')
                            ->where('subject_id', $subject->id)
                            ->pluck('teacher_id')
                            ->unique()
                            ->toArray();
                        @endphp                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">{{ $subject->name }}</td>
                        <td class="px-6 py-4">{{ $subject->code }}</td>
                        <td class="px-6 py-4">
                            <button data-modal-target="see-subjects-{{$subject->id}}" data-modal-toggle="see-subjects-{{$subject->id}}" class="text-blue-500" type="button">
                                See list of teachers
                            </button>
                        </td>
                        @include('subjects._see-teacher-modal')
                    
                    </tr>
                @empty
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td colspan="6" class="px-6 py-4 text-center">No subjects found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{-- <div class="mt-4">
            <x-paginator :paginator="$subjects" />
        </div> --}}
    </div>
</x-app-layout>
