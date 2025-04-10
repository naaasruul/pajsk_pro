@props(['id' => 'default-button'])

{{-- Button component with Tailwind CSS classes --}}
{{-- You can customize the button's ID and other attributes as needed --}}
{{-- Example usage: <x-button id="my-button">Click Me</x-button> --}}
{{-- You can also pass additional attributes like onclick, class, etc. --}}
{{-- Example usage: <x-button id="my-button" onclick="alert('Button clicked!')">Click Me</x-button> --}}

{{-- Button HTML --}}
<button type="button" id="{{ $id }}" class="text-white hidden bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium 
                rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">{{ $slot }}</button>