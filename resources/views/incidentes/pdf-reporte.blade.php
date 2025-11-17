<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Incidentes</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 10pt;
            color: #1D1616;
            line-height: 1.4;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 3px solid #8E1616;
        }

        .header h1 {
            color: #8E1616;
            font-size: 22pt;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .header p {
            color: #666;
            font-size: 10pt;
        }

        .info-box {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 20px;
        }

        .info-box p {
            margin-bottom: 5px;
        }

        .info-box strong {
            color: #8E1616;
        }

        .stats-container {
            display: table;
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .stat-box {
            display: table-cell;
            width: 20%;
            text-align: center;
            padding: 15px 5px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }

        .stat-box .number {
            font-size: 24pt;
            font-weight: bold;
            color: #8E1616;
            display: block;
            margin-bottom: 5px;
        }

        .stat-box .label {
            font-size: 9pt;
            color: #666;
            text-transform: uppercase;
        }

        .priority-stats {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }

        .priority-stats h3 {
            color: #8E1616;
            font-size: 12pt;
            margin-bottom: 10px;
            border-bottom: 2px solid #8E1616;
            padding-bottom: 5px;
        }

        .priority-grid {
            display: table;
            width: 100%;
            margin-top: 10px;
        }

        .priority-item {
            display: table-cell;
            width: 25%;
            text-align: center;
            padding: 8px;
        }

        .priority-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 9pt;
        }

        .priority-urgente { background-color: #fee2e2; color: #991b1b; }
        .priority-alta { background-color: #fed7aa; color: #9a3412; }
        .priority-media { background-color: #fef3c7; color: #92400e; }
        .priority-baja { background-color: #d1fae5; color: #065f46; }

        .table-container {
            margin-top: 20px;
        }

        .table-title {
            color: #8E1616;
            font-size: 14pt;
            margin-bottom: 10px;
            font-weight: bold;
            border-bottom: 2px solid #8E1616;
            padding-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 8pt;
        }

        thead {
            background-color: #8E1616;
            color: white;
        }

        th {
            padding: 8px 5px;
            text-align: left;
            font-weight: bold;
            font-size: 8pt;
        }

        td {
            padding: 6px 5px;
            border-bottom: 1px solid #ddd;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #f0f0f0;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 7pt;
            font-weight: bold;
            white-space: nowrap;
        }

        .estado-pendiente { background-color: #fef3c7; color: #92400e; }
        .estado-asignado { background-color: #dbeafe; color: #1e40af; }
        .estado-en-proceso { background-color: #e0e7ff; color: #3730a3; }
        .estado-resuelto { background-color: #d1fae5; color: #065f46; }
        .estado-cerrado { background-color: #e5e7eb; color: #374151; }
        .estado-cancelado { background-color: #fee2e2; color: #991b1b; }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8pt;
            color: #666;
            padding: 10px 0;
            border-top: 1px solid #ddd;
        }

        .page-break {
            page-break-after: always;
        }

        .codigo {
            font-family: 'Courier New', monospace;
            font-weight: bold;
            color: #8E1616;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #999;
            font-style: italic;
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <div class="header">
        <h1>REPORTE DE INCIDENTES</h1>
        <p>Sistema de Gestión de Incidentes - FESC</p>
    </div>

    <!-- INFO BOX -->
    <div class="info-box">
        <p><strong>Generado por:</strong> {{ $user->name }}</p>
        <p><strong>Rol:</strong> {{ ucfirst($user->getRoleNames()->first()) }}</p>
        <p><strong>Fecha:</strong> {{ now()->format('d/m/Y H:i:s') }}</p>
        <p><strong>Total de incidentes:</strong> {{ $estadisticas['total'] }}</p>
    </div>

    <!-- ESTADÍSTICAS GENERALES -->
    <div class="stats-container">
        <div class="stat-box">
            <span class="number">{{ $estadisticas['pendientes'] }}</span>
            <span class="label">Pendientes</span>
        </div>
        <div class="stat-box">
            <span class="number">{{ $estadisticas['en_proceso'] }}</span>
            <span class="label">En Proceso</span>
        </div>
        <div class="stat-box">
            <span class="number">{{ $estadisticas['resueltos'] }}</span>
            <span class="label">Resueltos</span>
        </div>
        <div class="stat-box">
            <span class="number">{{ $estadisticas['cerrados'] }}</span>
            <span class="label">Cerrados</span>
        </div>
        <div class="stat-box">
            <span class="number">{{ $estadisticas['total'] }}</span>
            <span class="label">Total</span>
        </div>
    </div>

    <!-- ESTADÍSTICAS POR PRIORIDAD -->
    <div class="priority-stats">
        <h3>Incidentes por Prioridad</h3>
        <div class="priority-grid">
            <div class="priority-item">
                <span class="priority-badge priority-urgente">
                    Urgente: {{ $estadisticas['por_prioridad']['urgente'] }}
                </span>
            </div>
            <div class="priority-item">
                <span class="priority-badge priority-alta">
                    Alta: {{ $estadisticas['por_prioridad']['alta'] }}
                </span>
            </div>
            <div class="priority-item">
                <span class="priority-badge priority-media">
                    Media: {{ $estadisticas['por_prioridad']['media'] }}
                </span>
            </div>
            <div class="priority-item">
                <span class="priority-badge priority-baja">
                    Baja: {{ $estadisticas['por_prioridad']['baja'] }}
                </span>
            </div>
        </div>
    </div>

    <!-- TABLA DE INCIDENTES -->
    <div class="table-container">
        <h2 class="table-title">Listado de Incidentes</h2>

        @if($incidentes->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th style="width: 8%;">Código</th>
                        <th style="width: 22%;">Título</th>
                        <th style="width: 13%;">Categoría</th>
                        <th style="width: 12%;">Solicitante</th>
                        <th style="width: 8%;">Salón</th>
                        <th style="width: 10%;">Prioridad</th>
                        <th style="width: 12%;">Estado</th>
                        <th style="width: 15%;">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($incidentes as $incidente)
                        <tr>
                            <td class="codigo">{{ $incidente->codigo }}</td>
                            <td>{{ Str::limit($incidente->titulo, 40) }}</td>
                            <td>{{ $incidente->categoria->nombre }}</td>
                            <td>{{ Str::limit($incidente->solicitante->name, 20) }}</td>
                            <td>{{ $incidente->salon?->codigo ?? 'N/A' }}</td>
                            <td>
                                <span class="badge priority-{{ $incidente->prioridad }}">
                                    {{ ucfirst($incidente->prioridad) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge estado-{{ str_replace('_', '-', $incidente->estado) }}">
                                    {{ ucfirst(str_replace('_', ' ', $incidente->estado)) }}
                                </span>
                            </td>
                            <td>{{ $incidente->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data">
                No hay incidentes registrados en el sistema.
            </div>
        @endif
    </div>

    <!-- FOOTER -->
    <div class="footer">
        <p>Reporte generado automáticamente por el Sistema de Gestión de Incidentes FESC</p>
    </div>
</body>
</html>
