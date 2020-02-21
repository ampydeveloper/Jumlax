Hi {{$booking->first_name}}, 

Ticket Booked!
Your tickets have been booked successfully.
Following are the booking details:

From: {{$booking->from}}
To: {{$booking->to}}
Contact: {{$booking->country_code}}-{{$booking->phone}}
Total Price: {{$price['total']}}
Booked at: {{$booking->created_at}}

Your ticked has been attached within this mail.

Jumlax