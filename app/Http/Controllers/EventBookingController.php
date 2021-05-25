<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Validator;
use App\Models\EventBooking;
use App\Models\Event;
use App\Models\EventTiming;
use Carbon\Carbon;
use DB;
use App\Http\Controllers\BaseController as BaseController;
class EventBookingController extends BaseController
{

public function generateSlot($event,$bookingDate){
    $durations = $event->durations;
    $eventTiming = $event->timing;
    $availableFrom = $eventTiming->available_from;
    $availableTo = $eventTiming->available_to;
    $notAvailableFrom = $eventTiming->not_available_from; 
    $notAvailableTo = $eventTiming->not_available_to;
    $preprationTime = $event->prepration_time;
    $allSlotBooked = $event->slotBooked->pluck('booking_time')->toArray();
    $slotBooked = $event->slotBooked->where('booking_date',$bookingDate)->pluck('booking_time')->toArray();
    if($event->participation_limitations>0 && count($allSlotBooked)>=$event->participation_limitations){
        return [];
    }
    $allSlots = [];
    for($i=$availableFrom;$i<=$availableTo;){
        $startTime = Carbon::parse($i);
        if($preprationTime>0){
            $startTime->addMinutes($preprationTime);
        }     
        $newSlot = $startTime; 
        array_push($allSlots, $newSlot->format('H:i'));  
        if(end($allSlots)>=$notAvailableFrom && end($allSlots)<$notAvailableTo ){
            array_pop($allSlots);
            $startTime = Carbon::parse($notAvailableTo);
            if($preprationTime>0){
                $startTime->addMinutes($preprationTime);
            } 
            $i = $startTime->format('H:i');
        }else{
            $endTime = $startTime->addMinutes($durations);
            $i = $endTime->format('H:i');
        }
    }
    if(end($allSlots) >=$availableTo){
        array_pop($allSlots);
    } 
    $lastSlot = Carbon::parse(end($allSlots))->addMinutes($durations);
    if($lastSlot->format('H:i') > $availableTo){
        array_pop($allSlots);
    }
    $slotBookedCount = array_count_values( $slotBooked );
    foreach ($allSlots as $key => $value) {
        if($event->max_no_participation_per_book>0 && isset($slotBookedCount[$value]) && $slotBookedCount[$value]>=$event->max_no_participation_per_book ){
            unset($allSlots[$key]);
        }
    }
    $finalSlots = [];
    foreach ($allSlots as $value) {
        array_push($finalSlots,$value);
     } 
    return $finalSlots;
 
}
public function index(Request $request,$eventId=null)
{
    $todayDate = Carbon::now()->format('Y-m-d');
    $validator = Validator::make($request->all(), [
        'booking_date' => 'required|date_format:Y-m-d|after_or_equal:'.$todayDate,
    ]);
    if($validator->fails()){ 
        return $this->sendError('Validation Errors', [$validator->errors()], 422);
    }
    $dayName = Carbon::parse($request->booking_date)->format('l');
    $events = Event::whereHas('timing',function($q) use($dayName){
        $q->where('day_name','LIKE',$dayName);
    });
    if(empty($eventId)){
        $events = $events->get();
        if($events->count()){
            foreach ($events as &$event) {
                $event->timing = $event->timing($dayName);
                $event->availableSlot = $this->generateSlot($event,$request->booking_date);
                $event->unsetRelation('slotBooked');
                unset($event->timing,$event->participation_limitations,$event->max_no_participation_per_book,$event->durations,$event->bookable_in_advance,$event->prepration_time);
                break;
            }
        }

    }else{
        $events = $events->where('id',$eventId)->first();
        if(!empty($events)){
            if($events->bookable_in_advance>0){
                $bookable_for = Carbon::now()->addDays($events->bookable_in_advance)->format('Y-m-d');
                if($bookable_for<$request->booking_date){
                    return $this->sendError('Validation Errors',[['booking_date'=>'Booking date can not be advanced to '.$events->bookable_in_advance.' days.']],422);
                }
            } 
            $events->timing = $events->timing($dayName);
            $events->availableSlot = $this->generateSlot($events,$request->booking_date);
            $events->unsetRelation('slotBooked');
            unset($events->timing,$events->participation_limitations,$events->max_no_participation_per_book,$events->durations,$events->bookable_in_advance,$events->prepration_time);

        }else{
            return $this->sendError('Invalid event.',['No data found']);    
        }

    }
    if(empty($events)){
        return $this->sendResponse($events,'No time slot available.'); 
    }else{
        return $this->sendResponse($events,'Available time slot listing.');    
    }    
}

public function schedule(Request $request)
{  
    $todayDate = Carbon::now()->format('Y-m-d');
    $time = Carbon::now()->format('H:i');
    $validator = Validator::make($request->all(), [
        'event_id' => 'required',
        'email' => 'required|email|max:255',
        'first_name' => 'required|max:50',
        'last_name' => 'required|max:50',
        'booking_date' => 'required|date_format:Y-m-d|after_or_equal:'.$todayDate,
        'booking_time' => 'required|date_format:H:i',       
    ]);

    if($validator->fails()){ 
        return $this->sendError('Validation Errors', [$validator->errors()], 422);
    }

    if($todayDate == $request->booking_date && $request->booking_time <= $time){
        return $this->sendError('Validation Errors', [['booking_time'=> 'Invalid Booking time']], 422);
    }

    $dayName = Carbon::parse($request->booking_date)->format('l');
    $event = Event::whereHas('timing',function($q) use($dayName){
        $q->where('day_name','LIKE',$dayName);
    })->where('id',$request->event_id)->first();
    if(empty($event)){
        return $this->sendError('Validation Errors',[['event_id'=>'No data found for this '.$request->event_id.' event ID.']],422);
    }
    if($event->bookable_in_advance>0){
        $bookable_for = Carbon::now()->addDays($event->bookable_in_advance)->format('Y-m-d');
        if($bookable_for<$request->booking_date){
            return $this->sendError('Validation Errors',[['booking_date'=>'Booking date can not be advanced to '.$event->bookable_in_advance.' days.']],422);
        }
    } 
    $event->timing = $event->timing($dayName);
    $event->availableSlot = $this->generateSlot($event,$request->booking_date);
    $event->unsetRelation('slotBooked');
    unset($event->timing,$event->participation_limitations,$event->max_no_participation_per_book,$event->durations,$event->bookable_in_advance,$event->prepration_time);
    if(count($event->availableSlot) < 1 || !in_array($request->booking_time,$event->availableSlot)){
        return $this->sendError('Validation Errors',[['booking_time'=>'Time Slot not available.']],422);
    }
    $event_booking = EventBooking::create($request->only(['event_id','first_name','last_name','email','booking_date','booking_time']));
    if($event_booking){
// return response()->json([],201);
        return $this->sendResponse($event_booking, 'Event Booking sucessfully done',201);
    }
}

public function getSingleEvent($id, Request $request) {
    $booking_date = ((isset($request->booking_date)) ? $request->booking_date : null);
    
    if(empty($booking_date)){
        $event = Event::with('SlotBooked')->find($id);
    }else{
        $event = Event::with(['SlotBooked' => function($q) use($booking_date) {
                $q->whereDate('booking_date', '=', $booking_date); // '=' is optional
        }])->where('id',$id)->first();

    }
    if(empty($event)) {
        return $this->sendError('Invalid Event.', ['Event not found.'], 404);  
    }
    return $this->sendResponse($event, 'Event Details');

}

}
