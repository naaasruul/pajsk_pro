<button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar"
    type="button"
    class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
    <span class="sr-only">Open sidebar</span>
    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path clip-rule="evenodd" fill-rule="evenodd"
            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
        </path>
    </svg>
</button>

<aside id="default-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"
    aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            <x-sidebar-item :route="route('dashboard')" :role="request()->routeIs('dashboard')">
                Dashboard
            </x-sidebar-item>

            {{-- ADMIN SIDEBAR --}}
            @hasrole('admin')
            <button type="button"
                class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                aria-controls="dropdown-user" data-collapse-toggle="dropdown-user">
                <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Users</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                </svg>
            </button>
            <ul id="dropdown-user" class="hidden py-2 space-y-2">
                <x-sidebar-item class="pl-11" :route="route('teachers.index')" :role="request()->routeIs('teachers.*')">
                    Teachers
                </x-sidebar-item>
                <x-sidebar-item class="pl-11" :route="route('students.index')" :role="request()->routeIs('students.*')">
                    Students
                </x-sidebar-item>
            </ul>
            <x-sidebar-item class="" :route="route('activity.approval')" :role="request()->routeIs('activity.approval')">
                Activity
            </x-sidebar-item>
            @endhasrole

            {{-- TEACHER SIDEBAR --}}
            @hasanyrole('teacher')
            <button type="button"
                class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                aria-controls="dropdown-student" data-collapse-toggle="dropdown-student">
                <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Student Management</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                </svg>
            </button>
            <ul id="dropdown-student" class="hidden py-2 space-y-2">
                <x-sidebar-item class="pl-11" :route="route('club.index')" :role="request()->routeIs('club.*')">
                    Club Management
                </x-sidebar-item>
                <x-sidebar-item class="pl-11" :route="route('pajsk.index')" :role="request()->routeIs('pajsk.*')">
                    PAJSK Assessment
                </x-sidebar-item>
            </ul>

            <button type="button"
                class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                aria-controls="dropdown-activity" data-collapse-toggle="dropdown-activity">
                <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Activities</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                </svg>
            </button>
            <ul id="dropdown-activity" class="hidden py-2 space-y-2">
                <x-sidebar-item class="pl-11" :route="route('activity.index')" :role="request()->routeIs('activity.*')">
                    Activity List
                </x-sidebar-item>
                <x-sidebar-item class="pl-11" :route="route('cocuriculum.index')" :role="request()->routeIs('cocuriculum.*')">
                    Co-curriculum
                </x-sidebar-item>
                <x-sidebar-item class="pl-11" :route="route('cocuriculum.extra-cocuriculum')" :role="request()->routeIs('cocuriculum.extra-cocuriculum')">
                    Extra Co-curriculum
                </x-sidebar-item>
            </ul>

            <x-sidebar-item :route="route('activity.index')" :role="request()->routeIs('activity.*')">
                Reports
            </x-sidebar-item>
            @endhasanyrole

            <div class="pt-4 mt-4 space-y-2 border-t border-gray-200 dark:border-gray-700">
                <x-sidebar-item :route="route('profile.edit')" :role="request()->routeIs('profile.*')">
                    Profile
                </x-sidebar-item>
                <x-sidebar-item>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex w-full text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <span class="">Logout</span>
                        </button>
                    </form>
                </x-sidebar-item>
            </div>
        </ul>
    </div>
</aside>