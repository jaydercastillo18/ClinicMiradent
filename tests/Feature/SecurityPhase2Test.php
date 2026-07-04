<?php

namespace Tests\Feature;

use App\Models\Paciente;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests para el sistema de referidos por Nombre completo + DNI.
 *
 * NOTA ARQUITECTÓNICA — Re-validación en servidor al guardar reserva (punto 7):
 * El flujo actual de reserva es 100% client-side: el usuario rellena el
 * formulario y el botón "Enviar a WhatsApp" abre wa.me con un mensaje
 * predefinido. No existe un endpoint POST /reservas ni una tabla `reservas`
 * en la base de datos. Por lo tanto, no hay operación de guardado en el
 * servidor que re-validar. Si en el futuro se implementa ese endpoint,
 * deberá volver a llamar a la misma lógica de validación (DNI exacto +
 * nombre normalizado) antes de persistir el registro, y nunca confiar en
 * un campo hidden enviado desde el navegador.
 */
class SecurityPhase2Test extends TestCase
{
    use RefreshDatabase;

    // ─── Fixture ─────────────────────────────────────────────────────────────

    private Paciente $paciente;

    protected function setUp(): void
    {
        parent::setUp();

        $this->paciente = Paciente::create([
            'nombre'   => 'María',
            'apellido' => 'García López',
            'dni'      => '12345678',
            'telefono' => '999888777',
        ]);
    }

    // ─── Válido ───────────────────────────────────────────────────────────────

    public function test_nombre_y_dni_correctos_validan(): void
    {
        $this->postJson('/validar-referido', [
            'referido_nombre' => 'María García López',
            'referido_dni'    => '12345678',
        ])
        ->assertOk()
        ->assertJson(['success' => true, 'valid' => true])
        ->assertJsonPath('message', 'Referido validado correctamente.');
    }

    public function test_nombre_en_mayusculas_valida_correctamente(): void
    {
        $this->postJson('/validar-referido', [
            'referido_nombre' => 'MARÍA GARCÍA LÓPEZ',
            'referido_dni'    => '12345678',
        ])
        ->assertOk()
        ->assertJsonPath('valid', true);
    }

    public function test_nombre_con_espacios_extra_valida_correctamente(): void
    {
        $this->postJson('/validar-referido', [
            'referido_nombre' => '  María   García  López  ',
            'referido_dni'    => '12345678',
        ])
        ->assertOk()
        ->assertJsonPath('valid', true);
    }

    // ─── Inválido: campos correctos pero combinaciones incorrectas ────────────

    public function test_nombre_correcto_y_dni_incorrecto_no_valida(): void
    {
        $this->postJson('/validar-referido', [
            'referido_nombre' => 'María García López',
            'referido_dni'    => '99999999',
        ])
        ->assertOk()
        ->assertJsonPath('valid', false);
    }

    public function test_dni_correcto_y_nombre_incorrecto_no_valida(): void
    {
        $this->postJson('/validar-referido', [
            'referido_nombre' => 'Juan Pérez',
            'referido_dni'    => '12345678',
        ])
        ->assertOk()
        ->assertJsonPath('valid', false);
    }

    public function test_nombre_parcial_no_valida(): void
    {
        $this->postJson('/validar-referido', [
            'referido_nombre' => 'María García',
            'referido_dni'    => '12345678',
        ])
        ->assertOk()
        ->assertJsonPath('valid', false);
    }

    // ─── Inválido: solo uno de los dos campos ────────────────────────────────

    public function test_solo_nombre_sin_dni_valida_correctamente(): void
    {
        $this->postJson('/validar-referido', [
            'referido_nombre' => 'María García López',
        ])
        ->assertOk()
        ->assertJsonPath('valid', true);
    }

    public function test_solo_dni_sin_nombre_devuelve_422(): void
    {
        $this->postJson('/validar-referido', [
            'referido_dni' => '12345678',
        ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['referido_nombre']);
    }

    public function test_sin_datos_devuelve_422(): void
    {
        $this->postJson('/validar-referido', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['referido_nombre']);
    }

    // ─── Validación de formato ────────────────────────────────────────────────

    public function test_dni_con_letras_devuelve_422(): void
    {
        $this->postJson('/validar-referido', [
            'referido_nombre' => 'María García López',
            'referido_dni'    => 'ABCD1234',
        ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['referido_dni']);
    }

    public function test_dni_con_menos_de_8_digitos_devuelve_422(): void
    {
        $this->postJson('/validar-referido', [
            'referido_nombre' => 'María García López',
            'referido_dni'    => '1234567',
        ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['referido_dni']);
    }

    public function test_dni_con_mas_de_8_digitos_devuelve_422(): void
    {
        $this->postJson('/validar-referido', [
            'referido_nombre' => 'María García López',
            'referido_dni'    => '123456789',
        ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['referido_dni']);
    }

    public function test_nombre_demasiado_corto_devuelve_422(): void
    {
        $this->postJson('/validar-referido', [
            'referido_nombre' => 'AB',
            'referido_dni'    => '12345678',
        ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['referido_nombre']);
    }

    // ─── Seguridad: la respuesta no expone datos del paciente ────────────────

    public function test_respuesta_no_contiene_datos_del_paciente_en_exito(): void
    {
        $response = $this->postJson('/validar-referido', [
            'referido_nombre' => 'María García López',
            'referido_dni'    => '12345678',
        ])->assertOk();

        $json = $response->json();

        $this->assertArrayNotHasKey('id', $json);
        $this->assertArrayNotHasKey('nombre', $json);
        $this->assertArrayNotHasKey('apellido', $json);
        $this->assertArrayNotHasKey('dni', $json);
        $this->assertArrayNotHasKey('telefono', $json);
        $this->assertArrayNotHasKey('email', $json);
        $this->assertArrayNotHasKey('antecedentes_medicos', $json);
        $this->assertArrayNotHasKey('alergias', $json);
    }

    public function test_respuesta_no_indica_que_campo_fue_incorrecto(): void
    {
        // DNI correcto, nombre incorrecto — el mensaje no debe decir cuál falló
        $response = $this->postJson('/validar-referido', [
            'referido_nombre' => 'Nombre Incorrecto',
            'referido_dni'    => '12345678',
        ])->assertOk()->assertJsonPath('valid', false);

        $message = $response->json('message');

        // El mensaje no debe mencionar "nombre" ni "DNI" como campo incorrecto
        $this->assertStringNotContainsStringIgnoringCase('nombre', $message);
        $this->assertStringNotContainsStringIgnoringCase('dni encontrado', $message);
        $this->assertStringNotContainsStringIgnoringCase('paciente no existe', $message);
    }

    public function test_respuesta_no_contiene_datos_del_paciente_en_fallo(): void
    {
        $response = $this->postJson('/validar-referido', [
            'referido_nombre' => 'Nombre Inventado',
            'referido_dni'    => '00000000',
        ])->assertOk()->assertJsonPath('valid', false);

        $json = $response->json();

        $this->assertArrayNotHasKey('id', $json);
        $this->assertArrayNotHasKey('nombre', $json);
        $this->assertArrayNotHasKey('apellido', $json);
        $this->assertArrayNotHasKey('dni', $json);
    }

    // ─── Rate limiting ────────────────────────────────────────────────────────

    public function test_rate_limit_se_activa_despues_de_5_intentos(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->postJson('/validar-referido', [
                'referido_nombre' => 'Intento ' . $i,
                'referido_dni'    => '00000000',
            ]);
        }

        $this->postJson('/validar-referido', [
            'referido_nombre' => 'Sexto Intento',
            'referido_dni'    => '00000000',
        ])->assertStatus(429);
    }

    // ─── Login rate limiting (pre-existente) ─────────────────────────────────

    public function test_login_rate_limiting(): void
    {
        $response = null;
        for ($i = 0; $i < 6; $i++) {
            $response = $this->post('/doctora-acceso', [
                'email'    => 'admin@example.com',
                'password' => 'wrongpassword',
            ]);
        }

        $response->assertSessionHasErrors('email');
        $this->assertStringContainsString('Demasiados intentos', session('errors')->first('email'));
    }

    // ─── Acceso clínico por rol (pre-existente) ───────────────────────────────

    public function test_asistente_cannot_view_clinical_data_in_paciente_response(): void
    {
        $asistente = User::factory()->create(['role' => 'asistente']);
        $paciente  = Paciente::create([
            'nombre'               => 'Test',
            'apellido'             => 'Test',
            'dni'                  => '87654321',
            'telefono'             => '123456789',
            'antecedentes_medicos' => 'Hipertension',
            'alergias'             => 'Penicilina',
        ]);

        $this->actingAs($asistente)
            ->getJson("/admin/pacientes/{$paciente->id}")
            ->assertOk()
            ->assertJsonMissing(['antecedentes_medicos' => 'Hipertension'])
            ->assertJsonMissing(['alergias' => 'Penicilina']);
    }

    public function test_doctora_can_view_clinical_data(): void
    {
        $doctora  = User::factory()->create(['role' => 'doctora']);
        $paciente = Paciente::create([
            'nombre'               => 'Test2',
            'apellido'             => 'Test2',
            'dni'                  => '11223344',
            'telefono'             => '987654321',
            'antecedentes_medicos' => 'Diabetes',
            'alergias'             => 'Aspirina',
        ]);

        $this->actingAs($doctora)
            ->getJson("/admin/pacientes/{$paciente->id}")
            ->assertOk()
            ->assertJsonFragment(['antecedentes_medicos' => 'Diabetes'])
            ->assertJsonFragment(['alergias' => 'Aspirina']);
    }

    public function test_buscar_pacientes_is_protected_and_rate_limited(): void
    {
        $asistente = User::factory()->create(['role' => 'asistente']);
        $paciente  = Paciente::create([
            'nombre'   => 'Juan',
            'apellido' => 'Perez',
            'dni'      => '55667788',
            'telefono' => '999888777',
        ]);

        $this->actingAs($asistente)
            ->getJson('/admin/pacientes/buscar?search=Juan')
            ->assertOk()
            ->assertJsonFragment(['nombre' => 'Juan']);
    }
}
