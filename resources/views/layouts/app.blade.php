<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.46.0/dist/apexcharts.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

    <style>
        @media (max-width: 640px) {
			table {
				font-size: 0.7rem;
			}
		}

        /* report.blade.php */
        /* Score indicator styling */
		.score-indicator {
			position: absolute;
			bottom: 2px;
			right: 2px;
			width: 20px;
			height: 20px;
			background-color: #4b5563;
			border: 1px solid #6b7280;
			color: white;
			font-size: 9px;
			line-height: 16px;
			text-align: center;
			display: flex;
			align-items: center;
			justify-content: center;
			font-weight: bold;
		}

        @media print {
            @page {
                size: A4;
                margin: 5mm;
            }
            html, body {
                width: 210mm !important;
                height: 297mm !important;
                margin: 0 !important;
                padding: 0 !important;
                overflow: visible;
                /* visibility: hidden; */
				font-family: Arial, Helvetica, sans-serif;
            }
            #default-sidebar {
                display: none !important;
            }
            header {
                display: none !important;
            }
            .print-full-width {
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
            }
            body, .min-h-screen {
                margin: 0 !important;
                padding: 0 !important;
            }
            /* Override common spacing utilities */
            .p-4 {
                padding: 0.5rem !important;
            }
            .mb-4 {
                margin-bottom: 0.5rem !important;
            }
            .page-break {
                page-break-before: always;
            }
            .no-print {
                display: none !important;
            }

            /* report.blade.php */
            /* Hide non-printable elements */
			.no-print,
			header,
			nav,
			footer,
			button {
				display: none !important;
			}

            /* report.blade.php */
            .print-container,
			.print-container * {
				visibility: visible;
			}

            /* report.blade.php */
            /* Remove all margins/padding and position the table at the top */
			.print-container {
				position: absolute;
				left: 0;
				top: 0;
				width: 100%;
				padding: 0 !important;
				margin: 0 !important;
			}

            /* report.blade.php */
            /* Hide score indicators when printing */
			.score-indicator {
				background-color: #ffffff;
				border: 1px solid #000000;
				color: white;
			}

            /* report.blade.php */
			/* Reset all print colors to black on white */
			table {
				background-color: white !important;
				color: black !important;
			}

            /* report.blade.php */
			td,
			th {
				border: 1px solid black !important;
				background-color: white !important;
				color: black !important;
			}
        }
    </style>
    
    {{-- ADD STACK NI UNTUK DAPAT PUSH CHILD --}}
    @stack('scripts')

    {{-- <script type="module">
        $(document).ready(function() {
            alert("Thanks");
        });
    </script> --}}
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.side-navigation')

        <div class="p-4 sm:ml-64 h-full overflow-y-auto print-full-width">
            <!-- Session Alerts -->
            @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Page Heading -->
            @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow mb-4 rounded-lg">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
            @endisset

            <!-- Page Content -->
            <main class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                {{ $slot }}
            </main>
        </div>
        @yield('modals')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>