<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Select Student for SEGAK Record') }}
        </h2>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <div class="flex justify-between mb-4">
                <h2 class="text-2xl font-bold mb-4">
                Segak Evaluation For Class:
                    <span
                        class="bg-purple-100 text-2xl font-bold text-purple-800  me-2 px-2.5 py-0.5 rounded-sm dark:bg-purple-900 dark:text-purple-300">
                        {{$class->year}} {{$class->class_name}}
                    </span>
                </h2>    

                <a href="{{ route('segak.view-class',['class_id'=>$class->id,'session_id'=>$session_id]) }}" class="text-white  font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 "type='button'>
                    <i class="fa-solid fa-eye fa-xl me-2"></i>
                    View
                </a>
            </div>
            

            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">#</th>
                            <th scope="col" class="px-6 py-3">Student Name</th>
                            {{-- <th scope="col" class="px-6 py-3">IC / ID</th> --}}
                            {{-- @hasrole('teacher') --}}
                            <th scope="col" class="px-6 py-3">Action</th>
                            {{-- @endhasrole --}}
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($students as $student)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">{{ $student->user->name }}</td>
                            {{-- <td class="px-6 py-4">{{ $student->ic ?? $student->id }}</td> --}}
                            @hasrole('teacher')
                            <td class="px-6 py-4">
                                <a href="{{ route('segak.create', ['class_id' => $class->id, 'session_id' => $session_id, 'student_id' => $student->id]) }}"
                                    class="inline-flex items-center px-3 py-1 bg-blue-600 text-white text-xs font-semibold rounded hover:bg-blue-700">
                                    Create SEGAK
                                </a>
                            </td>
                            @endhasrole

                            @hasrole('admin')
                            <td class="px-6 py-4">
                                <a href="{{ route('segak.view-student', ['student_id' => $student->id,'session_id' => $session_id, ]) }}"
                                    class="inline-flex items-center px-3 py-1 bg-blue-600 text-white text-xs font-semibold rounded hover:bg-blue-700">
                                    View Student
                                </a>
                            </td>
                            @endhasrole
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-2 text-center text-gray-500">No students found for this
                                class.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>