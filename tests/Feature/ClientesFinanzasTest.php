<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Pago;
use App\Models\Gasto;
use App\Models\Paciente;
use App\Models\Doctora;
use App\Models\Cita;
use App\Models\Servicio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Tests\TestCase;

class ClientesFinanzasTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $doctora;

    protected function setUp(): void
    {
        parent::setUp();

        // Create doctor user
        $this->user = User::create([
            'name' => 'Dra. Ana Miranda',
            'email' => 'miradentdentalclinic@gmail.com',
            'password' => Hash::make('Miradent2026'),
            'role' => 'doctora'
        ]);

        $this->doctora = Doctora::create([
            'user_id' => $this->user->id,
            'especialidad' => 'Odontóloga',
            'COP' => '50039',
            'telefono' => '987654321'
        ]);
    }

    /** @test */
    public function test_client_statuses_calculation()
    {
        // 1. Client with no appointments and no payments (total_cost = 0, total_paid = 0)
        $pacienteAlDia = Paciente::create([
            'nombre' => 'Juan',
            'apellido' => 'Perez',
            'dni' => '11111111',
            'telefono' => '999111222'
        ]);

        // 2. Client with appointment (treatment cost) but no payments (Pendiente)
        $pacientePendiente = Paciente::create([
            'nombre' => 'Maria',
            'apellido' => 'Gomez',
            'dni' => '22222222',
            'telefono' => '999333444'
        ]);

        $servicio = Servicio::create([
            'nombre' => 'Profilaxis',
            'precio' => 150.00,
            'duracion' => 30,
            'estado' => 1
        ]);

        Cita::create([
            'paciente_id' => $pacientePendiente->id,
            'doctora_id' => $this->doctora->id,
            'servicio_id' => $servicio->id,
            'fecha_hora' => Carbon::now()->format('Y-m-d H:i:s'),
            'estado' => 'completada'
        ]);

        // 3. Client with appointment and partial payment (Por cuotas)
        $pacienteCuotas = Paciente::create([
            'nombre' => 'Luis',
            'apellido' => 'Rodriguez',
            'dni' => '33333333',
            'telefono' => '999555666'
        ]);

        Cita::create([
            'paciente_id' => $pacienteCuotas->id,
            'doctora_id' => $this->doctora->id,
            'servicio_id' => $servicio->id,
            'fecha_hora' => Carbon::now()->format('Y-m-d H:i:s'),
            'estado' => 'completada'
        ]);

        Pago::create([
            'paciente_id' => $pacienteCuotas->id,
            'monto' => 50.00,
            'metodo_pago' => 'efectivo',
            'fecha_pago' => Carbon::now()->format('Y-m-d H:i:s'),
            'estado' => 'parcial'
        ]);

        // 4. Client with appointment, unpaid, and registered > 15 days ago (Moroso)
        $pacienteMoroso = new Paciente([
            'nombre' => 'Jorge',
            'apellido' => 'Lopez',
            'dni' => '44444444',
            'telefono' => '999777888',
        ]);
        $pacienteMoroso->timestamps = false;
        $pacienteMoroso->created_at = Carbon::now()->subDays(20);
        $pacienteMoroso->updated_at = Carbon::now()->subDays(20);
        $pacienteMoroso->save();

        Cita::create([
            'paciente_id' => $pacienteMoroso->id,
            'doctora_id' => $this->doctora->id,
            'servicio_id' => $servicio->id,
            'fecha_hora' => Carbon::now()->subDays(20)->format('Y-m-d H:i:s'),
            'estado' => 'completada'
        ]);

        // Make requests and check that the statuses are computed correctly
        $response = $this->actingAs($this->user)->get('/admin/finanzas');
        $response->assertStatus(200);

        $pacientes = $response->original->getData()['pacientesConFinanzas'];

        // Assert for Juan Perez (0 cost, 0 paid)
        $pAlDia = $pacientes->firstWhere('id', $pacienteAlDia->id);
        $this->assertEquals(0, $pAlDia->total_cost);
        $this->assertEquals(0, $pAlDia->total_paid);
        $this->assertEquals(0, $pAlDia->pending_amount);
        $this->assertEquals('pendiente', $pAlDia->estado_pago);

        // Assert for Maria Gomez (150 cost, 0 paid)
        $pPendiente = $pacientes->firstWhere('id', $pacientePendiente->id);
        $this->assertEquals(150.00, $pPendiente->total_cost);
        $this->assertEquals(0, $pPendiente->total_paid);
        $this->assertEquals(150.00, $pPendiente->pending_amount);
        $this->assertEquals('pendiente', $pPendiente->estado_pago);

        // Assert for Luis Rodriguez (150 cost, 50 paid)
        $pCuotas = $pacientes->firstWhere('id', $pacienteCuotas->id);
        $this->assertEquals(150.00, $pCuotas->total_cost);
        $this->assertEquals(50.00, $pCuotas->total_paid);
        $this->assertEquals(100.00, $pCuotas->pending_amount);
        $this->assertEquals('cuotas', $pCuotas->estado_pago);

        // Assert for Jorge Lopez (150 cost, 0 paid, > 15 days ago)
        $pMoroso = $pacientes->firstWhere('id', $pacienteMoroso->id);
        $this->assertEquals(150.00, $pMoroso->total_cost);
        $this->assertEquals(0, $pMoroso->total_paid);
        $this->assertEquals(150.00, $pMoroso->pending_amount);
        $this->assertEquals('moroso', $pMoroso->estado_pago);
    }

    /** @test */
    public function test_client_filters_and_search()
    {
        // Set up test clients
        $paciente1 = Paciente::create(['nombre' => 'Ana', 'apellido' => 'Ruiz', 'dni' => '10000001']);
        $paciente2 = Paciente::create(['nombre' => 'Beto', 'apellido' => 'Ortiz', 'dni' => '10000002']);

        $servicio = Servicio::create(['nombre' => 'Profilaxis', 'precio' => 100.00, 'duracion' => 30, 'estado' => 1]);

        // Ana has a completed treatment and paid fully
        Cita::create([
            'paciente_id' => $paciente1->id,
            'doctora_id' => $this->doctora->id,
            'servicio_id' => $servicio->id,
            'fecha_hora' => Carbon::now()->format('Y-m-d H:i:s'),
            'estado' => 'completada'
        ]);
        Pago::create([
            'paciente_id' => $paciente1->id,
            'monto' => 100.00,
            'metodo_pago' => 'yape',
            'fecha_pago' => Carbon::now()->format('Y-m-d H:i:s'),
            'estado' => 'pagado'
        ]);

        // Beto has a treatment but paid partially
        Cita::create([
            'paciente_id' => $paciente2->id,
            'doctora_id' => $this->doctora->id,
            'servicio_id' => $servicio->id,
            'fecha_hora' => Carbon::now()->format('Y-m-d H:i:s'),
            'estado' => 'completada'
        ]);
        Pago::create([
            'paciente_id' => $paciente2->id,
            'monto' => 40.00,
            'metodo_pago' => 'yape',
            'fecha_pago' => Carbon::now()->format('Y-m-d H:i:s'),
            'estado' => 'parcial'
        ]);

        // Filter: moroso (should return 0 patients)
        $response = $this->actingAs($this->user)->get('/admin/finanzas?filtro_cliente=moroso');
        $response->assertStatus(200);
        $pacientes = $response->original->getData()['pacientesConFinanzas'];
        $this->assertCount(0, $pacientes);

        // Filter: pagado (should return only Ana)
        $response = $this->actingAs($this->user)->get('/admin/finanzas?filtro_cliente=pagado');
        $response->assertStatus(200);
        $pacientes = $response->original->getData()['pacientesConFinanzas'];
        $this->assertCount(1, $pacientes);
        $this->assertEquals('Ana', $pacientes->first()->nombre);

        // Filter: cuotas (should return only Beto)
        $response = $this->actingAs($this->user)->get('/admin/finanzas?filtro_cliente=cuotas');
        $response->assertStatus(200);
        $pacientes = $response->original->getData()['pacientesConFinanzas'];
        $this->assertCount(1, $pacientes);
        $this->assertEquals('Beto', $pacientes->first()->nombre);

        // Search: "Beto"
        $response = $this->actingAs($this->user)->get('/admin/finanzas?search_cliente=Beto');
        $response->assertStatus(200);
        $pacientes = $response->original->getData()['pacientesConFinanzas'];
        $this->assertCount(1, $pacientes);
        $this->assertEquals('Beto', $pacientes->first()->nombre);

        // Search: "10000001"
        $response = $this->actingAs($this->user)->get('/admin/finanzas?search_cliente=10000001');
        $response->assertStatus(200);
        $pacientes = $response->original->getData()['pacientesConFinanzas'];
        $this->assertCount(1, $pacientes);
        $this->assertEquals('Ana', $pacientes->first()->nombre);
    }
}
