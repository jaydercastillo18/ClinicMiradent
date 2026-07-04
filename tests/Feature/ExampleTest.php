<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_single_service_redirects_to_catalog(): void
    {
        $servicio = \App\Models\Servicio::create([
            'nombre' => 'Ortodoncia Invisible',
            'categoria' => 'Ortodoncia',
            'descripcion' => 'Alineadores transparentes modernos',
            'duracion_minutos' => 45,
            'precio' => 2500,
            'activo' => true
        ]);

        $response = $this->get('/servicios/' . $servicio->id);

        $response->assertStatus(302);
        $response->assertRedirect('/servicios?search=Ortodoncia%20Invisible');
    }

    public function test_invalid_service_redirects_to_catalog_root(): void
    {
        $response = $this->get('/servicios/99999');

        $response->assertStatus(302);
        $response->assertRedirect('/servicios');
    }
}
