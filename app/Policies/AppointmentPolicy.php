<?php

namespace App\Policies;

use App\Models\Cita;
use App\Models\User;

class AppointmentPolicy
{
    /**
     * Determine whether the user can view the appointment.
     */
    public function view(User $user, Cita $cita): bool
    {
        return in_array($user->role, ['doctora', 'asistente']);
    }

    /**
     * Determine whether the user can view clinical data of the appointment.
     */
    public function viewClinicalData(User $user, Cita $cita): bool
    {
        return $user->role === 'doctora';
    }

    /**
     * Determine whether the user can update the schedule or basic data of the appointment.
     */
    public function updateSchedule(User $user, Cita $cita): bool
    {
        return in_array($user->role, ['doctora', 'asistente']);
    }

    /**
     * Determine whether the user can update the diagnosis or clinical data of the appointment.
     */
    public function updateDiagnosis(User $user, Cita $cita): bool
    {
        return $user->role === 'doctora';
    }

    /**
     * Determine whether the user can delete the appointment.
     */
    public function delete(User $user, Cita $cita): bool
    {
        return $user->role === 'doctora';
    }
}
