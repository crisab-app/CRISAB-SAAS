<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ url()->previous() }}" class="text-gray-500 hover:text-indigo-600 dark:text-gray-400 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                ✏️ Editar Usuario: <span class="text-indigo-600 dark:text-indigo-400">{{ $user->name }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 dark:bg-green-900/30 dark:border-green-800 dark:text-green-400 rounded-xl p-4 shadow-sm font-bold flex items-center gap-2">
                    <span>✅</span> {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Información y Privilegios</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Modifica el acceso y el rol de este usuario en su iglesia.</p>
                </div>
                <div class="bg-blue-50 dark:bg-blue-900/20 border-b border-blue-100 dark:border-blue-800 px-6 py-4 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-blue-100 dark:bg-blue-800 text-blue-600 dark:text-blue-300 rounded-full">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-blue-800 dark:text-blue-400 uppercase tracking-wider">Última sesión en el sistema</p>
                            <p class="text-sm font-medium text-blue-900 dark:text-blue-300 mt-0.5">
                                @if($user->last_login_at)
                                    {{ \Carbon\Carbon::parse($user->last_login_at)->translatedFormat('l d \d\e F, Y - h:i A') }}
                                    <span class="text-blue-500 dark:text-blue-400 text-xs ml-2">({{ \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() }})</span>
                                @else
                                    <span class="italic opacity-70">El usuario aún no ha iniciado sesión.</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    @if($user->last_login_ip)
                        <div class="text-right">
                            <p class="text-xs font-bold text-blue-800 dark:text-blue-400 uppercase tracking-wider">Dirección IP</p>
                            <p class="text-sm font-medium text-blue-900 dark:text-blue-300 mt-0.5 font-mono bg-white dark:bg-blue-900/50 px-2 py-0.5 rounded border border-blue-200 dark:border-blue-700">
                                {{ $user->last_login_ip }}
                            </p>
                        </div>
                    @endif
                </div>
                ```

**¿Qué hace esto?**
Crea una barra de monitoreo en tono azul claro (o azul oscuro si usas modo noche) que te mostrará:
* El día exacto y la hora del último inicio de sesión (Ej. "Miércoles 08 de Abril, 2026 - 11:09 AM").
* Hace cuánto tiempo fue eso (Ej. "hace 2 días").
* La dirección IP desde donde se conectó (muy útil por seguridad).

Si un usuario se acaba de registrar pero nunca ha entrado, la plataforma elegantemente te dirá: *"El usuario aún no ha iniciado sesión."*

                <div class="p-8">
                    <form action="{{ route('superadmin.users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Nombre Completo</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                        <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Correo Electrónico</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div> <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Teléfono (Opcional)</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <hr class="my-6 border-gray-200 dark:border-gray-700">

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Rol en la Iglesia</label>
                            <select name="role" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="miembro" {{ $user->role == 'miembro' ? 'selected' : '' }}>Miembro (Acceso Básico)</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrador (Gestión de Iglesia)</option>
                                <option value="pastor" {{ $user->role == 'pastor' ? 'selected' : '' }}>Pastor / Presidente (Acceso Total)</option>
                            </select>
                        </div>
                        
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mt-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">🔐 Cambiar Contraseña (Opcional)</h3>
                            <p class="text-sm text-gray-500 mb-4">Si dejas este campo en blanco, la contraseña actual se mantendrá intacta.</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nueva Contraseña</label>
                                    <input type="password" name="password" placeholder="Mínimo 8 caracteres" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-6 p-4 bg-purple-50 dark:bg-purple-900/20 border border-purple-100 dark:border-purple-800 rounded-lg mt-8">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="is_church_owner" value="1" {{ $user->is_church_owner ? 'checked' : '' }} class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-500 dark:bg-gray-900 dark:border-gray-600 w-5 h-5">
                                <span class="ml-3 text-sm text-purple-900 dark:text-purple-300 font-bold">Es el Creador / Dueño de la cuenta</span>
                            </label>
                            <p class="text-xs text-purple-700 dark:text-purple-400 ml-8 mt-1">Solo el dueño tiene poder absoluto y no puede ser borrado por otros pastores.</p>
                        </div>

                        <div class="mb-8 p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-100 dark:border-amber-800 rounded-lg">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active_donor" value="1" {{ $user->is_active_donor ? 'checked' : '' }} class="rounded border-gray-300 text-amber-600 shadow-sm focus:border-amber-500 dark:bg-gray-900 dark:border-gray-600 w-5 h-5">
                                <span class="ml-3 text-sm text-amber-900 dark:text-amber-300 font-bold">Cuenta ACTIVADA (Donador Activo)</span>
                            </label>
                            <p class="text-xs text-amber-700 dark:text-amber-400 ml-8 mt-1">
                                Si este switch está encendido, el usuario no verá el mensaje de cobro y tendrá acceso completo a su nivel.
                            </p>
                        </div>

                        <div class="flex justify-end gap-4 border-t border-gray-100 dark:border-gray-700 pt-5">
                            <a href="{{ url()->previous() }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 font-bold py-2 transition">Cancelar</a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow-sm transition">
                                💾 Guardar Privilegios
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>