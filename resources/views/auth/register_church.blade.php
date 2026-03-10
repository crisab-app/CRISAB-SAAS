<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-200">Crea tu cuenta en administrarme.com</h2>
        <p class="text-sm text-gray-400">Digitaliza la administración de tu iglesia hoy mismo</p>
    </div>

    <form method="POST" action="{{ route('church.register.store') }}" class="space-y-4">
        @csrf
        
        <div class="bg-gray-800 p-6 rounded-xl shadow-lg border border-gray-700 space-y-4">
            
            <div class="border-b border-gray-700 pb-4 mb-4">
                <h3 class="text-sm font-bold text-indigo-400 uppercase mb-3">1. Datos del Ministerio</h3>
                <div>
                    <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Nombre de la Iglesia / Ministerio *</label>
                    <input type="text" name="church_name" value="{{ old('church_name') }}" required autofocus placeholder="Ej. Iglesia Ebenezer"
                        class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('church_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <h3 class="text-sm font-bold text-indigo-400 uppercase mb-3">2. Datos del Administrador</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Nombre Completo *</label>
                        <input type="text" name="pastor_name" value="{{ old('pastor_name') }}" required placeholder="Tu nombre"
                            class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('pastor_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Correo Electrónico *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="admin@iglesia.com"
                            class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Contraseña *</label>
                            <input type="password" name="password" required placeholder="Mínimo 8 caracteres"
                                class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Confirmar Contraseña *</label>
                            <input type="password" name="password_confirmation" required placeholder="Repite la contraseña"
                                class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-4">
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-4 rounded-xl font-bold shadow-lg transition transform active:scale-95 text-lg">
                    Crear Cuenta de mi Iglesia
                </button>
            </div>
            
            <div class="text-center mt-4">
                <a href="{{ route('login') }}" class="text-sm text-gray-400 hover:text-white transition">¿Ya tienes una cuenta? <span class="text-indigo-400 underline">Inicia sesión aquí</span></a>
            </div>
        </div>
    </form>
</x-guest-layout>