<x-guest-layout>
    <div class="pt-4 bg-gray-100 dark:bg-gray-900">
        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
            <div class="w-full sm:max-w-4xl mt-6 p-8 bg-white dark:bg-gray-800 shadow-xl overflow-hidden sm:rounded-lg prose dark:prose-invert">
                
                <h1 class="text-3xl font-bold mb-6 text-indigo-600 dark:text-indigo-400">Aviso de Privacidad</h1>
                <p class="text-sm text-gray-500 mb-8">Última actualización: {{ date('d/m/Y') }}</p>

                <section>
                    <h3 class="text-xl font-bold mt-6 mb-2">1. Identidad y Domicilio del Responsable</h3>
                    <p>
                        En cumplimiento con la <strong>Ley Federal de Protección de Datos Personales en Posesión de los Particulares</strong>, <strong>Representaciones y comunicaciones Crisab, S.A.S. de C.V.</strong> (RFC: RCC1810197I7), responsable de la plataforma <strong>AdministrarMe.com</strong>, con domicilio en Calle 32 Pte Mza 69 lote 1 Edif C1 Depto 104, Colonia SM 92, C.P. 77516, Cancún, Quintana Roo, México, le informa sobre el tratamiento de sus datos personales.
                    </p>
                </section>

                <section>
                    <h3 class="text-xl font-bold mt-6 mb-2">2. Datos que recopilamos</h3>
                    <p>Recopilamos los siguientes datos para proveer el servicio de gestión e infraestructura:</p>
                    <ul>
                        <li><strong>Identificación:</strong> Nombre(s), apellidos, fecha de nacimiento, estado civil, nacionalidad, CURP, teléfono y correo electrónico.</li>
                        <li><strong>Documentación:</strong> Fotografía de perfil e imágenes de identificación oficial para el expediente digital.</li>
                    </ul>
                    <p class="text-indigo-600 dark:text-indigo-400 font-bold">Datos Personales Sensibles:</p>
                    <p>Debido a la naturaleza del software, se procesan datos sobre creencias religiosas (estatus de bautismo y roles eclesiásticos). Estos datos son tratados con protocolos de seguridad reforzados.</p>
                </section>

                <section>
                    <h3 class="text-xl font-bold mt-6 mb-2">3. Uso de la Información y Propiedad de los Datos</h3>
                    <p>Sus datos no serán vendidos, alquilados ni compartidos con terceros para fines publicitarios.</p>
                    <p>Es importante señalar que los datos almacenados por las iglesias (información de sus miembros) son propiedad exclusiva de la iglesia respectiva. <strong>AdministrarMe.com</strong> actúa únicamente como proveedor de infraestructura de almacenamiento y procesamiento de datos.</p>
                </section>

                <section>
                    <h3 class="text-xl font-bold mt-6 mb-2">4. Transferencia de Datos</h3>
                    <p>Sus datos personales son compartidos dentro de la plataforma exclusivamente con los administradores autorizados de la congregación a la cual usted solicitó unirse. No se realizan transferencias externas salvo las excepciones legales previstas.</p>
                </section>

                <section>
                    <h3 class="text-xl font-bold mt-6 mb-2">5. Derechos ARCO</h3>
                    <p>
                        Usted tiene derecho al Acceso, Rectificación, Cancelación u Oposición del uso de sus datos. Para ejercer estos derechos, puede contactar a la administración de su congregación local, o bien, dirigirse directamente con nosotros a través de:
                    </p>
                    <ul>
                        <li><strong>Correo:</strong> soporte.mail@crisab.com</li>
                        <li><strong>Teléfono:</strong> +52 1 998 107 0428</li>
                    </ul>
                </section>

                <section>
                    <h3 class="text-xl font-bold mt-6 mb-2">6. Seguridad</h3>
                    <p>
                        Implementamos medidas de seguridad técnicas avanzadas, tales como encriptación de contraseñas, certificados de seguridad SSL y protocolos de aislamiento de bases de datos para proteger su información contra acceso no autorizado o pérdida de integridad.
                    </p>
                </section>

                <div class="mt-10 pt-6 border-t border-gray-200 dark:border-gray-700 text-center">
                    <a href="{{ url('/') }}" class="no-underline text-indigo-600 hover:text-indigo-500 font-bold">← Volver al inicio</a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>