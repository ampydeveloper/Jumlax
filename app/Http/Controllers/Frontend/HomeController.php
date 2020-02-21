<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
//use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Models\AirportDetails;
use App\Models\AirlineDetails;
use App\Models\Countries;
use App\Models\Bookings;
use App\Models\BookingPassengerDetails;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\Auth;
use App\Mail\Frontend\Flight\FlightBooked;
use Session;
use DB;
use PDF;

/**
 * Class HomeController.
 */
class HomeController extends Controller {

    /**
     * @return \Illuminate\View\View
     */
//    public function index() {
//        // return view('frontend.index');
//    }

    public function about() {
        return view('frontend.about');
    }

    public function terms_conditions() {
        return view('frontend.terms_conditions');
    }

    public function privacy_policy() {
        return view('frontend.privacy_policy');
    }

    public function trips() {
//        $ticket_data = Session::get('ticket_data');
//    dd($ticket_data);
//        $ticket_pdf = PDF::loadView('create_ticket', $ticket_data);
//        $ticket_pdf->save(public_path().'/charter_tickets/'.$booking->name.'_'.$booking->booking_reference.'.pdf');
        

//        $data = ['title' => 'Welcome to HDTuto.com'];
//        $pdf = PDF::loadView('create_ticket', $data);
//        return $ticket_pdf->stream();
//        die('DONE');


        $data['bookings'] = Bookings::all();
        dd($data);
        return view('frontend.user.trips', $data);
    }

    public function review(Request $request) {
        Session::put('segment', $request->segment);
        Session::put('price', $request->price);
        Session::put('travelerPricings', $request->travelerPricings);
        $data['segment'] = unserialize($request->segment);
        $data['price'] = unserialize($request->price);
        $data['travelerPricings'] = unserialize($request->travelerPricings);
        foreach ($data['segment'] as $key => $itinary) {
            $airport_code = [];
            foreach ($itinary['segments'] as $segment) {
                if (!in_array($segment['departure']['iataCode'], $airport_code)) {

                    $airport_code[] = $segment['departure']['iataCode'];
                }
                if (!in_array($segment['arrival']['iataCode'], $airport_code)) {

                    $airport_code[] = $segment['arrival']['iataCode'];
                }
            }
        }
        if (session()->has('adults')) {
            $data['adults'] = session::get('adults');
        } else {
            $data['adults'] = 1;
        }
        if (session()->has('children')) {
            $data['children'] = session::get('children');
        } else {
            $data['children'] = 0;
        }
        if (session()->has('infants')) {
            $data['infants'] = session::get('infants');
        } else {
            $data['infants'] = 0;
        }
        $data['airports'] = AirportDetails::whereIn('airport_code', $airport_code)->get();
        $data['airline'] = AirlineDetails::get();

        return view('frontend.flight.review', $data);
    }

    public function traveller_details() {


        $data['segment'] = unserialize(session::get('segment'));
        $data['price'] = unserialize(session::get('price'));
        $data['travelerPricings'] = unserialize(session::get('travelerPricings'));
        foreach ($data['segment'] as $key => $itinary) {
            $airport_code = [];
            foreach ($itinary['segments'] as $segment) {
                if (!in_array($segment['departure']['iataCode'], $airport_code)) {

                    $airport_code[] = $segment['departure']['iataCode'];
                }
                if (!in_array($segment['arrival']['iataCode'], $airport_code)) {

                    $airport_code[] = $segment['arrival']['iataCode'];
                }
            }
        }
        $data['airports'] = AirportDetails::whereIn('airport_code', $airport_code)->get();
        if (session()->has('adults')) {
            $data['adults'] = session::get('adults');
        } else {
            $data['adults'] = 1;
        }
        if (session()->has('children')) {
            $data['children'] = session::get('children');
        } else {
            $data['children'] = 0;
        }
        if (session()->has('infants')) {
            $data['infants'] = session::get('infants');
        } else {
            $data['infants'] = 0;
        }
        $data['airline'] = AirlineDetails::get();
        $data['countries'] = Countries::get();

        return view('frontend.flight.traveller_details', $data);
    }

    public function paymentDone(Request $request){
        $storageFile = Auth()->user()['id'] . '-passengerDetails';
        $passengerDetails = unserialize(Storage::disk('local')->get($storageFile));
        Session::put('passangerDetail', $passengerDetails);

        // $resp = json_decode('{"idTransaction": '.Session::get("s2m_transaction-reference").',"transactionStat":"S"}', true);
        print_r($request->all());
        // if($resp['idTransaction'] == Session::get('s2m_transaction-reference') && $resp['transactionStat'] == 'S'){
            // print_r('in');
            // return redirect()->route('frontend.paymentGet', ['paymentDone' => true]);
        // }else{
            // print_r('ins');
            // echo "yeaha";
            // return redirect()->route('frontend.paymentGet', ['paymentDone' => false]);
        // }
    }

    public function paymentCancelled(){
        $storageFile = Auth()->user()['id'] . '-passengerDetails';
        $passengerDetails = unserialize(Storage::disk('local')->get($storageFile));
        Session::put('passangerDetail', $passengerDetails);
        return redirect()->route('frontend.paymentGet');
    }

    public function payment(Request $request) {
//        dd($request->toArray());
//        $this->validate(request(), [
//            'name' => 'required|array',
//            'nationality' => 'required|array',
//            'gender' => 'required|array',
//            'passport' => 'required|array',
//            'expiry_date' => 'required|array|date_format:DD/MM/YY',
//            'birth_date' => 'required|array|date_format:DD/MM/YY',
//            'phone_number' => 'required|array|regex:/(01)[0-9]{9}/',
//            'email' => 'required|array|email',
//            'address' => 'required|array',
//            'agree' => 'required',
//            'reference_passenger_name' => 'required',
//            'reference' => 'required',
//            'reference_gender' => 'required',
//        ]);
        Session::put('passangerDetail', $request->all());

        if (Auth()->user()) {
            return redirect()->route('frontend.paymentGet');
        } else {
            Session::save();
            return redirect()->route('frontend.auth.login');
        }
    }

    public function paymentGet($paymentDone=false) {
        if (Auth()->user()) {
            $passangerDetail = Session::get('passangerDetail');
            if(!(isset($paymentDone)) || !$paymentDone){
                $storageFile = Auth()->user()['id'] . '-passengerDetails';
                Storage::disk('local')->put($storageFile, serialize($passangerDetail));
            }
            // dd($passangerDetail);
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => env("WP_URL") . "laravel-user.php?action=wallet-balance&email=" . auth()->user()->email,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);
            if (!$err) {
                $data['terawallet_balance'] = $response;
            }
            $data['teraWalletGateway'] = env("WP_URL") . "index.php/jumlax-terawallet/";
            // exit();
            $data['segment'] = unserialize(session::get('segment'));
            $data['price'] = unserialize(session::get('price'));
            $airports = array();
            foreach ($data['segment'] as $key => $itinary) {
                $airport_code = [];
                foreach ($itinary['segments'] as $segment) {
                    if (!in_array($segment['departure']['iataCode'], $airport_code)) {
                        $airport_code[] = $segment['departure']['iataCode'];
                    }
                    if (!in_array($segment['arrival']['iataCode'], $airport_code)) {
                        $airport_code[] = $segment['arrival']['iataCode'];
                    }
                }
            }
            $data['airports'] = AirportDetails::whereIn('airport_code', $airport_code)->get();
            $data['requestdata'] = $passangerDetail;
//            dd($data['requestdata']);
            $data['s2mGateway'] = env('S2MGATEWAY');
            if(!$paymentDone){
                $data['s2mConfig'] = [
                    'pspId' => env('PSPID'),
                    'mpiId' => env('MPIID'),
                    'cardAcceptor' => env('CARDACCEPTOR'),
                    'mcc' => env('MCC'),
                    'merchantKitId' => env('MERCHANTKITID'),
                    'authenticationToken' => env('AUTHENTICATIONTOKEN'),
                    //'transactionReference' => 'YU0055212PI',
                    'transactionReference' => substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 15)), 0, 15),
                    'language' => env('LANGUAGE'),
                    'transactionAmount' => $data['price']['grandTotal'],
                    'currency' => env('CURRENCY'),
                    'cardHolderMailAddress' => $passangerDetail['email'][0],
                    'cardHolderPhoneNumber' => $passangerDetail['phone_number'][0],
                    // 'cardHolderIPAddress' => $_SERVER['HTTP_X_REAL_IP'],
                    'cardHolderIPAddress' => $_SERVER['REMOTE_ADDR'],
                    'countryCode' => env('COUNTRYCODE'),
                    // callBackUrl=https://jumlax.com/devnew
                    'callBackUrl' => env('CALLBACKURL'),
                    'redirectBackUrl' => env('REDIRECTBACKURL')
                ];

                session::put('s2m_transaction-reference', $data['s2mConfig']['transactionReference']);
            }else if(isset($paymentDone) && !$paymentDone){
                $data['s2mFailed'] = true;
            }else{
                $data['s2mSuccess'] = true;
            }
            session::put('bookingDetails', $passangerDetail);
            if (session()->has('adults')) {
                $data['adults'] = session::get('adults');
            } else {
                $data['adults'] = 1;
            }
            if (session()->has('children')) {
                $data['children'] = session::get('children');
            } else {
                $data['children'] = 0;
            }
            if (session()->has('infants')) {
                $data['infants'] = session::get('infants');
            } else {
                $data['infants'] = 0;
            }
            $data['airline'] = AirlineDetails::get();
            return view('frontend.flight.payment', $data);
        } else {
            return redirect()->route('frontend.index');
        }
    }

    public function process_payment(Request $request) {
//        dump($request->all());
        $payment = false;
        $wp_error = '';
        if ($request['type']) {
            if ($request['type'] == 'terawallet') {
                $booking_reference = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 15)), 0, 15);
                $payment_method = 'terawallet';
                $token = uniqid();
                $tokenExists = \DB::connection('mysql_wp')->select('SELECT * FROM `single_signin_tokens` WHERE `email`="' . auth()->user()->email . '"');
                if ($tokenExists) {
                    \DB::connection('mysql_wp')->update('UPDATE `single_signin_tokens` SET `token` = "' . $token . '" WHERE `email` = "' . auth()->user()->email . '"');
                } else {
                    \DB::connection('mysql_wp')->insert('INSERT INTO `single_signin_tokens`(email, token) VALUES ("' . auth()->user()->email . '","' . $token . '");');
                }

                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => env("WP_URL") . "laravel-user.php?action=payment",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 90,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => "email=" . auth()->user()->email . "&amount=" . $request['amount'] . "&flight=Flight-Tickets-" . $booking_reference . "&token=" . $token,
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);

                // dd($response);
                curl_close($curl);
                if ($err) {
                    echo "cURL Error #:" . $err;
                } else {
                    if($response == 'success'){
                        $payment = true;
                    }else if($response == 'balance'){
                        $payment = false;
                        $wp_error = 'low-balance';
                    }else{
                        // echo $response;
                        $wp_error = 'error';
                    }
                }
            } else if ($request['type'] == 's2m') {
                if (true) {
                    $payment_method = 's2m';
                    $payment = true;
                    $booking_reference = Session::get('s2m_transaction-reference');
                }
            }
        }
        // exit();
        if ($payment) {
            DB::beginTransaction();
            $booking = new Bookings;
            $booking->user_id = auth()->user()->id;
            $booking->booking_reference = $booking_reference;
            $booking->from = session::get('from');
            $booking->to = session::get('to');
            $booking->segment = session::get('segment');
            $booking->price = session::get('price');
            $booking->payment_method = $payment_method;

            $bookingDetails = session::get('bookingDetails');
            foreach ($bookingDetails['name'] as $key => $name) {
                if ($key == 0) {
                    $booking->name = $name;
                } else {
                    $passanger['name'][] = $name;
                }
            }
            foreach ($bookingDetails['nationality'] as $key => $name) {
                if ($key == 0) {
                    $booking->nationality = $name;
                } else {
                    $passanger['nationality'][] = $name;
                }
            }
            foreach ($bookingDetails['gender'] as $key => $name) {
                if ($key == 0) {
                    $booking->gender = $name;
                } else {
                    $passanger['gender'][] = $name;
                }
            }
            foreach ($bookingDetails['passport'] as $key => $name) {
                if ($key == 0) {
                    $booking->passport = $name;
                } else {
                    $passanger['passport'][] = $name;
                }
            }
            foreach ($bookingDetails['expiry_date'] as $key => $name) {
                if ($key == 0) {
                    $booking->expiry_date = $name;
                } else {
                    $passanger['expiry_date'][] = $name;
                }
            }
            foreach ($bookingDetails['birth_date'] as $key => $name) {
                if ($key == 0) {
                    $booking->birth_date = $name;
                } else {
                    $passanger['birth_date'][] = $name;
                }
            }
            foreach ($bookingDetails['phone_number'] as $key => $name) {
                if ($key == 0) {
                    $booking->phone_number = $name;
                } else {
                    $passanger['phone_number'][] = $name;
                }
            }
            foreach ($bookingDetails['email'] as $key => $name) {
                if ($key == 0) {
                    $booking->email = $name;
                } else {
                    $passanger['email'][] = $name;
                }
            }
            foreach ($bookingDetails['address'] as $key => $name) {
                if ($key == 0) {
                    $booking->address = $name;
                } else {
                    $passanger['address'][] = $name;
                }
            }
            $booking->reference_passenger_name = $bookingDetails['reference_passenger_name'];
            $booking->reference = $bookingDetails['reference'];
            $booking->reference_gender = $bookingDetails['reference_gender'];
            $booking->terms_agree = $bookingDetails['agree'];

            if ($booking->save()) {
                if (isset($passanger)) {
                    $count = count($passanger['name']);
                    for ($i = 0; $i < $count; $i++) {
                        $BookingPassengerDetails = new BookingPassengerDetails;
                        $BookingPassengerDetails->booking_id = $booking->id;
                        $BookingPassengerDetails->name = $passanger['name'][$i];
                        $BookingPassengerDetails->nationality = $passanger['nationality'][$i];
                        $BookingPassengerDetails->gender = $passanger['gender'][$i];
                        $BookingPassengerDetails->passport = $passanger['passport'][$i];
                        $BookingPassengerDetails->expiry_date = $passanger['expiry_date'][$i];
                        $BookingPassengerDetails->birth_date = $passanger['birth_date'][$i];
                        $BookingPassengerDetails->phone_number = $passanger['phone_number'][$i];
                        $BookingPassengerDetails->email = $passanger['email'][$i];
                        $BookingPassengerDetails->address = $passanger['address'][$i];
                        if (!$BookingPassengerDetails->save()) {
                            $data = [
                                "error" => true,
                                'message' => 'fail'
                            ];
                            DB::rollback();
                            return response()->json($data);
                        }
                    }
                }
                DB::commit();
            }



            if (!isset($passanger)) {
                Mail::send(new FlightBooked($booking, []));
//                $ticket_data = [
//                    'booking' => $booking,
//                    'passanger' => [],
//                ];
//                $ticket_pdf = PDF::loadView('create_ticket', $ticket_data);
//                return $ticket_pdf->stream();
//                die('red');
            } else {
                Mail::send(new FlightBooked($booking, $passanger));
//                $ticket_data = [
//                    'booking' => $booking,
//                    'passanger' => $passanger,
//                ];
//                $ticket_pdf = PDF::loadView('create_ticket', $ticket_data);
//                return $ticket_pdf->stream();
//                die('red');
            }
            $data = [
                "error" => false,
                'message' => 'success'
            ];
            return response()->json($data);
        } else {
            $data = [
                "error" => true,
                'message' => 'fail',
                'info' => $wp_error
            ];
            return response()->json($data);
        }
    }

    public function booked(Request $request) {
        return view('frontend.flight.booked');
    }

}
