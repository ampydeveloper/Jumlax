@extends('frontend.layouts.app')

@section('nav')
@include('frontend.includes.nav')
@endsection

@section('title', app_name() . ' | Traveller Details')

@section('content')
<?php
//dd('redd');
?>
<section class="container-fluid blue-back">
    <div class="container">

        <div class="row">
            <div class="col-sm-12 review-box">
                <h5>Traveller & Addons</h5>     
                <ul class="list-unstyled list-inline">
                    <li class="active">
                        <a href="">
                            <span class="count">1</span>
                            <span class="line"></span>
                            <span>Review</span>
                        </a>
                    </li>
                    <li class="current">
                        <a href="">
                            <span class="count"><i class="fas fa-check"></i></span>
                            <span class="line"></span>
                            <span>Traveller Details</span>
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

<section class="container-fluid gray-back itinerary-outer traveller-details-outer">
    <div class="container">
        <form action="{{url('charterpayment')}}" method="post">
            {!! csrf_field() !!}
            <div class="row traveller-row">

                <div class="col-sm-12 col-md-9 itinerary-box">
                    <h5>Flight Summary</h5>
                    <div class="white-box chartedetails-box">
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

                    @if(isset($return) && is_array($return))
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


                    <h5 class="w-top-box">Traveller Details</h5>

                    <div class="white-box">
                        <h6>Passengers</h6>

                        <input type="hidden" value="{{json_encode($result)}}" name="result">
                        <input type="hidden" value="{{json_encode($searchdata)}}" name="searchdata">
                        @if(isset($return) && is_array($return))
                        <input type="hidden" value="{{json_encode($return)}}" name="return">
                        @endif

                        <?php
                        $passenger = $searchdata['charteradult'] + $searchdata['charterchild'];
                        ?>
                        @for ($i = 0; $i < $passenger; $i++)
                        <div class="each-person">
                            <div class="head">Passenger</div>
                            <div class="contt">
                                <span><b>Important:</b> Enter your name as it is mentioned on passport or any government ID.</span>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <input type="text" class="form-input" required name="name[]" value="{{old('name.$i')}}" placeholder="Name Of Passenger"/>
                                        @if ($errors->has('name'))
                                        <span class="error">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-input" required name="nationality[]" value="{{old('nationality.$i')}}" placeholder="Nationality"/>
                                        @if ($errors->has('nationality'))
                                        <span class="error">
                                            <strong>{{ $errors->first('nationality') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-sm-4 rest-details">
                                        <div class="form-wrap radio-inline-wrapper">
                                            <label class="radio-inline">
                                                <input name="gender[{{$i}}]" value="M" required type="radio" checked="" class="radio-custom">
                                                Male
                                            </label>
                                            <label class="radio-inline">
                                                <input name="gender[{{$i}}]" value="F" required type="radio" class="radio-custom">
                                                Female
                                            </label>
                                        </div>
                                        @if ($errors->has('gender.0'))
                                        <span class="error">
                                            <strong>{{ $errors->first('gender') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <input type="text" class="form-input" required name="passport[]" value="{{old('passport.$i')}}" placeholder="Passport Number"/>
                                        @if ($errors->has('passport'))
                                        <span class="error">
                                            <strong>{{ $errors->first('passport') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-input p_expiry_date" required name="expiry_date[]" value="{{old('expiry_date.$i')}}" placeholder="Expiry Date"/>
                                        @if ($errors->has('expiry_date'))
                                        <span class="error">
                                            <strong>{{ $errors->first('expiry_date') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-input p_birth_date" required name="birth_date[]" value="{{old('birth_date.$i')}}" placeholder="Birth Date DD/MM/YY"/>
                                        @if ($errors->has('birth_date'))
                                        <span class="error">
                                            <strong>{{ $errors->first('birth_date') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <input type="text" class="form-input" required name="phone_number[]" value="{{old('phone_number.$i')}}" placeholder="Phone Number"/>
                                        @if ($errors->has('phone_number'))
                                        <span class="error">
                                            <strong>{{ $errors->first('phone_number') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="email" class="form-input" required name="email[]" value="{{old('email.$i')}}" placeholder="Email"/>
                                        @if ($errors->has('email'))
                                        <span class="error">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-input" required name="address[]" value="{{old('address.$i')}}" placeholder="Address"/>
                                        @if ($errors->has('address'))
                                        <span class="error">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        @endfor
                        <!--                        <div id="extra-passenger-append">
                                                </div>-->
                        <!--<a href="#" class="button button-primary button-sm button-naira button-naira-up" id="add-paggenger">Add Passenger</a>-->
                    </div>

                    <h5 class="w-top-box">Contact Information</h5>
                    <div class="white-box contact-box">
                        <!--<small>Your tickets and flights information will be sent here.</small>-->
                        <div class="row">
                            <div class="col-sm-4">
                                <input type="text" class="form-input" required name="reference_passenger_name" value="{{old('reference_passenger_name.$i')}}" placeholder="Reference Name"/>
                                @if ($errors->has('reference_passenger_name'))
                                <span class="error">
                                    <strong>{{ $errors->first('reference_passenger_name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-input" required name="reference" value="{{old('reference.$i')}}" placeholder="Reference Phone"/>
                                @if ($errors->has('reference'))
                                <span class="error">
                                    <strong>{{ $errors->first('reference') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-sm-4 rest-details">
                                <div class="form-wrap radio-inline-wrapper">
                                    <label class="radio-inline">
                                        <input name="reference_gender" value="M" required type="radio" checked="" class="radio-custom">
                                        <!--<span class="radio-custom-dummy"></span>-->
                                        Male
                                    </label>
                                    <label class="radio-inline">
                                        <input name="reference_gender" value="F" required type="radio" class="radio-custom">
                                        <!--<span class="radio-custom-dummy"></span>-->
                                        Female
                                    </label>
                                </div>
                                @if ($errors->has('reference_gender'))
                                <span class="error">
                                    <strong>{{ $errors->first('reference_gender') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <h5 class="w-top-box">Acknowledgement</h5>
                    <div class="white-box acknow-box">
                        <div class="pretty p-default">
                            <input type="checkbox" name="agree">
                            <div class="state p-primary">
                                <label>I understands and agree with the terms and conditions.</label>
                            </div>
                        </div>
                        @if ($errors->has('agree'))
                        <span class="error">
                            <strong>{{ $errors->first('agree') }}</strong>
                        </span>
                        @endif
                    </div>

                </div>
                <div class="col-sm-12 col-md-3 fare-summary-box">
                    <h5>Fare Summary</h5>
                    <?php
                    $passenger = $searchdata['charteradult'] + $searchdata['charterchild'];

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
                        @if(isset($return) && is_array($return))
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

                <div class="col-sm-12">
                    <button class="button button-primary button-sm button-naira button-naira-up" type="submit">continue</button>
                </div>
            </div>
        </form>
    </div>
</section>

<script id="passenger-template" type="text/html">
    <div class="each-person">
        <div class="head">Passenger</div>
        <div class="contt">
            <span><b>Important:</b> Enter your name as it is mentioned on passport or any government ID.</span>


            <div class="row">
                <div class="col-sm-4">
                    <input type="text" class="form-input" name="passenger[first_name][<%= count %>]" value="" placeholder="First Name"/>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-input" name="passenger[last_name][<%= count %>]" value="" placeholder="Last Name"/>
                </div>
                <div class="col-sm-4 rest-details">
                    <div class="form-wrap radio-inline-wrapper">
                        <label class="radio-inline">
                            <input name="passenger[gender][<%= count %>]" value="M" type="radio" checked="" class="radio-custom">
                            Male
                        </label>
                        <label class="radio-inline">
                            <input name="passenger[gender][<%= count %>]" value="F" type="radio" class="radio-custom">
                            Female
                        </label>
                    </div>
                    <div class="pretty p-default">
                        <input type="checkbox" name="passenger[child][<%= count %>]">
                        <div class="state p-primary">
                            <label>Child</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>
@endsection

@push('after-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"></script>
<script>
$(function () {
    $('#add-paggenger').on('click', function (e) {
        var passengerAppend = $('#extra-passenger-append'),
                passengerTemplate = $('#passenger-template').html();
        passengerTemplate = _.template(passengerTemplate);
        var passengerData = {
            count: parseInt($('.traveller-details-outer .white-box .each-person').length) + 1
        };
        passengerAppend.append(passengerTemplate(passengerData));
        $('.radio-inline-wrapper .radio-inline').each(function (i, v) {
            var $this = $(this);
            if ($this.find('.radio-custom-dummy').length == 0) {
                $this.find('input').after("<span class='radio-custom-dummy'></span>");
            }
        });
        e.preventDefault();
    });

    var date = new Date();
    date.setDate(date.getDate());
    $('.p_expiry_date').datepicker({
        format: 'dd/mm/yyyy',
        startDate: date,
    });
    $('.p_birth_date').datepicker({
        format: 'dd/mm/yyyy',
    });
});
</script>
@endpush
