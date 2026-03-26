<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Modificar Expediente: ') }} {{ $miembro->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                <form action="{{ route('miembros.update', $miembro->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">1. Información Personal</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre(s) *</label>
                                <input type="text" name="name" value="{{ old('name', $miembro->name) }}" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Apellido Paterno</label>
                                <input type="text" name="paternal_surname" value="{{ old('paternal_surname', $miembro->paternal_surname) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Apellido Materno</label>
                                <input type="text" name="maternal_surname" value="{{ old('maternal_surname', $miembro->maternal_surname) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Teléfono *</label>
                                <input type="tel" name="phone" value="{{ old('phone', $miembro->phone) }}" required placeholder="+52..." class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Correo Electrónico (Opcional)</label>
                                <input type="email" name="email" value="{{ old('email', $miembro->email) }}" placeholder="tu@correo.com" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha de Nacimiento *</label>
                                <input type="date" name="birthdate" 
                                    value="{{ old('birthdate', $miembro->birthdate ? $miembro->birthdate->format('Y-m-d') : '') }}" 
                                    required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estado Civil</label>
                                <select name="marital_status" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @foreach(['Soltero(a)', 'Casado(a)', 'Divorciado(a)', 'Viudo(a)', 'Concubinato'] as $status)
                                        <option value="{{ $status }}" {{ $miembro->marital_status == $status ? 'selected' : '' }}>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nacionalidad</label>
                                <select name="nationality" id="nationality" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @foreach(['México', 'Guatemala', 'Estados Unidos', 'Colombia', 'Honduras', 'El Salvador'] as $pais)
                                        <option value="{{ $pais }}" {{ $miembro->nationality == $pais ? 'selected' : '' }}>{{ $pais }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label id="curp_label" class="block text-sm font-medium text-gray-700 dark:text-gray-300">CURP</label>
                                <input type="text" name="curp" id="curp" value="{{ old('curp', $miembro->curp) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 uppercase">
                            </div>
                        </div>

                        <div class="col-span-full mt-6 p-5 bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-xl">
                            <h4 class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-4 flex items-center gap-2">
                                🕊️ Paso Espiritual (Bautismo)
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="flex items-center h-full pt-2">
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input type="hidden" name="is_baptized" value="0">
                                        <input type="checkbox" name="is_baptized" id="is_baptized" value="1" 
                                            class="w-5 h-5 text-indigo-600 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-900 focus:ring-indigo-500 shadow-sm" 
                                            onchange="toggleBaptismDate()"
                                            {{ (isset($miembro) && $miembro->is_baptized) ? 'checked' : '' }}>
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">¿Está bautizado en agua?</span>
                                    </label>
                                </div>

                                <div id="baptism_date_container" class="{{ (isset($miembro) && $miembro->is_baptized) ? '' : 'hidden' }}">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha de Bautismo</label>
                                    <input type="date" name="baptism_date" 
                                        value="{{ (isset($miembro) && $miembro->baptism_date) ? $miembro->baptism_date->format('Y-m-d') : '' }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>
                        </div>
                    
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">2. Actualizar Documentos</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fotografía de Perfil</label>
                                @if($miembro->profile_photo_path)
                                    <img src="{{ asset('storage/'.$miembro->profile_photo_path) }}" class="h-20 w-20 rounded mb-2 object-cover border border-gray-300 dark:border-gray-600">
                                @endif
                                <input type="file" name="profile_photo" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900/50 dark:file:text-indigo-400">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Credencial (Frente)</label>
                                @if($miembro->id_front_path)
                                    <div class="text-xs text-green-600 dark:text-green-400 mb-1">✓ Archivo existente</div>
                                @endif
                                <input type="file" name="id_front" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900/50 dark:file:text-indigo-400">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Credencial (Reverso)</label>
                                @if($miembro->id_back_path)
                                    <div class="text-xs text-green-600 dark:text-green-400 mb-1">✓ Archivo existente</div>
                                @endif
                                <input type="file" name="id_back" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900/50 dark:file:text-indigo-400">
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">3. Actualizar Privilegios</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($skills as $skill)
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="skills[]" value="{{ $skill->id }}" 
                                        {{ in_array($skill->id, $memberSkills) ? 'checked' : '' }}
                                        class="rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $skill->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6 gap-4 border-t border-gray-200 dark:border-gray-700 pt-6">
                        <a href="{{ route('miembros.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 transition">Cancelar</a>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded shadow-sm transition">
                            💾 Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-black text-gray-900 dark:text-white mb-2">🛡️ Permisos de Sistema (RBAC)</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Enciende o apaga el acceso a los módulos restringidos. Se guarda automáticamente.</p>

                <div class="space-y-4">
                    
                    <form action="{{ route('miembros.permissions', $miembro->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <input type="hidden" name="permission_type" value="can_manage_finances">
                        <label class="flex items-center cursor-pointer gap-4 p-4 border rounded-xl transition-colors {{ $miembro->can_manage_finances ? 'border-indigo-500 bg-indigo-50 dark:bg-indigo-900/20' : 'border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
                            <input type="checkbox" name="status" onchange="this.form.submit()" class="sr-only" {{ $miembro->can_manage_finances ? 'checked' : '' }}>
                            <div style="width: 3.5rem; height: 1.75rem; border-radius: 9999px; position: relative; transition: background-color 0.3s; background-color: {{ $miembro->can_manage_finances ? '#4f46e5' : '#9ca3af' }};">
                                <div style="width: 1.5rem; height: 1.5rem; background-color: white; border-radius: 9999px; position: absolute; top: 0.125rem; transition: left 0.3s; left: {{ $miembro->can_manage_finances ? '1.875rem' : '0.125rem' }}; box-shadow: 0 1px 3px rgba(0,0,0,0.3);"></div>
                            </div>
                            <div class="flex-1">
                                <span class="font-bold text-gray-900 dark:text-white flex items-center gap-2">💰 Módulo de Finanzas</span>
                                <p class="text-xs text-gray-500 mt-1">Permite registrar ingresos, egresos y auditorías.</p>
                            </div>
                        </label>
                    </form>

                    <form action="{{ route('miembros.permissions', $miembro->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <input type="hidden" name="permission_type" value="can_manage_members">
                        <label class="flex items-center cursor-pointer gap-4 p-4 border rounded-xl transition-colors {{ $miembro->can_manage_members ? 'border-green-500 bg-green-50 dark:bg-green-900/20' : 'border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
                            <input type="checkbox" name="status" onchange="this.form.submit()" class="sr-only" {{ $miembro->can_manage_members ? 'checked' : '' }}>
                            <div style="width: 3.5rem; height: 1.75rem; border-radius: 9999px; position: relative; transition: background-color 0.3s; background-color: {{ $miembro->can_manage_members ? '#22c55e' : '#9ca3af' }};">
                                <div style="width: 1.5rem; height: 1.5rem; background-color: white; border-radius: 9999px; position: absolute; top: 0.125rem; transition: left 0.3s; left: {{ $miembro->can_manage_members ? '1.875rem' : '0.125rem' }}; box-shadow: 0 1px 3px rgba(0,0,0,0.3);"></div>
                            </div>
                            <div class="flex-1">
                                <span class="font-bold text-gray-900 dark:text-white flex items-center gap-2">👥 Gestión de Miembros</span>
                                <p class="text-xs text-gray-500 mt-1">Permite agregar miembros, editar expedientes y dar bajas.</p>
                            </div>
                        </label>
                    </form>

                    <form action="{{ route('miembros.permissions', $miembro->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <input type="hidden" name="permission_type" value="can_manage_church">
                        <label class="flex items-center cursor-pointer gap-4 p-4 border rounded-xl transition-colors {{ $miembro->can_manage_church ? 'border-amber-500 bg-amber-50 dark:bg-amber-900/20' : 'border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
                            <input type="checkbox" name="status" onchange="this.form.submit()" class="sr-only" {{ $miembro->can_manage_church ? 'checked' : '' }}>
                            <div style="width: 3.5rem; height: 1.75rem; border-radius: 9999px; position: relative; transition: background-color 0.3s; background-color: {{ $miembro->can_manage_church ? '#f59e0b' : '#9ca3af' }};">
                                <div style="width: 1.5rem; height: 1.5rem; background-color: white; border-radius: 9999px; position: absolute; top: 0.125rem; transition: left 0.3s; left: {{ $miembro->can_manage_church ? '1.875rem' : '0.125rem' }}; box-shadow: 0 1px 3px rgba(0,0,0,0.3);"></div>
                            </div>
                            <div class="flex-1">
                                <span class="font-bold text-gray-900 dark:text-white flex items-center gap-2">⛪ Configuración de Iglesia</span>
                                <p class="text-xs text-gray-500 mt-1">Permite editar nombre, logo y suspender la cuenta.</p>
                            </div>
                        </label>
                    </form>

                </div>
            </div>

        </div>
    </div>
    
    <script>
        function toggleBaptismDate() {
            const checkbox = document.getElementById('is_baptized');
            const container = document.getElementById('baptism_date_container');
            if(checkbox.checked) {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
                // Limpia la fecha si se desmarca
                container.querySelector('input').value = '';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const nationalitySelect = document.getElementById('nationality');
            const curpInput = document.getElementById('curp');
            const curpLabel = document.getElementById('curp_label');
            function toggleCurp() {
                if (nationalitySelect.value === 'México') { curpInput.required = true; curpLabel.innerHTML = 'CURP *'; } 
                else { curpInput.required = false; curpLabel.innerHTML = 'CURP (Opcional)'; }
            }
            nationalitySelect.addEventListener('change', toggleCurp);
            toggleCurp();
        });
    </script>
</x-app-layout>