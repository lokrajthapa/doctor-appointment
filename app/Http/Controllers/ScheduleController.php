<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScheduleRequest;
use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ScheduleResource;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Info(
 *    title="Laravel v11 API",
 *    version="1.0.0"
 * )
 *
 * @OA\Schema(
 *     schema="Schedule",
 *     type="object",
 *     title="Schedule",
 *     description="A schedule model",
 *     required={"id","doctor_id","date","start_time","end_time"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The unique identifier of the schedule"
 *     ),
 *     @OA\Property(
 *         property="doctor_id",
 *         type="integer",
 *         description="The ID of the doctor associated with the schedule"
 *     ),
 *     @OA\Property(
 *         property="date",
 *         type="string",
 *         format="date",
 *         description="The date of the schedule"
 *     ),
 *     @OA\Property(
 *         property="start_time",
 *         type="string",
 *         format="time",
 *         description="The start time of the schedule"
 *     ),
 *      @OA\Property(
 *         property="end_time",
 *         type="string",
 *         format="time",
 *         description="The end time of the schedule"
 *     )
 * )
 *
 *  @OA\Schema(
 *     schema="StoreScheduleRequest",
 *     type="object",
 *     title="Store Schedule Request",
 *     description="Schema for storing a schedule",
 *     required={"doctor_id", "date", "start_time", "end_time"},
 *     @OA\Property(
 *         property="doctor_id",
 *         type="integer",
 *         description="The ID of the doctor associated with the schedule"
 *     ),
 *     @OA\Property(
 *         property="date",
 *         type="string",
 *         format="date",
 *         description="The date of the schedule"
 *     ),
 *     @OA\Property(
 *         property="start_time",
 *         type="string",
 *         format="time",
 *         description="The start time of the schedule"
 *     ),
 *     @OA\Property(
 *         property="end_time",
 *         type="string",
 *         format="time",
 *         description="The end time of the schedule"
 *     )
 * )
 */




class ScheduleController extends Controller
{
   /**
     * @OA\Get(
     *     path="/api/schedules",
     *     tags={"Schedules"},
     *     summary="Get all schedules",
     *     description="Retrieve a list of all schedules associated with the authenticated doctor.",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Schedule")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */

    public function index()
    {
        $schedules = Auth::user()->doctor->schedules;
        return  ScheduleResource::collection($schedules);


    }




   /**
     * @OA\Post(
     *     path="/api/schedules",
     *     tags={"Schedules"},
     *     summary="Create a new schedule",
     *     description="Store a newly created schedule in the database.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              required={"doctor_id", "date", "start_time", "end_time"},
     *             @OA\Property(property="doctor_id", type="integer", example=1, description="ID of the doctor"),
     *             @OA\Property(property="date", type="string", format="date", example="2024-08-26", description="Date of the schedule"),
     *             @OA\Property(property="start_time", type="string", format="time", example="09:00", description="Start time of the schedule"),
     *             @OA\Property(property="end_time", type="string", format="time", example="12:00", description="End time of the schedule"),
     *           )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Schedule created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Schedule")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */
    public function store(StoreScheduleRequest $request)
    {

      $schedules = Schedule::create($request->all());

      return new ScheduleResource($schedules);
    }

        /**
     * @OA\Get(
     *     path="/api/schedules/{id}",
     *     tags={"Schedules"},
     *     summary="Get a specific schedule",
     *     description="Retrieve a specific schedule by its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Schedule")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Schedule not found"
     *     )
     * )
     */
    public function show(Schedule $schedule)
    {
        return new ScheduleResource($schedule);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule)
    {
        return new ScheduleResource($schedule);
    }

    /**
     * @OA\Put(
     *     path="/api/schedules/{id}",
     *     tags={"Schedules"},
     *     summary="Update a specific schedule",
     *     description="Update the details of an existing schedule.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Schedule")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Schedule updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Schedule")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Schedule not found"
     *     )
     * )
     */
    public function update(Request $request, Schedule $schedule)
    {

      $schedule->update($request->all());

      return new ScheduleResource($schedule);
    }

      /**
     * @OA\Delete(
     *     path="/api/schedules/{id}",
     *     tags={"Schedules"},
     *     summary="Delete a specific schedule",
     *     description="Delete a schedule by its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Schedule deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Schedule deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Schedule not found"
     *     )
     * )
     */
    public function destroy(Schedule $schedule): JsonResponse
    {
        $schedule->delete();

       return response()->json(['message'=>"Schedule deleted successfuly"],200);
    }
}
