<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actividad - {{ $event->title }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; font-size: 14px; }
        .header { text-align: center; border-bottom: 2px solid #4f46e5; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; color: #1f2937; font-size: 24px; }
        .header p { margin: 5px 0 0 0; color: #6b7280; font-size: 14px; }
        
        .section-title { background-color: #f3f4f6; padding: 8px; font-weight: bold; border-left: 4px solid #4f46e5; margin-top: 20px; margin-bottom: 10px; }
        
        table { w-full; border-collapse: collapse; margin-bottom: 20px; width: 100%; }
        th, td { border: 1px solid #d1d5db; padding: 10px; text-align: left; }
        th { background-color: #e5e7eb; font-weight: bold; }
        
        .content-box { border: 1px solid #d1d5db; padding: 15px; margin-bottom: 20px; background-color: #fafafa; }
    </style>
</head>
<body>

    <div class="header">
        <h1>{{ $event->title }}</h1>
        <p>
            <strong>Inicio:</strong> {{ \Carbon\Carbon::parse($event->start_time)->format('d/m/Y h:i A') }} <br>
            <strong>Fin:</strong> {{ \Carbon\Carbon::parse($event->end_time)->format('d/m/Y h:i A') }}
        </p>
    </div>

    <div class="section-title">📋 Orden de Servicio</div>
    
    @if($event->items && $event->items->count() > 0)
        <table>
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="30%">Participación</th>
                    <th width="30%">Encargado</th>
                    <th width="35%">Detalles / Himno</th>
                </tr>
            </thead>
            <tbody>
                @foreach($event->items as $item)
                    <tr>
                        <td style="text-align: center; font-weight: bold;">{{ $loop->iteration }}</td>
                        <td>{{ strtoupper($item->name) }}</td>
                        <td>
                            @php
                                $user = \App\Models\User::find($item->user_id);
                            @endphp
                            {{ $user ? $user->name : 'Sin asignar' }}
                        </td>
                        <td>{{ $item->details ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay orden de servicio registrado.</p>
    @endif

    @if($event->bible_reading)
        <div class="section-title">📖 Lectura Bíblica Principal</div>
        <div class="content-box">
            {!! $event->bible_reading !!}
        </div>
    @endif

    <div class="section-title">🎤 Bosquejo de Predicación</div>
    <p><strong>Tema:</strong> {{ $event->preaching_topic ?? 'Sin título definido' }}</p>
    
    @if($event->sermon_notes)
        <div class="content-box">
            {!! $event->sermon_notes !!}
        </div>
    @else
        <p>No hay apuntes del bosquejo.</p>
    @endif

</body>
</html>