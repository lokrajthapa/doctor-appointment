<?php

use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\DepartmentController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

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





        //  // Handle the image upload


