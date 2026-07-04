<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Doctora;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DoctoraConfigTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $doctora;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a doctor user and associated profile
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
            'telefono' => '987654321',
            'bio' => 'Trayectoria profesional larga.'
        ]);
    }

    public function test_guest_cannot_access_profile_or_config()
    {
        $this->get('/admin/doctora')->assertRedirect(route('login'));
        $this->get('/admin/configuracion')->assertRedirect(route('login'));
    }

    public function test_authenticated_doctor_can_access_profile_and_config()
    {
        $response = $this->actingAs($this->user)->get('/admin/doctora');
        $response->assertStatus(200);
        $response->assertSee('Ana Miranda');
        $response->assertSee('50039');

        $responseConfig = $this->actingAs($this->user)->get('/admin/configuracion');
        $responseConfig->assertStatus(200);
        $responseConfig->assertSee('Horarios de Atención');
    }

    public function test_doctor_can_update_profile()
    {
        $response = $this->actingAs($this->user)->put('/admin/doctora', [
            'name' => 'Dra. Ana Miranda R.',
            'email' => 'doctora_new@miradent.com',
            'especialidad' => 'Ortodoncista',
            'COP' => '99999',
            'telefono' => '911111111',
            'bio' => 'Biografía modificada.'
        ]);

        $response->assertRedirect(route('doctora.profile'));
        $this->user->refresh();
        $this->doctora->refresh();

        $this->assertEquals('Dra. Ana Miranda R.', $this->user->name);
        $this->assertEquals('doctora_new@miradent.com', $this->user->email);
        $this->assertEquals('Ortodoncista', $this->doctora->especialidad);
        $this->assertEquals('99999', $this->doctora->COP);
        $this->assertEquals('911111111', $this->doctora->telefono);
        $this->assertEquals('Biografía modificada.', $this->doctora->bio);
    }

    public function test_doctor_can_update_working_hours()
    {
        $horarioData = [
            'Lunes' => ['activo' => '1', 'inicio' => '08:00', 'fin' => '17:00'],
            'Martes' => ['activo' => '0', 'inicio' => '09:00', 'fin' => '18:00'],
            'Miércoles' => ['activo' => '1', 'inicio' => '09:00', 'fin' => '18:00'],
            'Jueves' => ['activo' => '1', 'inicio' => '09:00', 'fin' => '18:00'],
            'Viernes' => ['activo' => '1', 'inicio' => '09:00', 'fin' => '18:00'],
            'Sábado' => ['activo' => '1', 'inicio' => '09:00', 'fin' => '13:00'],
            'Domingo' => ['activo' => '0', 'inicio' => '09:00', 'fin' => '18:00'],
        ];

        $response = $this->actingAs($this->user)->put('/admin/configuracion', [
            'horario' => $horarioData
        ]);

        $response->assertRedirect(route('doctora.config'));
        $this->doctora->refresh();

        $decoded = json_decode($this->doctora->horario_atencion, true);
        $this->assertTrue($decoded['Lunes']['activo']);
        $this->assertEquals('08:00', $decoded['Lunes']['inicio']);
        $this->assertFalse($decoded['Martes']['activo']);
    }

    public function test_doctor_can_change_password()
    {
        $response = $this->actingAs($this->user)->put('/admin/configuracion', [
            'horario' => [
                'Lunes' => ['activo' => '1', 'inicio' => '09:00', 'fin' => '18:00']
            ],
            'current_password' => 'Miradent2026',
            'new_password' => 'newpassword123',
            'new_password_confirmation' => 'newpassword123'
        ]);

        $response->assertRedirect(route('doctora.config'));
        $this->user->refresh();

        $this->assertTrue(Hash::check('newpassword123', $this->user->password));
    }
}
