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

class AxiosMvcIntegrationTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Doctora $doctora;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'name' => 'Dra. Ana Miranda',
            'email' => 'miradentdentalclinic@gmail.com',
            'password' => Hash::make('Miradent2026'),
            'role' => 'doctora',
        ]);

        $this->doctora = Doctora::create([
            'user_id' => $this->user->id,
            'especialidad' => 'Odontóloga',
            'COP' => '50039',
            'telefono' => '987654321',
        ]);
    }

    public function test_authenticated_patient_crud_returns_json_for_axios(): void
    {
        $response = $this->actingAs($this->user)
            ->postJson('/admin/pacientes', [
                'nombre' => 'Lucia',
                'apellido' => 'Ramos',
                'dni' => '76543210',
                'telefono' => '999222111',
            ]);

        $response->assertCreated()
            ->assertJsonPath('paciente.nombre_completo', 'Lucia Ramos');

        $this->actingAs($this->user)
            ->getJson('/admin/pacientes/buscar?search=Lucia')
            ->assertOk()
            ->assertJsonPath('total', 1)
            ->assertJsonPath('data.0.dni', '76543210');
    }

    public function test_service_with_related_appointments_cannot_be_deleted_by_axios(): void
    {
        $paciente = Paciente::create([
            'nombre' => 'Mario',
            'apellido' => 'Lopez',
            'dni' => '12312312',
        ]);

        $servicio = Servicio::create([
            'nombre' => 'Profilaxis',
            'precio' => 120,
            'duracion_minutos' => 30,
            'categoria' => 'Prevención',
            'activo' => true,
        ]);

        Cita::create([
            'paciente_id' => $paciente->id,
            'doctora_id' => $this->doctora->id,
            'servicio_id' => $servicio->id,
            'fecha_hora' => now(),
            'estado' => 'pendiente',
        ]);

        $this->actingAs($this->user)
            ->deleteJson('/admin/servicios/' . $servicio->id)
            ->assertUnprocessable()
            ->assertJsonPath('message', 'No se puede eliminar el tratamiento porque tiene citas o pagos asociados.');
    }

    public function test_public_services_endpoint_keeps_landing_data_available_as_json(): void
    {
        Servicio::create([
            'nombre' => 'Blanqueamiento',
            'descripcion' => 'Tratamiento estético dental',
            'precio' => 350,
            'duracion_minutos' => 60,
            'categoria' => 'Estética',
            'activo' => true,
        ]);

        $this->getJson('/servicios?buscar=Blanqueamiento')
            ->assertOk()
            ->assertJsonPath('meta.total', 1)
            ->assertJsonPath('data.0.nombre', 'Blanqueamiento');
    }
}
