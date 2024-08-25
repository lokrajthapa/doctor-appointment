<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;




class PatientController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index():JsonResponse
    {
        $patients = Patient::with('user')->get();

        return response()->json($patients,200 );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePatientRequest $request):JsonResponse
    {
        Patient::create($request->all());
        return response()->json("patient created successfuly",200 );

    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient): JsonResponse
    {
        return response()->json($patient);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        $this->authorize('edit', $patient);

          return response()->json($patient);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatientRequest $request, Patient $patient): JsonResponse
    {
        $this->authorize('edit', $patient);
        $patient->update($request->all());

        return response()->json(["message"=>"patient updated successfuly"],200 );

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient):JsonResponse
    {
        $this->authorize('delete', $patient);
        $patient->delete();
        return response()->json(["message"=>"Patient deleted successfully"],200);
    }
}
