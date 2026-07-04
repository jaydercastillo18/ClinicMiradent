<?php

namespace Tests\Feature;

use App\Models\Cita;
use App\Models\Doctora;
use App\Models\Paciente;
use App\Models\Servicio;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RolesAccessTest extends TestCase
{
    use RefreshDatabase;

    private User $docUser;
    private User $asistente;
    private Doctora $doctora;

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
        ]);
    }

    // ─── Usuarios no autenticados ─────────────────────────────────────────────

    public function test_unauthenticated_user_cannot_access_dashboard(): void
    {
        $this->get('/admin/dashboard')->assertRedirect(route('login'));
    }

    public function test_unauthenticated_user_cannot_access_any_admin_route(): void
    {
        $adminRoutes = [
            '/admin/pacientes',
            '/admin/citas',
        ];

        foreach ($adminRoutes as $route) {
            $this->get($route)->assertRedirect(route('login'));
        }
    }

    // ─── Asistente: acceso permitido ─────────────────────────────────────────

    public function test_asistente_can_access_dashboard(): void
    {
        $this->actingAs($this->asistente)
            ->get('/admin/dashboard')
            ->assertOk();
    }

    public function test_asistente_can_access_pacientes_index(): void
    {
        $this->actingAs($this->asistente)
            ->get('/admin/pacientes')
            ->assertOk();
    }

    public function test_asistente_can_access_citas_index(): void
    {
        $this->actingAs($this->asistente)
            ->get('/admin/citas')
            ->assertOk();
    }

    // ─── Asistente: acceso denegado (role:doctora) ────────────────────────────

    public function test_asistente_cannot_access_finanzas(): void
    {
        $this->actingAs($this->asistente)
            ->get('/admin/finanzas')
            ->assertForbidden();
    }

    public function test_asistente_cannot_access_auditoria(): void
    {
        $this->actingAs($this->asistente)
            ->get('/admin/auditoria')
            ->assertForbidden();
    }

    public function test_asistente_cannot_access_usuarios(): void
    {
        $this->actingAs($this->asistente)
            ->get('/admin/usuarios')
            ->assertForbidden();
    }

    public function test_asistente_cannot_access_doctora_profile(): void
    {
        $this->actingAs($this->asistente)
            ->get('/admin/doctora')
            ->assertForbidden();
    }

    public function test_asistente_cannot_access_gastos(): void
    {
        $this->actingAs($this->asistente)
            ->get('/admin/gastos')
            ->assertForbidden();
    }

    public function test_asistente_cannot_create_pagos(): void
    {
        $this->actingAs($this->asistente)
            ->postJson('/admin/pagos', [])
            ->assertForbidden();
    }

    // ─── Doctora: acceso completo ─────────────────────────────────────────────

    public function test_doctora_can_access_dashboard(): void
    {
        $this->actingAs($this->docUser)
            ->get('/admin/dashboard')
            ->assertOk();
    }

    public function test_doctora_can_access_pacientes(): void
    {
        $this->actingAs($this->docUser)
            ->get('/admin/pacientes')
            ->assertOk();
    }

    public function test_doctora_can_access_citas(): void
    {
        $this->actingAs($this->docUser)
            ->get('/admin/citas')
            ->assertOk();
    }

    public function test_doctora_can_access_finanzas(): void
    {
        $this->actingAs($this->docUser)
            ->get('/admin/finanzas')
            ->assertOk();
    }

    public function test_doctora_can_access_auditoria(): void
    {
        $this->actingAs($this->docUser)
            ->get('/admin/auditoria')
            ->assertOk();
    }

    public function test_doctora_can_access_usuarios(): void
    {
        $this->actingAs($this->docUser)
            ->get('/admin/usuarios')
            ->assertOk();
    }

    // ─── Autorización a nivel de acción (Gate/Policy) ─────────────────────────

    public function test_asistente_cannot_delete_paciente_returns_403(): void
    {
        $paciente = Paciente::create([
            'nombre'   => 'Protegido',
            'apellido' => 'Test',
            'dni'      => '00000001',
        ]);

        $this->actingAs($this->asistente)
            ->deleteJson("/admin/pacientes/{$paciente->id}")
            ->assertForbidden();
    }

    public function test_asistente_cannot_update_clinical_data_returns_403(): void
    {
        $paciente = Paciente::create([
            'nombre'   => 'Clinico',
            'apellido' => 'Test',
            'dni'      => '00000002',
        ]);

        $this->actingAs($this->asistente)
            ->putJson("/admin/pacientes/{$paciente->id}", [
                'nombre'               => 'Clinico',
                'apellido'             => 'Test',
                'dni'                  => '00000002',
                'antecedentes_medicos' => 'Intento de escritura clínica',
            ])
            ->assertForbidden();
    }

    public function test_asistente_cannot_update_cita_diagnostico_returns_403(): void
    {
        $servicio = Servicio::create([
            'nombre'           => 'Test',
            'precio'           => 100,
            'duracion_minutos' => 30,
            'categoria'        => 'General',
            'activo'           => true,
        ]);

        $paciente = Paciente::create([
            'nombre'   => 'P',
            'apellido' => 'Test',
            'dni'      => '00000003',
        ]);

        $cita = Cita::create([
            'paciente_id' => $paciente->id,
            'doctora_id'  => $this->doctora->id,
            'servicio_id' => $servicio->id,
            'fecha_hora'  => now()->addDays(1),
            'estado'      => 'pendiente',
        ]);

        $this->actingAs($this->asistente)
            ->putJson("/admin/citas/{$cita->id}", [
                'paciente_id' => $paciente->id,
                'doctora_id'  => $this->doctora->id,
                'servicio_id' => $servicio->id,
                'fecha_hora'  => now()->addDays(1)->format('Y-m-d H:i:s'),
                'estado'      => 'confirmada',
                'diagnostico' => 'No autorizado',
            ])
            ->assertForbidden();
    }

    public function test_asistente_cannot_delete_cita_returns_403(): void
    {
        $servicio = Servicio::create([
            'nombre'           => 'Test2',
            'precio'           => 100,
            'duracion_minutos' => 30,
            'categoria'        => 'General',
            'activo'           => true,
        ]);

        $paciente = Paciente::create([
            'nombre'   => 'Q',
            'apellido' => 'Test',
            'dni'      => '00000004',
        ]);

        $cita = Cita::create([
            'paciente_id' => $paciente->id,
            'doctora_id'  => $this->doctora->id,
            'servicio_id' => $servicio->id,
            'fecha_hora'  => now()->addDays(1),
            'estado'      => 'pendiente',
        ]);

        $this->actingAs($this->asistente)
            ->deleteJson("/admin/citas/{$cita->id}")
            ->assertForbidden();
    }

    // ─── Acceso de doctora a datos clínicos ───────────────────────────────────

    public function test_doctora_receives_clinical_fields_in_paciente_resource(): void
    {
        $paciente = Paciente::create([
            'nombre'               => 'Clinico',
            'apellido'             => 'Doctora',
            'dni'                  => '00000010',
            'antecedentes_medicos' => 'Asma',
        ]);

        $this->actingAs($this->docUser)
            ->getJson("/admin/pacientes/{$paciente->id}")
            ->assertOk()
            ->assertJsonPath('paciente.antecedentes_medicos', 'Asma');
    }

    public function test_asistente_does_not_receive_clinical_fields_in_paciente_resource(): void
    {
        $paciente = Paciente::create([
            'nombre'               => 'Clinico',
            'apellido'             => 'Asistente',
            'dni'                  => '00000011',
            'antecedentes_medicos' => 'Asma',
        ]);

        $this->actingAs($this->asistente)
            ->getJson("/admin/pacientes/{$paciente->id}")
            ->assertOk()
            ->assertJsonMissingPath('paciente.antecedentes_medicos');
    }
}
