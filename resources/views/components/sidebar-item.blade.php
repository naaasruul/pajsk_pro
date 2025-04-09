<li>
    <a href="{{ $route }}"
        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ $role ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
        {{-- <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
            <path d="M18.9 0H1.1A1.1 1.1 0 0 0 0 1.1v1.8A1.1 1.1 0 0 0 1.1 4h.9v13a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V4h.9A1.1 1.1 0 0 0 20 2.9V1.1A1.1 1.1 0 0 0 18.9 0zm-7 15h-4a1 1 0 0 1-1-1v-1a3 3 0 0 1 6 0v1a1 1 0 0 1-1 1z"/>
            <path d="M14 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
        </svg> --}}
        <span class="flex-1 ms-3">{{ $slot }}</span>
    </a>
</li>