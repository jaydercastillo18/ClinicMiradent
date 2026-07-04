<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Caja y Finanzas - {{ $mes }}</title>
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
            background-color: #f2faf6;
            border: 1px solid #1b5c3a;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .summary-title {
            font-weight: bold;
            color: #1b5c3a;
            margin-bottom: 5px;
            font-size: 12px;
        }

        .summary-table {
            width: 100%;
        }

        .summary-table td {
            padding: 4px 0;
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

        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .badge-ingreso {
            background-color: #d4f5e4;
            color: #175d3d;
        }

        .badge-egreso {
            background-color: #fee2e2;
            color: #dc2626;
        }

        .font-bold {
            font-weight: bold;
        }

        .text-success {
            color: #175d3d;
        }

        .text-danger {
            color: #dc2626;
        }

        .balance-neto {
            font-weight: bold;
            padding-top: 6px;
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
                <td class="title">Reporte de Caja y Finanzas</td>
            </tr>
        </table>
    </div>

    <table class="meta-info">
        <tr>
            <td style="width: 50%;">
                <strong>Período:</strong> {{ $mes }}<br>
                @if($tipo)<strong>Tipo:</strong> {{ ucfirst($tipo) }}<br>@endif
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
        <div class="summary-title">Resumen de Caja</div>
        <table class="summary-table">
            <tr>
                <td>Total Ingresos:</td>
                <td class="text-right font-bold text-success">S/. {{ number_format($totalIngresos, 2) }}</td>
            </tr>
            <tr>
                <td>Total Egresos:</td>
                <td class="text-right font-bold text-danger">S/. {{ number_format($totalEgresos, 2) }}</td>
            </tr>
            <tr style="border-top: 1px solid #ccc;">
                <td class="balance-neto">Balance Neto:</td>
                <td class="text-right balance-neto {{ $balance >= 0 ? 'text-success' : 'text-danger' }}">
                    S/. {{ number_format($balance, 2) }}
                </td>
            </tr>
        </table>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th style="width: 15%;">Fecha</th>
                <th style="width: 12%;">Tipo</th>
                <th style="width: 35%;">Concepto</th>
                <th style="width: 15%;">Categoría</th>
                <th style="width: 11%;">Método</th>
                <th class="text-right" style="width: 12%;">Monto</th>
            </tr>
        </thead>
        <tbody>
            @forelse($movimientos as $mov)
            <tr>
                <td>{{ \Carbon\Carbon::parse($mov->fecha)->format('d/m/Y') }}</td>
                <td>
                    <span class="badge badge-{{ $mov->tipo }}">
                        {{ $mov->tipo }}
                    </span>
                </td>
                <td>{{ $mov->concepto }}</td>
                <td>{{ $mov->categoria }}</td>
                <td>{{ ucfirst($mov->metodo_pago) }}</td>
                <td class="text-right font-bold {{ $mov->tipo === 'ingreso' ? 'text-success' : 'text-danger' }}">
                    S/. {{ number_format($mov->monto, 2) }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center" style="padding: 20px; color: #777;">
                    No se registraron movimientos en este período.
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
