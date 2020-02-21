<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Session;
use Illuminate\Http\Request;
use App\Models\CharterBooking;
//use Illuminate\Support\Facades\Session;
use App\Models\CharterPlaneFlightDetails;
use App\Models\CharterBookingPassengerDetail;
use Illuminate\Support\Facades\Mail;
use App\Mail\Frontend\Flight\CharterFlightBooked;
use PDF;
use Carbon;

class CharterPlaneController extends Controller {
    /*
     * get charter plane details
     * @param post request
     * return array
     */

    public function getCharterListing(Request $request) {
//        dump($request->all());
        $request->validate([
            'chartertype' => 'required',
            'charterclass' => 'required',
            'charterfrom' => 'required',
            'charterto' => 'required',
            'charterdeparture' => 'required',
//            'charterreturn' => 'required',
            'charteradult' => 'required',
            'charterchild' => 'required',
            'charterinfant' => 'required',
        ]);
        if ($request->charterreturn) {
            $result = CharterPlaneFlightDetails::whereDate('departure_time', '>=', date('Y-m-d', strtotime($request->charterdeparture)))
                            ->where('from', 'like', '%' . $request->charterfrom . '%')
                            ->where('to', 'like', '%' . $request->charterto . '%')
                            ->where(function($query) use ($request) {
                                if ($request->charterclass == 1) {
                                    $query->where('economy_seat', '>=', ($request->charteradult + $request->charterchild));
                                } else if ($request->charterclass == 2) {
                                    $query->where('premium_seat', '>=', ($request->charteradult + $request->charterchild));
                                } else if ($request->charterclass == 3) {
                                    $query->where('business_seat', '>=', ($request->charteradult + $request->charterchild));
                                } else {
                                    $query->where('first_seat', '>=', ($request->charteradult + $request->charterchild));
                                }
                            })
                            ->with('planes.charterDetails', 'bookings.passengers')->paginate(10);

            if ($result->count()) {
                $data['result'] = $result;
                $data['return'] = false;
                $data['status'] = 2;
            } else {
                $data['result'] = [];
                $data['return'] = false;
                $data['status'] = 0;
            }
        } else {
            
            $result = CharterPlaneFlightDetails::whereDate('departure_time', '>=', date('Y-m-d', strtotime($request->charterdeparture)))
                            ->where('from', 'like', '%' . $request->charterfrom . '%')
                            ->where('to', 'like', '%' . $request->charterto . '%')
                            ->where(function($query) use ($request) {
                                if ($request->charterclass == 1) {
                                    $query->where('economy_seat', '>=', ($request->charteradult+$request->charterchild));
                                } else if ($request->charterclass == 2) {
                                    $query->where('premium_seat', '>=', ($request->charteradult+$request->charterchild));
                                } else if ($request->charterclass == 3) {
                                    $query->where('business_seat', '>=', ($request->charteradult+$request->charterchild));
                                } else {
                                    $query->where('first_seat', '>=', ($request->charteradult+$request->charterchild));
                                }
                            })
                            ->with('planes.charterDetails', 'bookings.passengers')
                                    ->paginate(10);
            if ($result->count()) {
                $data['result'] = $result;
                $data['return'] = false;
                $data['status'] = 2;
            } else {
                $data['result'] = [];
                $data['return'] = false;
                $data['status'] = 0;
            }
        }
//        dd($data);

        

        Session::put('charter', 'on');
        $data['requestdata'] = $request->all();
        return view('frontend.charter-search', $data);
    }

    public function chartereview(Request $request) {
//        if (Auth::user()) {
        session::put('result', $request->result);
        $data['result'] = json_decode($request->result);
        $data['searchdata'] = unserialize($request->searchdata);
        session::put('searchdata', $data['searchdata']);

        if ($request->return) {
            session::put('return', $request->return);
            $data['return'] = json_decode($request->return);
        }
        return view('frontend.flight.charterreview', $data);
//        } else {
//            return redirect('login');
//        }
    }

    public function chartedetails() {

        $data['result'] = json_decode(session::get('result'));
        $data['searchdata'] = session::get('searchdata');
        if (session()->has('return')) {
            $data['return'] = json_decode(session::get('return'));
        }
//dump($data);
        return view('frontend.flight.charterdetail', $data);
    }

    public function charterpayment(Request $request) {

//        dd($request->all());
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
            return redirect()->route('frontend.charterpaymentGet');
        } else {
            Session::save();
            return redirect()->route('frontend.auth.login');
        }
    }

    public function charterpaymentGet() {
        if (Auth::user()) {
//            dd('in');
            $passangerDetail = Session::get('passangerDetail');
//            dd($passangerDetail);
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "http://jwp.leagueofclicks.com/laravel-user.php?action=wallet-balance&email=" . auth()->user()->email,
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
            // exit();
            $data['result'] = json_decode($passangerDetail['result']);
            $data['searchdata'] = json_decode($passangerDetail['searchdata']);
//            dd($data['searchdata']->charterclass);
            if ($data['searchdata']->charterclass == 1) {
                $price = $data['result']->economy_price;
            } else if ($data['searchdata']->charterclass == 2) {
                $price = $data['result']->premium_price;
            } else if ($data['searchdata']->charterclass == 3) {
                $price = $data['result']->business_price;
            } else if ($data['searchdata']->charterclass == 4) {
                $price = $data['result']->first_price;
            }
//            dd($price);
            $data['requestdata'] = $passangerDetail;
            $data['s2mGateway'] = env('S2MGATEWAY');
            $data['s2mConfig'] = [
                'pspId' => env('PSPID'),
                'mpiId' => env('MPIID'),
                'cardAcceptor' => env('CARDACCEPTOR'),
                'mcc' => env('MCC'),
                'merchantKitId' => env('MERCHANTKITID'),
                'authenticationToken' => env('AUTHENTICATIONTOKEN'),
                //'transactionReference' => 'YU0055212PI',
                'transactionReference' => uniqid('s2m'),
                'language' => env('LANGUAGE'),
                'transactionAmount' => $price,
                'currency' => env('CURRENCY'),
                'cardHolderMailAddress' => $data['requestdata']['email'][0],
                'cardHolderPhoneNumber' => $data['requestdata']['phone_number'][0],
                // 'cardHolderIPAddress' => $_SERVER['HTTP_X_REAL_IP'],
                'cardHolderIPAddress' => $_SERVER['REMOTE_ADDR'],
                'countryCode' => env('COUNTRYCODE'),
                // callBackUrl=https://jumlax.com/devnew
                'callBackUrl' => env('CALLBACKURL'),
                'redirectBackUrl' => env('REDIRECTBACKURL')
            ];

            session::put('s2m_transaction-reference', $data['s2mConfig']['transactionReference']);
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


            if (isset($passangerDetail['return'])) {
                $data['return'] = json_decode($passangerDetail['return']);
            }
//dd('123');
//            dump($data);
            return view('frontend.flight.charterpayment', $data);
        } else {
//            dd('out');
            return redirect()->route('frontend.index');
        }
    }

    public function process_payment(Request $request) {
//        dump($request->all());
        $payment = false;
        if ($request['type']) {
            if ($request['type'] == 'terawallet') {
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
                    CURLOPT_URL => "http://jwp.leagueofclicks.com/laravel-user.php?action=payment",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 90,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => "email=" . auth()->user()->email . "&amount=" . $request['amount'] . "&flight=" . $request['flight'] . "&token=" . $token,
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);

//                dd($response);
                curl_close($curl);
                if ($err) {
                    echo "cURL Error #:" . $err;
                } else {
                    $payment = true;
                }
            } else if ($request['type'] == 's2m') {
                if (true) {
                    $payment_method = 'payfull';
                    $payment = true;
                }
            }
        }

        if ($payment) {
            $passangerDetail = session::get('passangerDetail');
//            dump($passangerDetail);
            $result = json_decode($passangerDetail['result']);
//            dd($result);
            $searchdata = json_decode($passangerDetail['searchdata']);
//            dd($searchdata);
            DB::beginTransaction();
            $booking = new CharterBooking;
            $booking->user_id = auth()->user()->id;
            $booking->booking_reference = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 15)), 0, 15);
            $booking->from = $searchdata->charterfrom;
            $booking->to = $searchdata->charterto;
            $booking->departure_date_time = $result->departure_time;
            $booking->return_date_time = $result->arriving_time;
            $booking->airport_code = $result->airport_code;
            $booking->airport_name = $result->airport_name;
            $booking->country_name = $result->country_name;
            $booking->city_name = $result->city_name;
            $booking->plan_id = $result->planes->id;
            $booking->charter_plane_flight_details_id = $result->id;

            if ($searchdata->charterclass == 1) {
                $booking->price = $result->economy_price;
            } else if ($searchdata->charterclass == 2) {
                $booking->price = $result->premium_price;
            } else if ($searchdata->charterclass == 3) {
                $booking->price = $result->business_price;
            } else if ($searchdata->charterclass == 4) {
                $booking->price = $result->first_price;
            }
            $booking->payment_method = $payment_method;

            foreach ($passangerDetail['name'] as $key => $name) {
                if ($key == 0) {
                    $booking->name = $name;
                } else {
                    $passanger['name'][] = $name;
                }
            }
            foreach ($passangerDetail['nationality'] as $key => $name) {
                if ($key == 0) {
                    $booking->nationality = $name;
                } else {
                    $passanger['nationality'][] = $name;
                }
            }
            foreach ($passangerDetail['gender'] as $key => $name) {
                if ($key == 0) {
                    $booking->gender = $name;
                } else {
                    $passanger['gender'][] = $name;
                }
            }
            foreach ($passangerDetail['passport'] as $key => $name) {
                if ($key == 0) {
                    $booking->passport = $name;
                } else {
                    $passanger['passport'][] = $name;
                }
            }
            foreach ($passangerDetail['expiry_date'] as $key => $name) {
                if ($key == 0) {
                    $booking->expiry_date = $name;
                } else {
                    $passanger['expiry_date'][] = $name;
                }
            }
            foreach ($passangerDetail['birth_date'] as $key => $name) {
                if ($key == 0) {
                    $booking->birth_date = $name;
                } else {
                    $passanger['birth_date'][] = $name;
                }
            }
            foreach ($passangerDetail['phone_number'] as $key => $name) {
                if ($key == 0) {
                    $booking->phone_number = $name;
                } else {
                    $passanger['phone_number'][] = $name;
                }
            }
            foreach ($passangerDetail['email'] as $key => $name) {
                if ($key == 0) {
                    $booking->email = $name;
                } else {
                    $passanger['email'][] = $name;
                }
            }
            foreach ($passangerDetail['address'] as $key => $name) {
                if ($key == 0) {
                    $booking->address = $name;
                } else {
                    $passanger['address'][] = $name;
                }
            }
            $booking->reference_passenger_name = $passangerDetail['reference_passenger_name'];
            $booking->reference = $passangerDetail['reference'];
            $booking->reference_gender = $passangerDetail['reference_gender'];
            $booking->terms_agree = $passangerDetail['agree'];
//dd($passanger);
            if ($booking->save()) {
                if (isset($passanger)) {
                    $count = count($passanger['name']);
                    for ($i = 0; $i < $count; $i++) {
                        $BookingPassengerDetails = new CharterBookingPassengerDetail;
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
                $charter_details = CharterPlaneFlightDetails::where('id', $result->id)->first();

                $ticket_data = [
                    'booking' => $booking,
                    'passanger' => [],
                    'charter_details' => $charter_details
                ];
//                Session::put('ticket_data', $ticket_data);
//                 Session::save();

                $ticket_pdf = PDF::loadView('create_ticket', $ticket_data);
                $ticket_name = $booking->name . '_' . $booking->booking_reference . '.pdf';
                $ticket_pdf->save(public_path() . '/charter_tickets/' . $ticket_name);

                Mail::send(new CharterFlightBooked($booking, [], $ticket_name));
            } else {
                $charter_details = CharterPlaneFlightDetails::where('id', $result->id)->first();

                $ticket_data = [
                    'booking' => $booking,
                    'passanger' => $passanger,
                    'charter_details' => $charter_details
                ];

                $ticket_pdf = PDF::loadView('create_ticket', $ticket_data);
                $ticket_name = $booking->name . '_' . $booking->booking_reference . '.pdf';
                $ticket_pdf->save(public_path() . '/charter_tickets/' . $ticket_name);

                Mail::send(new CharterFlightBooked($booking, $passanger, $ticket_name));
            }
            $data = [
                "error" => false,
                'message' => 'success'
            ];
            return response()->json($data);
        } else {
            $data = [
                "error" => true,
                'message' => 'fail'
            ];
            return response()->json($data);
        }
    }

}
