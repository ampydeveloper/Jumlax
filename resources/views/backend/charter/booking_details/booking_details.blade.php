@extends('backend.layouts.app')

@section('title', app_name() . ' | Booking Details')

@section('breadcrumb-links')
@endsection

@section('content')
<style type="text/css">
    .book-dates{
            display: inline;
    font-size: 13px;
    float: right;
    }
</style>
<div class="card">
    <div class="card-body"> 
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    {{ __('Fight Booking Details') }}
                </h4>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col">
                <h4>
                    Flight Ticket - <b>{{$booking->from}}</b> to <b>{{$booking->to}}</b>  
                    <div class="book-dates">
                        <span>
                            Booking ID: <span style="text-transform:uppercase;"><b><?php echo $booking->booking_reference; ?></b></span>
                        </span>
                        <span>
                            Booking Date: <b>{{ \Carbon\Carbon::parse($booking->created_at)->format('D, d M Y') }}</b>
                        </span>
                    </div>
                </h4>

                <hr />

                <div class="division">
                    <h4>Passenger Details</h4>
                    <table class='table'>
                        <thead>
                            <tr>
                                <th>Passenger Name</th>
                                <th>Nationality</th>
                                <th>Gender</th>
                                <th>Passport Number</th>
                                <th>Expiry Date</th>
                                <th>Birth Date</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$booking->name}}</td>
                                <td>{{$booking->nationality}}</td>
                                <td>{{$booking->gender}}</td>
                                <td>{{$booking->passport}}</td>
                                <td>{{$booking->expiry_date}}</td>
                                <td>{{$booking->birth_date}}</td>
                                <td>{{$booking->phone_number}}</td>
                                <td>{{$booking->email}}</td>
                                <td>{{$booking->address}}</td>
                            </tr>
                            <?php
                            if (!empty($passanger)) {
                                $passanger_list = count($passanger['name']);
                                for ($i = 0; $i < $passanger_list; $i++) {
                                    ?>
                                    <tr>
                                        <td><?php echo $passanger['name'][$i]; ?></td>
                                        <td><?php echo $passanger['nationality'][$i]; ?></td>
                                        <td><?php echo $passanger['gender'][$i]; ?></td>
                                        <td><?php echo $passanger['passport'][$i]; ?></td>
                                        <td><?php echo $passanger['expiry_date'][$i]; ?></td>
                                        <td><?php echo $passanger['birth_date'][$i]; ?></td>
                                        <td><?php echo $passanger['phone_number'][$i]; ?></td>
                                        <td><?php echo $passanger['email'][$i]; ?></td>
                                        <td><?php echo $passanger['address'][$i]; ?></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>

                    <h5>Reference Details</h5>
                    <table class='table'>
                        <thead>
                            <tr>
                                <th>Reference Name</th>
                                <th>Reference Phone</th>
                                <th>Gender</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$booking->reference_passenger_name}}</td>
                                <td>{{$booking->reference}}</td>
                                <td>{{$booking->reference_gender}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <hr />

                <div class="division">
                    <h5>
                        Going 
                        <!--| 3 h 55 m-->
                    </h5>
                    <table class='table'>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Time</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Flight No.</th>
                                <th>Charter</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{\Carbon\Carbon::parse($booking->departure_date_time)->format('D, d M Y')}}</td>
                                <td>{{\Carbon\Carbon::parse($booking->departure_date_time)->format('H:i a')}}</td>
                                <td>{{$booking->from}}</td>
                                <td>{{$booking->to}}</td>
                                <td>{{$booking->charterDetails->planes->plane_number}}</td>
                                <td>{{$booking->charterDetails->planes->charterDetails->name}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <p>{{ $booking->airport_name .' ('. $booking->airport_code .'), '. $booking->city_name .', '. $booking->country_name  }}</p>

                    <!--            <h4>
                                    Return | 3 h 55 m
                                </h4>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Flight No.</th>
                                            <th>Charter</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Fri, 21 Dec 2018</td>
                                            <td>Fri, 21 Dec 2018</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p>Airport name, airtort addresss, airoort country</p>-->
                </div>

                <hr />

                <div class="division">
                    <h5>Payment details</h5>
                    <table class='table'>
                        <thead>
                            <tr>
                                <th>Payment type</th>
                                <th>Card Number</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$booking->payment_method}}</td>
                                <td>-</td>
                                <td>LD {{$booking->price}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
<!--                <div>
                    <h5></h5>
                    <a href=""></a>
                </div>-->

            <a href="{{ route('admin.download-pdf', $booking->name . '_' . $booking->booking_reference . '.pdf') }}" target="_blank" class="btn btn-success ml-1" data-toggle="tooltip" title="View">
                                        Download Ticket
                                    </a>
            </div>
            <!--col-->
        </div>
        <!--row-->
    </div>
    <!--row-->
</div>
<!--card-body-->
</div>
<!--card-->
@endsection
@section('script')
<script>
    $(document).ready(function () {

    });
</script>
@endsection 