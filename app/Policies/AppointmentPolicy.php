<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;
use App\Models\Doctor;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class AppointmentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {

        return $user->isAdmin() || Auth::user()->patient()->exists() || Auth::user()->doctor()->exists();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(): bool
    {
        return true;
        // return $doctor->id === $appointment->doctor_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
       return $user->isAdmin()|| $user->isPatient();
    }

    /**
     * Determine whether the Doctor can update the model.
     */
    public function edit(): bool
    {
        return true;
        // return $user->doctor->id=== $appointment->doctor_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(): bool
    {
        return true;
        // return $user->doctor->id=== $appointment->doctor_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete( ): bool
    {
        return true;
        // return $user->doctor->id === $appointment->doctor_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore( ): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete( Appointment $appointment): bool
    {
        return true;
    }
}
