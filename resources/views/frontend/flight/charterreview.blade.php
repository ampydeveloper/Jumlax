@extends('frontend.layouts.app')

@section('nav')
@include('frontend.includes.nav')
@endsection

@section('title', app_name() . ' | Review')

@section('content')
<section class="container-fluid blue-back">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 review-box">
                <h5>Review your booking</h5>     
                <ul class="list-unstyled list-inline">
                    <li class="active">
                        <a href="">
                            <span class="count"><i class="fas fa-check"></i></span>
                            <span class="line"></span>
                            <span>Flight Selected</span>
                        </a>
                    </li>
                    <li class="current">
                        <a href="">
                            <span class="count">2</span>
                            <span class="line"></span>
                            <span>Review</span>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <span class="count">3</span>
                            <span class="line"></span>
                            <span>Make Payment</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="container-fluid gray-back itinerary-outer">
    <div class="container">
        <div class="row">

            <div class="col-sm-12 col-md-9 itinerary-box">
                <h5>Itinerary</h5>
                <div class="white-box">
                    @if($result)
                    <?php
                    $datetime1 = new DateTime($result->departure_time);
                    $datetime2 = new DateTime($result->arriving_time);
                    $interval = $datetime1->diff($datetime2);
                    $elapsed = $interval->format(' %hH%iM');

                    if ($searchdata['charterclass'] == 1) {
                        $charterclass = 'Economy';
                    } else if ($searchdata['charterclass'] == 2) {
                        $charterclass = 'Premium';
                    } else if ($searchdata['charterclass'] == 3) {
                        $charterclass = 'Business';
                    } else if ($searchdata['charterclass'] == 4) {
                        $charterclass = 'First';
                    }
                    ?>
                    <div class="head">
                        <span class="black">
                            DEPART<br>
                            <b>{{ \Carbon\Carbon::parse($result->departure_time)->format('l, d M') }}</b>
                        </span>
                        <span class="simple">
                            {{$result->from}}-{{$result->to}} <br>
                            <ul class="list-unstyled list-inline">
                                <li>Non Stop</li>
                                <li>{{$elapsed}}</li>
                                <li>{{$charterclass}}</li>
                            </ul>
                        </span>
                    </div>

                    <div class="content">
                        <div class="row">
                            <div class="col-sm-3 plane">
                                <img src="{{URL::asset('/charter_logos/'.$result->planes->charter_details->logo)}}" alt="{{$result->planes->charter_details->name}}" class="charter_logo" />
                                <p>
                                    {{$result->planes->charter_details->name}} <span>{{$result->planes->plane_number}}</span>
                                </p>
                            </div>
                            <div class="col-sm-3 destins">
                                <span class="time">{{ \Carbon\Carbon::parse($result->departure_time)->format('h:i') }}</span>
                                <span class="date">{{ \Carbon\Carbon::parse($result->departure_time)->format('l, d M y') }}</span>
                                <span class="location">
                                    {{$result->from}} <br>
                                    <span class="small d-block">{{$result->airport_code}}</span>
                                    <span class="small d-block">{{$result->airport_name}}</span>
                                </span>
                            </div>

                            <div class="col-sm-3 all-time">
                                {{$elapsed}}
                                <hr />
                            </div>
                            <div class="col-sm-3 destins">
                                <span class="time">{{ \Carbon\Carbon::parse($result->arriving_time)->format('h:i') }}</span>
                                <span class="date">{{ \Carbon\Carbon::parse($result->arriving_time)->format('l, d M y') }}</span>
                                <span class="location">
                                    {{$result->to}} <br>
                                    <span class="small d-block">{{$result->airport_code}}</span>
                                    <span class="small d-block">{{$result->airport_name}}</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    @endif
                    <div class="footer">
                        <p>Baggage: Check In</p>
                    </div>
                </div>
                @if(isset($return))
                <div class="white-box">
                    @if($return)

                    <?php
                    $datetime1 = new DateTime($return->departure_time);
                    $datetime2 = new DateTime($return->arriving_time);
                    $interval = $datetime1->diff($datetime2);
                    $elapsed1 = $interval->format(' %hH%iM');
                    
                    if ($searchdata['charterclass'] == 1) {
                        $charterclass = 'Economy';
                    } else if ($searchdata['charterclass'] == 2) {
                        $charterclass = 'Premium';
                    } else if ($searchdata['charterclass'] == 3) {
                        $charterclass = 'Business';
                    } else if ($searchdata['charterclass'] == 4) {
                        $charterclass = 'First';
                    }
                    ?>
                    <div class="head">
                        <span class="black">
                            DEPART<br>
                            <b>{{ \Carbon\Carbon::parse($return->departure_time)->format('l, d M') }}</b>
                        </span>
                        <span class="simple">
                            {{$return->from}}-{{$return->to}} <br>
                            <ul class="list-unstyled list-inline">
                                <li>Non Stop</li>
                                <li>{{$elapsed1}}</li>
                                <li>{{ $charterclass }}</li>
                            </ul>
                        </span>
                    </div>


                    <div class="content">
                        <div class="row">
                            <div class="col-sm-3 plane">
                                <img src="{{URL::asset('/charter_logos/'.$result->planes->charter_details->logo)}}" alt="{{$result->planes->charter_details->name}}" class="charter_logo" />
                                <p>
                                    {{$result->planes->charter_details->name}} <span>{{$result->planes->plane_number}}</span>
                                </p>
                            </div>
                            <div class="col-sm-3 destins">
                                <span class="time">{{ \Carbon\Carbon::parse($return->departure_time)->format('h:i') }}</span>
                                <span class="date">{{ \Carbon\Carbon::parse($return->departure_time)->format('l, d M y') }}</span>
                                <span class="location">
                                    {{$return->from}} <br>
                                    <span class="small d-block">{{$result->airport_code}}</span>
                                    <span class="small d-block">{{$result->airport_name}}</span>
                                </span>
                            </div>

                            <div class="col-sm-3 all-time">
                                {{$elapsed}}
                                <hr />
                            </div>
                            <div class="col-sm-3 destins">
                                <span class="time">{{ \Carbon\Carbon::parse($result->arriving_time)->format('h:i') }}</span>
                                <span class="date">{{ \Carbon\Carbon::parse($result->arriving_time)->format('l, d M y') }}</span>
                                <span class="location">
                                    {{$result->to}} <br>
                                    <span class="small d-block">{{$result->airport_code}}</span>
                                    <span class="small d-block">{{$result->airport_name}}</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    @endif

                    <div class="footer">
                        <p>Baggage: Check In</p>
                    </div>
                </div>
                @endif

                <div class="submit-fm">
                    <a href="{{url('chartedetails')}}" class="button button-primary button-sm button-naira button-naira-up">continue</a>
                </div>

            </div> 

            <div class="col-sm-12 col-md-3 fare-summary-box">
                <h5>Fare Summary</h5>
                <?php
                $passenger = $searchdata['charteradult'] + $searchdata['charterchild'];
//dd($searchdata);
                if ($searchdata['charterclass'] == 1) {
                    $fare = $result->economy_price;
                } else if ($searchdata['charterclass'] == 2) {
                    $fare = $result->premium_price;
                } else if ($searchdata['charterclass'] == 3) {
                    $fare = $result->business_price;
                } else if ($searchdata['charterclass'] == 4) {
                    $fare = $result->first_price;
                }
                ?>
                @if($result->planes)
                  <div class="white-box">
                        <p class="title">Base Fare</p>
                        <p class="pass">
                            <span class="grey">Adult(s)({{$searchdata['charteradult']}})</span> <br>
                            <span class="grey">Children({{$searchdata['charterchild']}})</span><br>
                            <span class="grey">Infant(s)({{$searchdata['charterinfant']}})</span>
                            <span class="black-full">LD ({{$fare}})</span>
                        </p>
                        @if(isset($return))
                        <p class="title">Return Base Fare</p>
                        <p class="pass">
                            <span class="grey">Adult(s)({{$searchdata['charteradult']}})</span> <br>
                            <span class="grey">Children({{$searchdata['charterchild']}})</span><br>
                            <span class="grey">Infant(s)({{$searchdata['charterinfant']}})</span>
                            <span class="black-full">LD ({{$fare}})</span>
                        </p>
                        @endif
                        <p class="total">
                            <span>Total Amount:</span>
                            <?php
                            $total = $passenger * $fare;
                            if (isset($return)) {
                                $retunrfare = $passenger * $fare;
                            } else {
                                $retunrfare = 0;
                            }
                            ?>
                            <span class="black-full">LD {{$total + $retunrfare}}</span>
                        </p>
                    </div>
                @endif
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
