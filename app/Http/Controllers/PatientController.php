<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use Illuminate\Support\Facades\Gate;


class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = Patient::with('user')->get(); // Retrieve all patients with associated user
        return view('patients.index', compact('patients'));
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
    public function store(StorePatientRequest $request)
    {
        Patient::create($request->all());

        return redirect(route('dashboard', absolute: false));


    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        return view('patients.create');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        // Gate::authorize('edit', $patient);
        return view('patients.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        // Gate::authorize('update', $patient);
        $patient->update($request->all());
         return redirect()->route('dashboard')->with('success', 'Patient updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('patients.index')->with('success', 'Patient deleted successfully.');
    }
}
