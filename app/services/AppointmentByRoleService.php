<?php

namespace App\services;
use Illuminate\Support\Facades\Auth;


class AppointmentByRoleService
{
    /**
     * Create a new class instance.
     */
    protected $user;

    public function __construct()
    {
        $user=Auth::user();
    }

    public function appointmentIndex()
    {
      if($this->user->user_type==='doctor')

            $appointments =  $this->user->doctor->appointments;
      else
      {
            $appointments = $this->user->patient->appointments;
      }

    }
}
