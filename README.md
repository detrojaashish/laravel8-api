## Please check the following API endpoints:


##### For getting timeslot by date

```
{base_url}/event/timeslot?booking_date=YYYY-MM-DD
```

##### For getting timeslot by date and event id

```
{base_url}/event/timeslot/{event_id}?booking_date=YYYY-MM-DD
```

##### For getting single event data (GET Method)

```
{base_url}/event/{event_id}
```

##### For getting single event with specific date (GET Method)

```
{base_url}/event/{event_id}?booking_date=YYYY-MM-DD
```

#####  Event Schedule (POST Method)

```
{base_url}/event/schedule
Body FORM data
{'event_id' : 1 ,'first_name' : 'Ashish', 'last_name' : 'Detroja', 'email' : 'akdetbigrock@gmail.com', 'slot_date' : '2021-05-27', 'slot_time' : '16:20'}
```
