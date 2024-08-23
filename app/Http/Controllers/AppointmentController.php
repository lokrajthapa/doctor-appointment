<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;


use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Mail\AppointmentScheduledEmail;
use App\Models\Department;
use App\services\AppointmentSearchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{
    use AuthorizesRequests;
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

        $departments=Department::with(['doctors','doctors.user','doctors.schedules'])->get()->toArray();

        return view('appointments.create', compact('departments'));


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppointmentRequest $request)
    {


        $appointment=Appointment::create($request->all());
        $doctor_email=$appointment->doctor->user->email;


      Mail::to(Auth::user())->queue(new AppointmentScheduledEmail($appointment));

    //mail for doctor
        Mail::to($doctor_email)->queue(new AppointmentScheduledEmail($appointment));

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
    public function edit($id)
    {

        $appointment = Appointment::findOrFail($id);

        $this->authorize('edit', $appointment);

        return view('appointments.edit', compact('appointment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAppointmentRequest $request, $id)
    {

        $appointment = Appointment::findOrFail($id);
        $this->authorize('update', $appointment);

        $appointment->update($request->all());
        return redirect()->route('appointments.index')->with('success', 'Appointment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {

        $appointment = Appointment::findOrFail($appointment->id);
        $this->authorize('delete', $appointment);

        $appointment->delete();

        return redirect()->route('appointments.index')->with('success', 'Appointment deleted successfully.');
    }

    public function search(Request $request)
    {
//TODO:  make this search functionality inside index
        $request->validate([
            'date'=>'required | date',
        ]);

      $appointments = new AppointmentSearchService();

      $appointments->searchAppointment($request);
      return view('appointments.index', compact('appointments'));

    }

    public function bookAppointment($id)
    {
        $doctor=Doctor::with(['schedules'])->findorfail($id);

         return view('appointments.create', compact('doctor'));
    }
}
