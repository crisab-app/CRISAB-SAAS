<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
            ⛪ Perfil de mi Iglesia
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-600/20 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg">
                    <p class="text-green-400 font-bold">{{ session('success') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-600/20 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
                    <ul class="list-disc ml-5 text-red-400 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div style="background-color: #1f2937; border: 1px solid #374151;" class="shadow-xl sm:rounded-lg overflow-hidden">
                
                <div class="h-48 w-full bg-gray-800 relative bg-cover bg-center border-b border-gray-700" 
                     style="background-image: url('{{ $church->cover_photo_path ? asset('storage/' . $church->cover_photo_path) : 'https://images.unsplash.com/photo-1438283173091-5dbf5c5a3206?q=80&w=1000&auto=format&fit=crop' }}');">
                    <div class="absolute inset-0 bg-black/40"></div>
                    
                    <div class="absolute -bottom-10 left-8">
                        <div class="h-24 w-24 rounded-full border-4 border-[#1f2937] bg-white overflow-hidden shadow-lg flex items-center justify-center">
                            @if($church->logo_path)
                                <img src="{{ asset('storage/' . $church->logo_path) }}" alt="Logo" class="h-full w-full object-cover">
                            @else
                                <span class="text-3xl">⛪</span>
                            @endif
                        </div>
                    </div>
                </div>

                <form action="{{ route('church.profile.update') }}" method="POST" enctype="multipart/form-data" class="p-8 pt-16">
                    @csrf 
                    @method('PUT')

                    <h3 class="text-xl font-bold text-white mb-6 border-b border-gray-700 pb-2">🖼️ Imágenes de la Iglesia</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Logo de la Iglesia (PNG/JPG)</label>
                            <input type="file" name="logo" accept="image/*"
                                class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 transition">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Foto de Portada / Banner (PNG/JPG)</label>
                            <input type="file" name="cover_photo" accept="image/*"
                                class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-700 file:text-white hover:file:bg-gray-600 transition">
                        </div>
                    </div>

                    <h3 class="text-xl font-bold text-white mb-6 border-b border-gray-700 pb-2">📜 Nuestra Historia</h3>
                    
                    <div class="mb-8">
                        <label class="block text-sm font-medium text-gray-300 mb-2">¿Quiénes somos? (Misión, Visión, Historia)</label>
                        <textarea name="history" rows="5" placeholder="Escribe aquí la historia de la iglesia para que los miembros la conozcan..."
                            style="background-color: #111827; border: 1px solid #374151; color: #f3f4f6;" 
                            class="w-full rounded-lg p-3 focus:ring-indigo-500 focus:border-indigo-500">{{ old('history', $church->history) }}</textarea>
                    </div>

                    <h3 class="text-xl font-bold text-white mb-6 border-b border-gray-700 pb-2">📞 Contacto y Redes</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Teléfono Principal</label>
                            <input type="text" name="contact_phone" value="{{ old('contact_phone', $church->contact_phone) }}" 
                                style="background-color: #111827; border: 1px solid #374151; color: #f3f4f6;" class="w-full rounded-lg p-2.5" placeholder="+1 234 567 8900">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Correo Electrónico</label>
                            <input type="email" name="contact_email" value="{{ old('contact_email', $church->contact_email) }}" 
                                style="background-color: #111827; border: 1px solid #374151; color: #f3f4f6;" class="w-full rounded-lg p-2.5" placeholder="contacto@iglesia.com">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Facebook (URL)</label>
                            <input type="url" name="facebook_url" value="{{ old('facebook_url', $church->facebook_url) }}" 
                                style="background-color: #111827; border: 1px solid #374151; color: #f3f4f6;" class="w-full rounded-lg p-2.5" placeholder="https://facebook.com/tu-iglesia">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">YouTube (URL)</label>
                            <input type="url" name="youtube_url" value="{{ old('youtube_url', $church->youtube_url) }}" 
                                style="background-color: #111827; border: 1px solid #374151; color: #f3f4f6;" class="w-full rounded-lg p-2.5" placeholder="https://youtube.com/@tu-iglesia">
                        </div>
                    </div>

                    <div class="flex justify-end mt-8">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg transition-all text-lg flex items-center gap-2">
                            💾 Guardar Perfil
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>