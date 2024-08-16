<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;

use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Mail\AppointmentScheduledEmail;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   protected $user;

   public function __construct()
   {
      $this->user=Auth::user();
   }

    public function index()
    {
        $user=Auth::user();

        if($this->user->user_type==='doctor')

          $appointments =  $this->user->doctor->appointments;

        else if(Auth::user()->user_type==='patient')
        {
            $appointments = $this->user->patient->appointments;
        }
        else
        {
            $appointments = Appointment::with(['patient', 'doctor'])->get();
        }

        return view('appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $patients = Patient::all();
        // $doctors = Doctor::all();
        $departments=Department::with(['doctors','doctors.user','doctors.schedules'])->get()->toArray();

        return view('appointments.create', compact('departments'));


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $appointment=Appointment::create($request->all());
        //$doctor_email=$appointment->doctor->user->email;

   //mail for patient conformation
      //Mail::to(Auth::user())->queue(new AppointmentScheduledEmail($appointment));

    //mail for doctor
        //Mail::to($doctor_email)->queue(new AppointmentScheduledEmail($appointment));

        return redirect()->route('appointments.index')->with('success', 'Appointment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        $appointment = Appointment::with(['patient', 'doctor'])->findOrFail($appointment);
        return view('appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        $appointment = Appointment::findOrFail($appointment);
        $patients = Patient::all();
        $doctors = Doctor::all();
        return view('appointments.edit', compact('appointment', 'patients', 'doctors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {

        $appointment = Appointment::findOrFail($appointment);
        $appointment->update($request->all());
        return redirect()->route('appointments.index')->with('success', 'Appointment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {

        $appointment = Appointment::findOrFail($appointment->id);


        $appointment->delete();

        return redirect()->route('appointments.index')->with('success', 'Appointment deleted successfully.');
    }

    public function search(Request $request)
    {

        $request->validate([
            'date'=>'required | date',
        ]);
        $date=$request->date;
        $appointments = $this->user->doctor->appointments()->whereDate('appointment_time', $date)->get();
        return view('appointments.index', compact('appointments'));
    }
}
