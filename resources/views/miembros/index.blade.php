<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Directorio de Miembros') }}
            </h2>
            
            <div class="flex items-center gap-3">
                <button onclick="copyInvitationLink()" 
                        class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-xs font-bold uppercase rounded-lg shadow-md transition duration-150 transform active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                    </svg>
                    Link de Invitación
                </button>

                <a href="{{ route('miembros.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg text-xs uppercase shadow-md transition duration-150">
                    + Nuevo Miembro
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border-l-4 border-indigo-500">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase">Total de Miembros</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $members->count() }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border-l-4 border-green-500">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase">Privilegios Asignados</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white">
                        {{ $members->filter(fn($m) => $m->skills->count() > 0)->count() }}
                    </p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border-l-4 border-yellow-500">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase">Pendientes de Revisar</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white">
                        {{ $members->filter(fn($m) => $m->skills->count() == 0)->count() }}
                    </p>
                </div>
            </div>

            @if (session('success'))
                <div class="bg-green-100 dark:bg-green-900/30 border border-green-400 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg mb-6">
                    <span class="block sm:inline">✅ {{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Miembro</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Edad / Estado Civil</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Privilegios</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($members as $member)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                @if($member->profile_photo_path)
                                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $member->profile_photo_path) }}">
                                                @else
                                                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold">
                                                        {{ substr($member->name, 0, 1) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $member->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $member->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-gray-100">{{ $member->age }} años</div>
                                        <div class="text-xs text-gray-500">{{ $member->marital_status ?? 'No definido' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-wrap gap-1">
                                            @forelse($member->skills as $skill)
                                                <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300 border border-green-200 dark:border-green-800">
                                                    {{ $skill->name }}
                                                </span>
                                            @empty
                                                <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-300 animate-pulse border border-yellow-200 dark:border-yellow-800">
                                                    ⚠️ PENDIENTE
                                                </span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('miembros.edit', $member->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-3">Editar</a>
                                        <form action="{{ route('miembros.destroy', $member->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Baja definitiva?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 font-bold">Baja</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<script>
    function copyInvitationLink() {
        // Obtenemos el ID directamente
        const idIglesia = "{{ auth()->user()->contract_id }}";
        // Construimos la URL completa
        const urlFinal = window.location.origin + "/unirme/" + idIglesia;

        // Intentamos copiar
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(urlFinal).then(() => {
                alert("✅ Link de invitación copiado:\n" + urlFinal);
            }).catch(err => {
                prompt("Copia este link manualmente:", urlFinal);
            });
        } else {
            // Respaldo para navegadores antiguos
            const textArea = document.createElement("textarea");
            textArea.value = urlFinal;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            alert("✅ Link de invitación copiado:\n" + urlFinal);
            document.body.removeChild(textArea);
        }
    }
</script></x-app-layout>