<nav x-data="{ open: false, scrolled: false }"
     @scroll.window="scrolled = window.scrollY > 10"
     class="fixed w-full z-50 transition-all duration-300"
     :class="{'bg-white/90 dark:bg-gray-900/90 backdrop-blur-sm shadow-sm': scrolled, 'bg-white dark:bg-gray-900': !scrolled}">

    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo avec animation au hover -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="group">
                        <img src="{{ asset('images/gestion_taches.png') }}" alt="Logo gestion de tâches" class="block h-12 w-auto transition-transform duration-300 group-hover:scale-110" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-1 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <span class="relative group">
                            {{ __('Dashboard') }}
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-indigo-500 transition-all duration-300 group-hover:w-full"></span>
                        </span>
                    </x-nav-link>
                    @auth
                        @if (auth()->user()->role === 'admin')
                            <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                                <span class="relative group">
                                    {{ __('Utilisateurs') }}
                                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-indigo-500 transition-all duration-300 group-hover:w-full"></span>
                                </span>
                            </x-nav-link>
                        @endif
                    @endauth
                    <x-nav-link :href="route('tasks.index')" :active="request()->routeIs('tasks.index')">
                        <span class="relative group">
                            {{ __('Tâches') }}
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-indigo-500 transition-all duration-300 group-hover:w-full"></span>
                        </span>
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-transparent hover:text-indigo-600 dark:hover:text-indigo-300 focus:outline-none transition-all duration-300 group">
                            <div class="flex items-center">
                                <div class="relative">
                                    <div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-600 dark:text-indigo-300 font-semibold group-hover:bg-indigo-200 dark:group-hover:bg-indigo-800 transition-colors duration-300">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                    <span class="absolute bottom-0 right-0 block h-2 w-2 rounded-full ring-2 ring-white dark:ring-gray-900 bg-green-400"></span>
                                </div>
                                <span class="ml-2">{{ Auth::user()->name }}</span>
                            </div>
                            <svg class="ml-1 h-4 w-4 transition-transform duration-200 transform group-hover:rotate-180" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="group">
                            <div class="flex items-center">
                                <svg class="mr-2 h-5 w-5 text-gray-500 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                                {{ __('Profile') }}
                            </div>
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" class="group"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                <div class="flex items-center">
                                    <svg class="mr-2 h-5 w-5 text-gray-500 group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                                    </svg>
                                    {{ __('Log Out') }}
                                </div>
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger Menu (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none transition duration-150 ease-in-out"
                        :class="{'bg-gray-100 dark:bg-gray-800': open}">
                    <svg class="h-6 w-6 transition-transform duration-200"
                         :class="{'rotate-90': open, 'rotate-0': !open}"
                         stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}"
                              class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open}"
                              class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="sm:hidden overflow-hidden">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @auth
                @if (auth()->user()->role === 'admin')
                    <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                        {{ __('Utilisateurs') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
            <x-responsive-nav-link :href="route('tasks.index')" :active="request()->routeIs('tasks.index')">
                {{ __('Tâches') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-700">
            <div class="px-4">
                <div class="flex items-center">
                    <div class="relative mr-3">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-600 dark:text-indigo-300 font-semibold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <span class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full ring-2 ring-white dark:ring-gray-900 bg-green-400"></span>
                    </div>
                    <div>
                        <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>
            </div>

            <div class="mt-3 space-y-1 px-4">
                <x-responsive-nav-link :href="route('profile.edit')">
                    <div class="flex items-center">
                        <svg class="mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        {{ __('Profile') }}
                    </div>
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        <div class="flex items-center">
                            <svg class="mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                            </svg>
                            {{ __('Log Out') }}
                        </div>
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
