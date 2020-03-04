<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\Bookings;
use App\Models\CharterBooking;
use Illuminate\Support\Facades\Auth;
use App\Models\AirlineDetails;
use DateTime;

/**
 * Class AccountController.
 */
class AccountController extends Controller {

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('frontend.user.account');
    }

    public function myTripe() {
        $airline = AirlineDetails::get()->toArray();
        $bookings = Bookings::where('user_id', Auth::user()->id)->with('passengers')->get();
        $charter_bookings = CharterBooking::where('user_id', Auth::user()->id)->with('passengers','charterDetails.planes.charterDetails')->get();
//        dump($data);
        $data = [];
        if (count($bookings) > 0) {
            foreach ($bookings as $key => $booking_details) {
                
                $segment_data = unserialize($booking_details['segment']);
                $price_data = unserialize($booking_details['price']);
                $details[$key]['currency'] = $price_data['currency'];
                $details[$key]['price'] = $price_data['grandTotal'];
                $details[$key]['booking_reference'] = $booking_details['booking_reference'];
                $explode1 = explode('PT', $segment_data[0]['duration']);
                $details[$key]['totalOnwayDuration'] = $explode1[1];
                $details[$key]['onewayDepatureAirport'] = $segment_data[0]['segments'][0]['departure']['iataCode'];
                $details[$key]['onewayDepatureDate'] = \Carbon\Carbon::parse(\Carbon\Carbon::parse($segment_data[0]['segments'][0]['departure']['at']))->format('D, d M');
                $details[$key]['onewayDepatureTime'] = \Carbon\Carbon::parse(\Carbon\Carbon::parse($segment_data[0]['segments'][0]['departure']['at']))->format('h:i');
                if (isset($segment_data[0]['segments'][0]['departure']['terminal'])) {
                    $details[$key]['onewayDepatureTerminal'] = $segment_data[0]['segments'][0]['departure']['terminal'];
                }
                foreach ($airline as $value) {
                    if ($segment_data[0]['segments'][0]['carrierCode'] == $value['al_code']) {
                        $details[$key]['onewayCarrierName'] = $value['al_name'];
                        break;
                    }
                }
                if (count($segment_data[0]['segments']) == 1) {
                    $details[$key]['onewayArrivalAirport'] = $segment_data[0]['segments'][0]['arrival']['iataCode'];
                    $details[$key]['onewayArrivalDate'] = \Carbon\Carbon::parse(\Carbon\Carbon::parse($segment_data[0]['segments'][0]['arrival']['at']))->format('D, d M');
                    $details[$key]['onewayArrivalTime'] = \Carbon\Carbon::parse(\Carbon\Carbon::parse($segment_data[0]['segments'][0]['arrival']['at']))->format('h:i');
                    if (isset($segment_data[0]['segments'][0]['arrival']['terminal'])) {
                        $details[$key]['onewayArrivalTerminal'] = $segment_data[0]['segments'][0]['arrival']['terminal'];
                    }
                    $details[$key]['onwayNoOfStops'] = 0;
                } else {
                    $count = count($segment_data[0]['segments']);
                    $details[$key]['onewayArrivalAirport'] = $segment_data[0]['segments'][$count - 1]['arrival']['iataCode'];
                    $details[$key]['onewayArrivalDate'] = \Carbon\Carbon::parse(\Carbon\Carbon::parse($segment_data[0]['segments'][$count - 1]['arrival']['at']))->format('D, d M');
                    $details[$key]['onewayArrivalTime'] = \Carbon\Carbon::parse(\Carbon\Carbon::parse($segment_data[0]['segments'][$count - 1]['arrival']['at']))->format('h:i');
                    if (isset($segment_data[0]['segments'][$count - 1]['arrival']['terminal'])) {
                        $details[$key]['onewayArrivalTerminal'] = $segment_data[0]['segments'][$count - 1]['arrival']['terminal'];
                    }
                    $details[$key]['onwayNoOfStops'] = $count - 1;
                }


                if (isset($segment_data[1])) {
                    $explode1 = explode('PT', $segment_data[0]['duration']);
                    $details[$key]['returnDuration'] = $explode1[1];
                    $details[$key]['returnDepatureAirport'] = $segment_data[1]['segments'][0]['departure']['iataCode'];
                    $details[$key]['returnDepatureDate'] = \Carbon\Carbon::parse(\Carbon\Carbon::parse($segment_data[1]['segments'][0]['departure']['at']))->format('D, d M');
                    $details[$key]['returnDepatureTime'] = \Carbon\Carbon::parse(\Carbon\Carbon::parse($segment_data[1]['segments'][0]['departure']['at']))->format('h:i');
                    if (isset($segment_data[1]['segments'][0]['departure']['terminal'])) {
                        $details[$key]['returnDepatureTerminal'] = $segment_data[1]['segments'][0]['departure']['terminal'];
                    }
                    foreach ($airline as $value) {
                        if ($segment_data[1]['segments'][0]['carrierCode'] == $value['al_code']) {
                            $details[$key]['returnCarrierName'] = $value['al_name'];
                            break;
                        }
                    }
                    if (count($segment_data[1]['segments']) == 1) {
                        $details[$key]['returnArrivalAirport'] = $segment_data[1]['segments'][0]['arrival']['iataCode'];
                        $details[$key]['returnArrivalDate'] = \Carbon\Carbon::parse(\Carbon\Carbon::parse($segment_data[1]['segments'][0]['arrival']['at']))->format('D, d M');
                        $details[$key]['returnArrivalTime'] = \Carbon\Carbon::parse(\Carbon\Carbon::parse($segment_data[1]['segments'][0]['arrival']['at']))->format('h:i');
                        
                        if (isset($segment_data[1]['segments'][0]['arrival']['terminal'])) {
                            $details[$key]['returnArrivalTerminal'] = $segment_data[1]['segments'][0]['arrival']['terminal'];
                        }
                        $details[$key]['returnNoOfStops'] = 0;
                    } else {
                        $count = count($segment_data[1]['segments']);
                        $details[$key]['returnArrivalAirport'] = $segment_data[1]['segments'][$count - 1]['arrival']['iataCode'];
                        $details[$key]['returnArrivalDate'] = \Carbon\Carbon::parse(\Carbon\Carbon::parse($segment_data[1]['segments'][$count - 1]['arrival']['at']))->format('D, d M');
                        $details[$key]['returnArrivalTime'] = \Carbon\Carbon::parse(\Carbon\Carbon::parse($segment_data[1]['segments'][$count - 1]['arrival']['at']))->format('h:i');
                        if (isset($segment_data[1]['segments'][$count - 1]['arrival']['terminal'])) {
                            $details[$key]['returnArrivalTerminal'] = $segment_data[1]['segments'][$count - 1]['arrival']['terminal'];
                        }
                        $details[$key]['returnNoOfStops'] = $count - 1;
                    }
                }
                $chosen_date = \Carbon\Carbon::parse($segment_data[0]['segments'][0]['departure']['at']);
                $today_date = \Carbon\Carbon::parse(date("Y-m-d"));
                if ($chosen_date->gt($today_date)) {
                    $data['upcoming']['flight'][$key] = $booking_details->toArray();
                    $data['upcoming']['flight'][$key]['booking_details'] = $details[$key];
                } else {
                    $data['previous']['flight'][$key] = $booking_details->toArray();
                    $data['previous']['flight'][$key]['booking_details'] = $details[$key];
                }
            }
        }
        if (count($charter_bookings)) {
            foreach ($charter_bookings as $key=>$charter_booking) {
//                dd($charter_booking->toArray());
                $charter_details['currency'] = 'LYD';
                $charter_details['price'] = $charter_booking->price;
                $charter_details['booking_reference'] = $charter_booking->booking_reference;
                $datetime1 = new DateTime($charter_booking['departure_date_time']);
                $datetime2 = new DateTime($charter_booking['return_date_time']);
                $interval = $datetime1->diff($datetime2);
                $elapsed = $interval->format(' %hH%iM');
                $charter_details['totalOnwayDuration'] = $elapsed;
                $charter_details['onewayDepatureAirport'] = $charter_booking->from;
                $charter_details['onewayDepatureDate'] = $datetime1->format('D, d M');
                $charter_details['onewayDepatureTime'] = $datetime1->format('h:i');
                $charter_details['onewayCarrierName'] = $charter_booking->charterDetails->planes->name;
                $charter_details['onewayArrivalAirport'] = $charter_booking->to;
                $charter_details['onewayArrivalDate'] = $datetime2->format('D, d M');
                $charter_details['onewayArrivalTime'] = $datetime2->format('h:i');
                $charter_details['onwayNoOfStops'] = 0;
                
//                dd($charter_details);
                
                
                $chosen_date = \Carbon\Carbon::parse($charter_booking->departure_date_time);
                $today_date = \Carbon\Carbon::parse(date("Y-m-d"));
                if ($chosen_date->gt($today_date)) {
                    $data['upcoming']['charter_flight'][$key] = $charter_booking->toArray();
                    $data['upcoming']['charter_flight'][$key]['booking_details'] = $charter_details;
                } else {
                    $data['previous']['charter_flight'][$key] = $charter_booking->toArray();
                    $data['previous']['charter_flight'][$key]['booking_details'] = $charter_details;
                }
            }
        }

//        dump($data);
//        dd('123');
        return view('frontend.user.trips', $data);
    }

}
