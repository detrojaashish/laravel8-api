<?php

namespace Database\Seeders;

use App\Models\EventBooking;
use App\Models\Event;
use App\Models\EventTiming;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
/**
* Run the database seeds.
*
* @return void
*/
public function run()
{

    $event1 = Event::create([
        'title' => 'Laracast technical events',
        'participation_limitations' => 300,
        'max_no_participation_per_book' => 5,
        'durations' => 20,
        'prepration_time' => 00,
        'bookable_in_advance' => 14,
    ]);

    EventTiming::create([
        'event_id' => $event1->id,
        'day_name' => 'Monday',
        'available_from' => "10:00",
        'available_to' => "18:00",
        'not_available_from' => "13:00",
        'not_available_to' => "14:00"
    ]);

    EventTiming::create([
        'event_id' => $event1->id,
        'day_name' => 'Tuesday',
        'available_from' => "10:00",
        'available_to' => "18:00",
        'not_available_from' => "13:00",
        'not_available_to' => "14:00"
    ]);

    EventTiming::create([
        'event_id' => $event1->id,
        'day_name' => 'Wednesday',
        'available_from' => "10:00",
        'available_to' => "18:00",
        'not_available_from' => "13:00",
        'not_available_to' => "14:00"
    ]);


    EventTiming::create([
        'event_id' => $event1->id,
        'day_name' => 'Thursday',
        'available_from' => "10:00",
        'available_to' => "18:00",
        'not_available_from' => "13:00",
        'not_available_to' => "14:00"
    ]);

    EventTiming::create([
        'event_id' => $event1->id,
        'day_name' => 'Friday',
        'available_from' => "10:00",
        'available_to' => "18:00",
        'not_available_from' => "13:00",
        'not_available_to' => "14:00"
    ]);







    $event2 = Event::create([
        'title' => 'Drupal Fundamental Technique event',
        'participation_limitations' => 100,
        'max_no_participation_per_book' => 4,
        'durations' => 20,
        'prepration_time' => 00,
        'bookable_in_advance' => 7,
    ]);


    EventTiming::create([
        'event_id' => $event2->id,
        'day_name' => 'Monday',
        'available_from' => "10:00",
        'available_to' => "18:00",
        'not_available_from' => "13:00",
        'not_available_to' => "14:00"
    ]);

    EventTiming::create([
        'event_id' => $event2->id,
        'day_name' => 'Tuesday',
        'available_from' => "10:00",
        'available_to' => "18:00",
        'not_available_from' => "13:00",
        'not_available_to' => "14:00"
    ]);

    EventTiming::create([
        'event_id' => $event2->id,
        'day_name' => 'Wednesday',
        'available_from' => "10:00",
        'available_to' => "18:00",
        'not_available_from' => "13:00",
        'not_available_to' => "14:00"
    ]);


    EventTiming::create([
        'event_id' => $event2->id,
        'day_name' => 'Thursday',
        'available_from' => "10:00",
        'available_to' => "18:00",
        'not_available_from' => "13:00",
        'not_available_to' => "14:00"
    ]);

    EventTiming::create([
        'event_id' => $event2->id,
        'day_name' => 'Friday',
        'available_from' => "10:00",
        'available_to' => "18:00",
        'not_available_from' => "13:00",
        'not_available_to' => "14:00"
    ]);



    $event3 = Event::create([
        'title' => 'Technical Intervice Process Events',
        'participation_limitations' => 200,
        'max_no_participation_per_book' => 8+10,
        'durations' => 20,
        'prepration_time' => 05,
        'bookable_in_advance' => 14,
    ]);


    EventTiming::create([
        'event_id' => $event3->id,
        'day_name' => 'Monday',
        'available_from' => "10:00",
        'available_to' => "18:00",
        'not_available_from' => "13:00",
        'not_available_to' => "14:00"
    ]);

    EventTiming::create([
        'event_id' => $event3->id,
        'day_name' => 'Tuesday',
        'available_from' => "10:00",
        'available_to' => "18:00",
        'not_available_from' => "13:00",
        'not_available_to' => "14:00"
    ]);

    EventTiming::create([
        'event_id' => $event3->id,
        'day_name' => 'Wednesday',
        'available_from' => "10:00",
        'available_to' => "18:00",
        'not_available_from' => "13:00",
        'not_available_to' => "14:00"
    ]);


    EventTiming::create([
        'event_id' => $event3->id,
        'day_name' => 'Thursday',
        'available_from' => "10:00",
        'available_to' => "18:00",
        'not_available_from' => "13:00",
        'not_available_to' => "14:00"
    ]);

    EventTiming::create([
        'event_id' => $event3->id,
        'day_name' => 'Friday',
        'available_from' => "10:00",
        'available_to' => "18:00",
        'not_available_from' => "13:00",
        'not_available_to' => "14:00"
    ]);

    $event4 = Event::create([
        'title' => 'Holiday All morning event',
        'participation_limitations' => 10,
        'max_no_participation_per_book' => 1,
        'durations' => 20,
        'prepration_time' => 00,
        'bookable_in_advance' => 30,
    ]);

    EventTiming::create([
        'event_id' => $event4->id,
        'day_name' => 'Saturday',
        'available_from' => "06:00",
        'available_to' => "11:00",
        'not_available_from' => "10:00",
        'not_available_to' => "10:20"
    ]);

    EventTiming::create([
        'event_id' => $event4->id,
        'day_name' => 'Sunday',
        'available_from' => "06:00",
        'available_to' => "11:00",
        'not_available_from' => "10:00",
        'not_available_to' => "10:20"
    ]);


}

}
