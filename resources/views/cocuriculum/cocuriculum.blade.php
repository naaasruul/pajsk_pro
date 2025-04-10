<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Co-Curriculum') }}
            </h2>
            <a href="{{ route('cocuriculum.create') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                {{ __('Create New') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-4xl font-extrabold dark:text-white">{{ $club->club_name ?? 'No Club' }}</h2>
                    <p class="my-2 text-lg text-gray-500">{{ $club->category ?? '' }}</p>
                    <div class="grid grid-cols-3 gap-4">
                        <x-card title="23" content="Male" />
                        <x-card title="22" content="Female" />
                        <x-card title="54" content="Total" />
                    </div>
                </div>
            </div>

            <x-container>
                <div class="mb-4 flex flex-col md:flex-row gap-4">
                    <div class="w-full md:w-1/4">
                        <label for="class" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Class</label>
                        <select id="class" name="class" onchange="updateFilters()"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">All Classes</option>
                            @foreach($classes as $class)
                                <option value="{{ $class }}" {{ request('class') == $class ? 'selected' : '' }}>
                                    {{ $class }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full md:w-1/4">
                        <label for="activity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Activity</label>
                        <select id="activity" name="activity" onchange="updateFilters()"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">All Activities</option>
                            @foreach($activityTypes as $type)
                                <option value="{{ $type }}" {{ request('activity') == $type ? 'selected' : '' }}>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="relative z-0 overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">#</th>
                                <th scope="col" class="px-6 py-3">Name</th>
                                <th scope="col" class="px-6 py-3">No Maktab</th>
                                <th scope="col" class="px-6 py-3">Class</th>
                                <th scope="col" class="px-6 py-3">Activity</th>
                                <th scope="col" class="px-6 py-3">Marks</th>
                                <th scope="col" class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activities as $activity)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $activities->firstItem() + $loop->index }}
                                </th>
                                <td class="px-6 py-4">{{ $activity->student->user->name }}</td>
                                <td class="px-6 py-4">{{ $activity->no_maktab }}</td>
                                <td class="px-6 py-4">{{ $activity->class }}</td>
                                <td class="px-6 py-4">{{ $activity->activity }}</td>
                                <td class="px-6 py-4">{{ $activity->marks }}</td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('cocuriculum.edit', $activity) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                    <form action="{{ route('cocuriculum.destroy', $activity) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline ms-3">Remove</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                <td colspan="7" class="px-6 py-4 text-center">No activities found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between pt-4" aria-label="Table navigation">
                        <span class="text-sm font-normal text-gray-500 dark:text-gray-400 mb-4 md:mb-0 block w-full md:inline md:w-auto">
                            Showing <span class="font-semibold text-gray-900 dark:text-white">{{ $activities->firstItem() ?? 0 }}-{{ $activities->lastItem() ?? 0 }}</span> of 
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $activities->total() }}</span>
                        </span>
                        {{ $activities->withQueryString()->links() }}
                    </nav>
                </div>
            </x-container>


            {{-- IF USE DATATABLES --}}
            {{-- <table id="default-table">
                <thead>
                    <tr>
                        <th>
                            <span class="flex items-center">
                                Name
                                <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                </svg>
                            </span>
                        </th>
                        <th data-type="date" data-format="YYYY/DD/MM">
                            <span class="flex items-center">
                                Release Date
                                <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                </svg>
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                NPM Downloads
                                <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                </svg>
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Growth
                                <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                </svg>
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">Flowbite</td>
                        <td>2021/25/09</td>
                        <td>269000</td>
                        <td>49%</td>
                    </tr>
                    <tr>
                        <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">React</td>
                        <td>2013/24/05</td>
                        <td>4500000</td>
                        <td>24%</td>
                    </tr>
                    <tr>
                        <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">Angular</td>
                        <td>2010/20/09</td>
                        <td>2800000</td>
                        <td>17%</td>
                    </tr>
                    <tr>
                        <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">Vue</td>
                        <td>2014/12/02</td>
                        <td>3600000</td>
                        <td>30%</td>
                    </tr>
                    <tr>
                        <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">Svelte</td>
                        <td>2016/26/11</td>
                        <td>1200000</td>
                        <td>57%</td>
                    </tr>
                    <tr>
                        <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">Ember</td>
                        <td>2011/08/12</td>
                        <td>500000</td>
                        <td>44%</td>
                    </tr>
                    <tr>
                        <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">Backbone</td>
                        <td>2010/13/10</td>
                        <td>300000</td>
                        <td>9%</td>
                    </tr>
                    <tr>
                        <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">jQuery</td>
                        <td>2006/28/01</td>
                        <td>6000000</td>
                        <td>5%</td>
                    </tr>
                    <tr>
                        <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">Bootstrap</td>
                        <td>2011/19/08</td>
                        <td>1800000</td>
                        <td>12%</td>
                    </tr>
                    <tr>
                        <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">Foundation</td>
                        <td>2011/23/09</td>
                        <td>700000</td>
                        <td>8%</td>
                    </tr>
                    <tr>
                        <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">Bulma</td>
                        <td>2016/24/10</td>
                        <td>500000</td>
                        <td>7%</td>
                    </tr>
                    <tr>
                        <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">Next.js</td>
                        <td>2016/25/10</td>
                        <td>2300000</td>
                        <td>45%</td>
                    </tr>
                    <tr>
                        <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">Nuxt.js</td>
                        <td>2016/16/10</td>
                        <td>900000</td>
                        <td>50%</td>
                    </tr>
                    <tr>
                        <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">Meteor</td>
                        <td>2012/17/01</td>
                        <td>1000000</td>
                        <td>10%</td>
                    </tr>
                    <tr>
                        <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">Aurelia</td>
                        <td>2015/08/07</td>
                        <td>200000</td>
                        <td>20%</td>
                    </tr>
                    <tr>
                        <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">Inferno</td>
                        <td>2016/27/09</td>
                        <td>100000</td>
                        <td>35%</td>
                    </tr>
                    <tr>
                        <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">Preact</td>
                        <td>2015/16/08</td>
                        <td>600000</td>
                        <td>28%</td>
                    </tr>
                    <tr>
                        <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">Lit</td>
                        <td>2018/28/05</td>
                        <td>400000</td>
                        <td>60%</td>
                    </tr>
                    <tr>
                        <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">Alpine.js</td>
                        <td>2019/02/11</td>
                        <td>300000</td>
                        <td>70%</td>
                    </tr>
                    <tr>
                        <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">Stimulus</td>
                        <td>2018/06/03</td>
                        <td>150000</td>
                        <td>25%</td>
                    </tr>
                    <tr>
                        <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">Solid</td>
                        <td>2021/05/07</td>
                        <td>250000</td>
                        <td>80%</td>
                    </tr>
                </tbody>
            </table> --}}

        </div>
    </div>

    @push('scripts')
    <script>
        function updateFilters() {
            const classValue = document.getElementById('class').value;
            const activityValue = document.getElementById('activity').value;
            
            let url = new URL(window.location.href);
            
            if (classValue) {
                url.searchParams.set('class', classValue);
            } else {
                url.searchParams.delete('class');
            }
            
            if (activityValue) {
                url.searchParams.set('activity', activityValue);
            } else {
                url.searchParams.delete('activity');
            }
            
            window.location.href = url.toString();
        }
    </script>
    @endpush
</x-app-layout>