<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Subject') }}
        </h2>
    </x-slot>

    <x-container>
        <h2 class="text-4xl font-extrabold dark:text-white">Add New Subject</h2>
        <p class="my-2 text-lg text-gray-500">Kindly complete the form below to submit a new subject application. Ensure
            all required fields are filled out accurately and thoroughly to facilitate a smooth and timely processing of
            your request.</p>
  <!-- Display Success Message -->
  @if (session('success'))
  <div class="mb-4 text-sm text-green-600 dark:text-green-400">
      {{ session('success') }}
  </div>
@endif

<!-- Display Validation Errors -->
@if ($errors->any())
  <div class="mb-4 text-sm text-red-600 dark:text-red-400">
      <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
  </div>
@endif
        <form method="POST" action="{{ route('subject.store') }}" class="space-y-6">
            @csrf
            <!-- User Information -->
            <h2 class="text-base text-black dark:text-white font-semibold leading-7">Subject Information</h2>

            <div class="mb-6">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                <input id="name" name="name" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>

            <div class="mb-6">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Code</label>
                <input id="email" name="code" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>

            <div class="mt-6 flex items-center gap-4">
                <x-primary-button>{{ __('Create') }}</x-primary-button>
                <a href="{{ route('teachers.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    {{ __('Cancel') }}
                </a>
            </div>
        </form>
    </x-container>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                </div>
            </div>
        </div>
    </div>
</x-app-layout>