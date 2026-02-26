<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Calendario de ') . (auth()->user()->contract ? auth()->user()->contract->name : 'la Iglesia') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="mb-6 flex justify-end">
                        <a href="{{ route('calendario.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 font-semibold shadow-sm">
                            + Crear Nuevo Evento
                        </a>
                    </div>
                    
                    <div id='calendar'></div>

                </div>
            </div>
        </div>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es', // ¡Calendario en español!
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    today: 'Hoy',
                    month: 'Mes',
                    week: 'Semana',
                    day: 'Día'
                },
                events: @json($events) // Aquí Laravel inyecta los datos de la base de datos
            });
            calendar.render();
        });
    </script>
</x-app-layout>