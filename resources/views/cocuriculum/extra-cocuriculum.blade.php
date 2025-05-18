<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Extra Co-Curriculum') }}
        </h2>
    </x-slot>
    @if (session('success'))
        <x-alert type='success' :title="session('success')" message=''></x-alert>
    @endif
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- Display all about co-curriculum here ONLY related to this teacher --}}
                    {{-- at here display mentee dia sahaja, macam (homeroom). pastu cikgu ni boleh masukkan markah Extra-Cocu --}}
                    <div class="relative overflow-x-auto">
                        <div class=" rounded-lg dark:border-gray-700">
                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                <div class="relative overflow-x-auto">
                                    @include('cocuriculum.partials.extra-cocuriculum-table')
                                </div>
                
                                <div class="mt-4 flex justify-between items-center">
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        <x-paginator :paginator="$students" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</x-app-layout>