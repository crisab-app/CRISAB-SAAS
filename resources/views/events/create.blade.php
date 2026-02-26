<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Nuevo Evento') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('calendario.store') }}" method="POST">
                    @csrf <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Título del Evento</label>
                        <input type="text" name="title" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Ej: Culto de Jóvenes" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Color del Evento</label>
                        <input type="color" name="color" value="#3b82f6" class="h-10 w-20 border-gray-300 rounded-md shadow-sm cursor-pointer">
                    </div>
                    <hr class="my-6 border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Roles y Encargados (Opcional)</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
    
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Director del Culto</label>
                            <select name="participants[Director]" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Seleccionar persona --</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Predicador</label>
                            <select name="participants[Predicador]" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Seleccionar persona --</option>
                                @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Ministro de Alabanza</label>
                            <select name="participants[Alabanza]" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Seleccionar persona --</option>
                                @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
    
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Ujier Principal</label>
                            <select name="participants[Ujier]" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Seleccionar persona --</option>
                                @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                        </select>
                        </div>

                    </div>
                    <hr class="my-6 border-gray-200">

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Fecha y Hora de Inicio</label>
                        <input type="datetime-local" name="start_time" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-2">Fecha y Hora de Fin</label>
                        <input type="datetime-local" name="end_time" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <div class="flex justify-end gap-4">
                        <a href="{{ route('calendario') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">Cancelar</a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Guardar Evento</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>