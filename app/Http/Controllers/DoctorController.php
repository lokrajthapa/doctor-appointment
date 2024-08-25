<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Models\Department;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;




class DoctorController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $doctors = Doctor::with(['user', 'department'])->get();
       return response()->json( $doctors,200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():  JsonResponse
    {
        $departments=Department::all();

         return response()->json( $departments,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDoctorRequest $request): JsonResponse
    {
         Doctor::create($request->all());
         return response()->json( "Doctor created successfully",201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor): JsonResponse
    {
        return response()->json( $doctor,200);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor): JsonResponse
    {

        $this->authorize('edit', $doctor);

        return response()->json($doctor, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDoctorRequest $request, Doctor $doctor): JsonResponse
    {
        $this->authorize('update', $doctor);
        $doctor->update($request->all());
        return response()->json("Doctor successfully updated", 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        $this->authorize('delete', $doctor);
        $doctor->delete();
        return response()->json("Doctor deleted successfully ", 200);
    }
}
