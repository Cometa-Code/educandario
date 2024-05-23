<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="bg-purple-950 h-20 flex justify-center">
        <!-- Logo -->
        <div class="w-64 items-center">
            <a href="{{ route('admin.home') }}">
                <x-application-logo class="block w-full h-8 fill-current text-gray-200" />
            </a>
        </div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('admin.home')" :active="request()->routeIs('admin.home')" icon="bi bi-house">
                        {{ __('Início') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('admin.families.list')" :active="request()->routeIs('admin.families.list')" icon="bi bi-card-list">
                        {{ __('Famílias') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('admin.families.members')" :active="request()->routeIs('admin.families.members')" icon="bi bi-card-list">
                        {{ __('Crianças') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('admin.evaluations')" :active="request()->routeIs('admin.evaluations')" icon="bi bi-box-arrow-in-right">
                        {{ __('Avaliações') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('admin.calendar')" :active="request()->routeIs('admin.calendar')" icon="bi bi-card-checklist">
                        {{ __('Calendário') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('admin.reports')" :active="request()->routeIs('admin.reports')" icon="bi bi-box">
                        {{ __('Relatórios') }}
                    </x-nav-link>
                </div>
                <!--div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('admin.home')" :active="request()->routeIs('payments')" icon="bi bi-cart-check">
                        {{ __('Pagamentos') }}
                    </x-nav-link>
                </div-->
                <!--div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('admin.home')" :active="request()->routeIs('certified')" icon="bi bi-card-checklist">
                        {{ __('Certificado') }}
                    </x-nav-link>
                </div-->

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('admin.groups')" :active="request()->routeIs('admin.groups')" icon="bi bi-card-checklist">
                        {{ __('Turmas') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link href="{{ route('admin.profile') }}">
                            {{ __('Perfil') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Sair') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('admin.home')" :active="request()->routeIs('admin.home')">
                {{ __('Início') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.families.list')" :active="request()->routeIs('admin.families.list')">
                {{ __('Famílias') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.families.members')" :active="request()->routeIs('admin.families.members')">
                {{ __('Crianças') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.evaluations')" :active="request()->routeIs('admin.evaluations')">
                {{ __('Avaliações') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.calendar')" :active="request()->routeIs('admin.calendar')">
                {{ __('Calendário') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.reports')" :active="request()->routeIs('admin.reports')">
                {{ __('Relatórios') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.groups')" :active="request()->routeIs('admin.groups')">
                {{ __('Turmas') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link href="{{ route('admin.home') }}">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Sair') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
