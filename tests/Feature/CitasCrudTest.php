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

class CitasCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $docUser;
    private User $asistente;
    private Doctora $doctora;
    private Paciente $paciente;
    private Servicio $servicio;

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

        $this->servicio = Servicio::create([
            'nombre'           => 'Limpieza Dental',
            'precio'           => 120.00,
            'duracion_minutos' => 30,
            'categoria'        => 'Prevención',
            'activo'           => true,
        ]);
    }

    // ─── Acceso sin autenticar ───────────────────────────────────────────────

    public function test_guest_cannot_access_citas(): void
    {
        $this->get('/admin/citas')->assertRedirect(route('login'));
        $this->postJson('/admin/citas', [])->assertUnauthorized();
    }

    // ─── Crear cita ──────────────────────────────────────────────────────────

    public function test_doctora_can_create_cita_via_axios(): void
    {
        $response = $this->actingAs($this->docUser)
            ->postJson('/admin/citas', [
                'paciente_id' => $this->paciente->id,
                'doctora_id'  => $this->doctora->id,
                'servicio_id' => $this->servicio->id,
                'fecha_hora'  => now()->addDays(3)->format('Y-m-d H:i:s'),
                'estado'      => 'pendiente',
                'motivo'      => 'Control semestral',
            ]);

        $response->assertCreated()
            ->assertJsonStructure([
                'message',
                'cita' => ['id', 'fecha_hora', 'servicio', 'doctora', 'estado'],
            ]);

        $this->assertDatabaseHas('citas', [
            'paciente_id' => $this->paciente->id,
            'estado'      => 'pendiente',
        ]);
    }

    public function test_asistente_can_create_cita_via_axios(): void
    {
        $response = $this->actingAs($this->asistente)
            ->postJson('/admin/citas', [
                'paciente_id' => $this->paciente->id,
                'doctora_id'  => $this->doctora->id,
                'servicio_id' => $this->servicio->id,
                'fecha_hora'  => now()->addDays(2)->format('Y-m-d H:i:s'),
                'estado'      => 'confirmada',
            ]);

        $response->assertCreated();
    }

    public function test_create_cita_missing_required_fields_returns_422(): void
    {
        $this->actingAs($this->docUser)
            ->postJson('/admin/citas', ['motivo' => 'Solo motivo'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['paciente_id', 'servicio_id', 'doctora_id', 'fecha_hora', 'estado']);
    }

    // ─── Editar cita ─────────────────────────────────────────────────────────

    public function test_doctora_can_update_cita_via_axios(): void
    {
        $cita = Cita::create([
            'paciente_id' => $this->paciente->id,
            'doctora_id'  => $this->doctora->id,
            'servicio_id' => $this->servicio->id,
            'fecha_hora'  => now()->addDays(1),
            'estado'      => 'pendiente',
        ]);

        $this->actingAs($this->docUser)
            ->putJson("/admin/citas/{$cita->id}", [
                'paciente_id' => $this->paciente->id,
                'doctora_id'  => $this->doctora->id,
                'servicio_id' => $this->servicio->id,
                'fecha_hora'  => now()->addDays(5)->format('Y-m-d H:i:s'),
                'estado'      => 'confirmada',
                'diagnostico' => 'Caries leve detectada',
            ])
            ->assertOk()
            ->assertJsonPath('cita.estado', 'confirmada');
    }

    public function test_asistente_can_update_cita_schedule(): void
    {
        $cita = Cita::create([
            'paciente_id' => $this->paciente->id,
            'doctora_id'  => $this->doctora->id,
            'servicio_id' => $this->servicio->id,
            'fecha_hora'  => now()->addDays(1),
            'estado'      => 'pendiente',
        ]);

        $this->actingAs($this->asistente)
            ->putJson("/admin/citas/{$cita->id}", [
                'paciente_id' => $this->paciente->id,
                'doctora_id'  => $this->doctora->id,
                'servicio_id' => $this->servicio->id,
                'fecha_hora'  => now()->addDays(7)->format('Y-m-d H:i:s'),
                'estado'      => 'confirmada',
            ])
            ->assertOk();
    }

    public function test_asistente_cannot_update_diagnostico(): void
    {
        $cita = Cita::create([
            'paciente_id' => $this->paciente->id,
            'doctora_id'  => $this->doctora->id,
            'servicio_id' => $this->servicio->id,
            'fecha_hora'  => now()->addDays(1),
            'estado'      => 'pendiente',
        ]);

        $this->actingAs($this->asistente)
            ->putJson("/admin/citas/{$cita->id}", [
                'paciente_id' => $this->paciente->id,
                'doctora_id'  => $this->doctora->id,
                'servicio_id' => $this->servicio->id,
                'fecha_hora'  => now()->addDays(1)->format('Y-m-d H:i:s'),
                'estado'      => 'confirmada',
                'diagnostico' => 'Intento de modificar diagnóstico',
            ])
            ->assertForbidden();
    }

    // ─── Cancelar / eliminar cita ─────────────────────────────────────────────

    public function test_doctora_can_cancel_cita_without_pagos(): void
    {
        $cita = Cita::create([
            'paciente_id' => $this->paciente->id,
            'doctora_id'  => $this->doctora->id,
            'servicio_id' => $this->servicio->id,
            'fecha_hora'  => now()->addDays(1),
            'estado'      => 'pendiente',
        ]);

        $this->actingAs($this->docUser)
            ->deleteJson("/admin/citas/{$cita->id}")
            ->assertOk();

        $this->assertSoftDeleted('citas', ['id' => $cita->id]);
    }

    public function test_cannot_cancel_cita_with_pagos(): void
    {
        $cita = Cita::create([
            'paciente_id' => $this->paciente->id,
            'doctora_id'  => $this->doctora->id,
            'servicio_id' => $this->servicio->id,
            'fecha_hora'  => now()->addDays(1),
            'estado'      => 'completada',
        ]);

        Pago::create([
            'paciente_id' => $this->paciente->id,
            'cita_id'     => $cita->id,
            'monto'       => 120.00,
            'metodo_pago' => 'yape',
            'fecha_pago'  => now(),
            'estado'      => 'pagado',
        ]);

        $this->actingAs($this->docUser)
            ->deleteJson("/admin/citas/{$cita->id}")
            ->assertUnprocessable()
            ->assertJsonFragment(['message' => 'No se puede eliminar la cita porque tiene pagos asociados.']);

        $this->assertDatabaseHas('citas', ['id' => $cita->id, 'deleted_at' => null]);
    }

    public function test_asistente_cannot_delete_cita(): void
    {
        $cita = Cita::create([
            'paciente_id' => $this->paciente->id,
            'doctora_id'  => $this->doctora->id,
            'servicio_id' => $this->servicio->id,
            'fecha_hora'  => now()->addDays(1),
            'estado'      => 'pendiente',
        ]);

        $this->actingAs($this->asistente)
            ->deleteJson("/admin/citas/{$cita->id}")
            ->assertForbidden();
    }

    // ─── Tolerancia a relaciones soft-deleted ────────────────────────────────

    public function test_cita_list_does_not_crash_with_soft_deleted_paciente(): void
    {
        Cita::create([
            'paciente_id' => $this->paciente->id,
            'doctora_id'  => $this->doctora->id,
            'servicio_id' => $this->servicio->id,
            'fecha_hora'  => now()->addDays(1),
            'estado'      => 'pendiente',
        ]);

        // Soft-delete the patient (simulate orphaned cita)
        $this->paciente->delete();

        $this->actingAs($this->docUser)
            ->get('/admin/citas')
            ->assertOk()
            ->assertSee('(sin nombre)');
    }

    public function test_cita_list_does_not_crash_with_soft_deleted_servicio(): void
    {
        Cita::create([
            'paciente_id' => $this->paciente->id,
            'doctora_id'  => $this->doctora->id,
            'servicio_id' => $this->servicio->id,
            'fecha_hora'  => now()->addDays(1),
            'estado'      => 'pendiente',
        ]);

        // Soft-delete the service
        $this->servicio->delete();

        $this->actingAs($this->docUser)
            ->get('/admin/citas')
            ->assertOk()
            ->assertSee('(sin tratamiento)');
    }

    // ─── CitaResource y filtros de rol ───────────────────────────────────────

    public function test_cita_resource_excludes_diagnostico_for_asistente(): void
    {
        // Background cita with diagnostico (should not appear in asistente response)
        Cita::create([
            'paciente_id' => $this->paciente->id,
            'doctora_id'  => $this->doctora->id,
            'servicio_id' => $this->servicio->id,
            'fecha_hora'  => now()->addDays(1),
            'estado'      => 'completada',
            'diagnostico' => 'Caries en molar superior',
        ]);

        // Asistente creates a cita → response from CitaResource
        $response = $this->actingAs($this->asistente)
            ->postJson('/admin/citas', [
                'paciente_id' => $this->paciente->id,
                'doctora_id'  => $this->doctora->id,
                'servicio_id' => $this->servicio->id,
                'fecha_hora'  => now()->addDays(10)->format('Y-m-d H:i:s'),
                'estado'      => 'pendiente',
            ]);

        $response->assertCreated();
        $this->assertArrayNotHasKey('diagnostico', $response->json('cita'));
    }

    public function test_doctora_receives_diagnostico_in_cita_resource(): void
    {
        $cita = Cita::create([
            'paciente_id' => $this->paciente->id,
            'doctora_id'  => $this->doctora->id,
            'servicio_id' => $this->servicio->id,
            'fecha_hora'  => now()->addDays(1),
            'estado'      => 'pendiente',
        ]);

        $response = $this->actingAs($this->docUser)
            ->putJson("/admin/citas/{$cita->id}", [
                'paciente_id' => $this->paciente->id,
                'doctora_id'  => $this->doctora->id,
                'servicio_id' => $this->servicio->id,
                'fecha_hora'  => now()->addDays(1)->format('Y-m-d H:i:s'),
                'estado'      => 'completada',
                'diagnostico' => 'Diagnóstico doctora',
            ]);

        $response->assertOk();
        $this->assertArrayHasKey('diagnostico', $response->json('cita'));
    }

    // ─── Calendar API ─────────────────────────────────────────────────────────

    public function test_calendar_api_returns_events(): void
    {
        Cita::create([
            'paciente_id' => $this->paciente->id,
            'doctora_id'  => $this->doctora->id,
            'servicio_id' => $this->servicio->id,
            'fecha_hora'  => now()->addDays(1),
            'estado'      => 'pendiente',
        ]);

        $this->actingAs($this->docUser)
            ->getJson('/admin/citas/api')
            ->assertOk()
            ->assertJsonStructure([['id', 'title', 'start', 'backgroundColor']]);
    }

    public function test_calendar_api_returns_empty_array_when_no_citas(): void
    {
        $this->actingAs($this->docUser)
            ->getJson('/admin/citas/api')
            ->assertOk()
            ->assertExactJson([]);
    }
}
