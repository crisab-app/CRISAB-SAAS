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
        <form id="registroForm" action="{{ route('miembros.invitacion.store', $iglesia->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            
            <div class="bg-gray-800 p-6 rounded-xl shadow-lg border border-gray-700 space-y-4">
                
                <div>
                    <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Nombre(s) *</label>
                    <input type="text" name="name" required placeholder="Tus nombres" 
                        class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 autosave">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Apellido Paterno</label>
                        <input type="text" name="paternal_surname" placeholder="Primer apellido" 
                            class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 autosave">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Apellido Materno</label>
                        <input type="text" name="maternal_surname" placeholder="Segundo apellido" 
                            class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 autosave">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Correo Electrónico *</label>
                    <input type="email" name="email" required placeholder="ejemplo@correo.com" 
                        class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 autosave">
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

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-400 uppercase mb-1">F. Nacimiento *</label>
                        <input type="date" name="birthdate" required 
                            class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500 autosave">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Género *</label>
                        <select name="gender" required class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500 autosave">
                            <option value="" disabled selected>Selecciona...</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Estado Civil</label>
                        <select name="marital_status" class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500 autosave">
                            <option value="Soltero(a)">Soltero(a)</option>
                            <option value="Casado(a)">Casado(a)</option>
                            <option value="Unión Libre">Unión Libre</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                    <div>
                        <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Nacionalidad</label>
                        <select name="nationality" id="nationality_public" 
                            class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 autosave">
                            <option value="México">México</option>
                            <option value="Guatemala">Guatemala</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-400 uppercase mb-1" id="curp_label">CURP *</label>
                        <input type="text" name="curp" id="curp_public" placeholder="Ingresa tu CURP" 
                            class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 uppercase focus:ring-indigo-500 focus:border-indigo-500 autosave">
                        @error('curp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="border-t border-gray-700 pt-5 mt-5 space-y-4">
                    <h3 class="text-sm font-bold text-gray-300 mb-2">Fotografía y Documentos <span class="text-gray-500 font-normal">(Opcional)</span></h3>
                    
                    <div>
                        <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Foto de Perfil</label>
                        <input type="file" name="profile_photo" id="profile_photo" accept="image/*" capture="user"
                            class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Identificación (Frente)</label>
                            <input type="file" name="id_front" id="id_front" accept="image/*" capture="environment"
                                class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-gray-700 file:text-white hover:file:bg-gray-600">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Identificación (Reverso)</label>
                            <input type="file" name="id_back" id="id_back" accept="image/*" capture="environment"
                                class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-gray-700 file:text-white hover:file:bg-gray-600">
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-4">
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-4 rounded-xl font-bold shadow-lg transition transform active:scale-95 text-lg">
                        Completar mi Registro
                    </button>
                    <p class="text-center text-[10px] text-gray-500 mt-4 italic">
                        Al registrarte, tu información será validada por la administración de la congregación.
                    </p>
                </div>
            </div>
        </form>
    @endif

    <script src="https://cdnjs.cloudflare.com/ajax/libs/compressorjs/1.2.1/compressor.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // --- 1. LÓGICA DE AUTO-GUARDADO (CONTRA EL REINICIO DE CÁMARA) ---
            const formInputs = document.querySelectorAll('.autosave');
            const formId = 'registro_miembro_';

            // Recuperar datos si la página se recargó
            formInputs.forEach(input => {
                const savedValue = sessionStorage.getItem(formId + input.name);
                if (savedValue !== null && input.value === '') {
                    input.value = savedValue;
                }

                // Guardar cada vez que el usuario escribe o cambia algo
                input.addEventListener('input', () => {
                    sessionStorage.setItem(formId + input.name, input.value);
                });
            });

            // Limpiar la memoria al enviar el formulario con éxito
            const form = document.getElementById('registroForm');
            if(form) {
                form.addEventListener('submit', () => {
                    formInputs.forEach(input => {
                        sessionStorage.removeItem(formId + input.name);
                    });
                });
            }

            // --- 2. LÓGICA DE CURP ---
            const nationalitySelect = document.getElementById('nationality_public');
            const curpInput = document.getElementById('curp_public');
            const curpLabel = document.getElementById('curp_label');
            
            function toggleCurpRequirement() {
                if (nationalitySelect.value === 'México') {
                    curpInput.required = true;
                    curpLabel.innerHTML = 'CURP *';
                    curpInput.placeholder = "Ingresa tu CURP";
                } else {
                    curpInput.required = false;
                    curpLabel.innerHTML = 'Documento de Identidad/CURP (Opcional)';
                    curpInput.placeholder = "CURP, DPI, Pasaporte, etc. (Opcional)";
                }
            }

            // Disparar la lógica de CURP después de restaurar los datos
            toggleCurpRequirement();
            nationalitySelect.addEventListener('change', toggleCurpRequirement);

            // --- 3. LÓGICA DE COMPRESIÓN DE IMÁGENES ---
            function activarCompresion(inputId) {
                const inputElement = document.getElementById(inputId);
                
                if (inputElement) {
                    inputElement.addEventListener('change', function(e) {
                        const file = e.target.files[0];
                        if (!file) return;

                        new Compressor(file, {
                            quality: 0.7, 
                            maxWidth: 1200, 
                            maxHeight: 1200,
                            mimeType: 'image/jpeg',
                            success(result) {
                                const dataTransfer = new DataTransfer();
                                const compressedFile = new File([result], result.name.replace(/\.[^/.]+$/, "") + ".jpg", {
                                    type: 'image/jpeg',
                                    lastModified: Date.now()
                                });
                                dataTransfer.items.add(compressedFile);
                                inputElement.files = dataTransfer.files;
                            },
                            error(err) {
                                console.error('Error al comprimir:', err.message);
                            },
                        });
                    });
                }
            }

            activarCompresion('profile_photo');
            activarCompresion('id_front');
            activarCompresion('id_back');
        });
    </script>
</x-guest-layout>