<x-guest-layout>
    <div class="pt-4 bg-gray-100 dark:bg-gray-900">
        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
            <div class="w-full sm:max-w-4xl mt-6 p-8 bg-white dark:bg-gray-800 shadow-xl overflow-hidden sm:rounded-lg prose dark:prose-invert">
                
                <h1 class="text-3xl font-bold mb-6 text-indigo-600 dark:text-indigo-400">Aviso de Privacidad</h1>
                <p class="text-sm text-gray-500 mb-8">Última actualización: {{ date('d/m/Y') }}</p>

                <p>En cumplimiento con la <strong>Ley Federal de Protección de Datos Personales en Posesión de los Particulares</strong>, <strong>Administrarme.com</strong> le informa sobre el tratamiento de sus datos personales:</p>

                <h3 class="text-xl font-bold mt-6 mb-2">1. Datos que recopilamos</h3>
                <p>Recopilamos su nombre, correo electrónico, y datos de contacto de la congregación con el único fin de proveer el servicio de software de gestión, crear su cuenta y procesar su suscripción.</p>

                <h3 class="text-xl font-bold mt-6 mb-2">2. Uso de la Información</h3>
                <p>Sus datos no serán vendidos, alquilados ni compartidos con terceros para fines publicitarios. Los datos almacenados por las iglesias (información de sus miembros) son propiedad de la iglesia respectiva, actuando <strong>Administrarme.com</strong> únicamente como proveedor de infraestructura de almacenamiento en la nube.</p>

                <h3 class="text-xl font-bold mt-6 mb-2">3. Derechos ARCO</h3>
                <p>Usted tiene derecho a conocer qué datos personales tenemos de usted, para qué los utilizamos y las condiciones del uso que les damos (Acceso). Asimismo, es su derecho solicitar la corrección de su información personal (Rectificación); que la eliminemos de nuestros registros (Cancelación); así como oponerse al uso de sus datos para fines específicos (Oposición). Para ejercer estos derechos, puede contactarnos a soporte@administrarme.com.</p>

                <h3 class="text-xl font-bold mt-6 mb-2">4. Seguridad</h3>
                <p>Implementamos medidas de seguridad técnicas (como encriptación de contraseñas y certificados SSL) para proteger su información contra acceso no autorizado.</p>

                <div class="mt-10 pt-6 border-t border-gray-200 dark:border-gray-700 text-center">
                    <a href="{{ url('/') }}" class="text-indigo-600 hover:text-indigo-500 font-bold">← Volver al inicio</a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>