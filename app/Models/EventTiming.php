<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class EventTiming extends Model
{

        
    public $timestamps = false;

    public function getAvailableFromAttribute($value)
	{
	    return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
	}
	public function getAvailableToAttribute($value)
	{
	    return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
	}

	 public function getNotAvailableFromAttribute($value)
	{
		if(empty($value)) return null;
			
	    return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
	}
	public function getNotAvailableToAttribute($value)
	{
		if(empty($value)) return null;

	    return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
	}

}
