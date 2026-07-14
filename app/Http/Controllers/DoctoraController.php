<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoctoraConfigRequest;
use App\Http\Requests\DoctoraProfileRequest;
use App\Models\Doctora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use App\Services\ImageUploadService;

class DoctoraController extends Controller
{
    /**
     * Display the doctor/clinic configuration form.
     */
    public function config()
    {
        $doctora = Auth::user()->doctora ?? Doctora::first();

        // Parse working hours JSON, or set a default schedule
        $schedule = [];
        if ($doctora && $doctora->horario_atencion) {
            $schedule = json_decode($doctora->horario_atencion, true);
        }

        // Default schedule if empty
        if (empty($schedule)) {
            $days = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
            foreach ($days as $day) {
                $schedule[$day] = [
                    'activo'  => !in_array($day, ['Sábado', 'Domingo']),
                    'inicio'  => '09:00',
                    'fin'     => '12:00',
                    'turno2'  => !in_array($day, ['Sábado', 'Domingo']),
                    'inicio2' => '16:00',
                    'fin2'    => '20:00',
                ];
            }
        }

        return view('configuracion', compact('doctora', 'schedule'));
    }

    /**
     * Update configuration details (working hours, security password).
     */
    public function updateConfig(DoctoraConfigRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $doctora = $user->doctora ?? Doctora::first();

        // Update working hours
        if ($doctora) {
            $formattedSchedule = [];
            $days = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

            foreach ($days as $day) {
                $dayData = $request->horario[$day] ?? [];
                $activo  = isset($dayData['activo'])  && $dayData['activo']  == '1';
                $turno2  = isset($dayData['turno2'])  && $dayData['turno2']  == '1';

                $formattedSchedule[$day] = [
                    'activo'  => $activo,
                    'inicio'  => $dayData['inicio']  ?? '09:00',
                    'fin'     => $dayData['fin']     ?? '12:00',
                    'turno2'  => $turno2,
                    'inicio2' => $dayData['inicio2'] ?? '16:00',
                    'fin2'    => $dayData['fin2']    ?? '20:00',
                ];
            }

            $doctora->horario_atencion = json_encode($formattedSchedule);
            $doctora->save();
        }

        // Update password if requested
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'La contraseña actual no es correcta.']);
            }

            $user->password = Hash::make($request->new_password);
            $user->save();
        }

        return redirect()->route('doctora.config')->with('success', 'Configuración actualizada correctamente.');
    }

    /**
     * Display the doctor profile page.
     */
    public function profile()
    {
        $doctora = Auth::user()->doctora ?? Doctora::first();
        return view('doctora', compact('doctora'));
    }

    /**
     * Update doctor profile details.
     */
    public function updateProfile(DoctoraProfileRequest $request, ImageUploadService $imageService)
    {
        try {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $doctora = $user->doctora;

            // Update User
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

            // Update or Create Doctora profile
            if (!$doctora) {
                $doctora = Doctora::first() ?? new Doctora();
                if (!$doctora->exists) {
                    $doctora->user_id = $user->id;
                }
            }

            $doctora->especialidad = $request->especialidad;
            $doctora->COP = $request->COP;
            $doctora->telefono = $request->telefono;
            $doctora->bio = $request->bio;
            if ($request->hasFile('avatar')) {
                $doctora->avatar = $imageService->uploadCustomName($request->file('avatar'), 'uploads/doctora', 'avatar.jpg', 800, 85);
            }

            $doctora->save();

            return $this->savedResponse($request, 'doctora.profile', 'Perfil profesional actualizado correctamente.');
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Error in DoctoraController@updateProfile: ' . $e->getMessage());
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al guardar: ' . $e->getMessage()
                ], 500);
            }
            throw $e;
        }
    }
}
