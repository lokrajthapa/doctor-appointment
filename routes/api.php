<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\DepartmentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {

 Route::apiResource('patients', PatientController::class);
 Route::apiResource('doctors', DoctorController::class);
 Route::apiResource('appointments', AppointmentController::class);
 Route::get('doctorsToAppointment/{id}', [AppointmentController::class, 'bookAppointment'])
     ->name('doctor.to.appointment');
 Route::apiResource('schedules', ScheduleController::class);
 Route::apiResource('departments', DepartmentController::class);
 Route::get('/search', [AppointmentController::class, 'search']);

});

require __DIR__.'/auth.php';

