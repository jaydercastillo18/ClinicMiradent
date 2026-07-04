<?php

namespace App\Policies;

use App\Models\Paciente;
use App\Models\User;

class PatientPolicy
{
    /**
     * Determine whether the user can view basic data of the patient.
     */
    public function viewBasicData(User $user, Paciente $paciente): bool
    {
        return in_array($user->role, ['doctora', 'asistente']);
    }

    /**
     * Determine whether the user can view clinical data of the patient.
     */
    public function viewClinicalData(User $user, Paciente $paciente): bool
    {
        return $user->role === 'doctora';
    }

    /**
     * Determine whether the user can update basic data of the patient.
     */
    public function updateBasicData(User $user, Paciente $paciente): bool
    {
        return in_array($user->role, ['doctora', 'asistente']);
    }

    /**
     * Determine whether the user can update clinical data of the patient.
     */
    public function updateClinicalData(User $user, Paciente $paciente): bool
    {
        return $user->role === 'doctora';
    }

    /**
     * Determine whether the user can delete the patient.
     */
    public function delete(User $user, Paciente $paciente): bool
    {
        return $user->role === 'doctora';
    }
}
