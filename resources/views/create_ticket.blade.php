<!DOCTYPE html>
<html>
    <head>
        <title>Charter Booking Ticket</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style type="text/css">
            @import url('https://fonts.googleapis.com/css?family=Lato:400,700&display=swap');
            body{
                font-family: Lato, "Helvetica Neue", Arial, sans-serif;
                font-size: 14px;
                font-weight: 400;
                line-height: 1.5;
                color: #212529;
                text-align: left;
            }
            .header .align-wid{
                width:50%;
                float:left;
            }
            .header .align-right{
                text-align:right;
            }
            .booking-d .align-right{
                text-align:right;
            }
            .booking-d{
                font-size:14px;
                margin-top:15px;
                width:100%;
            }
            h4{
                margin:5px;
                margin-left:0;
                font-size:14px;
            }
            hr{
                margin-top: 10px;
                margin-bottom: 10px;
                border-top: 1px solid #000;
            }
            .footer-d{
                font-size:13px;
            }
            .footer-d ul{
                padding-left:10px;
                font-size:13px;
            }
            .footer-d h5{
                margin: 15px 0 0px 0;
            }
            .division{
                margin-bottom:20px;
            }
            table, div, img, span{
                margin:0;
                padding:0;
            }
            table{
                width: 100%;
                margin-bottom: 15px;
                font-size:12px;
                border-bottom: 1px solid #dee2e6;
            }
            table thead th {
                vertical-align: bottom;
                margin:0;
            }
            table td, table th {
                padding: 5px;
                vertical-align: top;
                border-top: 1px solid #dee2e6;
                margin:0;
            }
            .clearfix:after {
                content: "";
                display: table;
                clear: both;
            }
        </style>
    </head>
    <body>
        <div class="header">
            <div class="align-wid">
                <img class="img-responsive center-block" src="{{ asset('/images/logo-white.png') }}" width="166" height="55" alt="">
            </div>
            <div class="align-wid align-right">
                <img src="{{ asset('/charter_logos/'.$charter_details->planes->charterDetails->logo) }}" height="40" alt="" />
            </div>
            <div class="clearfix"></div>
            <div class="booking-d align-right">
                <span>
                    Booking ID: <span style="text-transform:uppercase;"><b><?php echo $booking->booking_reference; ?></b></span>
                </span>
                <span>
                    Booking Date: <b>{{ \Carbon\Carbon::parse($booking->created_at)->format('D, d M Y') }}</b>
                </span>
            </div>
        </div>

        <h3>
            Flight Ticket - <b>{{$booking->from}}</b> to <b>{{$booking->to}}</b>  
        </h3>

        <hr />

        <div class="division">
            <h4>Passenger Details</h4>
            <table>
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

            <h4>Reference Details</h4>
            <table>
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
            <h4>
                Going 
                <!--| 3 h 55 m-->
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
                        <td>{{\Carbon\Carbon::parse($booking->departure_date_time)->format('D, d M Y')}}</td>
                        <td>{{\Carbon\Carbon::parse($booking->departure_date_time)->format('H:i a')}}</td>
                        <td>{{$booking->from}}</td>
                        <td>{{$booking->to}}</td>
                        <td>{{$charter_details->planes->plane_number}}</td>
                        <td>{{$charter_details->planes->charterDetails->name}}</td>
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
            <h4>Payment details</h4>
            <table>
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

        <hr />

        <div class='footer-d'>

            <h5>Visa Information</h5>
            <ul>
                <li>Your booking is confirmed separately with each airline. Every airline will issue its own booking reference number.</li>
                <li>Please be informed that your baggage allowance is as per the Charter policy and may differ for each sector.</li>
            </ul>
        </div>

    </body>
</html>