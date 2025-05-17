<x-app-layout>
	<x-slot name="header">
		<div class="flex justify-between items-center">
			<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
				{{ __('PAJSK Reports History') }}
			</h2>
		</div>
	</x-slot>

	<div class="py-4">
		<div class="max-w-full mx-auto sm:px-6 lg:px-8">
			<!-- Main Content -->
			<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg print-container">
				
				<p class="text-sm text-gray-600 dark:text-gray-400">Student: {{ isset($student) && isset($student->user) ? $student->user->name : '--' }}</p>
				<p class="text-sm text-gray-600 dark:text-gray-400">Class: {{ isset($report) && isset($report->classroom) ? $report->classroom->year . ' ' . $report->classroom->class_name : '--' }}</p>
				<div class="p-2 sm:p-4 overflow-x-auto">
					<table
						class="w-full text-sm text-left text-gray-500 dark:text-gray-300 border-collapse border border-gray-500 dark:border-gray-700 table-auto">
						<thead class="text-xs text-white uppercase bg-blue-600 dark:bg-blue-800">
							<tr>
								<th scope="col"
									class="px-2 py-2 sm:px-4 sm:py-3 text-center font-medium border border-gray-500 dark:border-gray-500">
									ELEMEN</th>
								<th scope="col"
									class="px-2 py-2 sm:px-4 sm:py-3 text-center font-medium border border-gray-500 dark:border-gray-500">
									ASPEK</th>
								<th scope="col"
									class="px-2 py-2 sm:px-4 sm:py-3 text-center font-medium border border-gray-500 dark:border-gray-500">
									SUKAN / PERMAINAN</th>
								<th scope="col"
									class="px-2 py-2 sm:px-4 sm:py-3 text-center font-medium border border-gray-500 dark:border-gray-500">
									KELAB / PERSATUAN</th>
								<th scope="col"
									class="px-2 py-2 sm:px-4 sm:py-3 text-center font-medium border border-gray-500 dark:border-gray-500">
									BADAN BERUNIFORM</th>
								<th scope="col"
									class="px-2 py-2 sm:px-4 sm:py-3 text-center font-medium border border-gray-500 dark:border-gray-500">
									EKSTRA KURIKULUM</th>
							</tr>
						</thead>
						<tbody>
							<!-- PENGLIBATAN Section -->
							<tr class="bg-white dark:bg-gray-700 border">
								<td rowspan="7"
									class="px-2 py-2 sm:px-4 sm:py-3 text-center font-bold border border-gray-500 dark:border-gray-500 bg-gray-100 dark:bg-gray-600">
									PENGLIBATAN</td>
								<td
									class="px-2 py-2 sm:px-4 sm:py-3 text-center font-bold border border-gray-500 dark:border-gray-500 bg-gray-100 dark:bg-gray-600">
									Jenis</td>
								<td class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
									{{ isset($clubs) && $clubs->get(0) ? $clubs->get(0)->club_name : '--' }}</td>
								<td class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
									{{ isset($clubs) && $clubs->get(1) ? $clubs->get(1)->club_name : '--' }}</td>
								<td class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
									{{ isset($clubs) && $clubs->get(2) ? $clubs->get(2)->club_name : '--' }}</td>
								<td
									class="px-2 py-2 sm:px-4 sm:py-3 text-center font-bold border border-gray-500 dark:border-gray-500 bg-gray-100 dark:bg-gray-600">
									Nama Jawatan</td>
							</tr>
							<tr class="bg-white dark:bg-gray-700 border">
								<td
									class="px-2 py-2 sm:px-4 sm:py-3 text-center font-bold border border-gray-500 dark:border-gray-500 bg-gray-100 dark:bg-gray-600">
									Jawatan</td>
								<td class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
									{{ isset($positions) && $positions->get(0) ? $positions->get(0)->position_name : 'N/A' }}</td>
								<td class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
									{{ isset($positions) && $positions->get(1) ? $positions->get(1)->position_name : 'N/A' }}</td>
								<td class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
									{{ isset($positions) && $positions->get(2) ? $positions->get(2)->position_name : '--' }}</td>
								<td
									class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
									-</td>
							</tr>
							<tr class="bg-white dark:bg-gray-700 border">
								<td
									class="px-2 py-2 sm:px-4 sm:py-3 text-center font-bold border border-gray-500 dark:border-gray-500 bg-gray-100 dark:bg-gray-600">
									Peringkat</td>
								<td class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
									{{ isset($assessment) && isset($assessment->total_scores[0]) ? $assessment->total_scores[0] : '--' }}
								</td>
								<td class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
									{{ isset($assessment) && isset($assessment->total_scores[1]) ? $assessment->total_scores[1] : '--' }}
								</td>
								<td class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
									{{ isset($assessment) && isset($assessment->total_scores[2]) ? $assessment->total_scores[2] : '--' }}
								</td>
								<td
									class="px-2 py-2 sm:px-4 sm:py-3 text-center font-bold border border-gray-500 dark:border-gray-500 bg-gray-100 dark:bg-gray-600">
									Anugerah Khas</td>
							</tr>
							<tr class="bg-white dark:bg-gray-700 border">
								<td rowspan="2"
									class="px-2 py-2 sm:px-4 sm:py-3 text-center font-bold border border-gray-500 dark:border-gray-500 bg-gray-100 dark:bg-gray-600">
									Komitmen
								</td>
								<td rowspan="2"
									class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
									{{ isset($commitmentNames) && isset($commitmentNames[0]) ? $commitmentNames[0] : '--' }}
								</td>
								<td rowspan="2"
									class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
									{{ isset($commitmentNames) && isset($commitmentNames[1]) ? $commitmentNames[1] : '--' }}
								</td>
								<td rowspan="2"
									class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
									{{ isset($commitmentNames) && isset($commitmentNames[2]) ? $commitmentNames[2] : '--' }}
								</td>
								<td
									class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
									{{ isset($extracocuricullum) && isset($extracocuricullum->specialAward) ? 
									$extracocuricullum->specialAward->name : '--' }}
								</td>
							</tr>
							<tr class="bg-white dark:bg-gray-700 border">
								<td
									class="px-2 py-2 sm:px-4 sm:py-3 text-center font-bold border border-gray-500 dark:border-gray-500 bg-gray-100 dark:bg-gray-600">
									Khidmat Sumbangan
								</td>
							</tr>
							<tr class="bg-white dark:bg-gray-700 border">
								<td rowspan="2"
									class="px-2 py-2 sm:px-4 sm:py-3 text-center font-bold border border-gray-500 dark:border-gray-500 bg-gray-100 dark:bg-gray-600">
									Khidmat
									Sumbangan</td>
								<td rowspan="2"
									class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
									{{ isset($serviceNames) && $serviceNames->get(0) ? $serviceNames->get(0)->service_name : '--' }}
								</td>
								<td rowspan="2"
									class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
									{{ isset($serviceNames) && $serviceNames->get(1) ? $serviceNames->get(1)->service_name : '--' }}

								</td>
								<td rowspan="2"
									class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
									{{ isset($serviceNames) && $serviceNames->get(2) ? $serviceNames->get(2)->service_name : '--' }}

								<td
									class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
									check service id</td>
							</tr>
							<tr class="bg-white dark:bg-gray-700 border">
								<td
									class="px-2 py-2 sm:px-4 sm:py-3 text-center font-bold border border-gray-500 dark:border-gray-500 bg-gray-100 dark:bg-gray-600">
									Program NILAM</td>
							</tr>

							<!-- PENYERTAAN Section -->
							<tr class="bg-white dark:bg-gray-700 border">
								<td
									class="px-2 py-2 sm:px-4 sm:py-3 text-center font-bold border border-gray-500 dark:border-gray-500 bg-gray-100 dark:bg-gray-600">
									PENYERTAAN</td>
								<td
									class="px-2 py-2 sm:px-4 sm:py-3 text-center font-bold border border-gray-500 dark:border-gray-500 bg-gray-100 dark:bg-gray-600">
									Kehadiran</td>
								<td
									class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
									{{ isset($attendanceCounts) && $attendanceCounts->get(0) ? 
									$attendanceCounts->get(0)->attendance_count . ' days' : '--' }}
								</td>
								<td
									class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
									{{ isset($attendanceCounts) && $attendanceCounts->get(1) ? 
									$attendanceCounts->get(1)->attendance_count . ' days' : '--' }}
								</td>
								<td
									class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
									{{ isset($attendanceCounts) && $attendanceCounts->get(2) ? 
									$attendanceCounts->get(2)->attendance_count . ' days' : '--' }}
								</td>
								<td class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
									{{ isset($extracocuricullum) && isset($extracocuricullum->nilam) ? 
									$extracocuricullum->nilam->tier->name . ' ' .
									$extracocuricullum->nilam->achievement->achievement_name : 'N/A' }}
								</td>
							</tr>

							<!-- PRESTASI Section -->
							<tr class="bg-white dark:bg-gray-700 border">
								<td rowspan="2"
									class="px-2 py-2 sm:px-4 sm:py-3 text-center font-bold border border-gray-500 dark:border-gray-500 bg-gray-100 dark:bg-gray-600">
									PRESTASI
								</td>
								<td rowspan="2"
									class="px-2 py-2 sm:px-4 sm:py-3 text-center font-bold border border-gray-500 dark:border-gray-500 bg-gray-100 dark:bg-gray-600">
									Tahap
									Pencapaian</td>
								<td rowspan="2"
									class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
									{{ isset($assessment->percentages[0]) ? $assessment->percentages[0].'%' : '--' }}
								</td>
								<td rowspan="2"
									class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
									{{ isset($assessment->percentages[1]) ? $assessment->percentages[1].'%' : '--' }}
								</td>
								<td rowspan="2"
									class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
									{{ isset($assessment->percentages[2]) ? $assessment->percentages[2].'%' : '--' }}
								</td>
								<td
									class="px-2 py-2 sm:px-4 sm:py-3 text-center font-bold border border-gray-500 dark:border-gray-500 bg-gray-100 dark:bg-gray-600">
									TIMMS DAN PISA</td>
							</tr>
							<tr class="bg-white dark:bg-gray-700 border">
								<td
									class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
									{{ isset($extracocuricullum) && isset($extracocuricullum->timmsAndPisa) ? 
									$extracocuricullum->timmsAndPisa->name : '--' }}
								</td>
							</tr>

							<!-- PELAPORAN MARKAH Section -->
							<tr class="bg-white dark:bg-gray-700 border">
								<td colspan="6"
									class="px-2 py-2 sm:px-4 sm:py-3 text-center font-bold border border-gray-500 dark:border-gray-500 bg-blue-600 dark:bg-blue-800 text-white">
									PELAPORAN
									MARKAH</td>
							</tr>
							<tr class="bg-white dark:bg-gray-700 border">
								<td colspan="2"
									class="px-2 py-2 sm:px-4 sm:py-3 text-center font-bold border border-gray-500 dark:border-gray-500 bg-gray-100 dark:bg-gray-600">
									SKOR
									ELEMEN</td>
								<td
									class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
									{{ isset($assessment->total_scores[0]) ?
									$assessment->total_scores[0] : '--' }}</td>
								<td
									class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
									{{ isset($assessment->total_scores[1]) ?
									$assessment->total_scores[1] : '--' }}</td>
								<td
									class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
									{{ isset($assessment->total_scores[2]) ?
									$assessment->total_scores[2] : '--' }}</td>
								<td
									class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
									{{ $extracocuricullum ?
									$extracocuricullum->total_point : '--' }}</td>
							</tr>
							<tr class="bg-white dark:bg-gray-700 border">
								<td colspan="2"
									class="px-2 py-2 sm:px-4 sm:py-3 text-center font-bold border border-gray-500 dark:border-gray-500 bg-gray-100 dark:bg-gray-600">
									JUMLAH
									SKOR (%)</td>
								<td
									class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
									{{ isset($assessment->percentages[0]) ?
									$assessment->percentages[0].'%' : '--' }}</td>
								<td
									class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
									{{ isset($assessment->percentages[1]) ?
									$assessment->percentages[1].'%' : '--' }}</td>
								<td
									class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
									{{ isset($assessment->percentages[2]) ?
									$assessment->percentages[2].'%' : '--' }}</td>
								<td
									class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
									{{ $extracocuricullum ? $extracocuricullum->total_point : '--' }}
								</td>
							</tr>
							<tr class="bg-white dark:bg-gray-700 border">
								<td colspan="2"
									class="px-2 py-2 sm:px-4 sm:py-3 text-center font-bold border border-gray-500 dark:border-gray-500 bg-gray-100 dark:bg-gray-600">
									GPA /
									GRED</td>
								<td colspan="4"
									class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
									{{ $report->gpa }}
								</td>
							</tr>
							<tr class="bg-white dark:bg-gray-700 border">
								<td colspan="2"
									class="px-2 py-2 sm:px-4 sm:py-3 text-center font-bold border border-gray-500 dark:border-gray-500 bg-gray-100 dark:bg-gray-600">
									CGPA /
									GRED</td>
								<td
									class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
								</td>
								<td
									class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
									{{ ($report->classroom->year - 1) == 0 ? '--' : 'Year ' . ($report->classroom->year - 1) . ': ' . $cgpaLast }}
								</td>
								<td
									class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
									{{ 'Year' . ' ' . $report->classroom->year
									. ': ' . $report->cgpa }}</td>
								<td
									class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
								</td>
							</tr>
							<tr class="bg-white dark:bg-gray-700 border">
								<td colspan="2"
									class="px-2 py-2 sm:px-4 sm:py-3 text-center font-bold border border-gray-500 dark:border-gray-500 bg-gray-100 dark:bg-gray-600">
									CGPA /
									(%)</td>
								<td colspan="4"
									class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
									{{ $report->cgpa_pctg }}</td>
							</tr>
							<tr class="bg-white dark:bg-gray-700 border">
								<td colspan="2"
									class="px-2 py-2 sm:px-4 sm:py-3 text-center font-bold border border-gray-500 dark:border-gray-500 bg-gray-100 dark:bg-gray-600">
									PENYATAAN
									LAPORAN</td>
								<td colspan="4"
									class="px-2 py-2 sm:px-4 sm:py-3 text-center border border-gray-500 dark:border-gray-500">
									{{ isset($report) && isset($report->report_description) ? $report->report_description : '--' }}
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="flex justify-end space-x-2 no-print">
				<button onclick="window.print()"
				class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-blue-800 uppercase tracking-widest hover:bg-blue-500 dark:hover:bg-blue-300">
				<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
				stroke="currentColor">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
				d="M6 9V2h12v7M6 22h12a2 2 0 002-2v-5H4v5a2 2 0 002 2zm6-17v6m-3-3h6" />
			</svg>
			Print
		</button>
			<a href="{{ route('pajsk.report-history') }}"
				class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white">
				Return to List
			</a>
		</div>
	</div>

	</div>

	<style>
		@media (max-width: 640px) {
			table {
				font-size: 0.7rem;
			}
		}

		@media print {

			/* Hide everything except the table */
			body * {
				visibility: hidden;
			}

			.print-container,
			.print-container * {
				visibility: visible;
			}

			/* Remove all margins/padding and position the table at the top */
			.print-container {
				position: absolute;
				left: 0;
				top: 0;
				width: 100%;
				padding: 0 !important;
				margin: 0 !important;
			}

			/* Hide non-printable elements */
			.no-print,
			header,
			nav,
			footer,
			button {
				display: none !important;
			}

			/* Reset all print colors to black on white */
			table {
				background-color: white !important;
				color: black !important;
			}

			td,
			th {
				border: 1px solid black !important;
				background-color: white !important;
				color: black !important;
			}
		}
	</style>
</x-app-layout>