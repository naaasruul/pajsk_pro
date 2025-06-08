    <div
        class=" hidden print:block border-none shadow-none print:text-black print:text-sm m-0 print:px-6 print:space-y-4">
        <div class="text-center mb-4">
            <h1 class="text-xl font-bold uppercase">SEGAK Report</h1>
            <p class="font-semibold">BORANG REKOD SEGAK DAN BMI</p>
        </div>

        <table class="w-full border border-black text-xs mb-4">
            <tbody>
                <tr>
                    <td class="border px-2 py-1 font-bold w-1/3">NAMA MURID</td>
                    <td class="border px-2 py-1 w-2/3">{{ $student->user->name }}</td>
                </tr>
                <tr>
                    <td class="border px-2 py-1 font-bold">KELAS</td>
                    <td class="border px-2 py-1">{{ $student->classroom->class_name }}</td>
                </tr>
                <tr>
                    <td class="border px-2 py-1 font-bold">JANTINA</td>
                    <td class="border px-2 py-1 capitalize">{{ $student->user->gender ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="border px-2 py-1 font-bold">UMUR</td>
                    <td class="border px-2 py-1">{{ $student->user->age ?? '-' }}</td>
                </tr>
            </tbody>
        </table>

        <table class="w-full border border-black text-xs">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-2 py-1">PERKARA</th>
                    <th class="border px-2 py-1 text-center">PENGGAL 1</th>
                    <th class="border px-2 py-1 text-center">PENGGAL 2</th>
                </tr>
            </thead>
            <tbody>
                <!-- BODY MASS INDEX -->
                <tr>
                    <td class="border px-2 py-1 font-bold">BODY MASS INDEX (BMI)</td>
                    <td class="border px-2 py-1">
                        <p class="flex justify-between items-center w-full">
                            <span class="w-3/4">BERAT BADAN (kg)</span> <span
                                class="p-2 border w-1/4 border-black rounded-md">{{ $segak_1->weight ?? 0 }}</span>
                        </p>
                        <p class="flex justify-between items-center w-full mt-3">
                            <span class="w-3/4">Tinggi (cm)</span> <span
                                class="p-2 border w-1/4 border-black rounded-md">{{ $segak_1->height ?? 0 }}</span>
                        </p>
                    </td>
                    <td class="border px-2 py-1">
                        <p class="flex justify-between items-center w-full">
                            <span class="w-3/4">BERAT BADAN (kg)</span> <span
                                class="p-2 border w-1/4 border-black rounded-md">{{ $segak_2->weight ?? 0 }}</span>
                        </p>    
                        <p class="flex justify-between items-center w-full mt-3">
                            <span class="w-3/4">Tinggi (cm)</span> <span
                                class="p-2 border w-1/4 border-black rounded-md">{{ $segak_2->height ?? 0 }}</span>
                        </p>
                    </td>
                </tr>

                <!-- UJIAN SEGAK -->
                <tr>
                    <td class="border px-2 py-1" rowspan="3">UJIAN SEGAK</td>
                    <td class="border px-2 py-1">
                        <p class="flex justify-between items-center w-full">
                            <span class="w-3/4">UJIAN NAIK TURUN BANGKU</span> <span
                                class="p-2 border w-1/4 border-black rounded-md">{{ $segak_1->step_test_score ?? 0 }}</span>
                        </p>
                    </td>
                    <td class="border px-2 py-1">
                        <p class="flex justify-between items-center w-full">
                            <span class="w-3/4">UJIAN NAIK TURUN BANGKU</span> <span
                                class="p-2 border w-1/4 border-black rounded-md">{{ $segak_2->step_test_score ?? 0 }}</span>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td class="border px-2 py-1">
                        <p class="flex justify-between items-center w-full">
                            <span class="w-3/4">UJIAN NAIK TURUN BANGKU</span> <span
                                class="p-2 border w-1/4 border-black rounded-md">{{ $segak_1->push_up_score ?? 0 }}</span>
                        </p>
                    </td>
                    <td class="border px-2 py-1">
                        <p class="flex justify-between items-center w-full">
                            <span class="w-3/4">UJIAN NAIK TURUN BANGKU</span> <span
                                class="p-2 border w-1/4 border-black rounded-md">{{ $segak_2->push_up_score ?? 0 }}</span>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td class="border px-2 py-1">
                        <p class="flex justify-between items-center w-full">
                            <span class="w-3/4">UJIAN NAIK TURUN BANGKU</span> <span
                                class="p-2 border w-1/4 border-black rounded-md">
                                {{ $segak_1->sit_up_score ?? 0 }}</span>
                        </p>
                    </td>
                    <td class="border px-2 py-1">
                        <p class="flex justify-between items-center w-full">
                            <span class="w-3/4">UJIAN NAIK TURUN BANGKU</span> <span
                                class="p-2 border w-1/4 border-black rounded-md">
                                {{ $segak_2->sit_up_score ?? 0 }}</span>
                        </p>
                    </td>
                </tr>

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
