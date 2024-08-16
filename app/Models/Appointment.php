<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_time',
        'department_name',
        'reason',
    ];

    public function patient():BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor():BelongsTo
    {
        return $this->belongsTo(Doctor::class);

    }

    public function getTimeFormatAttribute()
    {

       return Carbon::parse($this->appointment_time)->format('l, F j'). ',' .Carbon::parse($this->appointment_time)->format('g:i A');


    }




}
