<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Calendario de ') . (auth()->user()->contract ? auth()->user()->contract->name : 'la Iglesia') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg transition-colors duration-200">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <div class="mb-6 flex justify-end">
                        <a href="{{ route('calendario.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 font-semibold shadow-sm transition">
                            + Crear Nuevo Evento
                        </a>
                    </div>
                    
                    <div id='calendar'></div>

                </div>
            </div>
        </div>
    </div>

    <style>
        /* Cuando el HTML tenga la clase "dark", aplicamos estos colores al calendario */
        .dark {
            --fc-border-color: #374151; /* gray-700 para los bordes */
            --fc-today-bg-color: rgba(55, 65, 81, 0.5); /* Resalte del día de hoy en oscuro */
            --fc-neutral-bg-color: #1f2937; /* gray-800 para los encabezados */
            --fc-page-bg-color: #1f2937;
        }
        .dark .fc-col-header-cell-cushion, 
        .dark .fc-daygrid-day-number,
        .dark .fc-toolbar-title {
            color: #f3f4f6; /* text-gray-100 para los números y días */
        }
        .dark .fc .fc-button-primary {
            background-color: #3b82f6; /* blue-500 */
            border-color: #3b82f6;
        }
        .dark .fc .fc-button-primary:not(:disabled):active,
        .dark .fc .fc-button-primary:not(:disabled).fc-button-active,
        .dark .fc .fc-button-primary:hover {
            background-color: #2563eb; /* blue-600 */
            border-color: #2563eb;
        }
    </style>

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