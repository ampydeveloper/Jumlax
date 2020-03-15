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
                                    <?php $explode2 = explode('PT', $seg['duration']);
                                        $resStr1 = str_replace('H', ' hrs ', $explode2[1]);
                                        $resStr1 = str_replace('M', ' mins', $resStr1);
                                    ?>
                                    <li>{{$resStr1}}</li>
                                    <!--<li>Classs name - Economy</li>-->
                                </ul>
                        </span>
                    </div>
                    @foreach($seg['segments'] as $key2 => $val)
                    <div class="content">
                        <div class="row">
                            <div class="col-sm-3 plane">
                                <img src="http://pics.avs.io/60/24/{{$val['carrierCode']}}.png" alt=""><br>
                                {{$val['carrierCode'] .'-'. $val['aircraft']['code']}}
                            </div>
                            <div class="col-sm-3 destins">
                                <span class="time">{{ \Carbon\Carbon::parse($val['departure']['at'])->format('h:i') }}</span>
                                <span class="date">{{ \Carbon\Carbon::parse($val['departure']['at'])->format('l, d M y') }}</span>
                                <span class="location">
                                        {{$val['departure']['iataCode']}} <br>
                                        @if($airports)

                                        @foreach($airports as $value)

                                        @if($value->airport_code == $val['departure']['iataCode'])
                                        {{$value->airport_name}},
                                        {{$value->city_name}}
                                        @break
                                        @endif
                                        @endforeach
                                        @endif
                                        <br/>
                                        @if(isset($val['departure']['terminal']))
                                        Terminal {{$val['departure']['terminal']}}
                                        @else
                                        Terminal -
                                        @endif
                                    </span>
                            </div>

                            <div class="col-sm-3 all-time">
                                    <?php
                                    $explode1 = explode('PT', $val['duration']);
                                    $resStr = str_replace('H', ' hrs ', $explode1[1]);
                                    $resStr = str_replace('M', ' mins', $resStr);
                                    ?>
                                    {{$resStr}}
                                    <hr />
                                    @if($key == 0)
                                        @if(isset($oneSide[$key2]))
                                            {{$oneSide[$key2]}}
                                        @endif
                                    @else
                                        @if(isset($returnSide[$key2]))
                                            {{$returnSide[$key2]}}
                                        @endif
                                    @endif
                                </div>
                            <div class="col-sm-3 destins">
                                    <span class="time">{{ \Carbon\Carbon::parse($val['arrival']['at'])->format('h:i') }}</span>
                                    <span class="date">{{ \Carbon\Carbon::parse($val['arrival']['at'])->format('l, d M y') }}</span>
                                    <span class="location">
                                        {{$val['arrival']['iataCode']}} <br>
                                        @if($airports)
                                        @foreach($airports as $values)
                                        @if($values->airport_code == $val['arrival']['iataCode'])
                                        {{$values->airport_name}},
                                        {{$values->city_name}}
                                        @break
                                        @endif
                                        @endforeach
                                        @endif
                                        <br/>
                                        @if(isset($val['arrival']['terminal']))
                                        Terminal {{$val['arrival']['terminal']}}
                                        @else
                                        Terminal -
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
                                <!--{{$name}}-->
                                {{$count}}. {{$requestdata['name'][$key]}}, {{$requestdata['phone_number'][$key]}}, {{$requestdata['gender'][$key]}}
                            </div>
                        </div>
                    </div>
                    <?php $count++; ?>
                    @endforeach
                </div>
                @endif


                <h5 class="w-top-box" id="scrollToHere">Reference</h5>
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
                    
                    <div id="content" class="payment_section">

                        <div class="payment_container top_space clearfix">

			<!-- Payment-Option -->
			<div class="payment_option pull-left">

				<!-- Option-Tabs -->
				<div class="option_tabs clearfix">

					<div class="payment_widget clearfix">
                                            <div class="alert alert-success successMessageHere" style="display: none;">
                                                </div>

                                                <div class="alert alert-danger errorMessageHere" style="display: none;">
                                                </div>
                                            
						<form name="formID" id="formID"
							action="{{ route('frontend.payfull') }}"
							method="post" target="_parent" autocomplete="off">
                                                    
                                                    {!! csrf_field() !!}

							<div id="paymentWidget">
								<input type="text" style="display:none;" name="currentSelectedTab"
									id="currentSelectedTab" value="CC">
								<ul class="tab_section pull-left card_list">

									<li id="CC_tab">
										<a data-toggle="tab" href="#payfullTab" rel="CC" class="clearfix active" id="CC">
                                                                                    <span class="">
                                                                                        <img width="160" height="53" src="https://payfull.com/sites/all/themes/payfull2_theme/images/logo.png" class="custom-logo lazy" alt="S2M"
                                                                                             style="height:20px; width:84px; margin: 12px 22px 20px 28px;">
                                                                                    </span>
<!--											<span class="option_txt lato-regular">PayFull</span>-->
										</a>
										<div class="other_inside_options" id="CC_subTabs">
											<ul class="card_list">

											</ul>
										</div>
									</li>

									<li id="NB_tab">
                                                                            <button id="process_payment" style="display: none;"></button>
										<a data-toggle="tab" href="#s2mTab" rel="NB" class="clearfix activateS2m">
                                                                                    <span class="">
                                                                                        <img width="160" height="53" src="https://s2mworldwide.com/wp-content/uploads/2018/11/logo.png" class="custom-logo lazy" alt="S2M"
                                                                                             style="height:20px; width:50px; margin: 15px 42px 22px 44px;">
                                                                                    </span>
											<!--<span class="option_txt lato-regular">S2M</span>-->
										</a>
										<div class="other_inside_options" id="NB_subTabs">
											<ul class="card_list">

											</ul>
										</div>
									</li>

								</ul>
                                                                <div class="tab-content">
								<div id="payfullTab" class="tab-pane in active card_details pull-left col-lg-10 col-md-10 col-sm-9 col-xs-8 tab_conatiner"
									id="paymentCanvas">

									<div id="cardSection" class="clearfix append_bottom16" style="display: block;">

										<!-- Option-Heading -->
										<p class="option_heading append_bottom20 clearfix">
											<span class="cd_iconspace pull-left">
												<span
													class="cpay_american_express pull-left CRCNoShow ATMNoShow">&nbsp;</span>
												<span class="cpay_master_card pull-left">&nbsp;</span>
												<span class="cpay_maestro pull-left CRCNoShow">&nbsp;</span>
												<span class="cpay_visa pull-left">&nbsp;</span>
												<span
													class="cpay_diners_card pull-left CRCNoShow ATMNoShow">&nbsp;</span>
												<span class="cpay_rupay last pull-left CRCNoShow">&nbsp;</span>
											</span>
										</p>
										<!-- /Option-Heading -->

										<p class="cdfUserMessageSection coupon_appliedinfo lato-regular append_bottom25 clearfix col-lg-7"
											id="cdfUserMessageSection_CC" style="display: none; margin-bottom: 25px;">
										</p>

										<!-- Inner-Container -->
										<div class="inner_container clearfix">
											<div class="input_section append_bottom20">

												<p class="clearfix input_label lato-regular append_bottom8">
													<label for="cardnumber">CUSTOMER DETAILS</label>
												</p>
												<p class="clearfix card_type_input">
                                                                                                    <input type="text" class="form-input form-control-last-child return"
														name="customer_firstname"
														id="customer_firstname"
                                                                                                                placeholder="First name" required="">
												</p>
                                                                                                <div class="alert alert-danger customer_firstname" style="display: none;"></div>
                                                                                                <p class="clearfix card_type_input">
                                                                                                    <input type="text" class="form-input form-control-last-child return"
														name="customer_lastname"
														id="customer_lastname"
                                                                                                                placeholder="Last name" required="">
												</p>
                                                                                                <div class="alert alert-danger customer_lastname" style="display: none;"></div>
                                                                                                <p class="clearfix card_type_input">
                                                                                                    <input type="text" class="form-input form-control-last-child return"
														name="customer_email"
														id="customer_email"
														placeholder="Email" required="">
												</p>
                                                                                                <div class="alert alert-danger customer_email" style="display: none;"></div>
                                                                                                <p class="clearfix card_type_input">
                                                                                                    <input type="text" class="form-input form-control-last-child return"
														name="customer_phone"
														id="customer_phone"
														placeholder="Phone number" required="">
												</p>
                                                                                                <div class="alert alert-danger customer_phone" style="display: none;"></div>
											</div>
                                                                                    
											<div class="input_section append_bottom20">

												<p class="clearfix input_label lato-regular append_bottom8">
													<label for="cardnumber">CARD NUMBER</label>
												</p>
												<p class="clearfix card_type_input">
													<input type="tel" pattern="[0-9]*"
														class="form-input form-control-last-child return"
														name="card_number" id="card_number"
														autocomplete="off" maxlength="19" tabindex="7"
														placeholder="Enter card number here" value="">
												</p>
                                                                                                <div class="alert alert-danger card_number" style="display: none;"></div>
											</div>

											<!-- Input-Section -->
											<div class="input_section append_bottom20 hideNameOnCard">
												<p class="clearfix input_label lato-regular append_bottom8">
													<label for="nameoncard">NAME ON THE CARD</label>
												</p>
												<p class="clearfix card_type_input">
													<input type="text"
														class="form-input form-control-last-child return"
														placeholder="Enter name here"
														maxlength="40" tabindex="8" name="card_holder_name" id="card_holder_name" value="">
												</p>
                                                                                                <div class="alert alert-danger card_holder_name" style="display: none;"></div>
											</div>

											<div class="select_section clearfix append_bottom8" id="hiddenMaestroDiv">
												<!-- Month -->
												<span class="pull-left select_field">
													<label for="PAYMENT_expiryMonth"
														class="make_block input_label append_bottom8">EXPIRY
														DATE</label>
                                                                                                    <span class="make_block input_label append_bottom8">&nbsp;</span>
													<select
														class="form-input select2-hidden-accessible"
														name="card_month" id="card_month"
														tabindex="9">
														<option value="" selected="selected">Month</option>

														<option value="01">01</option>

														<option value="02">02</option>

														<option value="03">03</option>

														<option value="04">04</option>

														<option value="05">05</option>

														<option value="06">06</option>

														<option value="07">07</option>

														<option value="08">08</option>

														<option value="09">09</option>

														<option value="10">10</option>

														<option value="11">11</option>

														<option value="12">12</option>

													</select>
												</span>
												<!-- /Month -->
												<!-- Year -->
												<span class="pull-left year_info">
                                                                                                    <label for="PAYMENT_expiryMonth"
														class="make_block input_label append_bottom8">EXPIRY
														YEAR</label>
													<span class="make_block input_label append_bottom8">&nbsp;</span>
                                                                                                        
													<select
														class="form-input select2-hidden-accessible"
														id="card_year" tabindex="10" name="card_year">
														<option value="" selected="selected">Year</option>

														<option value="2020">2020</option>

														<option value="2021">2021</option>

														<option value="2022">2022</option>

														<option value="2023">2023</option>

														<option value="2024">2024</option>

														<option value="2025">2025</option>

														<option value="2026">2026</option>

														<option value="2027">2027</option>

														<option value="2028">2028</option>

														<option value="2029">2029</option>

														<option value="2030">2030</option>

														<option value="2031">2031</option>

														<option value="2032">2032</option>

														<option value="2033">2033</option>

														<option value="2034">2034</option>

														<option value="2035">2035</option>

														<option value="2036">2036</option>

														<option value="2037">2037</option>

														<option value="2038">2038</option>

														<option value="2039">2039</option>

														<option value="2040">2040</option>

														<option value="2041">2041</option>

														<option value="2042">2042</option>

														<option value="2043">2043</option>

														<option value="2044">2044</option>

														<option value="2045">2045</option>

														<option value="2046">2046</option>

														<option value="2047">2047</option>

														<option value="2048">2048</option>

														<option value="2049">2049</option>

														<option value="2050">2050</option>

														<option value="2051">2051</option>

														<option value="2052">2052</option>

														<option value="2053">2053</option>

														<option value="2054">2054</option>

														<option value="2055">2055</option>

														<option value="2056">2056</option>

													</select>
												</span>
												<!-- /Year -->
												<div class="mb_pull_left">
													<!-- Cvv -->
													<span class="pull-left cvv_info">
														<label for="PAYMENT_cvv"
															class="make_block input_label append_bottom8">CVV
															CODE</label>
                                                                                                            <span class="make_block input_label append_bottom8">&nbsp;</span>
														<input type="password" pattern="[0-9]*"
															class="form-input form-control validate[funcCall[payments.cardSection.cvv_alert]]"
															placeholder="CVV" tabindex="11"
															name="card_cvc" id="card_cvc" maxlength="3">
													</span>
													<!-- /Cvv -->
											
												</div>
                                                                                            
											</div>
                                                                                            <div class="select_section clearfix append_bottom8">
                                                                                                <div class="mb_pull_right">
                                                                                                    		<!-- Cvv-Additional-info -->
													<span class="pull-right cvv_additionalinfo">

														<!-- Cvv-Required -->
														<span class="make_block cvv_requiredinfo clearfix"> <span
																id="cvv_small_icon"
																class="pull-left cvv_icon_3digit"></span><span
																class="cvv_required lato-normal-italic pull-left"><span
																	class="cvvText">3</span><span
																	class="cvv_required_info"
																	style="margin-left:2px;">digits printed on the back
																	of the card<span></span> </span>
																<!-- /Cvv-Required -->
															</span>
														</span>
													</span>
													<!-- /Cvv-Additional-info -->
                                                                                                </div>
                                                                                                </div>
                                                                                        <div class="alert alert-danger cardDetailsErrors" style="display:none;">
                                                                                                <ul class="cardErrors">
                                                                                                </ul>
                                                                                            </div>
										</div>

									</div>

									<!-- Payment-Details -->
									<div class="payment_details clearfix" id="paySubmitSection" style="display: block;">

										<!-- Payment-Amount-Info -->
										<div class="pay_amountinfo pull-left">
											<p class="lato-bold total_price append_bottom5 total_amount"
												style="height: 20px;">
												
													<span class="formattedCurrency payable-Booking-amount"
														id="PAYMENT_amount">{{$price['currency']}} {{$price['grandTotal']}}</span>

												</span>
											</p>
			

										</div>
										<!-- /Payment-Amount-Info -->
                                                                                
                                                                                <input type="hidden" value="{{ $price['grandTotal'] }}" name="total" id="grandTotal" />

										<!-- Payment-Button-Info -->
										<div class="pull-right" id="make_payment_section" style="display: block;">
											<p class="clearfix append_bottom6">
                                                                                            <button type="button" tabindex="19" class="button button-sm ladda-button"
                                                                                                        id="widgetPayBtn" style="background:#ed1d2d">
													<!-- <span class="pull-left lock_icon">&nbsp;</span> --> <span
														class="pull-left lock_txt lato-bold">Make Payment </span>
												</button>

											</p>
											<p class="lato-normal-italic text-right buttonRedirectText mb_hide">You will
												be redirected to your bank</p>
											<p class="lato-normal-italic text-right buttonRedirectTextOTP mb_hide"
												style="display:none;">This is the final step. You will be not be
												redirected.</p>
										</div>
										<!-- /Payment-Button-Info -->

									</div>
								</div>
                                                                
                                                                <div id="s2mTab" class="tab-pane fade">
                                                                        <center>
                                                                            <div class="setMargin">
                                                                                <div class="paymentLoader"></div>
                                                                            </div>
                                                                        </center>
                                                                    <p>
                                                                    Please wait, We are processing your request!
                                                                    </p>
                                                                </div>
                                                                    
                                                                    </div>
                                                                
							</div>
						</form>
					</div>
				</div>
				<!-- /Option-Tabs -->
			</div>
			<!-- /Payment-Option -->

		</div>

	</div>
                    
<!--                    <ul>
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
                    </ul>-->
                    
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
                <!--<button type="button" class="button button-primary button-sm ladda-button" data-style="expand-left" id="process_payment">Proceed to Pay</button>-->
            </div>

        </div>
    </div>
</section>
@endsection
@push('after-scripts')
<script>
    
    $( document ).ready(function() {
        $(".activateS2m").click(function() {
            $('#process_payment').click();
        });
        
        $(".ladda-button").click(function() {
            $('.errorMessageHere').hide();
            $('.alert-danger').hide();
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '/process_payment',
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: {_token: CSRF_TOKEN, type: 'payfull', customer_firstname: $("#customer_firstname").val(),
                    customer_lastname: $("#customer_lastname").val(), customer_email: $("#customer_email").val(),
                    customer_phone: $("#customer_phone").val(), card_holder_name: $("#card_holder_name").val(),
                    card_number: $("#card_number").val(), card_month: $("#card_month").val(), card_year: $("#card_year").val(),
                    card_cvc: $("#card_cvc").val(), total: $("#grandTotal").val()},
                dataType: 'JSON',
                success: function (data) {
                    $('html, body').animate({
                        scrollTop: $("#scrollToHere").offset().top
                    }, 2000);
                    
                    if (data.message == 'success'){
                        window.location.href = "{{ url('booked') }}";
                    } else if (data.error){
                        $('.errorMessageHere').show();
                        $('.errorMessageHere').html(data.info.ErrorMSG);
                    }
                },
                error: function (xhr, status, error) {
                        $('.cardErrors').html('');
                        var res = $.parseJSON(xhr.responseText);                        
                        for (const [key, value] of Object.entries(res.errors)) {
                            if($('.'+key)) {                                
                                $('.'+key).show();
                                $('.'+key).html(res.errors[key][0]);
                            }
                            
                            if(key == 'card_year' || key == 'card_month' || key == 'card_cvc') {
                                $('.cardDetailsErrors').show();
                                $('.cardErrors').append('<li>'+res.errors[key][0]+'</li>');
                            }
                          }
                        
//                        if(!res.status){
//                             siyApp.ajaxInputErrorAmadeus(res, $("#most-search"));
//                               if(res.message === 'No itinerary found for requested segment!.'){
////                                 $("#most-search").find('.alert').addClass('alert-danger').text(res.message).show();
//                                    $('.openAlert').click();
//                             }
//                         }
                 }
            });
        });
    });
    
    $(function () {
        $('#process_payment').on('click', function(){
            var l = Ladda.create(document.querySelector('#process_payment'));
//            if ($('input.terawallet-payment-method').prop('checked')){
//                l.start();
//                $.ajax({
//                    url:'/process_payment',
//                    type: 'POST',
//                    data: {
//                        amount: {{$price['grandTotal']}},
//                        type: 'terawallet'
//                    }
//                }).done(function(e){
//                    if (e.message == 'success'){
//                        window.location.href = "{{ url('booked') }}";
//                    } else if(e.info == 'low-balance'){
//                        alert('Your Terawallet Balance is low, please recharge your wallet & try again!');
//                    } else if (e.info == 'error'){
//                        alert('There was an error processing your order, please try again or contact support!');
//                    }
//                    l.stop();
//                });
//            } else if ($('input.s2m-method').prop('checked')){
                l.start();
                
//                setTimeout(function(){
//                    $('#s2m-method').submit();
//                }, 3000);
                
            // alert('payment intiated');
//            }
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
            $('#process_payment').trigger('click');
        <?php }?>
        <?php if(isset($s2mFailed) && $s2mFailed){?>
            alert('Your card payment was not successful, please try-again!');
            // $('#process_payment').trigger('click');
        <?php }?>
    });
    
  
</script>
@endpush