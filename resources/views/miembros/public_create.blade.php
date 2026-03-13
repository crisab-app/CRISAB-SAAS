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
        
        <script>
            const formId = 'registro_miembro_';
            Object.keys(sessionStorage).forEach(key => {
                if(key.startsWith(formId)) sessionStorage.removeItem(key);
            });
        </script>
    @else

        @if($errors->any())
            <div class="bg-red-900/50 border border-red-500 text-red-200 p-4 rounded-xl mb-6 shadow-lg">
                <p class="font-bold mb-2 flex items-center gap-2">⚠️ Por favor corrige lo siguiente:</p>
                <ul class="list-disc list-inside text-sm space-y-1">
                    @foreach($errors->all() as $error)
                        @if(Str::contains($error, 'validation.min.string'))
                            <li>Uno de los campos es demasiado corto (Las contraseñas deben tener mínimo 8 caracteres).</li>
                        @elseif(Str::contains($error, 'validation.unique'))
                            <li>Ese correo o CURP ya está registrado en nuestro sistema.</li>
                        @else
                            <li>{{ str_replace('validation.', 'Error en: ', $error) }}</li>
                        @endif
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="registroForm" action="{{ route('miembros.invitacion.store', $iglesia->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            
            <div class="bg-gray-800 p-6 rounded-xl shadow-lg border border-gray-700 space-y-4">
                
                <div>
                    <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Nombre(s) *</label>
                    <input type="text" name="name" required placeholder="Tus nombres" value="{{ old('name') }}"
                        class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 autosave">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Apellido Paterno</label>
                        <input type="text" name="paternal_surname" placeholder="Primer apellido" value="{{ old('paternal_surname') }}"
                            class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 autosave">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Apellido Materno</label>
                        <input type="text" name="maternal_surname" placeholder="Segundo apellido" value="{{ old('maternal_surname') }}"
                            class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 autosave">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Correo Electrónico *</label>
                    <input type="email" name="email" required placeholder="ejemplo@correo.com" value="{{ old('email') }}"
                        class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 autosave">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Contraseña *</label>
                        <input type="password" name="password" required 
                            class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300">
                        <p class="text-[10px] text-gray-500 mt-1">Mínimo 8 caracteres.</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Confirmar Contraseña *</label>
                        <input type="password" name="password_confirmation" required 
                            class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-400 uppercase mb-1">F. Nacimiento *</label>
                        <input type="date" name="birthdate" required value="{{ old('birthdate') }}"
                            class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500 autosave">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Género *</label>
                        <select name="gender" required class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500 autosave">
                            <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Selecciona...</option>
                            <option value="Masculino" {{ old('gender') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                            <option value="Femenino" {{ old('gender') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Estado Civil</label>
                        <select name="marital_status" class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500 autosave">
                            <option value="Soltero(a)" {{ old('marital_status') == 'Soltero(a)' ? 'selected' : '' }}>Soltero(a)</option>
                            <option value="Casado(a)" {{ old('marital_status') == 'Casado(a)' ? 'selected' : '' }}>Casado(a)</option>
                            <option value="Unión Libre" {{ old('marital_status') == 'Unión Libre' ? 'selected' : '' }}>Unión Libre</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                    <div>
                        <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Nacionalidad</label>
                        <select name="nationality" id="nationality_public" 
                            class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 autosave">
                            <option value="México" {{ old('nationality') == 'México' ? 'selected' : '' }}>México</option>
                            <option value="Guatemala" {{ old('nationality') == 'Guatemala' ? 'selected' : '' }}>Guatemala</option>
                            <option value="Otro" {{ old('nationality') == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-400 uppercase mb-1" id="curp_label">CURP *</label>
                        <input type="text" name="curp" id="curp_public" placeholder="Ingresa tu CURP (18 caracteres)" value="{{ old('curp') }}"
                            class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 uppercase focus:ring-indigo-500 focus:border-indigo-500 autosave">
                        <p class="text-[10px] text-gray-500 mt-1" id="curp_helper">Formato de 18 caracteres.</p>
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
                    <button type="submit" id="submitBtn" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-4 rounded-xl font-bold shadow-lg transition transform active:scale-95 text-lg flex items-center justify-center gap-2">
                        <span>Completar mi Registro</span>
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
            
            // --- LÓGICA DE AUTO-GUARDADO SEGURO ---
            const formInputs = document.querySelectorAll('.autosave');
            const formId = 'registro_miembro_';

            formInputs.forEach(input => {
                const savedValue = sessionStorage.getItem(formId + input.name);
                if (savedValue !== null && input.value === '') {
                    input.value = savedValue;
                }
                input.addEventListener('input', () => {
                    sessionStorage.setItem(formId + input.name, input.value);
                });
            });

            const form = document.getElementById('registroForm');
            const submitBtn = document.getElementById('submitBtn');
            if(form) {
                form.addEventListener('submit', () => {
                    submitBtn.innerHTML = `
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Procesando...
                    `;
                    submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
                });
            }

            // --- LÓGICA DE CURP ---
            const nationalitySelect = document.getElementById('nationality_public');
            const curpInput = document.getElementById('curp_public');
            const curpLabel = document.getElementById('curp_label');
            const curpHelper = document.getElementById('curp_helper');
            
            function toggleCurpRequirement() {
                if (nationalitySelect && nationalitySelect.value === 'México') {
                    curpInput.required = true;
                    curpLabel.innerHTML = 'CURP *';
                    curpInput.placeholder = "Ingresa tu CURP (18 caracteres)";
                    if(curpHelper) curpHelper.style.display = 'block';
                } else if(curpInput) {
                    curpInput.required = false;
                    curpLabel.innerHTML = 'Documento de Identidad (Opcional)';
                    curpInput.placeholder = "DPI, Pasaporte, etc. (Opcional)";
                    if(curpHelper) curpHelper.style.display = 'none';
                }
            }

            if(nationalitySelect) {
                toggleCurpRequirement();
                nationalitySelect.addEventListener('change', toggleCurpRequirement);
            }

            // --- LÓGICA DE COMPRESIÓN DE IMÁGENES ---
            function activarCompresion(inputId) {
                const inputElement = document.getElementById(inputId);
                
                if (inputElement) {
                    inputElement.addEventListener('change', function(e) {
                        const file = e.target.files[0];
                        if (!file) return;

                        new Compressor(file, {
                            quality: 0.6, 
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