<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mi Perfil Personal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="p-6 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-xl border border-gray-200 dark:border-gray-700 flex flex-col md:flex-row gap-6 items-center md:items-start transition">
                
                <div class="flex-shrink-0">
                    @if($user->profile_photo_path)
                        <img class="h-24 w-24 rounded-full object-cover border-4 border-indigo-100 dark:border-indigo-900/50" src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Foto de {{ $user->name }}">
                    @else
                        <div class="h-24 w-24 rounded-full bg-indigo-100 dark:bg-indigo-900/50 border-4 border-indigo-200 dark:border-indigo-800 flex items-center justify-center text-indigo-700 dark:text-indigo-400 text-3xl font-black">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    @endif
                </div>

                <div class="flex-1 w-full text-center md:text-left">
                    <h3 class="text-3xl font-black text-gray-900 dark:text-white">{{ $user->name }}</h3>
                    <p class="text-sm font-bold text-indigo-600 dark:text-indigo-400 mb-6 flex items-center justify-center md:justify-start gap-2">
                        ⛪ {{ $user->contract->name ?? 'Administrador Global' }}
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-left">
                        
                        <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-xl border border-gray-200 dark:border-gray-700">
                            <h4 class="text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Mis Ministerios</h4>
                            <div class="flex flex-wrap gap-2">
                                @forelse($user->skills as $skill)
                                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300 border border-green-200 dark:border-green-800">
                                        {{ $skill->name }}
                                    </span>
                                @empty
                                    <span class="text-xs font-medium text-gray-400 dark:text-gray-500">No tienes ministerios asignados.</span>
                                @endforelse
                            </div>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-xl border border-gray-200 dark:border-gray-700">
                            <h4 class="text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Permisos de Sistema</h4>
                            <ul class="space-y-2">
                                <li class="flex items-center gap-2 text-sm font-medium {{ $user->can_manage_finances ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-500 dark:text-gray-400' }}">
                                    <span class="text-lg">{!! $user->can_manage_finances ? '✅' : '🔒' !!}</span>
                                    Acceso al Módulo de Finanzas
                                </li>
                                
                                @if($user->is_super_admin)
                                <li class="flex items-center gap-2 text-sm font-bold text-yellow-600 dark:text-yellow-500 mt-2">
                                    <span class="text-lg">👑</span> Acceso Master Panel Global
                                </li>
                                @endif
                            </ul>
                        </div>

                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>