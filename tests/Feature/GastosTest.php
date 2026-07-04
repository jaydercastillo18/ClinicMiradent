<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Gasto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class GastosTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a doctor user
        $this->user = User::create([
            'name' => 'Dra. Ana Miranda',
            'email' => 'miradentdentalclinic@gmail.com',
            'password' => Hash::make('Miradent2026'),
            'role' => 'doctora'
        ]);
    }

    public function test_guest_cannot_access_gastos()
    {
        $this->get('/admin/gastos')->assertRedirect(route('login'));
        $this->get('/admin/gastos/pdf')->assertRedirect(route('login'));
    }

    public function test_authenticated_doctor_can_access_gastos()
    {
        $response = $this->actingAs($this->user)->get('/admin/gastos');
        $response->assertStatus(200);
        $response->assertSee('Caja y Finanzas');
    }

    public function test_doctor_can_store_gasto()
    {
        $response = $this->actingAs($this->user)->post('/admin/gastos', [
            'concepto' => 'Alquiler del local',
            'monto' => 1200.00,
            'categoria' => 'Servicios',
            'metodo_pago' => 'transferencia',
            'fecha_gasto' => '2026-05-20',
            'descripcion' => 'Pago del mes corriente.',
            'comprobante' => 'F001-00012'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('gastos', [
            'concepto' => 'Alquiler del local',
            'monto' => 1200.00,
            'categoria' => 'Servicios'
        ]);
    }

    public function test_doctor_can_update_gasto()
    {
        $gasto = Gasto::create([
            'concepto' => 'Luz eléctrica',
            'monto' => 150.00,
            'categoria' => 'Servicios',
            'metodo_pago' => 'efectivo',
            'fecha_gasto' => '2026-05-19'
        ]);

        $response = $this->actingAs($this->user)->put('/admin/gastos/' . $gasto->id, [
            'concepto' => 'Luz eléctrica - Modificado',
            'monto' => 180.00,
            'categoria' => 'Servicios',
            'metodo_pago' => 'efectivo',
            'fecha_gasto' => '2026-05-19',
            'comprobante' => 'REC-44'
        ]);

        $response->assertRedirect();
        $gasto->refresh();
        $this->assertEquals('Luz eléctrica - Modificado', $gasto->concepto);
        $this->assertEquals(180.00, $gasto->monto);
    }

    public function test_doctor_can_delete_gasto()
    {
        $gasto = Gasto::create([
            'concepto' => 'Luz eléctrica',
            'monto' => 150.00,
            'categoria' => 'Servicios',
            'metodo_pago' => 'efectivo',
            'fecha_gasto' => '2026-05-19'
        ]);

        $response = $this->actingAs($this->user)->delete('/admin/gastos/' . $gasto->id);
        $response->assertRedirect();
        $this->assertSoftDeleted('gastos', [
            'id' => $gasto->id
        ]);
    }

    public function test_doctor_can_download_pdf_report()
    {
        Gasto::create([
            'concepto' => 'Útiles de Limpieza',
            'monto' => 75.50,
            'categoria' => 'Otros',
            'metodo_pago' => 'efectivo',
            'fecha_gasto' => '2026-05-20'
        ]);

        $response = $this->actingAs($this->user)->get('/admin/gastos/pdf?mes=2026-05');
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }
}
