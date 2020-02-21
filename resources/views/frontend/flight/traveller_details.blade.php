@extends('frontend.layouts.app')

@section('nav')
@include('frontend.includes.nav')
@endsection

@section('title', app_name() . ' | Traveller Details')

@section('content')
<section class="container-fluid blue-back">
    <div class="container">

        <div class="row">
            <div class="col-sm-12 review-box">
                <h5>Traveller & Addons</h5>     
                <ul class="list-unstyled list-inline">
                    <li class="active">
                        <a href="">
                            <span class="count"><i class="fas fa-check"></i></span>
                            <span class="line"></span>
                            <span>Review</span>
                        </a>
                    </li>
                    <li class="current">
                        <a href="">
                            <span class="count">2</span>
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
        <form action="{{url('payment')}}" method="post">
            {!! csrf_field() !!}
            <div class="row traveller-row">

                <div class="col-sm-12 col-md-9 itinerary-box">
                    <h5>Flight Summary</h5>
                    <div class="white-box flight-summary-box">
                        @if($segment)
                        @foreach($segment as $key => $seg)
                        <div class="head">
                            <?php
                            $segment_count = count($seg['segments']) - 1;
                            $totalNumberOfStops = 0;
                            foreach ($seg['segments'] as $valCal) {
                                $totalNumberOfStops = $totalNumberOfStops + $valCal['numberOfStops'];
                            }
                            if ($totalNumberOfStops == 0) {
                                $totalNumberOfStops = 'Non Stop';
                            }
                            $flight_date = $seg['segments'][0]['departure']['at'];
                            ?>
                            <span class="black">
                                @if($key == 0)
                                DEPART<br>
                                @else  
                                RETURN<br>
                                @endif
                                <b>{{ \Carbon\Carbon::parse($flight_date)->format('l, d M') }}</b>
                            </span>
                            <span class="simple">
                                <?php if ($segment_count == 0) { ?>
                                    {{$seg['segments'][0]['departure']['iataCode']}} <br>
                                <?php } else { ?>
                                    {{$seg['segments'][0]['departure']['iataCode']}}-{{$seg['segments'][$segment_count]['arrival']['iataCode']}} <br>
                                <?php } ?>
                                <ul class="list-unstyled list-inline">
                                    <li>{{$totalNumberOfStops}}</li>
                                    <?php $explode2 = explode('PT', $seg['duration']); ?>
                                    <li>{{$explode2[1]}}</li>
                                    <!--<li>Classs name - Economy</li>-->
                                </ul>
                            </span>
                        </div>
                        @foreach($seg['segments'] as $val)
                        <div class="content">
                            <div class="row">
                                <div class="col-sm-3 plane">
                                    <img src="http://pics.avs.io/60/24/{{$val['carrierCode']}}.png" alt=""><br>
                                    {{$val['aircraft']['code']}}
                                </div>
                                <div class="col-sm-3 destins">
                                    <span class="time">{{ \Carbon\Carbon::parse($val['departure']['at'])->format('h:i') }}</span>
                                    <span class="date">{{ \Carbon\Carbon::parse($val['departure']['at'])->format('l, d M y') }}</span>
                                    <span class="location">
                                        {{$val['departure']['iataCode']}} <br>
                                        @if($airports)

                                        @foreach($airports as $value)

                                        @if($value->airport_code == $val['departure']['iataCode'])
                                        {{$value->airport_name}}
                                        @break
                                        @endif
                                        @endforeach
                                        @endif
                                    </span>
                                </div>

                                <div class="col-sm-3 all-time">
                                    <?php
                                    $explode1 = explode('PT', $val['duration']);
                                    ?>
                                    {{$explode1[1]}}
                                    <hr />
                                </div>
                                <div class="col-sm-3 destins">
                                    <span class="time">{{ \Carbon\Carbon::parse($val['arrival']['at'])->format('h:i') }}</span>
                                    <span class="date">{{ \Carbon\Carbon::parse($val['arrival']['at'])->format('l, d M y') }}</span>
                                    <span class="location">
                                        {{$val['arrival']['iataCode']}} <br>
                                        @if($airports)
                                        @foreach($airports as $values)
                                        @if($values->airport_code == $val['arrival']['iataCode'])
                                        {{$values->airport_name}}
                                        @break
                                        @endif
                                        @endforeach
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endforeach
                        @endif
                    </div>


                    <h5 class="w-top-box">Traveller Details</h5>


                    <div class="white-box">
                        <h6>Passengers</h6>
                        <?php
                        //
//                        if (is_array($price)) {
////                            die('i');
//                            $price = unserialize($price);
//                        } else {
//                            $price = $price;
//                        }
//                        die('in');
                        ?>
                        <input type="hidden" value="{{serialize($segment)}}" name="segment">
                        <input type="hidden" value="{{serialize($price)}}" name="price">

                        @for ($i = 0; $i < ($adults+$children); $i++)

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
                                                <input name="gender[{{$i}}]" value="M" type="radio" checked="" class="radio-custom">
                                                Male
                                            </label>
                                            <label class="radio-inline">
                                                <input name="gender[{{$i}}]" value="F" type="radio" class="radio-custom">
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
                                                </div>
                                                <a href="#" class="button button-primary button-sm button-naira button-naira-up" id="add-paggenger">Add Passenger</a>-->
                    </div>
                    <h5 class="w-top-box">Reference</h5>
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
                                        <input name="reference_gender" value="M" type="radio" checked="" class="radio-custom">
                                        Male
                                    </label>
                                    <label class="radio-inline">
                                        <input name="reference_gender" value="F" type="radio" class="radio-custom">
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
                            <div class="state p-primary" style='margin: 0;'>
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
                    @if($price)
                    <div class="white-box">
                        <p class="title">Base Fare</p>
                        <p class="pass">
                            <span class="grey">Adult(s)({{$adults}})</span> <br>
                            <span class="grey">Children({{$children}})</span><br>
                            <span class="grey">Infant(s)({{$infants}})</span>
                            <span class="black-full">{{$price['currency']}} ({{$price['base']}})</span>
                        </p>
                        <?php
                        if (!empty($price['additionalServices'])) {
                            foreach ($price['additionalServices'] as $value) {
                                ?>
                                <p class="standard">
                                    <span><?php echo $value['type']; ?></span>
                                    <span class="black-full"> <?php echo $value['amount']; ?></span>
                                </p>
                                <?php
                            }
                        }
                        ?>
                        <?php
                        if (!empty($price['fees'])) {
                            foreach ($price['fees']as $fee) {
                                ?>
                                <p class="standard">
                                    <span><?php echo $fee['type']; ?></span>
                                    <span class="black-full"> <?php echo $fee['amount']; ?></span>
                                </p>
                                <?php
                            }
                        }
                        ?>
                        <p class="total">
                            <span>Total Amount:</span>
                            <span class="black-full">{{$price['currency']}} {{$price['grandTotal']}}</span>
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

<!--<script id="passenger-template" type="text/html">
    <div class="each-person">
        <div class="head">Passenger</div>
        <div class="contt">
            <span><b>Important:</b> Enter your name as it is mentioned on passport or any government ID.</span>


            <div class="row">
                <div class="col-sm-4">
                    <input type="text" class="form-input" name="passenger[name][<%= count %>]" value="" placeholder="Passanger Name"/>
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
</script>-->
@endsection
<style>
    .select2-container .select2-selection {
        height: 37px !important;
    }
    .select2-selection__rendered {
        line-height: 33px !important;
    }
</style>
@push('after-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"></script>
<script src="{{ asset('assets/js/intlTelInput.min.js') }}"></script>
<script>
// Vanilla Javascript
//var input = document.querySelector("#telephone");
//window.intlTelInput(input,({
//  // options here
//}));

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
