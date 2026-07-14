<?php

namespace App\Providers;

use App\Models\CasoExito;
use App\Models\Cita;
use App\Models\Gasto;
use App\Models\Paciente;
use App\Models\Pago;
use App\Models\Promocion;
use App\Models\Servicio;
use App\Models\Testimonio;
use App\Observers\AuditObserver;
use App\Services\DoctoraService;
use App\ViewModels\DoctoraViewModel;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Policies\PatientPolicy;
use App\Policies\AppointmentPolicy;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if (file_exists(app_path('helpers.php'))) {
            require_once app_path('helpers.php');
        }
    }

    public function boot(): void
    {
        \Illuminate\Support\Facades\URL::forceScheme('https');
        Paginator::useTailwind();

        RateLimiter::for('global', function (Request $request) {
            return Limit::perMinute(100)->by($request->user()?->id ?: $request->ip());
        });

        Gate::policy(Paciente::class, PatientPolicy::class);
        Gate::policy(Cita::class, AppointmentPolicy::class);

        Paciente::observe(AuditObserver::class);
        Cita::observe(AuditObserver::class);
        Pago::observe(AuditObserver::class);
        Gasto::observe(AuditObserver::class);
        Servicio::observe(AuditObserver::class);
        Promocion::observe(AuditObserver::class);
        CasoExito::observe(AuditObserver::class);
        Testimonio::observe(AuditObserver::class);

        View::composer(
            ['layouts.public', 'partials.navbar', 'welcome', 'public_servicios', 'public_promociones', 'public_contacto'],
            function ($view): void {
                $data = $view->getData();
                $currentDoctora = $data['doctora'] ?? null;

                $doctora = $currentDoctora instanceof DoctoraViewModel
                    ? $currentDoctora
                    : app(DoctoraService::class)->getPublicProfile();

                $view->with([
                    'doctora' => $doctora,
                    'estadoClinica' => $data['estadoClinica'] ?? $doctora->estado_clinica,
                    'publicAssets' => (object) [
                        'favicon' => asset('images/miradent_icono_vectorizado.svg'),
                        'logo' => asset('images/miradent_logo_vectorizado.svg'),
                        'year' => now()->year,
                    ],
                ]);
            }
        );
    }
}
