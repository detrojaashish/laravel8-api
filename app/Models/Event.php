<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{

	use SoftDeletes;

	
	public function timing($dayName=null){

        $data = $this->hasMany('App\Models\EventTiming','event_id');
    	if($dayName){
    		$data = $data->where('day_name','LIKE',$dayName)->first();
    	}
    	return $data;
    }

	public function slotBooked(){
        return $this->hasMany('App\Models\EventBooking','event_id');
    }


}
