<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'department_id',
        'bio',
        'address',

    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function department():BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function appointments():HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function schedules():HasMany
    {
        return $this->hasMany(Schedule::class);
    }


}
