<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-200">¡Bienvenido(a)!</h2>
        <p class="text-sm text-gray-400">Estás registrándote en:</p>
        <p class="text-indigo-400 text-xl font-bold uppercase tracking-wider">{{ $iglesia->name }}</p>
    </div>

    @if(session('success'))
        <div class="bg-green-600/20 border border-green-500 text-green-400 p-4 rounded-lg mb-6 text-center font-medium">
            {{ session('success') }}
        </div>
    @else
        <form action="{{ route('miembros.invitacion.store', $iglesia->id) }}" method="POST" class="space-y-4">
            @csrf
            
            <div class="bg-gray-800 p-6 rounded-xl shadow-lg border border-gray-700 space-y-4">
                
                <div>
                    <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Nombre Completo *</label>
                    <input type="text" name="name" required placeholder="Tu nombre" 
                        class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Correo Electrónico *</label>
                    <input type="email" name="email" required placeholder="ejemplo@correo.com" 
                        class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Contraseña *</label>
                        <input type="password" name="password" required 
                            class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Confirmar *</label>
                        <input type="password" name="password_confirmation" required 
                            class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-400 uppercase mb-1">F. Nacimiento *</label>
                        <input type="date" name="birthdate" required 
                            class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Estado Civil</label>
                        <select name="marital_status" class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 text-sm">
                            <option value="Soltero(a)">Soltero(a)</option>
                            <option value="Casado(a)">Casado(a)</option>
                            <option value="Unión Libre">Unión Libre</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 pt-2">
                    <select name="nationality" id="nationality_public" 
                        class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300">
                        <option value="México">México</option>
                        <option value="Guatemala">Guatemala</option>
                        <option value="Otro">Otro</option>
                    </select>
                    <input type="text" name="curp" id="curp_public" placeholder="CURP *" 
                        class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 uppercase">
                </div>

                <div class="mt-6">
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-lg font-bold shadow-lg transition transform active:scale-95">
                        Completar mi Registro
                    </button>
                    <p class="text-center text-[10px] text-gray-500 mt-4 italic">
                        Tu información será validada por el administrador de la iglesia.
                    </p>
                </div>
            </div>
        </form>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nationality = document.getElementById('nationality_public');
            const curp = document.getElementById('curp_public');
            
            nationality.addEventListener('change', function() {
                if (this.value === 'México') {
                    curp.required = true;
                    curp.placeholder = "CURP *";
                } else {
                    curp.required = false;
                    curp.placeholder = "CURP (Opcional)";
                }
            });
        });
    </script>
</x-guest-layout>