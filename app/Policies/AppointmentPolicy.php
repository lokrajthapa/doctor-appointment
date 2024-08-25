<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;
use App\Models\Doctor;
use Illuminate\Auth\Access\Response;


class AppointmentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Doctor $doctor, Appointment $appointment): bool
    {
        return $doctor->id === $appointment->doctor_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Doctor $doctor, Appointment $appointment): bool
    {
        return $doctor->id === $appointment->doctor_id;
    }

    /**
     * Determine whether the Doctor can update the model.
     */
    public function edit(User $user, Appointment $appointment): bool
    {
        return $user->doctor->id=== $appointment->doctor_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Appointment $appointment): bool
    {
        return $user->doctor->id=== $appointment->doctor_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Appointment $appointment): bool
    {
        return $user->doctor->id === $appointment->doctor_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Appointment $appointment): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Appointment $appointment): bool
    {
        //
    }
}
