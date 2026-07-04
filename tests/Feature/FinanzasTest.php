<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Pago;
use App\Models\Gasto;
use App\Models\Paciente;
use App\Models\Doctora;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class FinanzasTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $doctora;
    protected $paciente;

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

        $this->paciente = Paciente::create([
            'nombre' => 'Carlos',
            'apellido' => 'Perez',
            'dni' => '12345678',
            'email' => 'carlos@perez.com',
            'telefono' => '999888777',
            'fecha_nacimiento' => '1990-05-15',
            'genero' => 'masculino'
        ]);
    }

    public function test_guest_cannot_access_finanzas()
    {
        $this->get('/admin/finanzas')->assertRedirect(route('login'));
        $this->get('/admin/finanzas/pdf')->assertRedirect(route('login'));
    }

    public function test_doctor_can_access_finanzas_dashboard()
    {
        // Create an income (Pago)
        Pago::create([
            'paciente_id' => $this->paciente->id,
            'monto' => 350.00,
            'metodo_pago' => 'yape',
            'fecha_pago' => '2026-05-20 10:00:00',
            'estado' => 'pagado'
        ]);

        // Create an expense (Gasto)
        Gasto::create([
            'concepto' => 'Alquiler consultorio',
            'monto' => 150.00,
            'categoria' => 'Servicios',
            'metodo_pago' => 'transferencia',
            'fecha_gasto' => '2026-05-20'
        ]);

        $response = $this->actingAs($this->user)->get('/admin/finanzas?mes=2026-05');

        $response->assertStatus(200);
        $response->assertSee('Caja y Finanzas');
        $response->assertSee('350.00'); // Total Incomes
        $response->assertSee('150.00'); // Total Expenses
        $response->assertSee('200.00'); // Net balance
        $response->assertSee('Superávit');
    }

    public function test_doctor_can_filter_finanzas_by_type()
    {
        Pago::create([
            'paciente_id' => $this->paciente->id,
            'monto' => 300.00,
            'metodo_pago' => 'yape',
            'fecha_pago' => '2026-05-20 10:00:00',
            'estado' => 'pagado'
        ]);

        Gasto::create([
            'concepto' => 'Guantes de látex',
            'monto' => 80.00,
            'categoria' => 'Material',
            'metodo_pago' => 'efectivo',
            'fecha_gasto' => '2026-05-20'
        ]);

        // Request incomes only
        $responseIncomes = $this->actingAs($this->user)->get('/admin/finanzas?mes=2026-05&tipo=ingreso');
        $responseIncomes->assertStatus(200);
        $responseIncomes->assertSee('Pago de Paciente: Carlos Perez');
        $responseIncomes->assertDontSee('Guantes de látex');

        // Request expenses only
        $responseExpenses = $this->actingAs($this->user)->get('/admin/finanzas?mes=2026-05&tipo=egreso');
        $responseExpenses->assertStatus(200);
        $responseExpenses->assertSee('Guantes de látex');
        $responseExpenses->assertDontSee('Pago de Paciente: Carlos Perez');
    }

    public function test_doctor_can_download_finanzas_pdf()
    {
        Pago::create([
            'paciente_id' => $this->paciente->id,
            'monto' => 100.00,
            'metodo_pago' => 'yape',
            'fecha_pago' => '2026-05-20 10:00:00',
            'estado' => 'pagado'
        ]);

        Gasto::create([
            'concepto' => 'Servicio internet',
            'monto' => 60.00,
            'categoria' => 'Servicios',
            'metodo_pago' => 'bcp',
            'fecha_gasto' => '2026-05-20'
        ]);

        $response = $this->actingAs($this->user)->get('/admin/finanzas/pdf?mes=2026-05');
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }
}
