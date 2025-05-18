<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Evaluate Student Extra-Cocuricculum') }}
        </h2>
    </x-slot>

    <x-container>
        <h2 class="text-4xl font-extrabold dark:text-white mb-4">
            Evaluate Student Extra-Cocuricculum
        </h2>
        <p class="my-2 text-lg text-gray-500">
            Please fill out the form below to evaluate the student's extra-cocuricculum performance.
            Use the dropdowns to assign marks for each category. Ensure all fields are completed accurately.
        </p>

        <form action="{{ route('pajsk.extra-cocuriculum.store', $student->id ) }}" method="POST" class="mt-6">
            @csrf
            <!-- Service Point -->
            <div class="relative mb-6">
                <label for="service_point" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Service Point
                </label>
                <select id="service_point" name="service_point" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}">{{ $service->name }} [{{ $service->point }}]</option>
                    @endforeach
                </select>
            </div>

            <!-- Special Award Point -->
            <div class="relative mb-6">
                <label for="special_award_point" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Special Award Point
                </label>
                <select id="special_award_point" name="special_award_point" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @foreach ($special_awards as $special_award)
                        <option value="{{ $special_award->id }}">{{ $special_award->name }} [{{ $special_award->point }}]</option>
                    @endforeach
                </select>
            </div>

            <!-- Community Service Point -->
            <div class="relative mb-6">
                <label for="community_service_point" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Community Service Point
                </label>
                <select id="community_service_point" name="community_service_point" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @foreach ($community_services as $community_service)
                        <option value="{{ $community_service->id }}">{{ $community_service->name }} [{{ $community_service->point }}]</option>
                        
                    @endforeach
                </select>
            </div>

            <!-- Nilam Point -->
            <div class="relative mb-6">
                <label for="nilam_point" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Nilam
                </label>
                <div class="grid grid-cols-2 gap-4">
                    <select id="achievement" name="achievement" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @foreach ($achievements as $achievement)
                            <option value="{{ $achievement->id }}">{{ $achievement->achievement_name }}</option>
                        @endforeach
                    </select>
                    <select id="tiers" name="tiers" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @foreach ($tiers as $tier)
                            <option value="{{ $tier->id }}">{{ $tier->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- TIMMS and PISA Point -->
            <div class="relative mb-6">
                <label for="timms_and_pisa_point" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    TIMMS and PISA Point
                </label>
                <select id="timms_and_pisa_point" name="timms_and_pisa_point" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @foreach ($timms_pisa as $item)
                        <option value="{{ $item->id }}">{{ $item->name }} [{{ $item->point }}]</option>
                    @endforeach
                </select>
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit"
                    class="px-6 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Submit Evaluation
                </button>
            </div>
        </form>
    </x-container>
</x-app-layout>