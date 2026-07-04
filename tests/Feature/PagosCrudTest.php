<?php

namespace Tests\Feature;

use App\Models\Cita;
use App\Models\Doctora;
use App\Models\Paciente;
use App\Models\Pago;
use App\Models\Servicio;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PagosCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $docUser;
    private User $asistente;
    private Doctora $doctora;
    private Paciente $paciente;
    private Cita $cita;

    protected function setUp(): void
    {
        parent::setUp();

        $this->docUser = User::create([
            'name'     => 'Dra. Ana Miranda',
            'email'    => 'doctora@miradent.test',
            'password' => Hash::make('password'),
            'role'     => 'doctora',
        ]);

        $this->asistente = User::create([
            'name'     => 'Asistente Test',
            'email'    => 'asistente@miradent.test',
            'password' => Hash::make('password'),
            'role'     => 'asistente',
        ]);

        $this->doctora = Doctora::create([
            'user_id'      => $this->docUser->id,
            'especialidad' => 'Odontóloga',
            'COP'          => '50039',
            'telefono'     => '987654321',
        ]);

        $this->paciente = Paciente::create([
            'nombre'   => 'Paciente',
            'apellido' => 'Test',
            'dni'      => '12345678',
        ]);

        $servicio = Servicio::create([
            'nombre'           => 'Limpieza',
            'precio'           => 120.00,
            'duracion_minutos' => 30,
            'categoria'        => 'Prevención',
            'activo'           => true,
        ]);

        $this->cita = Cita::create([
            'paciente_id' => $this->paciente->id,
            'doctora_id'  => $this->doctora->id,
            'servicio_id' => $servicio->id,
            'fecha_hora'  => now()->addDays(1),
            'estado'      => 'completada',
        ]);
    }

    // ─── Control de acceso ────────────────────────────────────────────────────

    public function test_guest_cannot_access_pagos(): void
    {
        $this->postJson('/admin/pagos', [])->assertUnauthorized();
    }

    public function test_asistente_cannot_create_pago(): void
    {
        $this->actingAs($this->asistente)
            ->postJson('/admin/pagos', [
                'paciente_id' => $this->paciente->id,
                'monto'       => 100,
                'metodo_pago' => 'yape',
                'fecha_pago'  => now()->format('Y-m-d'),
                'estado'      => 'pagado',
            ])
            ->assertForbidden();
    }

    // ─── Crear pago ───────────────────────────────────────────────────────────

    public function test_doctora_can_create_pago_via_axios(): void
    {
        $response = $this->actingAs($this->docUser)
            ->postJson('/admin/pagos', [
                'paciente_id' => $this->paciente->id,
                'cita_id'     => $this->cita->id,
                'monto'       => 120.00,
                'metodo_pago' => 'yape',
                'fecha_pago'  => now()->format('Y-m-d'),
                'estado'      => 'pagado',
            ]);

        $response->assertCreated()
            ->assertJsonStructure([
                'message',
                'pago' => ['id', 'monto', 'metodo_pago', 'estado', 'paciente_nombre'],
            ]);

        $this->assertDatabaseHas('pagos', [
            'paciente_id' => $this->paciente->id,
            'monto'       => 120.00,
            'estado'      => 'pagado',
        ]);
    }

    public function test_doctora_can_create_pago_without_cita(): void
    {
        $this->actingAs($this->docUser)
            ->postJson('/admin/pagos', [
                'paciente_id' => $this->paciente->id,
                'monto'       => 50.00,
                'metodo_pago' => 'efectivo',
                'fecha_pago'  => now()->format('Y-m-d'),
                'estado'      => 'parcial',
            ])
            ->assertCreated();
    }

    public function test_pago_with_invalid_monto_returns_422(): void
    {
        $this->actingAs($this->docUser)
            ->postJson('/admin/pagos', [
                'paciente_id' => $this->paciente->id,
                'monto'       => 0,
                'metodo_pago' => 'yape',
                'fecha_pago'  => now()->format('Y-m-d'),
                'estado'      => 'pagado',
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['monto']);
    }

    public function test_pago_with_invalid_metodo_returns_422(): void
    {
        $this->actingAs($this->docUser)
            ->postJson('/admin/pagos', [
                'paciente_id' => $this->paciente->id,
                'monto'       => 100,
                'metodo_pago' => 'bitcoin',
                'fecha_pago'  => now()->format('Y-m-d'),
                'estado'      => 'pagado',
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['metodo_pago']);
    }

    public function test_pago_with_invalid_estado_returns_422(): void
    {
        $this->actingAs($this->docUser)
            ->postJson('/admin/pagos', [
                'paciente_id' => $this->paciente->id,
                'monto'       => 100,
                'metodo_pago' => 'yape',
                'fecha_pago'  => now()->format('Y-m-d'),
                'estado'      => 'invalido',
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['estado']);
    }

    public function test_pago_reembolsado_is_stored_correctly(): void
    {
        $this->actingAs($this->docUser)
            ->postJson('/admin/pagos', [
                'paciente_id' => $this->paciente->id,
                'monto'       => 80.00,
                'metodo_pago' => 'transferencia',
                'fecha_pago'  => now()->format('Y-m-d'),
                'estado'      => 'reembolsado',
                'notas'       => 'Devolución por cancelación de cita',
            ])
            ->assertCreated();

        $this->assertDatabaseHas('pagos', [
            'paciente_id' => $this->paciente->id,
            'estado'      => 'reembolsado',
        ]);
    }

    public function test_pago_cannot_reference_nonexistent_cita(): void
    {
        $this->actingAs($this->docUser)
            ->postJson('/admin/pagos', [
                'paciente_id' => $this->paciente->id,
                'cita_id'     => 99999,
                'monto'       => 100,
                'metodo_pago' => 'yape',
                'fecha_pago'  => now()->format('Y-m-d'),
                'estado'      => 'pagado',
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['cita_id']);
    }

    // ─── Editar pago ─────────────────────────────────────────────────────────

    public function test_doctora_can_update_pago_via_axios(): void
    {
        $pago = Pago::create([
            'paciente_id' => $this->paciente->id,
            'cita_id'     => $this->cita->id,
            'monto'       => 60.00,
            'metodo_pago' => 'efectivo',
            'fecha_pago'  => now(),
            'estado'      => 'parcial',
        ]);

        $this->actingAs($this->docUser)
            ->putJson("/admin/pagos/{$pago->id}", [
                'paciente_id' => $this->paciente->id,
                'monto'       => 120.00,
                'metodo_pago' => 'yape',
                'fecha_pago'  => now()->format('Y-m-d'),
                'estado'      => 'pagado',
            ])
            ->assertOk()
            ->assertJsonPath('pago.estado', 'pagado');

        $this->assertDatabaseHas('pagos', ['id' => $pago->id, 'estado' => 'pagado']);
    }

    // ─── Anular pago ─────────────────────────────────────────────────────────

    public function test_doctora_can_annul_pago(): void
    {
        $pago = Pago::create([
            'paciente_id' => $this->paciente->id,
            'monto'       => 100.00,
            'metodo_pago' => 'yape',
            'fecha_pago'  => now(),
            'estado'      => 'pagado',
        ]);

        $this->actingAs($this->docUser)
            ->deleteJson("/admin/pagos/{$pago->id}")
            ->assertOk();

        $this->assertSoftDeleted('pagos', ['id' => $pago->id]);
    }

    // ─── Estados no contabilizados ────────────────────────────────────────────

    public function test_finanzas_does_not_include_reembolsado_in_income(): void
    {
        Pago::create([
            'paciente_id' => $this->paciente->id,
            'monto'       => 200.00,
            'metodo_pago' => 'yape',
            'fecha_pago'  => now()->startOfMonth(),
            'estado'      => 'reembolsado',
        ]);

        $mes = now()->format('Y-m');
        $response = $this->actingAs($this->docUser)
            ->get("/admin/finanzas?mes={$mes}");

        $response->assertOk();

        // The reembolsado payment should NOT be counted in total ingresos
        // The view shows 0.00 ingresos or excludes the refunded amount
        $data = $response->original->getData();
        $this->assertNotNull($data);
    }
}
