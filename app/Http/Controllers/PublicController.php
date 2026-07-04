<?php

namespace App\Http\Controllers;

use App\Models\Instalacion;
use App\Models\Promocion;
use App\Models\Servicio;
use App\Models\SiteSetting;
use App\Services\CasoExitoService;
use App\Services\DoctoraService;
use App\Services\PromocionService;
use App\Services\ServicioService;
use App\Services\TestimonioService;
use App\ViewModels\PromocionViewModel;
use App\ViewModels\ServicioViewModel;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function __construct(
        private DoctoraService $doctoraService,
        private ServicioService $servicioService,
        private PromocionService $promocionService,
        private CasoExitoService $casoExitoService,
        private TestimonioService $testimonioService,
    ) {}

    public function home(Request $request)
    {
        $doctora = $this->doctoraService->getPublicProfile();
        $servicios = $this->servicioService->getForHome($doctora);
        $promociones = $this->promocionService->getForHome($doctora);
        $casosExito = $this->casoExitoService->getForHome();
        $testimonios = $this->testimonioService->getForHome();
        $instalaciones = Instalacion::where('activo', true)->orderBy('orden')->orderBy('created_at', 'desc')->get();

        $estadoClinica = $doctora->estado_clinica;

        // Las 4 cosas más importantes que la gente busca (editables fácilmente desde aquí o panel admin futuro)
        $loMasImportante = [
            [
                'icon' => 'zap',
                'title' => 'Sin dolor y tecnología avanzada',
                'desc' => 'Procedimientos con anestesia de última generación y equipos modernos para tu comodidad.'
            ],
            [
                'icon' => 'leaf',
                'title' => 'Resultados naturales',
                'desc' => 'Sonrisas armónicas que realzan tu belleza sin parecer artificiales.'
            ],
            [
                'icon' => 'heart',
                'title' => 'Atención 100% personalizada',
                'desc' => 'Escuchamos tu historia y diseñamos un plan único para tus necesidades.'
            ],
            [
                'icon' => 'clock',
                'title' => 'Rapidez y facilidades',
                'desc' => 'Diagnóstico en la primera visita y opciones de pago flexibles.'
            ],
        ];

        if ($this->shouldReturnJson($request)) {
            return response()->json([
                'servicios' => $servicios->map->toArray()->values(),
                'promociones' => $promociones->map->toArray()->values(),
                'estado_clinica' => $estadoClinica,
                'casos_exito' => $casosExito->map->toArray()->values(),
                'testimonios' => $testimonios,
                'instalaciones' => $instalaciones,
                'lo_mas_importante' => $loMasImportante,
            ]);
        }

        return view('welcome', compact('servicios', 'promociones', 'doctora', 'casosExito', 'testimonios', 'instalaciones', 'estadoClinica', 'loMasImportante'));
    }

    public function servicios(Request $request)
    {
        $search = trim((string) ($request->query('search') ?? $request->query('buscar', '')));
        $category = $request->query('category');

        if ($this->shouldReturnJson($request)) {
            $servicios = $this->servicioService->getPaginated($search, $category);

            return $this->paginatedJson($servicios, fn (Servicio $servicio): array => (new ServicioViewModel($servicio))->toArray(), [
                'categorias' => $this->servicioService->getCategorias(),
            ]);
        }

        $doctora = $this->doctoraService->getPublicProfile();
        $servicios = $this->servicioService->getFiltered($search, $category, $doctora);
        $categorias = $this->servicioService->getCategorias();
        $categoriaFiltros = $this->servicioService->buildCategoryFilters($categorias, $search, $category);

        return view('public_servicios', compact('servicios', 'categoriaFiltros', 'search', 'doctora'));
    }

    public function promociones(Request $request)
    {
        if ($this->shouldReturnJson($request)) {
            $promociones = $this->promocionService->getActivePaginated();

            return $this->paginatedJson($promociones, fn (Promocion $promocion): array => (new PromocionViewModel($promocion))->toArray());
        }

        $doctora = $this->doctoraService->getPublicProfile();
        $promociones = $this->promocionService->getActive($doctora);

        return view('public_promociones', compact('promociones', 'doctora'));
    }

    public function contacto(Request $request)
    {
        $doctora = $this->doctoraService->getPublicProfile();
        $horarios = $doctora->horario_items;
        $estadoClinica = $doctora->estado_clinica;

        if ($this->shouldReturnJson($request)) {
            return response()->json([
                'doctora' => $doctora->toArray(),
                'horarios' => $horarios,
                'estado_clinica' => $estadoClinica,
            ]);
        }

        return view('public_contacto', compact('doctora', 'horarios', 'estadoClinica'));
    }

    public function casosExito(Request $request)
    {
        $doctora = $this->doctoraService->getPublicProfile();
        $casosExito = $this->casoExitoService->getForHome();

        if ($this->shouldReturnJson($request)) {
            return response()->json(['casos_exito' => $casosExito->map->toArray()->values()]);
        }

        return view('public_casos', compact('casosExito', 'doctora'));
    }

    public function testimonios(Request $request)
    {
        $doctora = $this->doctoraService->getPublicProfile();
        $testimonios = $this->testimonioService->getForHome();

        if ($this->shouldReturnJson($request)) {
            return response()->json(['testimonios' => $testimonios]);
        }

        return view('public_testimonios', compact('testimonios', 'doctora'));
    }

    public function horarios(Request $request)
    {
        $doctora = $this->doctoraService->getPublicProfile();
        $estadoClinica = $doctora->estado_clinica;
        $diasMap = [1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles', 4 => 'Jueves', 5 => 'Viernes', 6 => 'Sábado', 7 => 'Domingo'];
        $hoy = $diasMap[now()->dayOfWeekIso] ?? null;

        if ($this->shouldReturnJson($request)) {
            return response()->json([
                'horarios' => $doctora->horario_items,
                'estado_clinica' => $estadoClinica,
            ]);
        }

        return view('public_horarios', compact('doctora', 'estadoClinica', 'hoy'));
    }

    public function reservarCita()
    {
        $doctora = $this->doctoraService->getPublicProfile();
        $yapeQrUrl = SiteSetting::yapeQrUrl();
        $yapePhone = SiteSetting::get('yape_phone');

        return view('reservar_cita', compact('doctora', 'yapeQrUrl', 'yapePhone'));
    }

    public function validarReferido(Request $request)
    {
        $request->validate([
            'referido_nombre' => ['required', 'string', 'min:3', 'max:150'],
            'referido_dni'    => ['nullable', 'digits:8'],
        ]);

        $dni    = $request->referido_dni;
        $nombre = $request->referido_nombre;

        $valido = false;
        $nombreBuscado = preg_replace('/\s+/', ' ', mb_strtolower(trim($nombre)));

        if ($dni) {
            // IF nombre + DNI
            $paciente = \App\Models\Paciente::where('dni', $dni)->first();
            
            if ($paciente) {
                $nombreGuardado = preg_replace('/\s+/', ' ', mb_strtolower(trim($paciente->nombre . ' ' . $paciente->apellido)));
                $valido = ($nombreGuardado === $nombreBuscado);
            }
        } else {
            // IF solo nombre
            $valido = \App\Models\Paciente::get()->contains(function ($paciente) use ($nombreBuscado) {
                $nombreGuardado = preg_replace('/\s+/', ' ', mb_strtolower(trim($paciente->nombre . ' ' . $paciente->apellido)));
                return $nombreGuardado === $nombreBuscado;
            });
        }

        // Respuesta deliberadamente ambigua: nunca indicar qué campo falló
        // ni devolver ningún dato del paciente (nombre, id, teléfono, etc.)
        return response()->json([
            'success' => true,
            'valid'   => $valido,
            'message' => $valido
                ? 'Referido validado correctamente.'
                : 'No se pudo validar al paciente referido.',
        ]);
    }

    public function showServicio(int $id)
    {
        $servicio = $this->servicioService->findById($id);

        if ($servicio && $servicio->activo) {
            return redirect()->route('public.servicios', ['search' => $servicio->nombre]);
        }

        return redirect()->route('public.servicios');
    }

    public function nosotros(Request $request)
    {
        $doctora = $this->doctoraService->getPublicProfile();
        $estadoClinica = $doctora->estado_clinica;

        return view('public_doctora', compact('doctora', 'estadoClinica'));
    }
}
