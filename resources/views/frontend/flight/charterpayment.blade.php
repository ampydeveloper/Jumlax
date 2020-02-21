@extends('frontend.layouts.app')

@section('nav')
@include('frontend.includes.nav')
@endsection

@section('title', app_name() . ' | Payment')

@section('content')
<section class="container-fluid blue-back">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 review-box">
                <h5>Make Payment</h5>     
                <ul class="list-unstyled list-inline">
                    <li class="active">
                        <a href="">
                            <span class="count">1</span>
                            <span class="line"></span>
                            <span>Review</span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="">
                            <span class="count">2</span>
                            <span class="line"></span>
                            <span>Traveller Details</span>
                        </a>
                    </li>
                    <li class="current">
                        <a href="">
                            <span class="count"><i class="fas fa-check"></i></span>
                            <span class="line"></span>
                            <span>Make Payment</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="container-fluid gray-back itinerary-outer traveller-details-outer">
    <div class="container">
        <div class="row">

            <div class="col-sm-12 col-md-9 itinerary-box">
                <h5>Flight Summary</h5>
                <div class="white-box flight-summary-box">
                    @if($result)
                    <?php
                    $datetime1 = new DateTime($result->departure_time);
                    $datetime2 = new DateTime($result->arriving_time);
                    $interval = $datetime1->diff($datetime2);
                    $elapsed = $interval->format(' %hH%iM');
                    if ($searchdata->charterclass == 1) {
                        $charterclass = 'Economy';
                    } else if ($searchdata->charterclass == 2) {
                        $charterclass = 'Premium';
                    } else if ($searchdata->charterclass == 3) {
                        $charterclass = 'Business';
                    } else if ($searchdata->charterclass == 4) {
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
                <div class="white-box flight-summary-box">
                    @if($return)
                    <?php
                    $datetime1 = new DateTime($return->departure_time);
                    $datetime2 = new DateTime($return->arriving_time);
                    $interval = $datetime1->diff($datetime2);
                    $elapsed1 = $interval->format(' %hH%iM');

                    if ($searchdata->charterclass == 1) {
                        $charterclass = 'Economy';
                    } else if ($searchdata->charterclass == 2) {
                        $charterclass = 'Premium';
                    } else if ($searchdata->charterclass == 3) {
                        $charterclass = 'Business';
                    } else if ($searchdata->charterclass == 4) {
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

                <h5 class="w-top-box">Traveller Details</h5>
                <div class="white-box">
                    @if($requestdata)
                    <?php $count = 1; ?>
                    @foreach($requestdata['name'] as $key => $name)
                    <div class="contt">
                        <div class="row">
                            <div class="col-sm-12">
                                {{$count}}. {{$requestdata['name'][$key]}}, {{$requestdata['gender'][$key]}}
                            </div>
                        </div>
                    </div>
                    <?php $count++; ?>
                    @endforeach
                </div>
                @endif

                <h5 class="w-top-box">Reference</h5>
                @if($requestdata)
                <div class="white-box">
                    <div class="contt">
                        <div class="row">
                            <div class="col-sm-12">
                                {{$requestdata['reference_passenger_name']}}, {{$requestdata['reference']}}, {{$requestdata['reference_gender']}}
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <h5 class="w-top-box">Payment Options</h5>
                <div class="white-box payment-box">
                    <ul>
                        <li>
                            <input type="radio" name="payment" class="terawallet-payment-method">&nbsp;&nbsp;TeraWallet
                            <span class="float-right">| Balance: {!! $terawallet_balance !!}</span>
                            <a class="float-right" target="_blank" href="http://jwp.leagueofclicks.com/index.php/jumlax-terawallet/">Manage</a>
                        </li>
                        <li>&nbsp;</li>
                        <li><input type="radio" name="payment" class="s2m-method">&nbsp;&nbsp;S2M Payment</li>
                    </ul>
                    <form id="s2m-method" method="post" action="{{$s2mGateway}}" >
                        @php
                        {{  
                            // print_r($_SERVER);
                            
                            $html = '';
                            foreach($s2mConfig as $k => $v){
                                //$html.= "<label for='$k'>'$k'</label>&nbsp;&nbsp;";
                                $html.= "<input type='hidden' name='".$k."' id='".$k."' value='".$v."' />";
                            }
                            echo $html;
                        }}
                        @endphp
                    </form>
                    <div id='payfull-card-details' style="display: none;">
                        <br/>
                        <h6>Credit/Debit Cards</h6>
                        <div class="row">
                            <div class="col-sm-12 card-number">
                                <label for="">Card Number</label>
                                <input type="text" class="form-input" name="card-number" placeholder="Enter card number"/>
                            </div>
                            <div class="col-sm-12">
                                <label for="">Name on the card</label>
                                <input type="text" class="form-input" name="card-name" placeholder="Enter name here"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <label for="">Expiry Date</label>
                                <input type="text" class="form-input" name="card-expiry" placeholder="Expiry Date"/>
                            </div> --}}
                            {{-- <div class="col-sm-4">
                                <label for="">Email</label>
                                <input type="text" class="form-input" name="card" placeholder="Year"/>
                            </div> --}}
                            <div class="col-sm-5">
                                <label for="">CVV</label>
                                <input type="text" class="form-input" name="card-cvv" placeholder="CVV"/>
                            </div>
                        </div> 
                    </div> 
                </div>

            </div>

            <div class="col-sm-12 col-md-3 fare-summary-box">
                <h5>Fare Summary</h5>
                <?php
//                dd($searchdata->charteradult);
                $passenger = $searchdata->charteradult + $searchdata->charterchild;

                if ($searchdata->charterclass == 1) {
                    $fare = $result->economy_price;
                } else if ($searchdata->charterclass == 2) {
                    $fare = $result->premium_price;
                } else if ($searchdata->charterclass == 3) {
                    $fare = $result->business_price;
                } else if ($searchdata->charterclass == 4) {
                    $fare = $result->first_price;
                }
//                    dd('123')
                ?>
                @if($result->planes)
                <div class="white-box">
                    <p class="title">Base Fare</p>
                    <p class="pass">
                        <span class="grey">Adult(s)({{$searchdata->charteradult}})</span> <br>
                        <span class="grey">Children({{$searchdata->charterchild}})</span><br>
                        <span class="grey">Infant(s)({{$searchdata->charterinfant}})</span>
                        <span class="black-full">LD ({{$fare}})</span>
                    </p>
                    @if(isset($return) && is_array($return))
                    <p class="title">Return Base Fare</p>
                    <p class="pass">
                        <span class="grey">Adult(s)({{$searchdata->charteradult}})</span> <br>
                        <span class="grey">Children({{$searchdata->charterchild}})</span><br>
                        <span class="grey">Infant(s)({{$searchdata->charterinfant}})</span>
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

            <div class="col-sm-12">
                <button type="button" class="button button-primary button-sm ladda-button" id="process_payment">Proceed to Pay</button>
            </div>

        </div>
    </div>
</section>
@endsection

@push('after-scripts')
<script>
    $(function () {
    $('#process_payment').on('click', function(){
    $('#process_payment').attr('disabled', 'disabled');
    if ($('input.terawallet-payment-method').prop('checked')){

    $.ajax({
    url:'/process_payment_charter',
            type: 'POST',
            data: {
            amount: {{$fare}},
                    flight: 'Test Flight',
                    type: 'terawallet'
            }
    }).done(function(e){
    if (e.message == 'success'){
    $('#process_payment').removeAttr('disabled');
    window.location.href = "{{ url('booked') }}";
    } else if (e.message == 'error'){
    $('#process_payment').removeAttr('disabled');
    }
    });
    }
    });
    });
</script>
@endpush
