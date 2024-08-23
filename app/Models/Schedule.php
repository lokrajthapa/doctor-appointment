<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;


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
      return Carbon::parse($this->start_time)->format('g:i A').'-'.Carbon::parse($this->end_time)->format('g:i A');
   }

   public function getDateFormatAttribute()
   {

      return Carbon::parse($this->date)->format('l, F j');


   }

}
