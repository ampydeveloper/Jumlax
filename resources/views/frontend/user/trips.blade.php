@extends('frontend.layouts.app')

@section('nav')
@include('frontend.includes.nav')
@endsection

@section('title', app_name() . ' | My Trips')

@section('content')
<section class="container-fluid section-lg-120 gray-back">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box trips-box">
                    <h3>My Trips</h3>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="upcoming-tab" data-toggle="tab" href="#upcoming" role="tab" aria-controls="upcoming" aria-selected="true">Upcoming</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="previous-tab" data-toggle="tab" href="#previous" role="tab" aria-controls="previous" aria-selected="false">Previous</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="upcoming" role="tabpanel" aria-labelledby="upcoming-tab">
                            <?php if(isset($upcoming)) {
                                if(isset($upcoming['flight'])) { ?>
                            <h3>Flights</h3>
                            <?php
                                    foreach($upcoming['flight'] as $flight) { ?>
                                        <ul class="list-tickets my-trips-list">
                                            <li class="list-item">
                                                <div class="list-item-inner">
                                                    <div class="list-item-main list-item-heading1">
                                                        <div class="list-item-footer">
                                                            <h5 class="text-bold list-item-price">
                                                                {{ $flight['booking_details']['currency'].' '.$flight['booking_details']['price'] --}}
                                                            </h5>
                                                            <h5 class="text-bold list-item-price">Booking ID: {{ $flight['booking_details']['booking_reference']}}</h5>
                                                        </div>
                                                    </div>
                                                    <div class="list-item-main list-item-plane-details">
                                                        <div class="plane-details">
                                                            <span>Departure | </span>
                                                            {{ $flight['booking_details']['onewayDepatureDate']. " | ".$flight['booking_details']['onewayCarrierName'] }}
                                                        </div> 
                                                        @if($flight['booking_details']['returnDuration']) 
                                                        <div class="plane-details">
                                                            <span>Return | </span>
                                                            @php
                                                            $returnCarrier = isset($flight['booking_details']['returnCarrierName']) ? " | ".$flight['booking_details']['returnCarrierName']:'';
                                                            @endphp
                                                            {{$flight['booking_details']['returnDepatureDate'].$returnCarrier}} 
                                                        </div> 
                                                        @endif
                                                    </div> 

                                                    <div class="list-item-main list-item-flights">
                                                        <hr class="divider divider-wide">
                                                        <div class="list-item-top">
                                                            <div class="list-item-content">
                                                                <div class="list-item-content-left">
                                                                    <div class="text-bold text-base">{{$flight['booking_details']['onewayDepatureTime']}}</div>
                                                                    <span class="small d-block">{{$flight['booking_details']['onewayDepatureAirport']}} </span>
                                                                    @if(isset($flight['booking_details']['onewayDepatureTerminal']))
                                                                    <span class="small d-block">Terminal {{$flight['booking_details']['onewayDepatureTerminal']}} </span>
                                                                    @endif
                                                                </div>
                                                                <div class="list-item-content-line-wrapper small">
                                                                    <div class="list-item-content-line-top">
                                                                        @php
                                                                        $resStr1 = str_replace('H', ' hrs ', $flight['booking_details']['totalOnwayDuration']);
                                                                        $resStr1 = str_replace('M', ' mins', $resStr1);
                                                                        @endphp
                                                                        {{$resStr1}}
                                                                    </div>  
<!--                                                                    @php
                                                                    $toolTipData = $flight['booking_details']['onwayNoOfStops']." Plane Change"
                                                                    @endphp-->
                                                                    
                                                                    <div class="list-item-content-line"></div>
                                                                    <div class="list-item-content-line-bottom text-info-dr link" data-tooltip="">
                                                                        {{$flight['booking_details']['onwayNoOfStops']}} stops
                                                                    </div>
                                                                </div>
                                                                <div class="list-item-content-right">
                                                                    <div class="text-bold text-base">{{$flight['booking_details']['onewayArrivalTime']}} </div>
                                                                    <span class="small d-block">{{$flight['booking_details']['onewayArrivalAirport']}} </span>
                                                                    @if(isset($flight['booking_details']['onewayArrivalTerminal']))
                                                                    <span class="small d-block">Terminal {{$flight['booking_details']['onewayArrivalTerminal']}} </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        @if($flight['booking_details']['returnDuration']) 
                                                        
                                                        <hr class="divider divider-wide">
                                                        <div class="list-item-top">
                                                            <div class="list-item-content">
                                                                <div class="list-item-content-left">
                                                                    <div class="text-bold text-base">{{$flight['booking_details']['returnDepatureTime']}}</div>
                                                                    <span class="small d-block">{{ $flight['booking_details']['returnDepatureAirport'] }} </span>
                                                                    @if(isset($flight['booking_details']['returnDepatureTerminal']))
                                                                    <span class="small d-block">Terminal {{$flight['booking_details']['returnDepatureTerminal']}} </span>
                                                                    @endif
                                                                </div>
                                                                <div class="list-item-content-line-wrapper small" >
                                                                    <div class="list-item-content-line-top">
                                                                        @php
                                                                        $resStr1 = str_replace('H', ' hrs ', $flight['booking_details']['returnDuration']);
                                                                        $resStr1 = str_replace('M', ' mins', $resStr1);
                                                                        @endphp
                                                                        {{ $resStr1 }}
                                                                    </div>
                                                                    <div class="list-item-content-line"></div>
                                                                    <div class="list-item-content-line-bottom text-info-dr">
                                                                        {{ $flight['booking_details']['returnNoOfStops'] }} stops
                                                                    </div>
                                                                </div>
                                                                <div class="list-item-content-right">
                                                                    <div class="text-bold text-base">{{$flight['booking_details']['returnArrivalTime']}} </div>
                                                                    <span class="small d-block">{{ $flight['booking_details']['returnArrivalAirport'] }} </span>
                                                                    @if(isset($flight['booking_details']['returnArrivalTerminal']))
                                                                    <span class="small d-block">Terminal {{$flight['booking_details']['returnArrivalTerminal']}} </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <div class="list-item-passanger">
                                                        <h5>Passengers Details</h5>
                                                        <div class="each-passenger clearfix">
                                                            <h6>Passenger</h6>
                                                            <div class="col-sm-4"><span>Name:</span> <?php echo $flight['name']; ?></div>
                                                            <div class="col-sm-4"><span>Phone:</span> <?php echo $flight['phone_number']; ?></div>
                                                            <div class="col-sm-4"><span>Email:</span> <?php echo $flight['email']; ?></div>
                                                            <div class="col-sm-4"><span>Address:</span> <?php echo $flight['address']; ?></div>
                                                            <div class="col-sm-4"><span>Gender:</span> <?php echo $flight['gender']; ?></div>
                                                        </div>                                               
                                                        <?php
                                                        if (isset($flight['passengers'])) {
                                                            foreach ($flight['passengers'] as $passengers) {
                                                                ?>
                                                                <div class="each-passenger clearfix">
                                                                    <h6>Passenger</h6>
                                                                    <div class="col-sm-4"><span>Name:</span> <?php echo $passengers['name']; ?></div>
                                                                    <div class="col-sm-4"><span>Phone:</span> <?php echo $passengers['phone_number']; ?></div>
                                                                    <div class="col-sm-4"><span>Email:</span> <?php echo $passengers['email']; ?></div>
                                                                    <div class="col-sm-4"><span>Address:</span> <?php echo $passengers['address']; ?></div>
                                                                    <div class="col-sm-4"><span>Gender:</span> <?php echo $passengers['gender']; ?></div>
                                                                </div>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                   <?php }
                                } ?>
                            
                            <?php
                                if(isset($upcoming['charter_flight'])) { ?>
                            <h3>Charter Flights</h3>
                            <?php
                                    foreach($upcoming['charter_flight'] as $flight) { ?>
                                        <ul class="list-tickets my-trips-list">
                                            <li class="list-item">
                                                <div class="list-item-inner">
                                                    <div class="list-item-main list-item-heading1">
                                                        <div class="list-item-footer">
                                                            <h5 class="text-bold list-item-price">
                                                                {{ $flight['booking_details']['currency'].' '.$flight['booking_details']['price'] --}}
                                                            </h5>
                                                            <h5 class="text-bold list-item-price">{{ $flight['booking_details']['booking_reference']}}</h5>
                                                        </div>
                                                    </div>
                                                    <div class="list-item-main list-item-plane-details">
                                                        <div class="plane-details">
                                                            <span>Departure | </span>
                                                            {{ $flight['booking_details']['onewayDepatureDate']. " | ".$flight['booking_details']['onewayCarrierName'] }}
                                                        </div> 
                                                    </div> 

                                                    <div class="list-item-main list-item-flights">
                                                        <hr class="divider divider-wide">
                                                        <div class="list-item-top">
                                                            <div class="list-item-content">
                                                                <div class="list-item-content-left">
                                                                    <div class="text-bold text-base">{{$flight['booking_details']['onewayDepatureTime']}}</div>
                                                                    <span class="small d-block">{{$flight['booking_details']['onewayDepatureAirport']}} </span>
                                                                    @if(isset($flight['booking_details']['onewayDepatureTerminal']))
                                                                    <span class="small d-block">Terminal {{$flight['booking_details']['onewayDepatureTerminal']}} </span>
                                                                    @endif
                                                                </div>
                                                                <div class="list-item-content-line-wrapper small">
                                                                    <div class="list-item-content-line-top"> 
                                                                        {{$flight['booking_details']['totalOnwayDuration']}}
                                                                    </div>
                                                                    <div class="list-item-content-line"></div>
                                                                    <div class="list-item-content-line-bottom text-info-dr">
                                                                        {{$flight['booking_details']['onwayNoOfStops']}} stops
                                                                    </div>
                                                                </div>
                                                                <div class="list-item-content-right">
                                                                    <div class="text-bold text-base">{{$flight['booking_details']['onewayArrivalTime']}} </div>
                                                                    <span class="small d-block">{{$flight['booking_details']['onewayArrivalAirport']}} </span>
                                                                    @if(isset($flight['booking_details']['onewayArrivalTerminal']))
                                                                    <span class="small d-block">Terminal {{$flight['booking_details']['onewayArrivalTerminal']}} </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                    <div class="list-item-passanger">
                                                        <h5>Passengers Details</h5>
                                                        <div class="each-passenger clearfix">
                                                            <h6>Passenger</h6>
                                                            <div class="col-sm-4"><span>Name:</span> <?php echo $flight['name']; ?></div>
                                                            <div class="col-sm-4"><span>Phone:</span> <?php echo $flight['phone_number']; ?></div>
                                                            <div class="col-sm-4"><span>Email:</span> <?php echo $flight['email']; ?></div>
                                                            <div class="col-sm-4"><span>Address:</span> <?php echo $flight['address']; ?></div>
                                                            <div class="col-sm-4"><span>Gender:</span> <?php echo $flight['gender']; ?></div>
                                                        </div>                                               
                                                        <?php
                                                        if (isset($flight['passengers'])) {
                                                            foreach ($flight['passengers'] as $passengers) {
                                                                ?>
                                                                <div class="each-passenger clearfix">
                                                                    <h6>Passenger</h6>
                                                            <?php // dd($passengers); ?>
                                                                    <div class="col-sm-4"><span>Name:</span> <?php echo $passengers['name']; ?></div>
                                                                    <div class="col-sm-4"><span>Phone:</span> <?php echo $passengers['phone_number']; ?></div>
                                                                    <div class="col-sm-4"><span>Email:</span> <?php echo $passengers['email']; ?></div>
                                                                    <div class="col-sm-4"><span>Address:</span> <?php echo $passengers['address']; ?></div>
                                                                    <div class="col-sm-4"><span>Gender:</span> <?php echo $passengers['gender']; ?></div>
                                                                </div>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                <?php    }
                                }
                            } else { ?>
                                <div class="icon">
                               <i class="fa fa-suitcase-rolling"></i>
                           </div>
                           <div class="desc">
                               <h5>Looks empty, you've no upcoming bookings.</h5>
                               <small>When you book a trip, you will see your itinerary here.</small>
                           </div>
                            <div class="clearfix"></div>
                           <?php }
                            ?>
                        </div>
                        <div class="tab-pane fade show" id="previous" role="tabpanel" aria-labelledby="previous-tab">
                            <?php if(isset($previous)) {
                                if(isset($previous['flight'])) { ?>
                            <h3>Flights</h3>
                            <?php
                                    foreach($previous['flight'] as $flight) { ?>
                                        <ul class="list-tickets my-trips-list">
                                            <li class="list-item">
                                                <div class="list-item-inner">
                                                    <div class="list-item-main list-item-heading1">
                                                        <div class="list-item-footer">
                                                            <h5 class="text-bold list-item-price">
                                                                {{ $flight['booking_details']['currency'].' '.$flight['booking_details']['price'] --}}
                                                            </h5>
                                                            <h5 class="text-bold list-item-price">Booking ID: {{ $flight['booking_details']['booking_reference']}}</h5>
                                                        </div>
                                                    </div>
                                                    <div class="list-item-main list-item-plane-details">
                                                        <div class="plane-details">
                                                            <span>Departure | </span>
                                                            {{ $flight['booking_details']['onewayDepatureDate']. " | ".$flight['booking_details']['onewayCarrierName'] }}
                                                        </div> 
                                                        @if($flight['booking_details']['returnDuration']) 
                                                        <div class="plane-details">
                                                            <span>Return | </span>
                                                            {{$flight['booking_details']['returnDepatureDate']. " | ".isset($flight['booking_details']['returnCarrierName'])}} 
                                                        </div> 
                                                        @endif
                                                    </div> 

                                                    <div class="list-item-main list-item-flights">
                                                        <hr class="divider divider-wide">
                                                        <div class="list-item-top">
                                                            <div class="list-item-content">
                                                                <div class="list-item-content-left">
                                                                    <div class="text-bold text-base">{{$flight['booking_details']['onewayDepatureTime']}}</div>
                                                                    <span class="small d-block">{{$flight['booking_details']['onewayDepatureAirport']}} </span>
                                                                    @if(isset($flight['booking_details']['onewayDepatureTerminal']))
                                                                    <span class="small d-block">Terminal {{$flight['booking_details']['onewayDepatureTerminal']}} </span>
                                                                    @endif
                                                                </div>
                                                                <div class="list-item-content-line-wrapper small">
                                                                    <div class="list-item-content-line-top"> 
                                                                        {{$flight['booking_details']['totalOnwayDuration']}}
                                                                    </div>
                                                                    <div class="list-item-content-line"></div>
                                                                    <div class="list-item-content-line-bottom text-info-dr">
                                                                        {{$flight['booking_details']['onwayNoOfStops']}} stops
                                                                    </div>
                                                                </div>
                                                                <div class="list-item-content-right">
                                                                    <div class="text-bold text-base">{{$flight['booking_details']['onewayArrivalTime']}} </div>
                                                                    <span class="small d-block">{{$flight['booking_details']['onewayArrivalAirport']}} </span>
                                                                    @if(isset($flight['booking_details']['onewayArrivalTerminal']))
                                                                    <span class="small d-block">Terminal {{$flight['booking_details']['onewayArrivalTerminal']}} </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        @if($flight['booking_details']['returnDuration']) 
                                                        
                                                        <hr class="divider divider-wide">
                                                        <div class="list-item-top">
                                                            <div class="list-item-content">
                                                                <div class="list-item-content-left">
                                                                    <div class="text-bold text-base">{{$flight['booking_details']['returnDepatureTime']}}</div>
                                                                    <span class="small d-block">{{ $flight['booking_details']['returnDepatureAirport'] }} </span>
                                                                    @if(isset($flight['booking_details']['returnDepatureTerminal']))
                                                                    <span class="small d-block">Terminal {{$flight['booking_details']['returnDepatureTerminal']}} </span>
                                                                    @endif
                                                                </div>
                                                                <div class="list-item-content-line-wrapper small" >
                                                                    <div class="list-item-content-line-top">
                                                                        {{ $flight['booking_details']['returnDuration'] }}
                                                                    </div>
                                                                    <div class="list-item-content-line"></div>
                                                                    <div class="list-item-content-line-bottom text-info-dr">
                                                                        {{ $flight['booking_details']['returnNoOfStops'] }} stops
                                                                    </div>
                                                                </div>
                                                                <div class="list-item-content-right">
                                                                    <div class="text-bold text-base">{{$flight['booking_details']['returnArrivalTime']}} </div>
                                                                    <span class="small d-block">{{ $flight['booking_details']['returnArrivalAirport'] }} </span>
                                                                    @if(isset($flight['booking_details']['returnArrivalTerminal']))
                                                                    <span class="small d-block">Terminal {{$flight['booking_details']['returnArrivalTerminal']}} </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <div class="list-item-passanger">
                                                        <h5>Passengers Details</h5>
                                                        <div class="each-passenger clearfix">
                                                            <h6>Passenger</h6>
                                                            <div class="col-sm-4"><span>Name:</span> <?php echo $flight['name']; ?></div>
                                                            <div class="col-sm-4"><span>Phone:</span> <?php echo $flight['phone_number']; ?></div>
                                                            <div class="col-sm-4"><span>Email:</span> <?php echo $flight['email']; ?></div>
                                                            <div class="col-sm-4"><span>Address:</span> <?php echo $flight['address']; ?></div>
                                                            <div class="col-sm-4"><span>Gender:</span> <?php echo $flight['gender']; ?></div>
                                                        </div>                                               
                                                        <?php
                                                        if (isset($flight['passengers'])) {
                                                            foreach ($flight['passengers'] as $passengers) {
                                                                ?>
                                                                <div class="each-passenger clearfix">
                                                                    <h6>Passenger</h6>
                                                            <?php // dd($passengers); ?>
                                                                    <div class="col-sm-4"><span>Name:</span> <?php echo $passengers['name']; ?></div>
                                                                    <div class="col-sm-4"><span>Phone:</span> <?php echo $passengers['phone_number']; ?></div>
                                                                    <div class="col-sm-4"><span>Email:</span> <?php echo $passengers['email']; ?></div>
                                                                    <div class="col-sm-4"><span>Address:</span> <?php echo $passengers['address']; ?></div>
                                                                    <div class="col-sm-4"><span>Gender:</span> <?php echo $passengers['gender']; ?></div>
                                                                </div>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                   <?php }
                                } ?>
                            
                            <?php
                                if(isset($previous['charter_flight'])) { ?>
                            <h3>Charter Flights</h3>
                            <?php
                                    foreach($previous['charter_flight'] as $flight) { ?>
                                        <ul class="list-tickets my-trips-list">
                                            <li class="list-item">
                                                <div class="list-item-inner">
                                                    <div class="list-item-main list-item-heading1">
                                                        <div class="list-item-footer">
                                                            <h5 class="text-bold list-item-price">
                                                                {{ $flight['booking_details']['currency'].' '.$flight['booking_details']['price'] --}}
                                                            </h5>
                                                            <h5 class="text-bold list-item-price">Booking ID: {{ $flight['booking_details']['booking_reference']}}</h5>
                                                        </div>
                                                    </div>
                                                    <div class="list-item-main list-item-plane-details">
                                                        <div class="plane-details">
                                                            <span>Departure | </span>
                                                            {{ $flight['booking_details']['onewayDepatureDate']. " | ".$flight['booking_details']['onewayCarrierName'] }}
                                                        </div> 
                                                    </div> 

                                                    <div class="list-item-main list-item-flights">
                                                        <hr class="divider divider-wide">
                                                        <div class="list-item-top">
                                                            <div class="list-item-content">
                                                                <div class="list-item-content-left">
                                                                    <div class="text-bold text-base">{{$flight['booking_details']['onewayDepatureTime']}}</div>
                                                                    <span class="small d-block">{{$flight['booking_details']['onewayDepatureAirport']}} </span>
                                                                    @if(isset($flight['booking_details']['onewayDepatureTerminal']))
                                                                    <span class="small d-block">Terminal {{$flight['booking_details']['onewayDepatureTerminal']}} </span>
                                                                    @endif
                                                                </div>
                                                                <div class="list-item-content-line-wrapper small">
                                                                    <div class="list-item-content-line-top"> 
                                                                        {{$flight['booking_details']['totalOnwayDuration']}}
                                                                    </div>
                                                                    <div class="list-item-content-line"></div>
                                                                    <div class="list-item-content-line-bottom text-info-dr">
                                                                        {{$flight['booking_details']['onwayNoOfStops']}} stops
                                                                    </div>
                                                                </div>
                                                                <div class="list-item-content-right">
                                                                    <div class="text-bold text-base">{{$flight['booking_details']['onewayArrivalTime']}} </div>
                                                                    <span class="small d-block">{{$flight['booking_details']['onewayArrivalAirport']}} </span>
                                                                    @if(isset($flight['booking_details']['onewayArrivalTerminal']))
                                                                    <span class="small d-block">Terminal {{$flight['booking_details']['onewayArrivalTerminal']}} </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                    <div class="list-item-passanger">
                                                        <h5>Passengers Details</h5>
                                                        <div class="each-passenger clearfix">
                                                            <h6>Passenger</h6>
                                                            <div class="col-sm-4"><span>Name:</span> <?php echo $flight['name']; ?></div>
                                                            <div class="col-sm-4"><span>Phone:</span> <?php echo $flight['phone_number']; ?></div>
                                                            <div class="col-sm-4"><span>Email:</span> <?php echo $flight['email']; ?></div>
                                                            <div class="col-sm-4"><span>Address:</span> <?php echo $flight['address']; ?></div>
                                                            <div class="col-sm-4"><span>Gender:</span> <?php echo $flight['gender']; ?></div>
                                                        </div>                                               
                                                        <?php
                                                        if (isset($flight['passengers'])) {
                                                            foreach ($flight['passengers'] as $passengers) {
                                                                ?>
                                                                <div class="each-passenger clearfix">
                                                                    <h6>Passenger</h6>
                                                            <?php // dd($passengers); ?>
                                                                    <div class="col-sm-4"><span>Name:</span> <?php echo $passengers['name']; ?></div>
                                                                    <div class="col-sm-4"><span>Phone:</span> <?php echo $passengers['phone_number']; ?></div>
                                                                    <div class="col-sm-4"><span>Email:</span> <?php echo $passengers['email']; ?></div>
                                                                    <div class="col-sm-4"><span>Address:</span> <?php echo $passengers['address']; ?></div>
                                                                    <div class="col-sm-4"><span>Gender:</span> <?php echo $passengers['gender']; ?></div>
                                                                </div>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                <?php    }
                                }
                            } else { ?>
                                <div class="icon">
                               <i class="fa fa-suitcase-rolling"></i>
                           </div>
                           <div class="desc">
                               <h5>Looks empty, you've no previous bookings.</h5>
                               <small>When you book a trip, you will see your itinerary here.</small>
                           </div>
                            <div class="clearfix"></div>
                           <?php }
                            ?>
                        </div>
                        
                        
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('after-scripts')
<script>
    $(function () {


    });
</script>
@endpush
