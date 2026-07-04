<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ficha Clínica - {{ $paciente->nombre }} {{ $paciente->apellido }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; font-size: 11px; line-height: 1.4; }
        .header { width: 100%; border-bottom: 2px solid #1b5c3a; padding-bottom: 10px; margin-bottom: 20px; }
        .logo { font-size: 20px; font-weight: bold; color: #1b5c3a; }
        .title { text-align: right; font-size: 16px; font-weight: bold; color: #555; }
        .section-title { font-size: 13px; font-weight: bold; color: #1b5c3a; border-bottom: 1px solid #1b5c3a; padding-bottom: 4px; margin-top: 20px; margin-bottom: 10px; text-transform: uppercase; }
        .info-table { width: 100%; margin-bottom: 15px; }
        .info-table td { padding: 4px 6px; vertical-align: top; }
        .info-table td.label { font-weight: bold; width: 20%; color: #555; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th { background-color: #1b5c3a; color: white; text-align: left; padding: 6px 8px; font-weight: bold; }
        .table td { border-bottom: 1px solid #ddd; padding: 6px 8px; vertical-align: top; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 8px; color: #777; border-top: 1px solid #eee; padding-top: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <table style="width: 100%;">
            <tr>
                <td class="logo">Clínica Dental Miradent</td>
                <td class="title">Ficha Clínica Paciente</td>
            </tr>
        </table>
    </div>

    <div class="section-title">Datos Personales</div>
    <table class="info-table">
        <tr>
            <td class="label">Paciente:</td>
            <td>{{ $paciente->nombre }} {{ $paciente->apellido }}</td>
            <td class="label">DNI:</td>
            <td>{{ $paciente->dni }}</td>
        </tr>
        <tr>
            <td class="label">Teléfono:</td>
            <td>{{ $paciente->telefono ?? '—' }}</td>
            <td class="label">Email:</td>
            <td>{{ $paciente->email ?? '—' }}</td>
        </tr>
        <tr>
            <td class="label">F. Nacimiento:</td>
            <td>{{ $paciente->fecha_nacimiento ? $paciente->fecha_nacimiento->format('d/m/Y') : '—' }}</td>
            <td class="label">Género:</td>
            <td>{{ ucfirst($paciente->genero ?? '—') }}</td>
        </tr>
        <tr>
            <td class="label">Tipo Sangre:</td>
            <td>{{ $paciente->tipo_sangre ?? '—' }}</td>
            <td class="label">Dirección:</td>
            <td>{{ $paciente->direccion ?? '—' }}</td>
        </tr>
    </table>

    <div class="section-title">Antecedentes Médicos</div>
    <table class="info-table">
        <tr>
            <td class="label">Alergias:</td>
            <td>{{ $paciente->alergias ?? 'Ninguna registrada' }}</td>
        </tr>
        <tr>
            <td class="label">Medicamentos:</td>
            <td>{{ $paciente->medicamentos_habituales ?? 'Ninguno registrado' }}</td>
        </tr>
        <tr>
            <td class="label">Historial Med.:</td>
            <td>{{ $paciente->antecedentes_medicos ?? 'Ninguno registrado' }}</td>
        </tr>
    </table>

    <div class="section-title">Historial de Citas y Tratamientos</div>
    <table class="table">
        <thead>
            <tr>
                <th style="width: 15%;">Fecha/Hora</th>
                <th style="width: 20%;">Tratamiento</th>
                <th style="width: 20%;">Doctora</th>
                <th style="width: 30%;">Diagnóstico/Notas</th>
                <th style="width: 15%;">Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($citas as $cita)
                <tr>
                    <td>{{ $cita->fecha_hora ? $cita->fecha_hora->format('d/m/Y H:i') : '—' }}</td>
                    <td>{{ $cita->servicio?->nombre ?? 'Tratamiento' }}</td>
                    <td>{{ $cita->doctora?->user?->name ?? '—' }}</td>
                    <td>
                        @if($cita->diagnostico)<strong>Diag:</strong> {{ $cita->diagnostico }}<br>@endif
                        @if($cita->notas_tratamiento)<strong>Notas:</strong> {{ $cita->notas_tratamiento }}@endif
                        @if(!$cita->diagnostico && !$cita->notas_tratamiento)—@endif
                    </td>
                    <td>{{ ucfirst($cita->estado) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center" style="padding: 15px; color: #777;">
                        No hay citas registradas para este paciente.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">Historial de Pagos</div>
    <table class="table">
        <thead>
            <tr>
                <th style="width: 20%;">Fecha</th>
                <th style="width: 35%;">Método de Pago</th>
                <th style="width: 25%;">Estado</th>
                <th class="text-right" style="width: 20%;">Monto</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pagos as $pago)
                <tr>
                    <td>{{ $pago->fecha_pago ? $pago->fecha_pago->format('d/m/Y') : '—' }}</td>
                    <td>{{ ucfirst($pago->metodo_pago) }} @if($pago->notas) ({{ $pago->notas }}) @endif</td>
                    <td>{{ ucfirst($pago->estado) }}</td>
                    <td class="text-right" style="font-weight: bold; color: #175d3d;">
                        S/. {{ number_format($pago->monto, 2) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center" style="padding: 15px; color: #777;">
                        No hay pagos registrados para este paciente.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Clínica Dental Miradent · Jr. Unión 637, Miramar Alto, Chimbote · Ficha clínica confidencial
    </div>
</body>
</html>
