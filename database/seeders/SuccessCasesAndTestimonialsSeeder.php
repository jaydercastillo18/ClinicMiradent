<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CasoExito;
use App\Models\Testimonio;
use Carbon\Carbon;

class SuccessCasesAndTestimonialsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (CasoExito::count() == 0) {
            CasoExito::create([
                'titulo_tratamiento' => 'Diseño de Sonrisa con Carillas',
                'descripcion_resultado' => 'Paciente presentaba diastema y coloración irregular. Se colocaron carillas de porcelana de alta estética logrando simetría y brillo natural.',
                'categoria' => 'Estética Dental',
                'antes_img' => 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&q=80&w=600&h=450',
                'despues_img' => 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?auto=format&fit=crop&q=80&w=600&h=450',
                'activo' => true
            ]);

            CasoExito::create([
                'titulo_tratamiento' => 'Alineamiento con Ortodoncia',
                'descripcion_resultado' => 'Tratamiento de 18 meses para corregir apiñamiento severo y mordida cruzada anterior. Resultados funcionales y estéticos excelentes.',
                'categoria' => 'Ortodoncia',
                'antes_img' => 'https://images.unsplash.com/photo-1606811971618-4486d14f3f99?auto=format&fit=crop&q=80&w=600&h=450',
                'despues_img' => 'https://images.unsplash.com/photo-1513412893-c40d58525b6c?auto=format&fit=crop&q=80&w=600&h=450',
                'activo' => true
            ]);

            CasoExito::create([
                'titulo_tratamiento' => 'Blanqueamiento Dental Clínico',
                'descripcion_resultado' => 'Aclarado de 4 tonos en una sola sesión de blanqueamiento foto-activado. Esmalte fuerte y libre de manchas.',
                'categoria' => 'Estética Dental',
                'antes_img' => 'https://images.unsplash.com/photo-1579684453401-966b11832b44?auto=format&fit=crop&q=80&w=600&h=450',
                'despues_img' => 'https://images.unsplash.com/photo-1598256989800-fe5f95da9787?auto=format&fit=crop&q=80&w=600&h=450',
                'activo' => true
            ]);
        }

        if (Testimonio::count() == 0) {
            Testimonio::create([
                'nombre_paciente' => 'Juan Carlos R.',
                'testimonio' => 'La mejor experiencia dental. La Dra. Miranda me explicó todo el proceso para mis carillas y el resultado superó mis expectativas. ¡Muy profesional!',
                'fecha' => Carbon::now()->subDays(14),
                'estrellas' => 5,
                'activo' => true
            ]);

            Testimonio::create([
                'nombre_paciente' => 'María Fe O.',
                'testimonio' => 'Llevé a mi hijo para su limpieza y tratamiento de flúor. El trato fue sumamente cálido y paciente. El consultorio tiene un ambiente muy agradable y seguro.',
                'fecha' => Carbon::now()->subDays(30),
                'estrellas' => 5,
                'activo' => true
            ]);

            Testimonio::create([
                'nombre_paciente' => 'Roberto L.',
                'testimonio' => 'Me realicé una endodoncia de emergencia. No sentí ningún dolor gracias a la delicadeza de la doctora. Totalmente recomendada por su paciencia.',
                'fecha' => Carbon::now()->subDays(20),
                'estrellas' => 5,
                'activo' => true
            ]);
        }
    }
}
