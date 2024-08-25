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
use App\services\AppointmentByRoleService;
use App\services\AppointmentSearchService;
use Illuminate\Http\JsonResponse;
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

    public function index():JsonResponse

    {

        $appointments= new AppointmentByRoleService();
        $appointments->appointmentIndex();

        return response()->json($appointments,200);


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

       // not done anything


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppointmentRequest $request):JsonResponse
    {


        $appointment=Appointment::create($request->all());
        $doctor_email=$appointment->doctor->user->email;


      Mail::to(Auth::user())->queue(new AppointmentScheduledEmail($appointment));

    //mail for doctor
        Mail::to($doctor_email)->queue(new AppointmentScheduledEmail($appointment));
        return response()->json("Appointment created successfully ", 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment):JsonResponse
    {
        $appointment = Appointment::with(['patient', 'doctor'])->findOrFail($appointment);
        return response()->json($appointment);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id):JsonResponse
    {

        $appointment = Appointment::findOrFail($id);

        $this->authorize('edit', $appointment);

        return response()->json($appointment);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAppointmentRequest $request, $id):JsonResponse
    {

        $appointment = Appointment::findOrFail($id);
        $this->authorize('update', $appointment);

        $appointment->update($request->all());
        return response()->json(["message"=>"Doctor deleted successfully "], 201);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment):JsonResponse
    {

        $appointment = Appointment::findOrFail($appointment->id);
        $this->authorize('delete', $appointment);
        $appointment->delete();
        return response()->json("Appointment deleted successfully ", 200);
    }

    public function search(Request $request):JsonResponse
    {

        $request->validate([
            'date'=>'required | date',
        ]);

      $appointments = new AppointmentSearchService();
      $appointments->searchAppointment($request);
      return response()->json($appointments, 200);

    }

    public function bookAppointment($id):JsonResponse
    {
        $doctor=Doctor::with(['schedules'])->findorfail($id);

        return response()->json($doctor, 200);
    }
}
