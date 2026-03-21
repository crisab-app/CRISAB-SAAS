<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
                🌱 {{ __('Academia Bíblica y Discipulado') }}
            </h2>
            <a href="{{ route('cursos.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow-sm transition">
                + Nuevo Curso
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if($courses->isEmpty())
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-10 text-center border border-gray-200 dark:border-gray-700">
                    <div class="text-6xl mb-4">📚</div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Aún no hay cursos creados</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">Comienza a estructurar el plan de crecimiento espiritual de tu iglesia creando clases de bautismo, teología o liderazgo.</p>
                    <a href="{{ route('cursos.create') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow transition">
                        Crear mi primer curso
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($courses as $course)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition">
                            <div class="h-2 bg-indigo-500 {{ $course->status == 'closed' ? 'bg-gray-400' : '' }}"></div>
                            <div class="p-5">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $course->name }}</h3>
                                    @if($course->status == 'active')
                                        <span class="px-2 py-1 bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 text-xs font-bold rounded-full">Activo</span>
                                    @else
                                        <span class="px-2 py-1 bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 text-xs font-bold rounded-full">Finalizado</span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4 line-clamp-2">{{ $course->description ?? 'Sin descripción.' }}</p>
                                
                                <div class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                                    <div class="flex items-center gap-2">
                                        👨‍🏫 <span class="font-medium">{{ $course->teacher ? $course->teacher->name : 'Sin maestro asignado' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        🕒 <span>{{ $course->schedule ?? 'Horario por definir' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        🎓 <span>{{ $course->students_count }} Alumnos inscritos</span>
                                    </div>
                                </div>
                            </div>
                            <div class="border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 p-3 flex justify-end gap-2">
                                <a href="{{ route('cursos.show', $course) }}" class="text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 font-bold px-3 py-1">Ver Aula / Alumnos</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>