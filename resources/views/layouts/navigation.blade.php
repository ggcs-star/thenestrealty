<!-- =========  Responsive Navigation  ========= -->
<nav x-data="{ open: false, openSearch: false }"
    class="bg-white border-b border-gray-200 fixed top-0 left-0 right-0 z-50">
    <!-- Top bar -->
    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">

            @php
                if (Auth::guard('employee')->check()) {
                    $dashboard = route('dashboard');
                } else {
                    $dashboard = route('dashboard');
                }
            @endphp

            <!-- ==== Left : Logo ==== -->
            <div class="flex items-center flex-shrink-0">
                <a href="{{ $dashboard }}">
                    <img src="{{ asset('build/assets/images/nest-realty.png') }}" alt="Logo"
                        class="h-[100px] w-[130px] object-contain" />
                </a>
            </div>




            <!-- ==== Centre : Search (desktop) ==== -->
            <!-- <div class="hidden lg:block flex-1 mx-6 max-w-sm">
                <div class="relative">
                    <input
                        type="text"
                        placeholder="Search…"
                        class="w-full rounded-md border border-black bg-white px-3 py-2 text-sm text-black placeholder-black focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                    />
                    <span class="absolute inset-y-0 right-3 flex items-center text-black">
                        <i class="fas fa-search text-xs"></i>
                    </span>
                </div>
            </div> -->

            <!-- ==== Right icons ==== -->
            <div class="flex items-center space-x-4">

                <!-- Mobile search icon -->
                <!-- <button
                    @click="openSearch = !openSearch"
                    class="lg:hidden focus:outline-none"
                    aria-label="Search"
                >
                    <i class="fas fa-search"></i>
                </button> -->

                <!-- Notification -->
                <button class="relative hover:text-gray-900 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4
                                   0v.341C7.67 6.165 6 8.388 6 11v3.159c0
                                   .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0
                                   11-6 0v-1m6 0H9" />
                    </svg>
                    <span class="absolute -top-0.5 -right-0.5 inline-block h-2 w-2 rounded-full bg-red-600"></span>
                </button>

                <!-- User dropdown (desktop) -->
                <div class="hidden sm:flex sm:items-center">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-medium text-black shadow focus:outline-none">
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="ms-1 h-4 w-4 fill-current" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0
                                           011.414 0L10 10.586l3.293-3.293a1 1 0
                                           111.414 1.414l-4 4a1 1 0
                                           01-1.414 0l-4-4a1 1 0
                                           010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            @php
                                // Decide which logout route to call
                                if (Auth::guard('employee')->check()) {
                                    $logoutRoute = route('employee.logout');
                                } else {
                                    $logoutRoute = route('logout');
                                }
                            @endphp

                            <form method="POST" action="{{ $logoutRoute }}">
                                @csrf
                                <x-dropdown-link :href="$logoutRoute" onclick="event.preventDefault();
                 this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>

                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Hamburger (menu) -->
                <button @click="open = !open" class="sm:hidden focus:outline-none" aria-label="Menu">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- ==== Mobile search bar ==== -->
    <div x-show="openSearch" x-transition x-cloak class="bg-black px-4 pb-4 lg:hidden">
        <input type="text" placeholder="Search…"
            class="w-full rounded-md border border-black bg-white px-3 py-2 text-sm text-gray-700 placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500" />
    </div>

    <!-- ==== Responsive links (Mobile) ==== -->
    <div x-show="open" x-transition x-cloak class="sm:hidden bg-black pb-4">
        <div class="space-y-1 px-4 pt-4">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- User info / links -->
        <div class="border-t border-gray-700 pt-4">
            <div class="px-4 text-gray-300">
                <div class="text-base font-medium">
                    {{ Auth::user()->name }}
                </div>
                <div class="text-sm">
                    {{ Auth::user()->email }}
                </div>
            </div>

            <div class="mt-3 space-y-1 px-4">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();
                                 this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>