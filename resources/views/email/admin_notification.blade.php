<div style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">
    <h2 style="color: #eab308;">🔔 ¡Nueva alta en el sistema!</h2>
    <p>Se acaba de registrar una nueva iglesia en la plataforma. Aquí están los detalles:</p>
    <ul>
        <li><strong>Ministerio:</strong> {{ $churchName }}</li>
        <li><strong>Administrador/Pastor:</strong> {{ $user->name }}</li>
        <li><strong>Teléfono:</strong> {{ $user->phone }}</li>
        <li><strong>Correo:</strong> {{ $user->email ?? 'No proporcionado' }}</li>
    </ul>
    <p>Puedes revisar más detalles desde tu panel de SuperAdmin.</p>
</div>