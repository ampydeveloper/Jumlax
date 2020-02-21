<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\CharterPlanes;
use App\Models\CharterPlaneFlightDetails;
use App\Models\CharterDetails;
use App\Models\CharterPlane;
use App\Models\CharterBooking;
use PDF;
use Response;

class ChatterController extends Controller {

    public function charterBooking() {
        $data['charter_bookings'] = CharterDetails::where('user_id', Auth::user()->id)->with('allPlanes.flight_details.booking_details.passengers')->get()->toArray();
        return view('backend.charter.booking_details.booking', $data);
    }

    public function charterBookingDetails($id) {
        $data['booking'] = CharterBooking::where('id', $id)->with('passengers')->with('charterDetails.planes.charterDetails')->first();
//        dd(public_path()."/charter_tickets/Manpreet Singh_0d3sot5hxqck3og.pdf");
        return view('backend.charter.booking_details.booking_details', $data);
    }

    public function charterPlane() {
        $data['charter_planes'] = CharterPlanes::where('user_id', Auth::user()->id)->get();
        return view('backend.charter.charter_plane.charter_plane', $data);
    }

    public function addcharterPlane() {
        $data['charter_details'] = CharterDetails::where('user_id', Auth::user()->id)->get();
        return view('backend.charter.charter_plane.add_charter_plane', $data);
    }

    public function savecharterPlane(Request $request) {
        $this->validate($request, [
//            'charter_details_id' => ['required'],
            'name' => ['required'],
            'plane_number' => ['required'],
            'seats' => ['required'],
        ]);

        $charter_details = CharterDetails::where('user_id', Auth::user()->id)->first();
        $addCharter = new CharterPlanes;
        $addCharter->user_id = Auth::user()->id;
        $addCharter->charter_details_id = $charter_details->id;
        $addCharter->name = $request->name;
        $addCharter->plane_number = $request->plane_number;
        $addCharter->seats = $request->seats;
        $addCharter->save();

        return redirect()->route('admin.charter-plane')->withFlashSuccess(__('Charter plane details added successfully.'));
    }

    public function editcharterPlane($id) {
        $data['charter_plane_details'] = CharterPlanes::where('id', $id)->with('CharterDetails')->first();
//        $data['charter_details'] = CharterDetails::where('user_id', Auth::user()->id)->get();
        return view('backend.charter.charter_plane.edit_charter_plane', $data);
    }

    public function updatecharterPlane(Request $request, $id) {
        $data = $request->all();
        $this->validate($request, [
//            'charter_details_id' => ['required'],
            'name' => ['required'],
            'plane_number' => ['required'],
            'seats' => ['required'],
        ]);

//        $charterPlaneDetails['charter_details_id'] = $data['charter_details_id'];
        $charterPlaneDetails['name'] = $data['name'];
        $charterPlaneDetails['plane_number'] = $data['plane_number'];
        $charterPlaneDetails['seats'] = $data['seats'];

        if (CharterPlanes::where('id', $id)->update($charterPlaneDetails)) {
            return redirect()->route('admin.charter-plane')->withFlashSuccess(__('Charter plane Details edited successfully.'));
        }
    }

    public function deletecharterPlane($id) {
        if (CharterPlanes::where('id', $id)->delete()) {
            return redirect()->route('admin.charter-plane')->withFlashSuccess(__('Charter plane Details deleted successfully.'));
        }
    }

    public function charterDetails() {
        $data['charter_details'] = CharterDetails::where('user_id', Auth::user()->id)->get();
        return view('backend.charter.charter_details.all_charter_details', $data);
    }

    public function addCharterDetails() {
        return view('backend.charter.charter_details.add_charter_details');
    }

    public function saveCharterDetails(Request $request) {
        $this->validate($request, [
            'name' => ['required'],
            'code' => ['required'],
            'country' => ['required'],
            'logo' => ['required']
        ]);

        $uploadedFile = $request->file('logo');
        $filename = time() . $uploadedFile->getClientOriginalName();
        $destinationPath = 'charter_logos';
        $uploadedFile->move($destinationPath, $filename);

        $addCharterDetails = new CharterDetails;
        $addCharterDetails->user_id = Auth::user()->id;
        $addCharterDetails->name = $request->name;
        $addCharterDetails->code = $request->code;
        $addCharterDetails->country = $request->country;
        $addCharterDetails->logo = $filename;
        $addCharterDetails->save();

        return redirect()->route('admin.charter-details')->withFlashSuccess(__('Charter Details added successfully.'));
    }

    public function editCharterDetails($id) {
        $data['charter_details'] = CharterDetails::where('id', $id)->first();
        return view('backend.charter.charter_details.edit_charter_details', $data);
    }

    public function updateCharterDetails(Request $request, $id) {
        $data = $request->all();
        $this->validate($request, [
            'name' => ['required'],
            'code' => ['required'],
            'country' => ['required'],
        ]);

        $charterDetails['name'] = $data['name'];
        $charterDetails['code'] = $data['code'];
        $charterDetails['country'] = $data['country'];

        if ($request->file('logo') != null) {
            $uploadedFile = $request->file('logo');
            $filename = time() . $uploadedFile->getClientOriginalName();
            $destinationPath = 'charter_logos';
            $uploadedFile->move($destinationPath, $filename);
            $charterDetails['logo'] = $filename;
        }

        if (CharterDetails::where('id', $id)->update($charterDetails)) {
            return redirect()->route('admin.charter-details')->withFlashSuccess(__('Charter Details edited successfully.'));
        }
    }

    public function deletecharterDetails($id) {
        if (CharterDetails::where('id', $id)->delete()) {
            return redirect()->route('admin.charter-details')->withFlashSuccess(__('Charter Details deleted successfully.'));
        }
    }

    public function flightDetails() {
        $data['charter_planes_details '] = [];
//        $charter_details = CharterDetails::with('allPlanes.flight_details')->get();
        $charter_details = CharterDetails::where('user_id', Auth::user()->id)->with('allPlanes.flight_details')->first();
        if (!empty($charter_details['allPlanes']) && count($charter_details['allPlanes']) > 0) {
            $data['charter_planes_details'] = $charter_details['allPlanes'][0]['flight_details'];
        }
//        $data['charter_planes_details'] = CharterPlaneFlightDetails::where('user_id', Auth::user()->id)->with('planes')->get();
        return view('backend.charter.flight_details.charter-flight-details', $data);
    }

    public function addFlightDetails() {
        $data['charter_planes'] = CharterPlanes::where('user_id', Auth::user()->id)->get();

        return view('backend.charter.flight_details.add-charter-flight-details', $data);
    }

    public function saveFlightDetails(Request $request) {
        $this->validate($request, [
            'plane_id' => ['required'],
            'departure_date' => ['required'],
            'arriving_date' => ['required'],
            'departure_time' => ['required'],
            'arriving_time' => ['required'],
            'location' => ['required'],
            'destination' => ['required'],
            'economy_seat' => ['required'],
            'economy_price' => ['required'],
            'premium_seat' => ['required'],
            'premium_price' => ['required'],
            'business_seat' => ['required'],
            'business_price' => ['required'],
            'first_seat' => ['required'],
            'first_price' => ['required'],
            'airport_code' => ['required'],
            'airport_name' => ['required'],
            'country_name' => ['required'],
            'city_name' => ['required'],
        ]);

        // add plane details
        if ($request->plane_id > 0) {
            $addPlaneDetails = new CharterPlaneFlightDetails;
            $addPlaneDetails->plane_id = $request->plane_id;
            $addPlaneDetails->from = $request->location;
            $addPlaneDetails->to = $request->destination;

            $addPlaneDetails->economy_seat = $request->economy_seat;
            $addPlaneDetails->economy_price = $request->economy_price;
            $addPlaneDetails->premium_seat = $request->premium_seat;
            $addPlaneDetails->premium_price = $request->premium_price;
            $addPlaneDetails->business_seat = $request->business_seat;
            $addPlaneDetails->business_price = $request->business_price;
            $addPlaneDetails->first_seat = $request->first_seat;
            $addPlaneDetails->first_price = $request->first_price;

            $addPlaneDetails->airport_code = $request->airport_code;
            $addPlaneDetails->airport_name = $request->airport_name;
            $addPlaneDetails->country_name = $request->country_name;
            $addPlaneDetails->city_name = $request->city_name;
            $addPlaneDetails->departure_time = date('Y-m-d h:i:s', strtotime($request->departure_date.' '.$request->departure_time));
            $addPlaneDetails->arriving_time = date('Y-m-d h:i:s', strtotime($request->arriving_date.' '.$request->arriving_time));
            $addPlaneDetails->save();
        } else {
            return redirect()->back()->withFlashDanger(__('Please Select Plane to proceed further.'));
        }

        return redirect()->route('admin.flight-details')->withFlashSuccess(__('Charter Flight Details added successfully'));
    }

    public function editFlightDetails($id) {
        $data['charter_planes'] = CharterPlanes::where('user_id', Auth::user()->id)->get();
        $data['charter_planes_details'] = CharterPlaneFlightDetails::where('id', $id)->with('planes')->first();
        return view('backend.charter.flight_details.edit_charter_flight_details', $data);
    }

    public function updateFlightDetails(Request $request, $id) {
        $data = $request->all();
        $this->validate($request, [
            'plane_id' => ['required'],
            'departure_date' => ['required'],
            'arriving_date' => ['required'],
            'departure_time' => ['required'],
            'arriving_time' => ['required'],
            'from' => ['required'],
            'to' => ['required'],
            'economy_seat' => ['required'],
            'economy_price' => ['required'],
            'premium_seat' => ['required'],
            'premium_price' => ['required'],
            'business_seat' => ['required'],
            'business_price' => ['required'],
            'first_seat' => ['required'],
            'first_price' => ['required'],
            'airport_code' => ['required'],
            'airport_name' => ['required'],
            'country_name' => ['required'],
            'city_name' => ['required'],
        ]);
        if ($data['plane_id'] > 0) {
            $charterDetails['plane_id'] = $data['plane_id'];
            $charterDetails['from'] = $data['from'];
            $charterDetails['to'] = $data['to'];

            $charterDetails['economy_seat'] = $data['economy_seat'];
            $charterDetails['economy_price'] = $data['economy_price'];
            $charterDetails['premium_seat'] = $data['premium_seat'];
            $charterDetails['premium_price'] = $data['premium_price'];
            $charterDetails['business_seat'] = $data['business_seat'];
            $charterDetails['business_price'] = $data['business_price'];
            $charterDetails['first_seat'] = $data['first_seat'];
            $charterDetails['first_price'] = $data['first_price'];

            $charterDetails['airport_code'] = $data['airport_code'];
            $charterDetails['airport_name'] = $data['airport_name'];
            $charterDetails['country_name'] = $data['country_name'];
            $charterDetails['city_name'] = $data['city_name'];
            $charterDetails['departure_time'] = date('Y-m-d h:i:s', strtotime($data['departure_date'].' '.$data['departure_time']));
            $charterDetails['arriving_time'] = date('Y-m-d h:i:s', strtotime($data['arriving_date'].' '.$data['arriving_time']));
        } else {
            return redirect()->back()->withFlashDanger(__('Please Select Plane to proceed further.'));
        }

        if (CharterPlaneFlightDetails::where('id', $id)->update($charterDetails)) {
            return redirect()->route('admin.flight-details')->withFlashSuccess(__('Charter Flight edited successfully.'));
        }
    }

    public function deleteFlightDetails($id) {
        if (CharterPlaneFlightDetails::where('id', $id)->delete()) {
            return redirect()->route('admin.flight-details')->withFlashSuccess(__('Charter Flight deleted successfully.'));
        }
    }
    
    public function download_pdf($fileName) {
        $file = public_path() . "/charter_tickets/".$fileName;
        $headers = array(
            'Content-Type: application/pdf',
        );
        return Response::download($file, 'ticket.pdf', $headers);
    }

}
