<?php

namespace App\services;
use Illuminate\Support\Facades\Auth;

class AppointmentSearchService
{
    /**
     * Create a new class instance.
     */
    protected $user;


    public function __construct()
    {

        $this->user=Auth::user();

    }

    public function searchAppointment($request)
    {

        $appointments = $this->user->doctor->appointments()->whereDate('appointment_time', $request->date)->get();

    }

}

