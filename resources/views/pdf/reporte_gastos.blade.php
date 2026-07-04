<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Gastos - {{ $mes }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            font-size: 11px;
            line-height: 1.4;
        }

        .header {
            width: 100%;
            border-bottom: 2px solid #1b5c3a;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .logo {
            font-size: 20px;
            font-weight: bold;
            color: #1b5c3a;
        }

        .title {
            text-align: right;
            font-size: 16px;
            font-weight: bold;
            color: #555;
        }

        .meta-info {
            width: 100%;
            margin-bottom: 20px;
        }

        .meta-info td {
            vertical-align: top;
        }

        .summary-box {
            background-color: #fee2e2;
            border: 1px solid #dc2626;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            width: 300px;
        }

        .summary-title {
            font-weight: bold;
            color: #dc2626;
            margin-bottom: 5px;
            font-size: 12px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th {
            background-color: #1b5c3a;
            color: white;
            text-align: left;
            padding: 6px 8px;
            font-weight: bold;
        }

        .table td {
            border-bottom: 1px solid #ddd;
            padding: 6px 8px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 8px;
            color: #777;
            border-top: 1px solid #eee;
            padding-top: 5px;
        }
    </style>
</head>

<body>
    <div class="header">
        <table style="width: 100%;">
            <tr>
                <td class="logo">Clínica Dental Miradent</td>
                <td class="title">Reporte de Gastos y Egresos</td>
            </tr>
        </table>
    </div>

    <table class="meta-info">
        <tr>
            <td style="width: 50%;">
                <strong>Período:</strong> {{ $mes }}<br>
                @if($categoria)<strong>Categoría:</strong> {{ $categoria }}<br>@endif
                @if($search)<strong>Búsqueda:</strong> "{{ $search }}"<br>@endif
            </td>
            <td style="width: 50%; text-align: right;">
                @if($doctora?->user?->name)<strong>Doctora:</strong> {{ $doctora->user->name }}<br>@endif
                @if($doctora?->especialidad)<strong>Especialidad:</strong> {{ $doctora->especialidad }}<br>@endif
                @if($doctora?->cop_formatted)<strong>COP:</strong> {{ $doctora->cop_formatted }}<br>@endif
                <strong>Fecha Emisión:</strong> {{ date('d/m/Y H:i') }}
            </td>
        </tr>
    </table>

    <div class="summary-box">
        <div class="summary-title">Total Egresos del Mes</div>
        <div style="font-size: 18px; font-weight: bold; color: #dc2626;">
            S/. {{ number_format($totalMes, 2) }}
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th style="width: 12%;">Fecha</th>
                <th style="width: 35%;">Concepto</th>
                <th style="width: 18%;">Categoría</th>
                <th style="width: 15%;">Método Pago</th>
                <th style="width: 10%;">Comprobante</th>
                <th class="text-right" style="width: 10%;">Monto</th>
            </tr>
        </thead>
        <tbody>
            @forelse($gastos as $gasto)
            <tr>
                <td>{{ \Carbon\Carbon::parse($gasto->fecha_gasto)->format('d/m/Y') }}</td>
                <td>
                    <strong>{{ $gasto->concepto }}</strong>
                    @if($gasto->descripcion)
                    <br><span style="color: #666; font-size: 10px;">{{ $gasto->descripcion }}</span>
                    @endif
                </td>
                <td>{{ $gasto->categoria }}</td>
                <td>{{ ucfirst($gasto->metodo_pago) }}</td>
                <td>{{ $gasto->comprobante ?? '—' }}</td>
                <td class="text-right" style="font-weight: bold; color: #dc2626;">
                    S/. {{ number_format($gasto->monto, 2) }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center" style="padding: 20px; color: #777;">
                    No se registraron gastos en este período.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Clínica Dental Miradent · Jr. Unión 637, Miramar Alto, Chimbote · Reporte generado automáticamente
    </div>
</body>

</html>
