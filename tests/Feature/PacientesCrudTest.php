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

class PacientesCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $doctora;
    private User $asistente;

    protected function setUp(): void
    {
        parent::setUp();

        $this->doctora = User::create([
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
    }

    // ─── Acceso sin autenticar ───────────────────────────────────────────────

    public function test_guest_cannot_access_pacientes(): void
    {
        $this->get('/admin/pacientes')->assertRedirect(route('login'));
        $this->postJson('/admin/pacientes', [])->assertUnauthorized();
    }

    // ─── Crear paciente ──────────────────────────────────────────────────────

    public function test_doctora_can_create_paciente_via_axios(): void
    {
        $response = $this->actingAs($this->doctora)
            ->postJson('/admin/pacientes', [
                'nombre'   => 'Lucía',
                'apellido' => 'Ramos',
                'dni'      => '76543210',
                'telefono' => '999222111',
            ]);

        $response->assertCreated()
            ->assertJsonPath('paciente.nombre', 'Lucía')
            ->assertJsonPath('paciente.apellido', 'Ramos')
            ->assertJsonPath('paciente.dni', '76543210');

        $this->assertDatabaseHas('pacientes', ['dni' => '76543210']);
    }

    public function test_asistente_can_create_paciente_via_axios(): void
    {
        $response = $this->actingAs($this->asistente)
            ->postJson('/admin/pacientes', [
                'nombre'   => 'Pedro',
                'apellido' => 'García',
                'dni'      => '11223344',
            ]);

        $response->assertCreated();
        $this->assertDatabaseHas('pacientes', ['dni' => '11223344']);
    }

    public function test_duplicate_dni_returns_422(): void
    {
        Paciente::create(['nombre' => 'A', 'apellido' => 'B', 'dni' => '99887766']);

        $this->actingAs($this->doctora)
            ->postJson('/admin/pacientes', [
                'nombre'   => 'Otro',
                'apellido' => 'Nombre',
                'dni'      => '99887766',
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['dni']);
    }

    public function test_create_paciente_missing_required_fields_returns_422(): void
    {
        $this->actingAs($this->doctora)
            ->postJson('/admin/pacientes', ['nombre' => 'Solo Nombre'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['apellido', 'dni']);
    }

    // ─── Editar paciente ─────────────────────────────────────────────────────

    public function test_doctora_can_update_paciente_via_axios(): void
    {
        $paciente = Paciente::create([
            'nombre'   => 'Juan',
            'apellido' => 'Perez',
            'dni'      => '12345678',
            'telefono' => '999000000',
        ]);

        $this->actingAs($this->doctora)
            ->putJson("/admin/pacientes/{$paciente->id}", [
                'nombre'   => 'Juan Editado',
                'apellido' => 'Perez',
                'dni'      => '12345678',
                'telefono' => '999111222',
            ])
            ->assertOk()
            ->assertJsonPath('paciente.nombre', 'Juan Editado');

        $this->assertDatabaseHas('pacientes', ['id' => $paciente->id, 'nombre' => 'Juan Editado']);
    }

    public function test_asistente_can_update_basic_data(): void
    {
        $paciente = Paciente::create([
            'nombre'   => 'Maria',
            'apellido' => 'Lopez',
            'dni'      => '55667788',
        ]);

        $this->actingAs($this->asistente)
            ->putJson("/admin/pacientes/{$paciente->id}", [
                'nombre'   => 'Maria Editada',
                'apellido' => 'Lopez',
                'dni'      => '55667788',
                'telefono' => '987654321',
            ])
            ->assertOk()
            ->assertJsonPath('paciente.nombre', 'Maria Editada');
    }

    public function test_asistente_cannot_update_clinical_data(): void
    {
        $paciente = Paciente::create([
            'nombre'   => 'Carlos',
            'apellido' => 'Ruiz',
            'dni'      => '44556677',
        ]);

        $this->actingAs($this->asistente)
            ->putJson("/admin/pacientes/{$paciente->id}", [
                'nombre'                => 'Carlos',
                'apellido'              => 'Ruiz',
                'dni'                   => '44556677',
                'antecedentes_medicos'  => 'Hipertensión',
            ])
            ->assertForbidden();
    }

    // ─── Eliminar paciente ────────────────────────────────────────────────────

    public function test_doctora_can_delete_paciente_without_relations(): void
    {
        $paciente = Paciente::create([
            'nombre'   => 'Sin',
            'apellido' => 'Relaciones',
            'dni'      => '00000001',
        ]);

        $this->actingAs($this->doctora)
            ->deleteJson("/admin/pacientes/{$paciente->id}")
            ->assertOk();

        $this->assertSoftDeleted('pacientes', ['id' => $paciente->id]);
    }

    public function test_cannot_delete_paciente_with_citas(): void
    {
        $docUser = $this->doctora;
        $doctora = Doctora::create([
            'user_id'      => $docUser->id,
            'especialidad' => 'Odontóloga',
            'COP'          => '50039',
        ]);

        $servicio = Servicio::create([
            'nombre'           => 'Profilaxis',
            'precio'           => 100,
            'duracion_minutos' => 30,
            'categoria'        => 'Prevención',
            'activo'           => true,
        ]);

        $paciente = Paciente::create([
            'nombre'   => 'Con',
            'apellido' => 'Citas',
            'dni'      => '00000002',
        ]);

        Cita::create([
            'paciente_id' => $paciente->id,
            'doctora_id'  => $doctora->id,
            'servicio_id' => $servicio->id,
            'fecha_hora'  => now(),
            'estado'      => 'pendiente',
        ]);

        $this->actingAs($this->doctora)
            ->deleteJson("/admin/pacientes/{$paciente->id}")
            ->assertUnprocessable()
            ->assertJsonFragment(['message' => 'No se puede eliminar el paciente porque tiene citas o pagos asociados.']);

        $this->assertDatabaseHas('pacientes', ['id' => $paciente->id, 'deleted_at' => null]);
    }

    public function test_asistente_cannot_delete_paciente(): void
    {
        $paciente = Paciente::create([
            'nombre'   => 'Protegido',
            'apellido' => 'Test',
            'dni'      => '00000003',
        ]);

        $this->actingAs($this->asistente)
            ->deleteJson("/admin/pacientes/{$paciente->id}")
            ->assertForbidden();
    }

    // ─── Respuesta JSON / Resource ───────────────────────────────────────────

    public function test_create_paciente_response_uses_paciente_resource(): void
    {
        $response = $this->actingAs($this->doctora)
            ->postJson('/admin/pacientes', [
                'nombre'   => 'Resource',
                'apellido' => 'Test',
                'dni'      => '77788899',
                'telefono' => '900111222',
            ]);

        $response->assertCreated()
            ->assertJsonStructure([
                'message',
                'paciente' => ['id', 'nombre', 'apellido', 'dni', 'telefono', 'nombre_completo'],
            ]);
    }

    public function test_asistente_cannot_see_clinical_data_in_paciente_response(): void
    {
        $paciente = Paciente::create([
            'nombre'               => 'Clinico',
            'apellido'             => 'Test',
            'dni'                  => '33344455',
            'antecedentes_medicos' => 'Diabetes',
            'alergias'             => 'Penicilina',
        ]);

        $this->actingAs($this->asistente)
            ->getJson("/admin/pacientes/{$paciente->id}")
            ->assertOk()
            ->assertJsonMissingPath('paciente.antecedentes_medicos')
            ->assertJsonMissingPath('paciente.alergias');
    }

    public function test_doctora_can_see_clinical_data_in_paciente_response(): void
    {
        $paciente = Paciente::create([
            'nombre'               => 'Clinico2',
            'apellido'             => 'Test',
            'dni'                  => '33344466',
            'antecedentes_medicos' => 'Diabetes',
            'alergias'             => 'Aspirina',
        ]);

        $this->actingAs($this->doctora)
            ->getJson("/admin/pacientes/{$paciente->id}")
            ->assertOk()
            ->assertJsonPath('paciente.antecedentes_medicos', 'Diabetes')
            ->assertJsonPath('paciente.alergias', 'Aspirina');
    }

    // ─── Búsqueda ────────────────────────────────────────────────────────────

    public function test_search_pacientes_returns_matching_results(): void
    {
        Paciente::create(['nombre' => 'Beatriz', 'apellido' => 'Torres', 'dni' => '50000001']);
        Paciente::create(['nombre' => 'Otro', 'apellido' => 'Paciente', 'dni' => '50000002']);

        $this->actingAs($this->doctora)
            ->getJson('/admin/pacientes/buscar?search=Beatriz')
            ->assertOk()
            ->assertJsonFragment(['nombre' => 'Beatriz'])
            ->assertJsonMissingExact(['nombre' => 'Otro']);
    }

    public function test_update_does_not_reject_own_dni_on_edit(): void
    {
        $paciente = Paciente::create([
            'nombre'   => 'Mismo',
            'apellido' => 'DNI',
            'dni'      => '12341234',
        ]);

        $this->actingAs($this->doctora)
            ->putJson("/admin/pacientes/{$paciente->id}", [
                'nombre'   => 'Mismo Editado',
                'apellido' => 'DNI',
                'dni'      => '12341234',
            ])
            ->assertOk();
    }
}
