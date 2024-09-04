<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;



/**
 * @OA\Schema(
 *     schema="Patient",
 *     type="object",
 *     title="Patient",
 *     description="A patient model",
 *     required={"id", "user_id", "dob", "gender", "phone"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The unique identifier of the patient"
 *     ),
 *     @OA\Property(
 *         property="user_id",
 *         type="integer",
 *         description="The ID of the user associated with the patient"
 *     ),
 *     @OA\Property(
 *         property="dob",
 *         type="string",
 *         format="date",
 *         description="The date of birth of the patient"
 *     ),
 *     @OA\Property(
 *         property="gender",
 *         type="string",
 *         enum={"male", "female", "other"},
 *         description="The gender of the patient"
 *     ),
 *     @OA\Property(
 *         property="phone",
 *         type="string",
 *         description="The phone number of the patient"
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="StorePatientRequest",
 *     type="object",
 *     title="Store Patient Request",
 *     description="Schema for storing a patient",
 *     required={"user_id", "dob", "gender", "phone"},
 *     @OA\Property(
 *         property="user_id",
 *         type="integer",
 *         description="The ID of the user associated with the patient"
 *     ),
 *     @OA\Property(
 *         property="dob",
 *         type="string",
 *         format="date",
 *         description="The date of birth of the patient"
 *     ),
 *     @OA\Property(
 *         property="gender",
 *         type="string",
 *         enum={"male", "female", "other"},
 *         description="The gender of the patient"
 *     ),
 *     @OA\Property(
 *         property="phone",
 *         type="string",
 *         description="The phone number of the patient"
 *     )
 * )
 */

class PatientController extends Controller
{
    use AuthorizesRequests;
    /**
     * @OA\Get(
     *     path="/api/patients",
     *     tags={"Patients"},
     *     summary="Get all patients",
     *     description="Retrieve a list of all patients.",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Patient")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
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
     * @OA\Post(
     *     path="/api/patients",
     *     tags={"Patients"},
     *     summary="Create a new patient",
     *     description="Store a newly created patient in the database.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StorePatientRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Patient created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Patient")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */
    public function store(StorePatientRequest $request):JsonResponse
    {
        Patient::create($request->all());
        return response()->json("patient created successfuly",200 );

    }

       /**
     * @OA\Get(
     *     path="/api/patients/{id}",
     *     tags={"Patients"},
     *     summary="Get a specific patient",
     *     description="Retrieve a specific patient by its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Patient")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Patient not found"
     *     )
     * )
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
     * @OA\Put(
     *     path="/api/patients/{id}",
     *     tags={"Patients"},
     *     summary="Update a specific patient",
     *     description="Update the details of an existing patient.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StorePatientRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Patient updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Patient")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Patient not found"
     *     )
     * )
     */
    public function update(UpdatePatientRequest $request, Patient $patient): JsonResponse
    {
        $this->authorize('update', $patient);
        $patient->update($request->all());

        return response()->json(["message"=>"patient updated successfuly"],200 );

    }

 /**
     * @OA\Delete(
     *     path="/api/patients/{id}",
     *     tags={"Patients"},
     *     summary="Delete a specific patient",
     *     description="Delete a patient by its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Patient deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Patient deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Patient not found"
     *     )
     * )
     */
    public function destroy(Patient $patient):JsonResponse
    {
        $this->authorize('delete', $patient);
        $patient->delete();
        return response()->json(["message"=>"Patient deleted successfully"],200);
    }
}
