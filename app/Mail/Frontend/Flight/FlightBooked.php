<?php

namespace App\Mail\Frontend\Flight;

use App\Models\Bookings;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Http\Controllers\Frontend\Auth;

class FlightBooked extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The order instance.
     *
     * @var Order
     */
    public $booking;
    public $passanger;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Bookings $booking, $passanger)
    {
        $this->booking = $booking;
        $this->passanger = $passanger;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->to(Auth()->user()->email, Auth()->user()->first_name.' '.Auth()->user()->last_name)
            ->view('frontend.mail.booked') 
//            ->text('frontend.mail.booked-text')
//            ->attach(storage_path('tickets/Ticket.pdf'), ['mime' => 'application/pdf'])
            ->with(['price' => unserialize($this->booking->price), 'segment' => unserialize($this->booking->segment), 'passanger' => $this->passanger]);
    }
}
