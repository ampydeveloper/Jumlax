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

                    <div class="footer">
                        <p>Baggage: Check In</p>
                    </div>
                </div>

                <div class="submit-fm">
                    <a href="{{url('traveller-details')}}" class="button button-primary button-sm button-naira button-naira-up">continue</a>
                </div>
            </div> 

            <div class="col-sm-12 col-md-3 fare-summary-box">
                <h5>Fare Summary</h5>
                @if($price)
                <div class="white-box">
                    <p class="title">Base Fare</p>
                    <p class="pass">
                        <?php
                        if (isset($price['base'])) {
                            $base_price = $price['base'];
                        } else {
                            $base_price = $price;
                        }
                        ?>
                        <span class="grey">Adult(s)({{$adults}})</span> <br>
                        <span class="grey">Children({{$children}})</span><br>
                        <span class="grey">Infant(s)({{$infants}})</span>
                        <span class="black-full">{{ (isset($price['currency']))?$price['currency']:'' }} ({{$base_price}})</span>
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
                        <?php
                        if (isset($price['grandTotal'])) {
                            $grand_total = $price['grandTotal'];
                        } else {
                            $grand_total = $price;
                        }
                        ?>
                        <span>Total Amount:</span>
                        <span class="black-full">{{ (isset($price['currency']))?$price['currency']:'' }} {{($grand_total)}}</span>
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
