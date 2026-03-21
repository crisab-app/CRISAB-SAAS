<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('cursos.index') }}" class="text-gray-500 hover:text-indigo-600 dark:text-gray-400 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                🎓 Aula Virtual: {{ $curso->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Información del Curso</h3>
                        
                        <div class="space-y-4 text-sm">
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 font-bold">Maestro a cargo:</p>
                                <p class="text-gray-900 dark:text-white flex items-center gap-2 mt-1">
                                    👨‍🏫 {{ $curso->teacher ? $curso->teacher->name : 'No asignado' }}
                                </p>
                            </div>
                            
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 font-bold">Horario:</p>
                                <p class="text-gray-900 dark:text-white mt-1">🕒 {{ $curso->schedule ?? 'Por definir' }}</p>
                            </div>

                            @if($curso->description)
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 font-bold">Descripción:</p>
                                <p class="text-gray-900 dark:text-white mt-1">{{ $curso->description }}</p>
                            </div>
                            @endif
                        </div>

                        <div class="mt-6 pt-6 border-t border-gray-100 dark:border-gray-700">
                            <form action="{{ route('cursos.destroy', $curso) }}" method="POST" onsubmit="return confirm('⚠️ ¿Estás totalmente seguro de eliminar este curso? Se borrará la lista de alumnos matriculados y no se puede deshacer.');">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-full flex justify-center items-center gap-2 bg-red-50 hover:bg-red-100 text-red-600 dark:bg-red-900/20 dark:hover:bg-red-900/40 dark:text-red-400 font-bold py-2 px-4 rounded-lg transition">
                                    🗑️ Eliminar este Curso
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-6">
                    
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                        <form action="{{ route('cursos.enroll', $curso) }}" method="POST" class="flex flex-col sm:flex-row gap-4 items-end">
                            @csrf
                            <div class="flex-1 w-full">
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Añadir Discípulo al Aula</label>
                                <select name="user_id" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500">
                                    <option value="">-- Seleccionar miembro --</option>
                                    @foreach($availableMembers as $member)
                                        <option value="{{ $member->id }}">{{ $member->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow transition">
                                + Inscribir
                            </button>
                        </form>
                    </div>

                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Discípulos Inscritos ({{ $curso->students->count() }})</h3>
                        </div>
                        
                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($curso->students as $student)
                                <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                    <div class="flex items-center gap-4">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&color=4f46e5&background=e0e7ff" class="h-10 w-10 rounded-full">
                                        <div>
                                            <p class="font-bold text-gray-900 dark:text-white">{{ $student->name }}</p>
                                            <p class="text-xs text-gray-500 mt-1">Inscrito: {{ \Carbon\Carbon::parse($student->pivot->enrollment_date)->format('d/m/Y') }}</p>
                                        </div>
                                    </div>

                                    <form action="{{ route('cursos.students.status', [$curso, $student]) }}" method="POST" class="flex items-center gap-2">
                                        @csrf @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 shadow-sm focus:border-indigo-500
                                            {{ $student->pivot->status === 'graduated' ? 'text-green-600 font-bold' : ($student->pivot->status === 'dropped' ? 'text-red-500' : 'text-gray-700 dark:text-gray-300') }}">
                                            <option value="enrolled" {{ $student->pivot->status === 'enrolled' ? 'selected' : '' }}>⏳ Cursando</option>
                                            <option value="graduated" {{ $student->pivot->status === 'graduated' ? 'selected' : '' }}>🎓 Graduado</option>
                                            <option value="dropped" {{ $student->pivot->status === 'dropped' ? 'selected' : '' }}>❌ Baja</option>
                                        </select>
                                    </form>
                                </div>
                            @empty
                                <div class="p-10 text-center text-gray-500 dark:text-gray-400">
                                    No hay discípulos inscritos en este curso todavía.
                                </div>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>