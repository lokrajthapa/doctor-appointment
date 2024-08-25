<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScheduleRequest;
use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;


class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $schedules = Auth::user()->doctor->schedules;
        return response()->json($schedules);


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('schedules.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreScheduleRequest $request) : JsonResponse
    {

      Schedule::create($request->all());
     return response()->json(['message'=>"Schedule created successfully"],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule) : JsonResponse
    {
       return response()->json($schedule);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Schedule $schedule): JsonResponse
    {

      $schedule->update($request->all());

       return response()->json(['message'=>"Schedule updated successfully"],201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule): JsonResponse
    {
        $schedule->delete();

       return response()->json(['message'=>"Schedule deleted successfuly"],200);
    }
}
