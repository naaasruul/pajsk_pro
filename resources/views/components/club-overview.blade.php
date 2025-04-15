<div class="p-6 text-gray-900 dark:text-gray-100">
    <h2 class="text-4xl font-extrabold dark:text-white">{{ $clubName ?? 'No Club' }}</h2>
    <p class="my-2 text-lg text-gray-500">{{ $clubCategory ?? '' }}</p>
    <p class="my-2 text-lg text-gray-500">Advisor:  {{ auth()->user()->name }}</p>

    <div class="grid grid-cols-3 gap-4 mb-6">
        {{ $slot }}
    </div>
</div>