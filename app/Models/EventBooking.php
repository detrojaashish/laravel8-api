<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
class EventBooking extends Model
{

	 use SoftDeletes;

	    protected $guarded = ['id'];

	    public function getBookingTimeAttribute($value)
		{
		    return Carbon::parse($value)->format('H:i');
		}
}
