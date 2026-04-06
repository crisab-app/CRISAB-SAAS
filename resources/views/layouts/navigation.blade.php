<nav x-data="{ open: false, openAviso: false }" class="bg-white border-b border-gray-100 dark:bg-gray-800 dark:border-gray-700 transition-colors duration-200 relative z-50">
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

                    @if(!Auth::user()->is_super_admin || Auth::user()->contract_id)
                        @if(Auth::user()->can_manage_members || Auth::user()->is_super_admin)
                            <x-nav-link :href="route('miembros.index')" :active="request()->routeIs('miembros.*')">
                                👥 {{ __('Miembros') }}
                            </x-nav-link>
                        @endif
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

                    <x-nav-link :href="route('cursos.index')" :active="request()->routeIs('cursos.*')">
                        🌱 {{ __('Discipulado') }}
                    </x-nav-link>
                    <x-nav-link :href="route('biblioteca.index')" :active="request()->routeIs('biblioteca.*')">
                        📚 {{ __('Biblioteca') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                
                @if(Auth::user()->can_manage_members || Auth::user()->can_manage_church || Auth::user()->is_super_admin)
                    <button @click="openAviso = true" title="Enviar Aviso a la Iglesia" class="mr-2 p-2 text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 transition-colors focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                    </button>
                @endif

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
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>

                <button onclick="localStorage.theme = localStorage.theme === 'dark' ? 'light' : 'dark'; document.documentElement.classList.toggle('dark')" class="mr-4 p-2 rounded-full text-gray-500 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 dark:text-gray-400 dark:hover:text-white dark:bg-gray-700 dark:hover:bg-gray-600 transition duration-150 ease-in-out">
                    🌓
                </button>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div class="h-8 w-8 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center mr-2 text-indigo-600 dark:text-indigo-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="url('/master-panel')">👑 {{ __('Master Panel') }}</x-dropdown-link>
                        <x-dropdown-link :href="route('profile.edit')">⚙️ {{ __('Mi Perfil') }}</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                🚪 {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-900 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 transition duration-150 ease-in-out relative z-50">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden absolute top-16 left-0 w-full bg-white dark:bg-gray-800 shadow-2xl border-b border-gray-200 dark:border-gray-700 z-50 overflow-y-auto">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">🏠 {{ __('Inicio') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('church.profile.edit')" :active="request()->routeIs('church.profile.*')">⛪ {{ __('Mi Iglesia') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('calendario')" :active="request()->routeIs('calendario.*')">📅 {{ __('Calendario') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('grupos.index')" :active="request()->routeIs('grupos.*')">👥 {{ __('Grupos') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('privilegios.index')" :active="request()->routeIs('privilegios.*')">⭐ {{ __('Privilegios') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('templates.index')" :active="request()->routeIs('templates.*')">📋 {{ __('Actividades') }}</x-responsive-nav-link>
            
            @if(Auth::user()->can_manage_finances || Auth::user()->is_super_admin)
                <x-responsive-nav-link :href="route('finances.index')" :active="request()->routeIs('finances.*')">💰 {{ __('Finanzas') }}</x-responsive-nav-link>
            @endif
            <x-responsive-nav-link :href="route('cursos.index')" :active="request()->routeIs('cursos.*')">🌱 {{ __('Discipulado') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('biblioteca.index')" :active="request()->routeIs('biblioteca.*')">📚 {{ __('Biblioteca') }}</x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-900">
            <div class="px-4 flex items-center gap-3 mb-3">
                <div class="h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-600 dark:text-indigo-400 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <div>
                    <div class="font-bold text-base text-gray-800 dark:text-gray-200 leading-tight">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-xs text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1 pb-4">
                @if(Auth::user()->can_manage_members || Auth::user()->can_manage_church || Auth::user()->is_super_admin)
                    <button @click="openAviso = true" class="w-full text-left flex items-center ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none transition duration-150 ease-in-out">
                        📢 Enviar Aviso Masivo
                    </button>
                @endif
                
                <button onclick="localStorage.theme = localStorage.theme === 'dark' ? 'light' : 'dark'; document.documentElement.classList.toggle('dark')" class="w-full text-left flex items-center ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none transition duration-150 ease-in-out">
                    🌓 Cambiar Tema
                </button>

                @if(!Auth::user()->is_super_admin || Auth::user()->contract_id)
                    @if(Auth::user()->can_manage_members || Auth::user()->is_super_admin)
                        <x-responsive-nav-link :href="route('miembros.index')" :active="request()->routeIs('miembros.*')">👥 {{ __('Miembros') }}</x-responsive-nav-link>
                    @endif
                @endif

                <x-responsive-nav-link :href="route('profile.edit')">⚙️ {{ __('Mi Perfil') }}</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        <span class="text-red-500 font-bold">🚪 {{ __('Cerrar Sesión') }}</span>
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>

    @if(Auth::user()->can_manage_members || Auth::user()->can_manage_church || Auth::user()->is_super_admin)
        <div x-show="openAviso" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-60 backdrop-blur-sm" @click.away="openAviso = false">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-md p-6 transform transition-all mx-4" @click.stop>
                <div class="flex justify-between items-center mb-5 border-b border-gray-100 dark:border-gray-700 pb-3">
                    <h3 class="text-xl font-black text-gray-900 dark:text-white flex items-center gap-2">📢 Enviar Aviso</h3>
                    <button @click="openAviso = false" class="text-gray-400 hover:text-red-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form action="{{ route('notifications.sendMassive') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Título del Aviso</label>
                        <input type="text" name="title" required placeholder="Ej. Cambio de horario dominical" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Mensaje</label>
                        <textarea name="message" required rows="3" placeholder="Escribe tu mensaje para toda la iglesia aquí..." class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>
                    <div class="flex justify-end gap-3 bg-gray-50 dark:bg-gray-900 -mx-6 -mb-6 p-4 rounded-b-2xl">
                        <button type="button" @click="openAviso = false" class="px-4 py-2 text-sm font-bold text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition">Cancelar</button>
                        <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-lg shadow-md transition">🚀 Enviar a todos</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</nav>