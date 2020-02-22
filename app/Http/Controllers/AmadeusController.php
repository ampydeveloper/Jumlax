<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AmadeusTokens;
//use Illuminate\Support\Facades\Session;
use App\Models\AirportDetails;
use App\Models\AirlineDetails;
use App\Models\CharterPlaneFlightDetails;
use DateTime;
use Session;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class AmadeusController extends Controller {
    /*
     * get amadeus access token
     * @param client key and secret
     * @env
     * return token
     */

    public function generateToken() {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://test.api.amadeus.com/v1/security/oauth2/token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "client_id=4feqw2rFNnRlG1x5njSuAwZPqTVVLi0x&client_secret=2woTiWNQSlKOh7mI&grant_type=client_credentials",
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $res = json_decode($response, true);
            // echo $response;
        }
        if (!empty($res['access_token']) && isset($res['access_token'])) {
            return $res['access_token'];
        } else {
            return;
        }
    }

    /*
     * get airport name based on country names and user search
     * @param access token
     * request subtype ('AIRPORT', 'CITY')
     * return airpot details 
     */

    public function getAirPortListing(Request $request) {
        $method = $request->method();

        if ($method == 'POST') {
            $airport = AirportDetails::Where('airport_name', 'like', '%' . $request->message . '%')
                    ->orWhere('city_name', 'like', '%' . $request->message . '%')
                    ->orWhere('country_name', 'like', '%' . $request->message . '%')
                    ->orWhere('airport_code', 'like', '%' . $request->message . '%')
                    ->get();
            if ($airport->count()) {
                return response()->json(['status' => true, 'data' => $airport]);
            } else {
                return response()->json(['status' => false]);
            }
        } else {
            $airport = AirportDetails::where('country_abbrev', 'IN')->get();
            $data['airports'] = $airport;
            return view('frontend.index', $data);
        }
    }

    /*
     * get charter plane details
     * @param access token
     * request subtype ('AIRPORT', 'CITY')
     * return airpot details 
     */

    public function getCharterFromListing(Request $request) {

        $method = $request->method();

        $airport = CharterPlaneFlightDetails::with('planes')
                ->Where('from', 'like', '%' . $request->message . '%')
//            ->orWhere('name', 'like', '%' . $request->message . '%')
                ->get();
        if ($airport->count()) {
            return response()->json(['status' => true, 'data' => $airport]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function getCharterToListing(Request $request) {
        $method = $request->method();
        $airport = CharterPlaneFlightDetails::with('planes')
                ->Where('to', 'like', '%' . $request->message . '%')
//            ->orWhere('name', 'like', '%' . $request->message . '%')
                ->get();
        if ($airport->count()) {
            return response()->json(['status' => true, 'data' => $airport]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    /*
     * get fliht search detail's
     * @param Post request
     * return flight details
     */

    public function getFlightListing($passenger_class, $flight_type, $from, $to, $departure, $return = null, $passenger_adult = 1, $passenger_child = 0, $passenger_infant = 0, $popular_destination) {     
           
        if ($departure == null) {
            return redirect()->back()->with('message', 'Departure field is required.');
        }
        if ($to == null) {
            return redirect()->back()->with('message', 'To field is required.');
        }
        if ($from == null) {
            return redirect()->back()->with('message', 'From field is required.');
        }

        $departure = date("Y-m-d", strtotime($departure));
        Session::put('departure', $departure);
        $requestdata['departure'] = $departure;
        Session::put('to', $to);
        $requestdata['to'] = $to;

        if ($popular_destination == 1) {
            $country = geoip($_SERVER['REMOTE_ADDR']);
            if (AirportDetails::where('airport_name', $country->city)->exists()) {
                $data['from'] = AirportDetails::where('airport_name', $country->city)->first();
                $from = $data['from']['airport_code'];
            }
        }
        Session::put('from', $from);
        $requestdata['from'] = $from;
        Session::put('class', $passenger_class);
        $requestdata['passenger_class'] = $passenger_class;
        Session::put('flight_type', $flight_type);
        $requestdata['flight_type'] = $flight_type;
        Session::put('adults', $passenger_adult);
        $requestdata['passenger_adult'] = $passenger_adult;
        Session::put('children', $passenger_child);
        $requestdata['passenger_child'] = $passenger_child;
        Session::put('infants', $passenger_infant);
        $requestdata['passenger_infant'] = $passenger_infant;

        if ($return != null && $return != 'null') {
            $return = date("Y-m-d", strtotime($return));
            Session::put('return', $return);
            $requestdata['return'] = $return;
        } else {
            $return = '';
        }

        $gettoken = AmadeusTokens::first();
        if ($gettoken) {
            $token = $gettoken->token;
        } else {
            $token = $this->generateToken();
            $amadeus = new AmadeusTokens;
            $amadeus->token = $token;
            $amadeus->save();
        }

        if (empty($return)) {

            $src = "https://test.api.amadeus.com/v2/shopping/flight-offers?originLocationCode=$from&destinationLocationCode=$to&departureDate=$departure&adults=$passenger_adult&children=$passenger_child&infants=$passenger_infant&currencyCode=LYD&travelClass=$passenger_class";
        } else {
            $src = "https://test.api.amadeus.com/v2/shopping/flight-offers?originLocationCode=$from&destinationLocationCode=$to&departureDate=$departure&returnDate=$return&adults=$passenger_adult&children=$passenger_child&infants=$passenger_infant&currencyCode=LYD&travelClass=$passenger_class";
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $src,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer $token",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $res = json_decode($response, true);
        }

        if (!empty($res['errors'])) {
            AmadeusTokens::truncate();
            $token = $this->generateToken();
            $amadeus = new AmadeusTokens;
            $amadeus->token = $token;
            $amadeus->save();
        }

        if ($res) {
            if (!empty($res['data'])) {
                $ticketsRequired = $passenger_adult + $passenger_child;
                $flights = [];
                foreach ($res['data'] as $key => $flight) {
                    if ($flight['numberOfBookableSeats'] >= $ticketsRequired) {

                        $flights[$key]['travelerPricings'] = $flight['travelerPricings'];
                        $flights[$key]['price'] = $flight['price'];
                        $flights[$key]['numberOfBookableSeats'] = $flight['numberOfBookableSeats'];
                        $flights[$key]['itineraries'] = $flight['itineraries'];

                        $explode1 = explode('PT', $flight['itineraries'][0]['duration']);
                        $flights[$key]['oneWayDetails']['duration'] = $explode1[1];
                        $count = count($flight['itineraries'][0]['segments']);
                        if ($count == 1) {
                            $flights[$key]['oneWayDetails']['stops']['total'] = 0;
                            $flights[$key]['oneWayDetails']['departure'] = $flight['itineraries'][0]['segments'][0]['departure'];
                            $flights[$key]['oneWayDetails']['arrival'] = $flight['itineraries'][0]['segments'][0]['arrival'];
                            $flights[$key]['oneWayDetails']['carrierCode'] = $flight['itineraries'][0]['segments'][0]['carrierCode'];
                            $flights[$key]['oneWayDetails']['number'] = $flight['itineraries'][0]['segments'][0]['number'];
                        } else {
                            $flights[$key]['oneWayDetails']['stops']['total'] = $count - 1;
                            $carrierCode = [];
                            foreach ($flight['itineraries'][0]['segments'] as $itinerarieKey => $itinerarieOneWay) {
                                if (!in_array($itinerarieOneWay['carrierCode'], $carrierCode)) {
                                    $carrierCode[] = $itinerarieOneWay['carrierCode'];
                                }
                                if ($itinerarieKey == 0) {
                                    $flights[$key]['oneWayDetails']['departure'] = $itinerarieOneWay['departure'];
                                    $flights[$key]['oneWayDetails']['carrierCode'] = $itinerarieOneWay['carrierCode'];
                                    $flights[$key]['oneWayDetails']['number'] = $itinerarieOneWay['number'];
                                    $flights[$key]['oneWayDetails']['stops'][$itinerarieKey + 1] = $itinerarieOneWay['arrival'];
                                } elseif ($itinerarieKey == $count - 1) {
                                    $flights[$key]['oneWayDetails']['arrival'] = $itinerarieOneWay['arrival'];
                                } else {
                                    $flights[$key]['oneWayDetails']['stops'][$itinerarieKey + 1] = $itinerarieOneWay['arrival'];
                                }
                            }
                            $flights[$key]['carrierCode'] = $carrierCode;
                            unset($carrierCode);
                        }

                        if (isset($flight['itineraries'][1])) {
                            $explode1 = explode('PT', $flight['itineraries'][1]['duration']);
                            $flights[$key]['returnDetails']['duration'] = $explode1[1];
                            $count = count($flight['itineraries'][1]['segments']);
                            if ($count == 1) {
                                $flights[$key]['returnDetails']['stops'] = 0;
                                $flights[$key]['returnDetails']['departure'] = $flight['itineraries'][1]['segments'][0]['departure'];
                                $flights[$key]['returnDetails']['arrival'] = $flight['itineraries'][1]['segments'][0]['arrival'];
                                $flights[$key]['returnDetails']['carrierCode'] = $flight['itineraries'][1]['segments'][0]['carrierCode'];
                                $flights[$key]['returnDetails']['number'] = $flight['itineraries'][1]['segments'][0]['number'];
                            } else {
                                $flights[$key]['returnDetails']['stops']['total'] = $count - 1;
                                $carrierCode = [];
                                foreach ($flight['itineraries'][1]['segments'] as $itinerarieReturnKey => $itinerarieReturn) {
                                    if (!in_array($itinerarieReturn['carrierCode'], $carrierCode)) {
                                        $carrierCode[] = $itinerarieReturn['carrierCode'];
                                    }
                                    if ($itinerarieReturnKey == 0) {
                                        $flights[$key]['returnDetails']['departure'] = $itinerarieReturn['departure'];
                                        $flights[$key]['returnDetails']['carrierCode'] = $itinerarieReturn['carrierCode'];
                                        $flights[$key]['returnDetails']['number'] = $itinerarieReturn['number'];
                                        $flights[$key]['returnDetails']['stops'][$itinerarieReturnKey + 1] = $itinerarieReturn['arrival'];
                                    } elseif ($itinerarieReturnKey == $count - 1) {
                                        $flights[$key]['returnDetails']['arrival'] = $itinerarieReturn['arrival'];
                                    } else {
                                        $flights[$key]['returnDetails']['stops'][$itinerarieReturnKey + 1] = $itinerarieReturn['arrival'];
                                    }
                                }
                                $flights[$key]['carrierCode'] = $carrierCode;
                                unset($carrierCode);
                            }
                        }
                    }
                }
                $data['flights'] = $flights;
                $data['status'] = 202;
            } else if (!empty($res['errors'])) {
                return redirect()->back()->with('message', $res['errors']);
//                return response()->json(['errors' => $res['errors']], 500);
            } else {
//                return response()->json(['message' => 'No itinerary found for requested segment!'], 500);
                return redirect()->back()->with('message', 'No itinerary found for requested segment!');
            }
        }

        if (!isset($data['from'])) {
            $data['from'] = AirportDetails::where('airport_code', $from)->first();
        }
        $data['to'] = AirportDetails::where('airport_code', $to)->first();
        $data['airline'] = AirlineDetails::get();
        $data['requestdata'] = $requestdata;

//        dd($data);

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $itemCollection = collect($data['flights']);
        $perPage = 5;
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        $paginatedItems = new LengthAwarePaginator($currentPageItems, count($itemCollection), $perPage);
//        dd($request->url());
        $paginatedItems->setPath(url('flight-search-listing'));
//        $data['paginatedItems'] = $paginatedItems;
         $data['paginatedItems'] = $data['flights'];
//        dd($data['paginatedItems']);
        Session::put('amadeus_result_data', $data);
         return response()->json(['data' => $data], 200);
//        return redirect(url('flight-search-listing'));
        die;
    }

    public function getFlightListingView(Request $request, $passenger_class, $flight_type, $from, $to, $departure, $return = null, $passenger_adult = 1, $passenger_child = 0, $passenger_infant = 0, $popular_destination) {
        $data = Session::get('amadeus_result_data');
        
        if(!$data){
            $makeRequest = $this->getFlightListing($passenger_class, $flight_type, $from, $to, $departure, $return = null, $passenger_adult = 1, $passenger_child = 0, $passenger_infant = 0, $popular_destination);
            $data = json_decode(json_encode($makeRequest), true)['original']['data'];
        }

        $parts = parse_url(\Request::getRequestUri());
        if (isset($parts['query'])) {
            parse_str($parts['query'], $query);
            $currentPage = (int) $query['page'];
        } else {
            $currentPage = 1;
        }
        $itemCollection = collect($data['flights']);
        $perPage = 5;
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        $paginatedItems = new LengthAwarePaginator($currentPageItems, count($itemCollection), $perPage);
        $paginatedItems->setPath(url('flight-search-listing'));
//        $data['paginatedItems'] = $paginatedItems;
         $data['paginatedItems'] = $data['flights'];
        $data['currentPage'] = $currentPage;
        return view('frontend.search_result', $data);
    }

    //get contact us page
    public function getContact() {
        return view('frontend.contact');
    }

    public function getCharterListing(Request $request) {

dd('123');
        $request->validate([
            'charter_type' => 'required',
            'charter-class' => 'required',
            'charter-departure' => 'required',
            'charter-return' => 'required',
            'charter-adult' => 'required',
            'charter-child' => 'required',
        ]);

        dd($request->all());
    }

    public function getPDF(Request $request) {
        if ($request->hasFile('pdf')) {
            $file = $request->file('pdf');

            $customerArr = $this->csvToArray($file);

            foreach ($customerArr as $value) {

                $airlines = new AirlineDetails;
                $airlines->al_code = $value['AL_CDA'];
                $airlines->al_code_number = $value['AL_CDN'];
                $airlines->al_icao = $value['ICAO'];
                $airlines->al_name = $value['AIRLINE'];
                $airlines->al_country = $value['COUNTRY'];
                $airlines->save();
            }


            return 'Job done or what ever';
        }
    }

    function csvToArray($filename = '', $delimiter = ',') {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
    }

}
