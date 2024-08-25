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


    Route::resource('patients', PatientController::class);
    Route::resource('doctors', DoctorController::class);
    Route::resource('appointments', AppointmentController::class);

    //for appointment booking
    Route::get('doctorsToAppointment/{id}',[AppointmentController::class,'bookAppointment'])->name('doctor.to.appointment');
    Route::resource('schedules', ScheduleController::class);
    Route::resource('departments', DepartmentController::class);
    //for search
    Route::get('/search',[AppointmentController::class,'search']);

});

require __DIR__.'/auth.php';

