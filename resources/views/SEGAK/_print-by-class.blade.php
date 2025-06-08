<div class="hidden print:block border-none shadow-none print:text-black print:text-sm m-0 print:px-6 print:space-y-4">
    <div class="text-center mb-4">
        <h1 class="text-xl font-bold uppercase">SEGAK Report For Session {{$session_id  }}</h1>
        <p class="font-semibold">BORANG REKOD SEGAK DAN BMI</p>
    </div>

    <table class="w-full border border-black text-xs mb-4">
        <tbody>
            <tr>
                <td class="border px-2 py-1 font-bold w-1/3">KELAS</td>
                <td class="border px-2 py-1 w-2/3">{{ $class_id->year }} {{ $class_id->class_name }}</td>
            </tr>
        </tbody>
    </table>

    <table class="w-full border border-black text-xs">
        <thead>
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
        <tbody>
            <!-- BODY MASS INDEX -->
            @forelse ($segaks as $segak)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 print:px-1 print:py-0.5 py-4">{{ $loop->iteration }}</td>
                                    <td class="px-6 print:px-1 print:py-0.5 py-4">{{ $segak->student->user->name }}</td>
                                    <td class="px-6 print:px-1 print:py-0.5 py-4">
                                        {{ $segak->classroom->year . ' ' . $segak->classroom->class_name }}</td>
                                    <td class="px-6 print:px-1 print:py-0.5 text-center py-4">{{ $segak->weight }}</td>
                                    <td class="px-6 print:px-1 print:py-0.5 text-center py-4">{{ $segak->height }}</td>
                                    <td class="px-6 print:px-1 print:py-0.5 text-center py-4">
                                        {{ $segak->step_test_score }}</td>
                                    <td class="px-6 print:px-1 print:py-0.5 text-center py-4">
                                        {{ $segak->push_up_score }}</td>
                                    <td class="px-6 print:px-1 print:py-0.5 text-center py-4">
                                        {{ $segak->sit_up_score }}</td>
                                    <td class="px-6 print:px-1 print:py-0.5 text-center py-4">
                                        {{ $segak->sit_and_reach_score }}</td>
                                    <td class="px-6 print:px-1 print:py-0.5 text-center py-4">{{ $segak->gred }}</td>
                                    <td class="px-6 print:px-1 print:py-0.5 text-center py-4">{{ $segak->bmi_status }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="px-4 py-2 text-center text-gray-500">No data found for
                                        this class.
                                    </td>
                                </tr>
                            @endforelse
        </tbody>
    </table>

    {{-- <!-- Footer Notes -->
            <div class="mt-4 text-xs">
                <p>Catatan: *Murid berkeperluan khas <span
                        class="inline-block border border-black w-4 h-4 align-middle"></span> dikecualikan <span
                        class="inline-block border border-black w-4 h-4 align-middle"></span></p>
                <p class="italic text-xs mt-1">*Sila tanda jika berkenaan</p>
            </div> --}}

</div>
