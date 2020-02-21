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
                            <span class="count"><i class="fas fa-check"></i></span>
                            <span class="line"></span>
                            <span>Review</span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="">
                            <span class="count"><i class="fas fa-check"></i></span>
                            <span class="line"></span>
                            <span>Traveller Details</span>
                        </a>
                    </li>
                    <li class="current">
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
        <div class="row">

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

                @if($requestdata)
                <div class="white-box">
                    <?php $count = 1; ?>
                    @foreach($requestdata['name'] as $key => $name)
                    <div class="contt">
                        <div class="row">
                            <div class="col-sm-12">
                                {{$count}}. {{$name}} {{$requestdata['name'][$key]}}, {{$requestdata['phone_number'][$key]}}, {{$requestdata['gender'][$key]}}
                            </div>
                        </div>
                    </div>
                    <?php $count++; ?>
                    @endforeach
                </div>
                @endif


                <h5 class="w-top-box">Reference</h5>
                <?php // dd($requestdata); ?>
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
                            <input type="radio" name="payment" class="terawallet-payment-method">&nbsp;&nbsp;TeraWallet Pay
                            <span class="float-right">| <i class="fas fa-info-circle" style="cursor: help;" data-toggle="tooltip" data-placement="top" title="Please refresh this page, after recharging your wallet for Balance changes to be reflected here!"></i>&nbsp;Balance: {!! $terawallet_balance !!}</span>
                            <a class="float-right" target="_blank" href="{{$teraWalletGateway}}">Manage</a>
                        </li>
                        <li>&nbsp;</li>
                        <li><input type="radio" name="payment" class="s2m-method">&nbsp;&nbsp;Card Payment</li>
                        @php
                            if(isset($s2mSuccess) && $s2mSuccess){
                                echo '<li style="display: none;"><input type="radio" checked name="payment" class="s2m">&nbsp;&nbsp;S2m</li>';
                            }
                        @endphp
                    </ul>
                    <form id="s2m-method" method="post" action="{{$s2mGateway}}" >
                        @php
                        {{  
                            // print_r($_SERVER);
                            if(isset($s2mConfig)){
                                $html = '';
                                foreach($s2mConfig as $k => $v){
                                    //$html.= "<label for='$k'>'$k'</label>&nbsp;&nbsp;";
                                    $html.= "<input type='hidden' name='".$k."' id='".$k."' value='".$v."' />";
                                }
                                echo $html;
                            }
                        }}
                        @endphp
                    </form>
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
                        <span class="black-full">{{$price['currency']}} {{$price['total']}}</span>
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
                <button type="button" class="button button-primary button-sm ladda-button" data-style="expand-left" id="process_payment">Proceed to Pay</button>
            </div>

        </div>
    </div>
</section>
@endsection
@push('after-scripts')
<script>
    $(function () {
        $('#process_payment').on('click', function(){
            var l = Ladda.create(document.querySelector('#process_payment'));
            if ($('input.terawallet-payment-method').prop('checked')){
                l.start();
                $.ajax({
                    url:'/process_payment',
                    type: 'POST',
                    data: {
                        amount: {{$price['grandTotal']}},
                        type: 'terawallet'
                    }
                }).done(function(e){
                    // console.log(e);
                    if (e.message == 'success'){
                        window.location.href = "{{ url('booked') }}";
                    } else if(e.info == 'low-balance'){
                        alert('Your Terawallet Balance is low, please recharge your wallet & try again!');
                    } else if (e.info == 'error'){
                        alert('There was an error processing your order, please try again or contact support!');
                    }
                    l.stop();
                });
            } else if ($('input.s2m-method').prop('checked')){
                l.start();
                $('#s2m-method').submit();
            // alert('payment intiated');
            }
            <?php if(isset($s2mSuccess) && $s2mSuccess){?> 
            else if ($('input.s2m').prop('checked')){
                l.start();
                $.ajax({
                    url:'/process_payment',
                    type: 'POST',
                    data: {
                    amount: {{$price['grandTotal']}},
                        type: 's2m'
                    }
                }).done(function(e){
                    // console.log(e);
                    if (e.message == 'success'){
                        window.location.href = "{{ url('booked') }}";
                    } else if (e.message == 'fail'){
                        alert('Your card payment was not successful, please try-again!');
                    }
                    l.stop();
                });
            }
            <?php }?>
        });
        $('input[name=payment]').on('change', function(){
            if ($('input.payfull-payment-method').prop('checked')){
                $('div#payfull-card-details').css('display', 'block');
            } else{
                $('div#payfull-card-details').css('display', 'none');
            }
        });

        <?php if(isset($s2mSuccess) && $s2mSuccess){?>
            // console.log('yeah');
            $('#process_payment').trigger('click');
        <?php }?>
        <?php if(isset($s2mFailed) && $s2mFailed){?>
            alert('Your card payment was not successful, please try-again!');
            // console.log('nae');
            // $('#process_payment').trigger('click');
        <?php }?>
    });
</script>
@endpush