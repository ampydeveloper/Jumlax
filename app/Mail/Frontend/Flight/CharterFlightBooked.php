<?php

namespace App\Mail\Frontend\Flight;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Http\Controllers\Frontend\Auth;

class CharterFlightBooked extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The order instance.
     *
     * @var Order
     */
    public $booking;
    public $passanger;
    public $ticket_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($booking, $passanger, $ticket_name)
    {
        $this->booking = $booking;
        $this->passanger = $passanger;
        $this->ticket_name = $ticket_name;
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
            ->view('frontend.mail.charter_booked') 
            ->attach(public_path() . '/charter_tickets/'.$this->ticket_name, ['mime' => 'application/pdf'])
            ->with(['price' => $this->booking, 'passanger' => $this->passanger]);
    }
}
