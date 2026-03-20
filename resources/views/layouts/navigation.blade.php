<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 dark:bg-gray-800 dark:border-gray-700 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-indigo-600 dark:text-indigo-400" />
                    </a>
                </div>

                <div class="hidden space-x-6 sm:-my-px sm:ms-8 sm:flex">
                @if(!Auth::user()->is_super_admin || Auth::user()->contract_id)
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        🏠 {{ __('Inicio') }}
                    </x-nav-link>

                    <x-nav-link :href="route('church.profile.edit')" :active="request()->routeIs('church.profile.*')">
                        ⛪ {{ __('Mi Iglesia') }}
                    </x-nav-link>

                    <x-nav-link :href="route('calendario')" :active="request()->routeIs('calendario.*')">
                        📅 {{ __('Calendario') }}
                    </x-nav-link>
                @endif
                @if(Auth::user()->is_super_admin && is_null(Auth::user()->contract_id))
                    <x-nav-link :href="route('superadmin.index')" :active="request()->routeIs('superadmin.*')">
                        👑 {{ __('Master Panel') }}
                    </x-nav-link>
                @endif

                    <x-nav-link :href="route('grupos.index')" :active="request()->routeIs('grupos.*')">
                        👥 {{ __('Grupos') }}
                    </x-nav-link>

                    <x-nav-link :href="route('privilegios.index')" :active="request()->routeIs('privilegios.*')">
                        ⭐ {{ __('Privilegios') }}
                    </x-nav-link>

                    <x-nav-link :href="route('templates.index')" :active="request()->routeIs('templates.*')">
                        📋 {{ __('Actividades') }}
                    </x-nav-link>
                    @if(auth()->user()->can_manage_finances || auth()->user()->is_super_admin)
                        <x-nav-link :href="route('finances.index')" :active="request()->routeIs('finances.*')">
                        💰 {{ __('Finanzas') }}
                        </x-nav-link>
                    @endif
                    

                    <x-nav-link href="#" :active="false">
                        🌱 {{ __('Discipulado') }}
                    </x-nav-link>
                </div>
            </div>


            <div class="hidden sm:flex sm:items-center sm:ms-6">
                
                <button onclick="localStorage.theme = localStorage.theme === 'dark' ? 'light' : 'dark'; document.documentElement.classList.toggle('dark')" class="mr-4 p-2 rounded-full text-gray-500 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 dark:text-gray-400 dark:hover:text-white dark:bg-gray-700 dark:hover:bg-gray-600 transition duration-150 ease-in-out">
                    🌓
                </button>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=4f46e5&background=e0e7ff&rounded=true" alt="Avatar" class="h-8 w-8 rounded-full mr-2 inline-block">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                    <div class="relative mr-4">
    <x-dropdown align="right" width="80">
        <x-slot name="trigger">
            <button class="relative flex items-center p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 transition-colors focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <span class="absolute top-1 right-1 flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500 text-[8px] text-white font-bold items-center justify-center">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span>
                    </span>
                @endif
            </button>
        </x-slot>

        <x-slot name="content">
            <div class="w-80 max-h-96 overflow-y-auto bg-white dark:bg-gray-800 rounded-md shadow-lg">
                <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-900/50">
                    <span class="text-sm font-bold text-gray-700 dark:text-gray-300">Notificaciones</span>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <form action="{{ route('notifications.markAsRead') }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="text-xs text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 font-bold">Marcar como leídas</button>
                        </form>
                    @endif
                </div>

                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse(auth()->user()->notifications->take(5) as $notification)
                        <a href="{{ $notification->data['url'] ?? '#' }}" class="block px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition {{ $notification->read_at ? 'opacity-60' : 'bg-indigo-50/50 dark:bg-indigo-900/20' }}">
                            <div class="flex items-start gap-3">
                                <div class="text-xl">{{ $notification->data['icon'] ?? '🔔' }}</div>
                                <div>
                                    <p class="text-sm font-bold text-gray-800 dark:text-gray-200">{{ $notification->data['title'] }}</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ $notification->data['message'] }}</p>
                                    <p class="text-[10px] text-gray-400 mt-2">{{ $notification->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="px-4 py-6 text-center text-sm text-gray-500">
                            No tienes notificaciones nuevas.
                        </div>
                    @endforelse
                </div>
                <div class="px-4 py-2 border-t border-gray-100 dark:border-gray-700 text-center">
                    <a href="#" class="text-xs font-bold text-gray-500 hover:text-gray-700 dark:text-gray-400">Ver todo el historial</a>
                </div>
            </div>
        </x-slot>
    </x-dropdown>
</div>
                        <x-dropdown-link :href="url('/master-panel')">
                            👑 {{ __('Master Panel') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('profile.edit')">
                            ⚙️ {{ __('Mi Perfil') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                🚪 {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-900 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden dark:bg-gray-800">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                🏠 {{ __('Inicio') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('church.profile.edit')" :active="request()->routeIs('church.profile.*')">
                ⛪ {{ __('Mi Iglesia') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('calendario')" :active="request()->routeIs('calendario.*')">
                📅 {{ __('Calendario') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('grupos.index')" :active="request()->routeIs('grupos.*')">
                👥 {{ __('Grupos') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('privilegios.index')" :active="request()->routeIs('privilegios.*')">
                ⭐ {{ __('Privilegios') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('templates.index')" :active="request()->routeIs('templates.*')">
                📋 {{ __('Actividades') }}
            </x-responsive-nav-link>

            @if(Auth::user()->can_manage_finances || Auth::user()->is_super_admin)
                <x-responsive-nav-link :href="route('finances.index')" :active="request()->routeIs('finances.*')">
                    💰 {{ __('Finanzas') }}
                </x-responsive-nav-link>
            @endif

            <x-responsive-nav-link href="#" :active="false">
                🌱 {{ __('Discipulado') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <button onclick="localStorage.theme = localStorage.theme === 'dark' ? 'light' : 'dark'; document.documentElement.classList.toggle('dark')" class="w-full text-left flex items-center ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none transition duration-150 ease-in-out">
                    🌓 Cambiar Tema
                </button>
                
                <x-responsive-nav-link :href="url('/master-panel')">
                    👑 {{ __('Master Panel') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('profile.edit')">
                    ⚙️ {{ __('Mi Perfil') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        🚪 {{ __('Cerrar Sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>