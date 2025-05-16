<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>PAJSK Report Detail</title>
    <!-- ...existing styles... -->
</head>
<body>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('PAJSK Report Detail') }}
            </h2>
        </x-slot>
        <div class="py-12">
           <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
              <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                 <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($report)
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Report ID: {{ $report->id }}</h3>
                        <p><strong>Student:</strong> {{ $report->student->user->name ?? 'N/A' }}</p>
                        <p><strong>Class:</strong> {{ $report->classroom->year . ' ' . $report->classroom->class_name ?? 'N/A' }}</p>
                        <p><strong>GPA:</strong> {{ $report->gpa }}</p>
                        <p><strong>CGPA:</strong> {{ $report->cgpa }}</p>
                        <p><strong>CGPA Percentage:</strong> {{ $report->cgpa_pctg }}</p>
                        <p><strong>Description:</strong> {{ $report->report_description }}</p>
                        <p><strong>Last Updated:</strong> {{ $report->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                    @else
                        <p>No report data available.</p>
                    @endif
                 </div>
              </div>
           </div>
        </div>
    </x-app-layout>
</body>
</html>
