<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            🏠 Inicio
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(request()->query('cafe') == 'gracias')
                <div class="mb-8 bg-gradient-to-r from-amber-100 to-orange-100 dark:from-amber-900/40 dark:to-orange-900/40 border border-amber-200 dark:border-amber-800 rounded-2xl p-6 shadow-sm flex items-center justify-between relative overflow-hidden">
                    <div class="flex items-center gap-4 z-10">
                        <div class="text-5xl drop-shadow-md">☕🎉</div>
                        <div>
                            <h4 class="text-xl font-extrabold text-amber-900 dark:text-amber-300">¡Muchísimas gracias por tu café!</h4>
                            <p class="text-amber-800 dark:text-amber-400 mt-1 font-medium">Tu aportación nos ayuda enormemente a mantener los servidores encendidos y a seguir mejorando esta herramienta. ¡Que Dios te multiplique!</p>
                        </div>
                    </div>
                    <button onclick="this.parentElement.style.display='none'" class="absolute top-4 right-4 text-amber-700 dark:text-amber-500 hover:text-amber-900 dark:hover:text-amber-300 transition z-10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                    <div class="absolute -right-10 -bottom-10 opacity-10 text-9xl pointer-events-none">✨</div>
                </div>
            @endif
            
            @php
                // Obtenemos mágicamente los datos de la iglesia a la que pertenece este usuario
                $church = Auth::user()->contract;
            @endphp

            @if($church)
                <div class="bg-gray-800 border border-gray-700 shadow-xl rounded-xl overflow-hidden mb-8">
                    <div class="h-64 md:h-80 w-full bg-gray-900 relative bg-cover bg-center"
                         style="background-image: url('{{ $church->cover_photo_path ? asset('storage/' . $church->cover_photo_path) : 'https://images.unsplash.com/photo-1438283173091-5dbf5c5a3206?q=80&w=1000&auto=format&fit=crop' }}');">
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/60 to-transparent"></div>

                        <div class="absolute bottom-0 left-0 w-full p-6 md:p-10 flex flex-col md:flex-row md:items-end gap-6">
                            <div class="h-28 w-28 md:h-36 md:w-36 rounded-full border-4 border-gray-800 bg-white overflow-hidden shadow-2xl shrink-0 flex items-center justify-center relative z-10">
                                @if($church->logo_path)
                                    <img src="{{ asset('storage/' . $church->logo_path) }}" alt="Logo" class="h-full w-full object-cover">
                                @else
                                    <span class="text-5xl">⛪</span>
                                @endif
                            </div>

                            <div class="pb-2 relative z-10">
                                <h1 class="text-3xl md:text-5xl font-extrabold text-white shadow-sm">{{ $church->name ?? 'Nuestra Iglesia' }}</h1>
                                <div class="text-gray-300 mt-3 flex flex-wrap gap-4 text-sm md:text-base font-medium">
                                    @if($church->contact_phone) 
                                        <span class="bg-gray-800/80 px-3 py-1 rounded-full border border-gray-600 backdrop-blur-sm">📞 {{ $church->contact_phone }}</span> 
                                    @endif
                                    @if($church->contact_email) 
                                        <span class="bg-gray-800/80 px-3 py-1 rounded-full border border-gray-600 backdrop-blur-sm">✉️ {{ $church->contact_email }}</span> 
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 p-6 md:p-10 bg-gray-800">

                        <div class="md:col-span-2 space-y-6">
                            
                            <div>
                                <h3 class="text-xl font-bold text-white mb-4 border-b border-gray-700 pb-2">📜 Quiénes Somos</h3>
                                @if($church->history)
                                    <div class="text-gray-300 leading-relaxed whitespace-pre-line text-lg">
                                        {{ $church->history }}
                                    </div>
                                @else
                                    <div class="bg-gray-900/50 border border-dashed border-gray-600 p-6 rounded-lg text-center">
                                        <p class="text-gray-500 italic">Próximamente conocerás más sobre nuestra historia y visión aquí.</p>
                                    </div>
                                @endif
                            </div>

                            <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 rounded-2xl p-6 mt-8">
                                <h3 class="text-lg font-black text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                                    📅 Próximas Actividades
                                </h3>

                                @if(isset($upcomingActivities) && $upcomingActivities->isEmpty())
                                    <div class="text-center py-6 text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/50 rounded-xl">
                                        No hay eventos programados próximamente.
                                    </div>
                                @elseif(isset($upcomingActivities))
                                    <ul class="space-y-3">
                                        @foreach($upcomingActivities as $activity)
                                            <li class="flex items-center gap-4 p-3 hover:bg-gray-50 dark:hover:bg-gray-750 rounded-xl transition border border-transparent hover:border-gray-200 dark:hover:border-gray-700">
                                                <div class="bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg p-2 text-center min-w-[60px]">
                                                    <p class="text-xs font-bold uppercase">{{ \Carbon\Carbon::parse($activity->start_time)->translatedFormat('M') }}</p>
                                                    <p class="text-xl font-black leading-none">{{ \Carbon\Carbon::parse($activity->start_time)->format('d') }}</p>
                                                </div>
                                                
                                                <div class="flex-grow">
                                                    <p class="font-bold text-gray-900 dark:text-white">{{ $activity->title }}</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                                        🕒 {{ \Carbon\Carbon::parse($activity->start_time)->format('h:i A') }}
                                                    </p>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    
                                    <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700 text-center">
                                        <a href="{{ route('calendario') }}" class="text-sm font-bold text-blue-600 dark:text-blue-400 hover:underline">
                                            Ver calendario completo &rarr;
                                        </a>
                                    </div>
                                @endif
                            </div>

                        </div>

                        <div class="space-y-6">
                            
                            @if($church->facebook_url || $church->youtube_url)
                                <div class="bg-gray-900 rounded-xl p-6 border border-gray-700 shadow-inner">
                                    <h3 class="text-lg font-bold text-white mb-4">🌐 Nuestras Redes</h3>
                                    <div class="flex flex-col gap-3">
                                        @if($church->facebook_url)
                                            <a href="{{ $church->facebook_url }}" target="_blank" class="flex items-center gap-2 text-blue-400 hover:text-blue-300 transition font-bold bg-blue-900/20 p-3 rounded-lg border border-blue-900/50">
                                                👍 Síguenos en Facebook
                                            </a>
                                        @endif
                                        @if($church->youtube_url)
                                            <a href="{{ $church->youtube_url }}" target="_blank" class="flex items-center gap-2 text-red-400 hover:text-red-300 transition font-bold bg-red-900/20 p-3 rounded-lg border border-red-900/50">
                                                ▶️ Canal de YouTube
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <div class="bg-indigo-900/20 rounded-xl p-6 border border-indigo-500/30">
                                <h3 class="text-lg font-bold text-indigo-300 mb-2">📅 Siguientes Pasos</h3>
                                <p class="text-sm text-gray-400 mb-4">Revisa los próximos cultos, liturgias y actividades de la semana.</p>
                                <a href="{{ route('calendario') }}" class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg transition shadow-lg">
                                    Ir al Calendario
                                </a>
                            </div>

                        </div>

                    </div>
                </div>
            @else
                <div class="bg-yellow-900/20 border border-yellow-600 p-10 rounded-xl text-center shadow-lg">
                    <span class="text-5xl mb-4 block">⚠️</span>
                    <h3 class="text-2xl font-bold text-yellow-500 mb-2">Cuenta en Revisión</h3>
                    <p class="text-gray-400 text-lg">Tu cuenta ha sido creada, pero aún no has sido asignado a una iglesia específica.</p>
                    <p class="text-gray-500 mt-4 text-sm">Por favor, contacta al administrador de tu congregación para que te dé acceso.</p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>