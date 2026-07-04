<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Initial Doctor User
        $doctorUser = User::create([
            'name' => 'Dra. Miranda',
            'email' => 'miradentdentalclinic@gmail.com',
            'password' => bcrypt(env('ADMIN_PASSWORD', 'Miradent2026')),
            'role' => 'doctora'
        ]);

        // 2. Doctora Profile Details
        \App\Models\Doctora::create([
            'user_id' => $doctorUser->id,
            'especialidad' => 'Odontología General y Estética',
            'COP' => 'COP 50039', // Colegio Médico / Odontológico del Perú
            'telefono' => '+51 990 353 982',
            'bio' => 'Especialista en estética dental, rehabilitación oral y diseño de sonrisa con más de 6 años de experiencia.',
            'horario_atencion' => json_encode([
                'Lunes'     => ['activo' => true,  'inicio' => '09:00', 'fin' => '12:00', 'turno2' => true,  'inicio2' => '16:00', 'fin2' => '20:00'],
                'Martes'    => ['activo' => true,  'inicio' => '09:00', 'fin' => '12:00', 'turno2' => true,  'inicio2' => '16:00', 'fin2' => '20:00'],
                'Miércoles' => ['activo' => true,  'inicio' => '09:00', 'fin' => '12:00', 'turno2' => true,  'inicio2' => '16:00', 'fin2' => '20:00'],
                'Jueves'    => ['activo' => true,  'inicio' => '09:00', 'fin' => '12:00', 'turno2' => true,  'inicio2' => '16:00', 'fin2' => '20:00'],
                'Viernes'   => ['activo' => true,  'inicio' => '09:00', 'fin' => '12:00', 'turno2' => true,  'inicio2' => '16:00', 'fin2' => '20:00'],
                'Sábado'    => ['activo' => false, 'inicio' => '09:00', 'fin' => '12:00', 'turno2' => false, 'inicio2' => '16:00', 'fin2' => '20:00'],
                'Domingo'   => ['activo' => false, 'inicio' => '09:00', 'fin' => '12:00', 'turno2' => false, 'inicio2' => '16:00', 'fin2' => '20:00'],
            ])
        ]);

        // 3. Seed all requested dental services
        $servicesData = [
            [
                'nombre' => 'Limpieza dental profesional',
                'descripcion' => 'Eliminación de sarro, placa bacteriana y pulido de manchas dentales para prevenir caries y gingivitis.',
                'precio' => 120.00,
                'duracion_minutos' => 45,
                'categoria' => 'Prevención',
                'activo' => true
            ],
            [
                'nombre' => 'Restauraciones de Resina',
                'descripcion' => 'Curación de caries con resina estética de alta duración y color idéntico al diente natural.',
                'precio' => 80.00,
                'duracion_minutos' => 30,
                'categoria' => 'Estética',
                'activo' => true
            ],
            [
                'nombre' => 'Endodoncia',
                'descripcion' => 'Tratamiento de conducto para salvar piezas dentales infectadas o con dolor severo, evitando la extracción.',
                'precio' => 380.00,
                'duracion_minutos' => 90,
                'categoria' => 'Endodoncia',
                'activo' => true
            ],
            [
                'nombre' => 'Protesis Fija (coronas dentales)',
                'descripcion' => 'Restauración dental completa mediante fundas de porcelana o zirconio sobre dientes dañados.',
                'precio' => 650.00,
                'duracion_minutos' => 60,
                'categoria' => 'Prótesis',
                'activo' => true
            ],
            [
                'nombre' => 'Prótesis Removibles',
                'descripcion' => 'Dispositivos artificiales móviles para reemplazar una o varias piezas dentales de forma cómoda.',
                'precio' => 450.00,
                'duracion_minutos' => 60,
                'categoria' => 'Prótesis',
                'activo' => true
            ],
            [
                'nombre' => 'Implantes dentales',
                'descripcion' => 'Reemplazo permanente de raíces dentales mediante pernos de titanio y coronas estéticas.',
                'precio' => 2800.00,
                'duracion_minutos' => 90,
                'categoria' => 'Implantes',
                'activo' => true
            ],
            [
                'nombre' => 'Tratamientos con flúor',
                'descripcion' => 'Aplicación profesional de barniz de flúor para fortalecer el esmalte dental y prevenir la caries.',
                'precio' => 60.00,
                'duracion_minutos' => 20,
                'categoria' => 'Prevención',
                'activo' => true
            ],
            [
                'nombre' => 'Selladores dentales',
                'descripcion' => 'Recubrimiento protector en las fosas de las muelas para evitar la acumulación de restos y bacterias.',
                'precio' => 50.00,
                'duracion_minutos' => 20,
                'categoria' => 'Prevención',
                'activo' => true
            ],
            [
                'nombre' => 'Blanqueamiento dental',
                'descripcion' => 'Aclaramiento químico dental en consultorio para una sonrisa radiante y libre de manchas.',
                'precio' => 400.00,
                'duracion_minutos' => 60,
                'categoria' => 'Estética',
                'activo' => true
            ],
            [
                'nombre' => 'Ortodoncia tradicionales o sistemas invisibles',
                'descripcion' => 'Corrección de la alineación y mordida mediante brackets metálicos convencionales o alineadores transparentes.',
                'precio' => 2500.00,
                'duracion_minutos' => 60,
                'categoria' => 'Ortodoncia',
                'activo' => true
            ],
            [
                'nombre' => 'Carillas',
                'descripcion' => 'Láminas ultrafinas de resina o porcelana para corregir forma, color y posición de los dientes frontales.',
                'precio' => 500.00,
                'duracion_minutos' => 60,
                'categoria' => 'Estética',
                'activo' => true
            ],
            [
                'nombre' => 'Extracciones dentales',
                'descripcion' => 'Remoción segura y sin dolor de piezas dentales severamente dañadas o muelas del juicio.',
                'precio' => 100.00,
                'duracion_minutos' => 45,
                'categoria' => 'Cirugía',
                'activo' => true
            ],
            [
                'nombre' => 'Prótesis dentales',
                'descripcion' => 'Estructuras completas o parciales diseñadas a medida para devolver la funcionalidad masticatoria total.',
                'precio' => 800.00,
                'duracion_minutos' => 60,
                'categoria' => 'Prótesis',
                'activo' => true
            ],
            [
                'nombre' => 'Tratamientos integrales',
                'descripcion' => 'Un enfoque clínico completo que busca restaurar la salud bucal completa, ayudando a comer, hablar y vivir mejor.',
                'precio' => 1500.00,
                'duracion_minutos' => 120,
                'categoria' => 'Tratamientos Integrales',
                'activo' => true
            ],
            [
                'nombre' => 'Medicamentos dentales',
                'descripcion' => 'Prescripción y aplicación de fármacos para controlar dolor, inflamación, o prevenir infecciones post-operatorias.',
                'precio' => 40.00,
                'duracion_minutos' => 15,
                'categoria' => 'Procedimientos',
                'activo' => true
            ]
        ];

        foreach ($servicesData as $serv) {
            \App\Models\Servicio::updateOrCreate(['nombre' => $serv['nombre']], $serv);
        }

        // Recuperar algunos servicios para asignar citas de prueba
        $profilaxis = \App\Models\Servicio::where('nombre', 'Limpieza dental profesional')->first();
        $ortodoncia = \App\Models\Servicio::where('nombre', 'Ortodoncia tradicionales o sistemas invisibles')->first();
        $endodoncia = \App\Models\Servicio::where('nombre', 'Endodoncia')->first();
        $blanqueamiento = \App\Models\Servicio::where('nombre', 'Blanqueamiento dental')->first();

        // 4. Seed Patients
        $paciente1 = \App\Models\Paciente::create([
            'nombre' => 'Alejandro',
            'apellido' => 'Mendoza',
            'dni' => '74859632',
            'telefono' => '987654321',
            'email' => 'alejandro.mendoza@example.com',
            'fecha_nacimiento' => '1990-05-15',
            'genero' => 'Masculino',
            'direccion' => 'Av. Larco 456, Miraflores',
            'antecedentes_medicos' => 'Hipertensión controlada.',
            'alergias' => 'Penicilina'
        ]);

        $paciente2 = \App\Models\Paciente::create([
            'nombre' => 'Sofía',
            'apellido' => 'Rodríguez',
            'dni' => '45698712',
            'telefono' => '912345678',
            'email' => 'sofia.rodriguez@example.com',
            'fecha_nacimiento' => '1995-08-22',
            'genero' => 'Femenino',
            'direccion' => 'Calle Las Flores 123, San Isidro',
            'alergias' => 'Ninguna'
        ]);

        $paciente3 = \App\Models\Paciente::create([
            'nombre' => 'Carlos',
            'apellido' => 'Pérez',
            'dni' => '12348765',
            'telefono' => '945678123',
            'email' => 'carlos.perez@example.com',
            'fecha_nacimiento' => '1988-11-02',
            'genero' => 'Masculino',
            'direccion' => 'Jr. Huallaga 789, Lima Centro',
            'antecedentes_medicos' => 'Diabetes tipo 2 en tratamiento.'
        ]);

        // Fetch doctor profile ID
        $doctoraId = 1;

        // 5. Seed Appointments for Today
        $cita1 = \App\Models\Cita::create([
            'paciente_id' => $paciente1->id,
            'doctora_id' => $doctoraId,
            'servicio_id' => $ortodoncia->id,
            'fecha_hora' => \Carbon\Carbon::today()->setHour(9)->setMinute(0),
            'motivo' => 'Control de brackets mensuales.',
            'diagnostico' => 'Evolución favorable de alineación maxilar.',
            'notas_tratamiento' => 'Cambio de arcos y ligaduras superiores.',
            'estado' => 'completada'
        ]);

        $cita2 = \App\Models\Cita::create([
            'paciente_id' => $paciente2->id,
            'doctora_id' => $doctoraId,
            'servicio_id' => $profilaxis->id,
            'fecha_hora' => \Carbon\Carbon::today()->setHour(10)->setMinute(30),
            'motivo' => 'Limpieza profiláctica semestral.',
            'estado' => 'en_espera'
        ]);

        $cita3 = \App\Models\Cita::create([
            'paciente_id' => $paciente3->id,
            'doctora_id' => $doctoraId,
            'servicio_id' => $endodoncia->id,
            'fecha_hora' => \Carbon\Carbon::today()->setHour(12)->setMinute(0),
            'motivo' => 'Dolor agudo en molar inferior.',
            'estado' => 'pendiente'
        ]);

        // 6. Seed Payments for this month
        \App\Models\Pago::create([
            'paciente_id' => $paciente1->id,
            'cita_id' => $cita1->id,
            'monto' => 150.00, // Costo de control mensual de ortodoncia
            'metodo_pago' => 'tarjeta',
            'fecha_pago' => \Carbon\Carbon::now(),
            'estado' => 'pagado',
            'notas' => 'Pago realizado con tarjeta de crédito Visa.'
        ]);

        \App\Models\Pago::create([
            'paciente_id' => $paciente2->id,
            'cita_id' => $cita2->id,
            'monto' => 120.00, // Costo de profilaxis
            'metodo_pago' => 'yape',
            'fecha_pago' => \Carbon\Carbon::now(),
            'estado' => 'pagado',
            'notas' => 'Yape verificado.'
        ]);

        \App\Models\Pago::create([
            'paciente_id' => $paciente3->id,
            'cita_id' => $cita3->id,
            'monto' => 350.00, // Costo de endodoncia
            'metodo_pago' => 'transferencia',
            'fecha_pago' => \Carbon\Carbon::now()->subDays(2),
            'estado' => 'pagado',
            'notas' => 'Transferencia interbancaria BCP.'
        ]);

        // 7. Seed Promotions / Campaigns
        \App\Models\Promocion::create([
            'titulo' => 'Campaña Escolar de Profilaxis',
            'descripcion' => 'Descuento del 20% en profilaxis completa para niños en edad escolar. Incluye fluorización de regalo.',
            'descuento_porcentaje' => 20,
            'fecha_inicio' => \Carbon\Carbon::now()->startOfMonth(),
            'fecha_fin' => \Carbon\Carbon::now()->endOfMonth(),
            'activo' => true
        ]);

        \App\Models\Promocion::create([
            'titulo' => 'Blanqueamiento Dental Día de la Madre',
            'descripcion' => 'Blanqueamiento led con 30% de descuento. Vuelve a sonreír con total confianza.',
            'descuento_porcentaje' => 30,
            'fecha_inicio' => \Carbon\Carbon::now()->subMonth()->startOfMonth(),
            'fecha_fin' => \Carbon\Carbon::now()->subMonth()->endOfMonth(), // Expired
            'activo' => true
        ]);

        // 8. Seed Casos de ?xito (Antes y Después)
        \App\Models\CasoExito::create([
            'titulo_tratamiento' => 'Diseño de Sonrisa con Carillas',
            'descripcion_resultado' => 'Paciente presentaba diastema y coloración irregular. Se colocaron carillas de porcelana de alta estética logrando simetría y brillo natural.',
            'categoria' => 'Estética Dental',
            'antes_img' => 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&q=80&w=600&h=450',
            'despues_img' => 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?auto=format&fit=crop&q=80&w=600&h=450',
            'activo' => true
        ]);

        \App\Models\CasoExito::create([
            'titulo_tratamiento' => 'Alineamiento con Ortodoncia',
            'descripcion_resultado' => 'Tratamiento de 18 meses para corregir apiñamiento severo y mordida cruzada anterior. Resultados funcionales y estéticos excelentes.',
            'categoria' => 'Ortodoncia',
            'antes_img' => 'https://images.unsplash.com/photo-1606811971618-4486d14f3f99?auto=format&fit=crop&q=80&w=600&h=450',
            'despues_img' => 'https://images.unsplash.com/photo-1513412893-c40d58525b6c?auto=format&fit=crop&q=80&w=600&h=450',
            'activo' => true
        ]);

        \App\Models\CasoExito::create([
            'titulo_tratamiento' => 'Blanqueamiento Dental Clínico',
            'descripcion_resultado' => 'Aclarado de 4 tonos en una sola sesión de blanqueamiento foto-activado. Esmalte fuerte y libre de manchas.',
            'categoria' => 'Estética Dental',
            'antes_img' => 'https://images.unsplash.com/photo-1579684453401-966b11832b44?auto=format&fit=crop&q=80&w=600&h=450',
            'despues_img' => 'https://images.unsplash.com/photo-1598256989800-fe5f95da9787?auto=format&fit=crop&q=80&w=600&h=450',
            'activo' => true
        ]);

        // 9. Seed Testimonios
        \App\Models\Testimonio::create([
            'nombre_paciente' => 'Juan Carlos R.',
            'testimonio' => 'La mejor experiencia dental. La Dra. Miranda me explicó todo el proceso para mis carillas y el resultado superó mis expectativas. ¡Muy profesional!',
            'fecha' => \Carbon\Carbon::now()->subDays(14),
            'estrellas' => 5,
            'activo' => true
        ]);

        \App\Models\Testimonio::create([
            'nombre_paciente' => 'María Fe O.',
            'testimonio' => 'Llevé a mi hijo para su limpieza y tratamiento de flúor. El trato fue sumamente cálido y paciente. El consultorio tiene un ambiente muy agradable y seguro.',
            'fecha' => \Carbon\Carbon::now()->subDays(30),
            'estrellas' => 5,
            'activo' => true
        ]);

        \App\Models\Testimonio::create([
            'nombre_paciente' => 'Roberto L.',
            'testimonio' => 'Me realicé una endodoncia de emergencia. No sentí ningún dolor gracias a la delicadeza de la doctora. Totalmente recomendada por su paciencia.',
            'fecha' => \Carbon\Carbon::now()->subDays(20),
            'estrellas' => 5,
            'activo' => true
        ]);
    }
}
