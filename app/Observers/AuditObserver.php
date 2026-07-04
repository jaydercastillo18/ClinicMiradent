<?php

namespace App\Observers;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuditObserver
{
    /**
     * Helper to log actions
     */
    protected function logAction(Model $model, string $action)
    {
        // Don't log if running from console/seeder or no authenticated user
        if (!Auth::check()) {
            return;
        }

        try {
            AuditLog::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'model_type' => get_class($model),
                'model_id' => $model->id,
                'details' => json_encode($model->getChanges() ?: $model->toArray()),
                'ip_address' => request()->ip(),
            ]);
        } catch (\Throwable $e) {
            // Un fallo al registrar la auditoría nunca debe impedir que se
            // complete la operación de negocio (crear/editar/eliminar) que la disparó.
            Log::error('AuditObserver: failed to write audit log', [
                'action'     => $action,
                'model_type' => get_class($model),
                'model_id'   => $model->id ?? null,
                'error'      => $e->getMessage(),
            ]);
            report($e);
        }
    }

    public function created(Model $model): void
    {
        $this->logAction($model, 'created');
    }

    public function updated(Model $model): void
    {
        $this->logAction($model, 'updated');
    }

    public function deleted(Model $model): void
    {
        $this->logAction($model, 'deleted');
    }

    public function restored(Model $model): void
    {
        $this->logAction($model, 'restored');
    }

    public function forceDeleted(Model $model): void
    {
        $this->logAction($model, 'forceDeleted');
    }
}
