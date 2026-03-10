<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-200">¡Bienvenido(a)!</h2>
        <p class="text-sm text-gray-400">Estás registrándote en:</p>
        <p class="text-indigo-400 text-xl font-bold uppercase tracking-wider">{{ $iglesia->name }}</p>
    </div>

    @if(session('success'))
        <div class="bg-green-600/20 border border-green-500 text-green-400 p-4 rounded-lg mb-6 text-center font-medium shadow-lg">
            <p class="text-lg mb-2">✅</p>
            {{ session('success') }}
            <p class="text-sm mt-4 text-gray-400 font-normal">Ya puedes cerrar esta ventana.</p>
        </div>
    @else
        <form action="{{ route('miembros.invitacion.store', $iglesia->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            
            <div class="bg-gray-800 p-6 rounded-xl shadow-lg border border-gray-700 space-y-4">
                
                <div>
                    <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Nombre(s) *</label>
                    <input type="text" name="name" required placeholder="Tus nombres" 
                        class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Apellido Paterno</label>
                        <input type="text" name="paternal_surname" placeholder="Primer apellido" 
                            class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Apellido Materno</label>
                        <input type="text" name="maternal_surname" placeholder="Segundo apellido" 
                            class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Correo Electrónico *</label>
                    <input type="email" name="email" required placeholder="ejemplo@correo.com" 
                        class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p