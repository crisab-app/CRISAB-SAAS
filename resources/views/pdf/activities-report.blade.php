<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Actividades</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 10px;
        }
        .church-name {
            font-size: 24px;
            font-weight: bold;
            color: #1e3a8a;
            margin: 0;
        }
        .report-title {
            font-size: 18px;
            color: #4b5563;
            margin-top: 5px;
        }
        .date-generated {
            font-size: 12px;
            color: #6b7280;
            margin-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background-color: #f3f4f6;
            color: #374151;
            font-weight: bold;
            text-align: left;
            padding: 12px;
            border-bottom: 2px solid #d1d5db;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: middle;
        }
        .date-col {
            width: 25%;
            font-weight: bold;
            color: #1f2937;
        }
        .time-col {
            width: 20%;
            color: #4b5563;
        }
        .title-col {
            width: 55%;
        }
        .color-indicator {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 3px; /* Cambia a 50% si prefieres que sea un círculo en vez de cuadrito */
            margin-right: 8px;
            vertical-align: middle;
            border: 1px solid rgba(0,0,0,0.1);
        }
        .empty-state {
            text-align: center;
            padding: 30px;
            color: #6b7280;
            font-style: italic;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 11px;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1 class="church-name">{{ $church->name ?? 'Nuestra Iglesia' }}</h1>
        <div class="report-title">Próximas Actividades (Agenda 60 días)</div>
        <div class="date-generated">Generado el: {{ now()->format('d/m/Y h:i A') }}</div>
    </div>

    @if($activities->isEmpty())
        <div class="empty-state">
            No hay actividades programadas para los próximos dos meses.
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th class="date-col">Fecha</th>
                    <th class="time-col">Hora</th>
                    <th class="title-col">Actividad</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activities as $activity)
                    <tr>
                        <td class="date-col">
                            {{ \Carbon\Carbon::parse($activity->start)->translatedFormat('d M, Y') }}
                        </td>
                        <td class="time-col">
                            {{ \Carbon\Carbon::parse($activity->start)->format('h:i A') }}
                        </td>
                        <td class="title-col">
                            <span class="color-indicator" style="background-color: {{ $activity->color ?? '#9ca3af' }};"></span>
                            <strong>{{ $activity->title }}</strong>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="footer">
        Documento generado automáticamente por administrarme.com
    </div>

</body>
</html>