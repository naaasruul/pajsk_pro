<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Co-Curriculum') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class=" text-gray-900 dark:text-gray-100">
                    <h2 class="text-4xl font-extrabold dark:text-white">Kelab Alam Sekitar</h2>
                    <p class="my-2 text-lg text-gray-500">Kelab Persatuan</p>
                    <div class="grid grid-cols-3 gap-4">
                        <x-card title="23" content="Male" />
                        <x-card title="22" content="Female" />
                        <x-card title="54" content="Total" />
                    </div>
                </div>
            </div>




            <x-container>
                <div class="relative z-0 overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    #
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    No Maktab
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Class
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Activity
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Marks
                                </th>
                                <th scope="col" class="px-6 py-3">

                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    1
                                </th>
                                <td class="px-6 py-4">
                                    Nasrulhaq Hidayat
                                </td>
                                <td class="px-6 py-4">
                                    BCS2211-035
                                </td>
                                <td class="px-6 py-4">
                                    DCS
                                </td>
                                <td class="px-6 py-4">
                                    Syarahan Kelab
                                </td>
                                <td class="px-6 py-4">
                                    86
                                </td>
                             <td class="px-6 py-4">
                                    <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                    <a href="#" class="font-medium text-red-600 dark:text-red-500 hover:underline ms-3">Remove</a>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                    <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between pt-4" aria-label="Table navigation">
                        <span class="text-sm font-normal text-gray-500 dark:text-gray-400 mb-4 md:mb-0 block w-full md:inline md:w-auto">Showing <span class="font-semibold text-gray-900 dark:text-white">1-10</span> of <span class="font-semibold text-gray-900 dark:text-white">1000</span></span>
                        <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
                            <li>
                                <a href="#" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Previous</a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">1</a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">2</a>
                            </li>
                            <li>
                                <a href="#" aria-current="page" class="flex items-center justify-center px-3 h-8 text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">3</a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">4</a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">5</a>
                            </li>
                            <li>
                        <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Next</a>
                            </li>
                        </ul>
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
    <script src="{{ asset('js/simple-db.js') }}"></script>
</x-app-layout>