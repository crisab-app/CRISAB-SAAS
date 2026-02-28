<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Don: {{ $skill->name }}</h2>
            <div class="flex gap-4">
                <a href="{{ route('privilegios.index') }}" class="bg-gray-200 px-4 py-2 rounded-md text-sm font-bold">&larr; Volver</a>
                @if(auth()->user()->system_role === 'admin')
                    <form action="{{ route('privilegios.destroy', $skill) }}" method="POST" onsubmit="return confirm('¿Eliminar este privilegio de la iglesia?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md text-sm font-bold">Eliminar</button>
                    </form>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="font-bold mb-4">Asignar a un Hermano</h3>
            <form action="{{ route('privilegios.assign', $skill) }}" method="POST">
                @csrf
                <select name="user_id" class="w-full border-gray-300 rounded-md mb-4">
                    @foreach($users as $user) <option value="{{ $user->id }}">{{ $user->name }}</option> @endforeach
                </select>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md">Asignar Don</button>
            </form>
        </div>

        <div class="md:col-span-2 bg-white p-6 rounded-lg shadow">
            <h3 class="font-bold mb-4">Hermanos con este Privilegio</h3>
            <ul class="divide-y divide-gray-200">
                @foreach($skill->users as $user)
                    <li class="py-3 flex justify-between items-center">
                        <span class="font-medium text-gray-800">{{ $user->name }}</span>
                        <form action="{{ route('privilegios.remove', [$skill, $user]) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 text-sm font-bold">Quitar</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-app-layout>