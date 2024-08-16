<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    use HasFactory;

   protected $fillable= ['doctor_id','date','start_time','end_time'];

   public function doctor():BelongsTo
   {
       return $this->belongsTo(Doctor::class);
   }


   public function getDateLengthAttribute()
   {
      return $this->start_time.'-'.$this->end_time;
   }
}
