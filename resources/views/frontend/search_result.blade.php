@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.general.home'))

@section('nav')
@include('frontend.includes.nav')
@endsection

@section('content')

<section class="container-fluid search-nav-form">
    <div class="container">
      <div id="error-show" class="alert alert-danger alert-dismissible fade" role="alert">
            <button type="button" class="close error-close"  aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <ul class="p-0 m-0 error-check" style="list-style: none;">
              
            </ul>
        </div>
        <form class="small home-search-fm" action="{{url('flight-search')}}" method="get">
            <div class="row">

                <div class="col-sm-12">
                    {!! csrf_field() !!}
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
                <div class="col-sm-12 col-lg-11">
                    <div class="row main-row">
                        <div class="col-sm-4 col-lg-2">
                            <label class="form-label-outside">Trip Type</label>
                            <select name="flight_type" class="tripType">
                                <option value="round" <?php echo ($requestdata['flight_type'] == 'round' ? 'selected' : ''); ?> >Round Trip</option>
                                <option value="oneway" <?php echo ($requestdata['flight_type'] == 'oneway' ? 'selected' : ''); ?>>One Way</option>
                            </select>
                        </div>

                        <div class="col-sm-4 col-lg-2">
                            {{--$from['airport_code']--}}
                            <label class="form-label-outside">From</label>
                            <div class="lisitng from-list">
                                <select class="form-input search-from search-from-set-val" name="from" value="{{$from['airport_code']}}">
                                    <option value="{{$from['airport_code']}}">{{$from['city_name']}} {{$from['country_name'].' ,'}} {{$from['airport_name']}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4 col-lg-2">
                            <label class="form-label-outside">To</label>
                            <div class="lisitng from-list-to">
                                <select class="form-input search-to search-to-set-val" name="to" id="xyz">
                                    <option value="{{$to['airport_code']}}">{{$to['city_name']}} {{$to['country_name'].' ,'}} {{$to['airport_name']}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4 col-lg-3 search-dividion-one">
                            <div class="col-sm-6">
                                <label class="form-label-outside">Departure</label>
                                <input class="form-input form-control-has-validation form-control-last-child" id="departure" name="departure" type="text" data-constraints="@Required" name="departure"  value="{{$requestdata['departure']}}">
                            </div>
                            <?php if (!empty($requestdata['return'])) { ?>
                                <div class="col-sm-6" id="returnDateCol">
                                    <label class="form-label-outside">Return</label>
                                    <input class="form-input form-control-has-validation form-control-last-child" id="return" name="return" type="text" data-constraints="@Required" name="return" value="<?php (isset($requestdata['return']) && !empty($requestdata['return'])) ? $requestdata['return'] : ''; ?>">
                                </div>
                            <?php } ?>
                            <div class="col-sm-6" id="returnDate" style="display:none">
                                    <label class="form-label-outside">Return</label>
                                    <input class="form-input form-control-has-validation form-control-last-child" id="return" name="return" type="text" data-constraints="@Required" name="return" value="<?php (isset($requestdata['return']) && !empty($requestdata['return'])) ? $requestdata['return'] : ''; ?>">
                            </div>
                        </div>

                        <div class="col-sm-4 col-lg-3 search-dividion-one">
                            <div class="col-sm-6">
                                <label class="form-label-outside">Class</label>
                                <select class="form-input" name="passenger-class">
                                    <option value="ECONOMY" <?php echo ($requestdata['passenger_class'] == "ECONOMY") ? 'selected' : ''; ?> >Economy</option>
                                    <option value="PREMIUM_ECONOMY" <?php echo ($requestdata['passenger_class'] == 'PREMIUM_ECONOMY') ? 'selected' : ''; ?> >Premium</option>
                                    <option value="BUSINESS" <?php echo ($requestdata['passenger_class'] == 'BUSINESS') ? 'selected' : ''; ?> >Business</option>
                                    <option value="FIRST" <?php echo ($requestdata['passenger_class'] == 'FIRST') ? 'selected' : ''; ?> >First</option>
                                </select>
                            </div>
                            <div class="col-sm-6 passengers-all-type">
                                <label class="form-label-outside">AD</label>
                                <label class="form-label-outside">CH</label>
                                <label class="form-label-outside">INF</label>
                                <input class="form-input form-control-has-validation form-control-last-child" type="text"  name="passenger_adult" value="<?php echo isset($requestdata['passenger_adult']) ? $requestdata['passenger_adult'] : 1; ?>" >
                                <input class="form-input form-control-has-validation form-control-last-child" type="text"  name="passenger_child" value="<?php echo isset($requestdata['passenger_child']) ? $requestdata['passenger_child'] : 0; ?>" >
                                <input class="form-input form-control-has-validation form-control-last-child" type="text"  name="passenger_infant" value="<?php echo isset($requestdata['passenger_infant']) ? $requestdata['passenger_infant'] : 0; ?>" >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-1 submit-fm-out">
                    <div class="submit-fm text-xl-right">
                        <button class="button button-primary button-sm button-naira button-naira-up" id="for-msubmit">
                            <span class="icon fas fa-search"></span>
                            <span>Search  <i class="fa fa-spinner fa-spin show-loader" style="display:none"></i></span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<section class="section-80 bg-gray-lighter">
    <div class="container container-wide">
        <div class="row row-50 text-xl-left">
            <div class="col-sm-12">
                <div class="inset-xxl-right-80">

                    @if($status == 404)

                    <h2 class="text-ubold">Sorry, No flights for this search</h2>
                    <p>We cannot find any flight for the arrival city of your search.Please modify your search criteria and try again. We recommend you look for a nearby airport.</p>
                    <a href="/" class="button button-primary button-sm button-naira button-naira-up popular-destination">Back</a>

                    @else

                    <h2 class="text-ubold">{{$from['city_name']}}, {{$from['country_abbrev']}} ({{$from['airport_code']}}) to {{$to['city_name']}}, {{$to['country_abbrev']}} ({{$to['airport_code']}})</h2>
                    <hr class="divider divider-lg-left divider-primary divider-80">

                    @foreach($paginatedItems as $key=>$flight)
                    <?php
//                    dump($key);
//                  dd($flight);
                    ?>
                    <ul class="list-tickets">
                        <li class="list-item">
                            <div class="list-item-inner">
                                <div class="list-item-main list-item-heading1">
                                    <div class="list-item-logo-outer">
                                        @if(isset($flight['carrierCode']))
                                        @foreach($flight['carrierCode'] as $carrierCode)
                                        <div class="list-item-logo">
                                            <img src="http://pics.avs.io/60/24/{{$carrierCode}}.png" alt="">
                                            <p>
                                                <?php
                                                foreach ($airline as $value) {
                                                    if ($carrierCode == $value['al_code']) {
                                                        echo $value['al_name'];
                                                    }
                                                }
                                                ?>
                                            </p>
                                        </div>
                                        @endforeach
                                        @else
                                        <div class="list-item-logo">
                                            <img src="http://pics.avs.io/60/24/{{$flight['oneWayDetails']['carrierCode']}}.png" alt="">
                                            <p>
                                                <?php
                                                foreach ($airline as $value) {
                                                    if ($flight['oneWayDetails']['carrierCode'] == $value['al_code']) {
                                                        echo $value['al_name'];
                                                        break;
                                                    }
                                                }
                                                ?>
                                            </p>
                                        </div>
                                        @endif
                                    </div>  

                                    <?php
                                    $layoverArray1 = array();
                                    if ($flight['oneWayDetails']['stops']['total'] >= 1) {
                                        if (is_array($flight['oneWayDetails']['stops'])) {
                                            $planeChange1 = $flight['oneWayDetails']['stops']['total'] . ' Plane change';
                                            foreach ($flight['oneWayDetails']['stops'] as $key => $stop) {
                                                if ($key != 'total') {
                                                    $layover1 = (isset($stop['layover'])?$stop['layover']:0) . " Layover";
                                                    $layoverArray1[$key - 1] = $layover1;
                                                    $secondValue = $key . ". " . $stop['airport_data']['airport_name'] . ", " . $stop['airport_data']['city_name'] . " (" . $stop['iataCode'] . ")" . " | " . $layover1;
                                                    $planeChange1 .= $secondValue != '' ? ' ' . $secondValue : '';
                                                }
                                                if (isset($stop['terminal'])) {
                                                    $terminal = 'Terminal ' . $stop['terminal'];
                                                } else {
                                                    $terminal = '';
                                                }

                                                $planeChange1 .= $terminal != '' ? ' ' . $terminal : '';
                                            }
                                        }
                                    } else {
                                        $planeChange1 = 'No Stop';
                                    }
                                    ?>

                                    <?php
                                    $layoverArray = array();
                                    if (isset($flight['returnDetails']) && $flight['returnDetails']['stops'] != 0 && count($flight['returnDetails']['stops']) > 1) {
                                        if (is_array($flight['returnDetails']['stops'])) {
                                            $planeChange = (count($flight['returnDetails']['stops']) - 1) . ' Plane change';
                                            foreach ($flight['returnDetails']['stops'] as $key => $stop) {
                                                if ($key != 'total') {
                                                    $layover = (isset($stop['layover'])?$stop['layover']:0) . " Layover";
//                                                    $layover = $stop['layover'] . " Layover";
                                                    $layoverArray[$key - 1] = $layover;
                                                    $secondValue = $key . ". " . $stop['airport_data']['airport_name'] . ", " . $stop['airport_data']['city_name'] . " (" . $stop['iataCode'] . ")" . " | " . $layover;
                                                    $planeChange .= $secondValue != '' ? ' ' . $secondValue : '';
                                                }
                                                if (isset($stop['terminal'])) {
                                                    $terminal = 'Terminal ' . $stop['terminal'];
                                                } else {
                                                    $terminal = '';
                                                }

                                                $planeChange .= $terminal != '' ? ' ' . $terminal : '';
                                            }
                                        }
                                    } else {
                                        $planeChange = 'No Stop';
                                    }
                                    ?>

                                    <div class="list-item-footer">
                                        <h5 class="text-bold list-item-price">{{ $flight['travelerPricings'][0]['price']['currency'].' '.$flight['travelerPricings'][0]['price']['total'] }} </h5>
                                        <form action="{{url('review')}}" method="post" id="most-search">
                                            {!! csrf_field() !!}
                                            <input type="hidden" value="{{ serialize($layoverArray) }}" name="return">
                                            <input type="hidden" value="{{ serialize($layoverArray1) }}" name="oneWay">
                                            <input type="hidden" value="{{ serialize($flight['itineraries']) }}" name="segment">
                                            <input type="hidden" value="{{ serialize($flight['price']) }}" name="price">
                                            <input type="hidden" value="{{ serialize($flight['travelerPricings']) }}" name="travelerPricings">
                                            <div class="submit-fm">
                                                <button class="button button-primary button-sm button-naira button-naira-up">
                                                    Book  Now
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="list-item-main list-item-plane-details">
                                    <div class="plane-details">
                                        <?php
                                        foreach ($airline as $value) {
                                            if ($flight['oneWayDetails']['carrierCode'] == $value['al_code']) {
                                                $carrierName = $value['al_name'];
                                                break;
                                            }
                                        }
                                        if ($flight['numberOfBookableSeats'] == 1) {
                                            $bookableSeats = "1 Seat Available";
                                        } else {
                                            $bookableSeats = $flight['numberOfBookableSeats'] . " Seats Available";
                                        }
                                        ?>
                                        <span>Departure | </span>
                                        {{\Carbon\Carbon::parse($flight['oneWayDetails']['departure']['at'])->format('D, d M'). " | ".$carrierName. " | ". $bookableSeats}}
                                    </div> 
                                    @if(isset($flight['returnDetails'])) 
                                    <div class="plane-details">
                                        <?php
                                        foreach ($airline as $value) {
                                            if ($flight['returnDetails']['carrierCode'] == $value['al_code']) {
                                                $carrierName = $value['al_name'];
                                                break;
                                            }
                                        }
                                        ?>
                                        <span>Return | </span>
                                        {{ \Carbon\Carbon::parse($flight['returnDetails']['departure']['at'])->format('D, d M'). " | ".$carrierName}} 
                                    </div> 
                                    @endif
                                </div> 


                                <div class="list-item-main list-item-flights">
                                    <hr class="divider divider-wide">
                                    <div class="list-item-top">
                                        <div class="list-item-content">
                                            <div class="list-item-content-left">
                                                <div class="text-bold text-base">{{ \Carbon\Carbon::parse($flight['oneWayDetails']['departure']['at'])->format('h:i') }}</div>
                                                <span class="small d-block">{{ $flight['oneWayDetails']['departure']['airport_data']['city_name'] }}&nbsp;&nbsp;({{ $flight['oneWayDetails']['departure']['iataCode'] }}) </span>
                                                @if(isset($flight['oneWayDetails']['departure']['terminal']))
                                                <span class="small d-block">Terminal {{ $flight['oneWayDetails']['departure']['terminal'] }} </span>
                                                @endif
                                            </div>
                                            <div class="list-item-content-line-wrapper small plane-change-topen" data-toggle="tooltip" data-html="true" data-placement="top">
                                                <div class="list-item-content-line-top"> 
                                                    <?php
                                                    $resStr = str_replace('H', ' hrs ', $flight['oneWayDetails']['duration']);
                                                    $resStr = str_replace('M', ' mins ', $resStr);
                                                    ?>
                                                    {{$resStr}}
                                                </div>
                                                <div class="list-item-content-line"></div>

                                                @if($planeChange1 != "No Stop")
                                                <div class="list-item-content-line-bottom text-info-dr link"
                                                     draggable="false"
                                                     data-tooltip="{{$planeChange1}}">
                                                @else    
                                                <div class="list-item-content-line-bottom text-info-dr"
                                                     draggable="false">
                                                    @endif
                                                    @if($flight['oneWayDetails']['stops']['total'] == 0)
                                                    Non-stop
                                                    @elseif($flight['oneWayDetails']['stops']['total'] == 1)
                                                    1 stop
                                                    @else
                                                    {{$flight['oneWayDetails']['stops']['total']}} stops
                                                    @endif


                                                    @if(count($flight['oneWayDetails']['stops']) > 1)
                                                    <!--                                                    <div class="tooltip plane-change-tooltip" role="tooltip">
                                                                                                            <div class="arrow"></div>
                                                                                                            <div class="tooltip-inner">
                                                    
                                                                                                                @if(is_array($flight['oneWayDetails']['stops']))
                                                                                                                {{count($flight['oneWayDetails']['stops']) - 1}} Plane change<br>
                                                                                                                @foreach($flight['oneWayDetails']['stops'] as $key => $stop) 
                                                                                                                @if($key != 'total')
                                                                                                                {{$key.". ".$stop['airport_data']['airport_name'] . ", " .$stop['airport_data']['city_name'] ." (".    $stop['iataCode'] .")"}} <br>
                                                                                                                @if(isset($stop['terminal']))
                                                                                                                {{'Terminal '.$stop['terminal']}} <br>
                                                                                                                @endif
                                                                                                                @endif
                                                                                                                @endforeach
                                                                                                                @endif
                                                                                                            </div>
                                                                                                        </div>-->
                                                    @endif
                                                </div>
                                            </div>
                                            <?php
                                            $arrival = \Carbon\Carbon::parse($flight['oneWayDetails']['arrival']['at'])->format('m/d/y');
                                            $departure = \Carbon\Carbon::parse($flight['oneWayDetails']['departure']['at'])->format('m/d/y');

                                            $date1 = new DateTime($arrival);
                                            $date2 = new DateTime($departure);
                                            $diff = $date1->diff($date2);
                                            ?>
                                            <div class="list-item-content-right">
                                                <div class="text-bold text-base">{{ \Carbon\Carbon::parse($flight['oneWayDetails']['arrival']['at'])->format('H:i') }} <span style="color:red; font-size: 10px">+{{$diff->days}} DAY</span></div>
                                                <span class="small d-block">{{ $flight['oneWayDetails']['arrival']['airport_data']['city_name'] }}&nbsp;&nbsp;({{ $flight['oneWayDetails']['arrival']['iataCode'] }})</span>
                                                @if(isset($flight['oneWayDetails']['arrival']['terminal']))
                                                <span class="small d-block">Terminal {{ $flight['oneWayDetails']['arrival']['terminal'] }} </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    @if(isset($flight['returnDetails'])) 
                                    <hr class="divider divider-wide">
                                    <div class="list-item-top">
                                        <div class="list-item-content">
                                            <div class="list-item-content-left">
                                                <div class="text-bold text-base">{{ \Carbon\Carbon::parse($flight['returnDetails']['departure']['at'])->format('H:i') }}</div>
                                                <span class="small d-block">{{ $flight['returnDetails']['departure']['airport_data']['city_name'] }}&nbsp;&nbsp;({{ $flight['returnDetails']['departure']['iataCode'] }}) </span>
                                                @if(isset($flight['returnDetails']['departure']['terminal']))
                                                <span class="small d-block">Terminal {{ $flight['returnDetails']['departure']['terminal'] }} </span>
                                                @endif
                                            </div>

                                            <div class="list-item-content-line-wrapper small plane-change-topen" data-toggle="tooltip" data-html="true" data-placement="top">
                                                <div class="list-item-content-line-top">

                                                    <?php
                                                    $resStr = str_replace('H', ' hrs ', $flight['returnDetails']['duration']);
                                                    $resStr = str_replace('M', ' mins ', $resStr);
                                                    ?>
                                                    {{$resStr}}
                                                </div>
                                                <div class="list-item-content-line"></div>

                                                @if($planeChange != "No Stop")
                                                <div class="list-item-content-line-bottom text-info-dr link"
                                                     draggable="false"
                                                     data-tooltip="{{$planeChange}}" >
                                                @else    
                                                <div class="list-item-content-line-bottom text-info-dr"
                                                     draggable="false">
                                                @endif    
                                                    @if($flight['returnDetails']['stops']['total'] == 0)
                                                    Non-stop
                                                    @elseif($flight['returnDetails']['stops']['total'] == 1)
                                                    1 stop
                                                    @else
                                                    {{$flight['returnDetails']['stops']['total']}} stops
                                                    @endif

                                                    @if(count($flight['oneWayDetails']['stops']) > 1)
                                                    <!--                                                    <div class="tooltip plane-change-tooltip" role="tooltip">
                                                                                                            <div class="arrow"></div>
                                                                                                            <div class="tooltip-inner">
                                                    
                                                                                                                @if(is_array($flight['oneWayDetails']['stops']))
                                                                                                                {{count($flight['oneWayDetails']['stops']) - 1}} Plane change<br>
                                                                                                                @foreach($flight['oneWayDetails']['stops'] as $key => $stop) 
                                                                                                                @if($key != 'total')
                                                                                                                {{$key.". ".$stop['airport_data']['airport_name'] . ", " .$stop['airport_data']['city_name'] ." (".    $stop['iataCode'] .")"}} <br>
                                                                                                                @if(isset($stop['terminal']))
                                                                                                                {{'Terminal '.$stop['terminal']}} <br>
                                                                                                                @endif
                                                                                                                @endif
                                                                                                                @endforeach
                                                                                                                @endif
                                                                                                            </div>
                                                                                                        </div>-->
                                                    @endif
                                                </div>

                                            </div>
                                            <div class="list-item-content-right">
                                                <div class="text-bold text-base">{{ \Carbon\Carbon::parse($flight['returnDetails']['arrival']['at'])->format('H:i') }} </div>
                                                <span class="small d-block">{{ $flight['returnDetails']['arrival']['airport_data']['city_name'] }}&nbsp;&nbsp;({{ $flight['returnDetails']['arrival']['iataCode'] }})</span>
                                                @if(isset($flight['returnDetails']['arrival']['terminal']))
                                                <span class="small d-block">Terminal {{ $flight['returnDetails']['arrival']['terminal'] }} </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                </div>
                            </div>

                            <!--                            <div class="small text-gray-light list-item-subtitle">
                                                            <i class="fa fa-roofhouse"></i>  Standard legroom
                                                        </div>-->
                        </li>
                    </ul>
                    @endforeach
                    @endif
                </div>
            </div>
            <div class="col-5">
                <div class="total-user">
                </div>
            </div>
            <div class="col-7">
                <div class="float-right">
                    <nav class="page-number"></nav>
                </div>
            </div><!--col-->

        </div>
    </div>
</section>
@endsection
<style>
    nav.page-number.light-theme.simple-pagination ul li {
        position: relative;
        display: block;
        margin-left: -1px;
        line-height: 1.25;
        color: #20a8d8;
        float: left
    }
    nav.page-number.light-theme.simple-pagination ul li.active span {
        position: relative;
        display: block;
        padding: 0.5rem 0.75rem;
        margin-left: -1px;
        line-height: 1.25;
        color: #fff;
        background-color: #007bff;
        border: 1px solid #dee2e6;
    }
    .toast {
        position: absolute;
        opacity: 1 !important;
        z-index: 999999;
        right: 0;
        top: 50%;
    }
</style>
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/simplePagination.js/1.6/jquery.simplePagination.js"></script>
<script type="text/javascript">
$(document).ready(function () {
    
    if($(".tripType option:selected").val() == 'round'){
       $("#returnDate").css('display', 'block');
    }

    var items = $(".list-tickets");
    var numItems = items.length;
    var perPage = 15;
    $(".total-user").text(numItems + ' Total Flights');
    items.slice(perPage).hide();
    
    var pathname = window.location.href;
    var explodePath = pathname.split('#');
    var defaultPage =1;
    if(explodePath.length > 1) {
        defaultPage = explodePath[1];
    }

    $('.page-number').pagination({
        items: numItems,
        itemsOnPage: perPage,
        currentPage: defaultPage,
        prevText: "&laquo;",
        nextText: "&raquo;",
        hrefTextPrefix: "#",
        onPageClick: function (pageNumber) {
            var showFrom = perPage * (pageNumber - 1);
            var showTo = showFrom + perPage;
            items.hide().slice(showFrom, showTo).show();
        },
        onInit: function () {
            if(explodePath.length > 1) {
                var NewPageNumber= defaultPage;
                var showFrom = perPage * (NewPageNumber - 1);
                var showTo = showFrom + perPage;
                items.hide().slice(showFrom, showTo).show();
            }
        }
    });

    var p = $(".list-tickets").first();
    $(document).on('click', '.page-link', function () {
        $("html, body").animate({
            scrollTop: p.scrollTop()
        }, 1000);
    });

    $(".search-from, .search-to").select2({
        ajax: {
            url: '/get-lisit',
            type: 'POST',
            dataType: 'json',
            data: function (params) {
                return {
                    message: params.term
                };
            },
            processResults: function (data, params) {
                return {
                    results: data.data
                };
            },
            cache: true
        },
        placeholder: 'Search City or Airport',
        minimumInputLength: 1,
        templateResult: formatRepo,
        templateSelection: formatRepoSelection
    });
    function formatRepo(repo) {
        if (repo.loading) {
            return 'Searching...';
        }
        var $container = $(
                "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title'></div>" +
                "<div class='select2-result-repository__description'></div>" +
                "</div>" +
                "</div>"
                );
        $container.find(".select2-result-repository__title").text(repo.city_name + ', ' + repo.country_name);
        $container.find(".select2-result-repository__description").text(repo.airport_name + ', ' + repo.airport_code);
        return $container;
    }
    function formatRepoSelection(repo) {
        return (repo.city_name != undefined) ? 'Search City or Airport' : repo.text;
    }
    $('.search-from').on('select2:select', function (e) {
        var data = e.params.data;
        $(".search-from").select2("destroy");
        var option = $("<option value='" + data.airport_code + "' selected>" + data.airport_name + ", " + data.airport_code + "</option>");
        $('.search-from-set-val').empty().append(option);
        $(".search-from").select2({
            ajax: {
                url: '/get-lisit',
                type: 'POST',
                dataType: 'json',
                data: function (params) {
                    return {
                        message: params.term
                    };
                },
                processResults: function (data, params) {
                    return {
                        results: data.data
                    };
                },
                cache: true
            },
            placeholder: 'Search City or Airport',
            minimumInputLength: 1,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection
        });
    });
    $('.search-to').on('select2:select', function (e) {
        var data = e.params.data;
        $(".search-to").select2("destroy");
        var option = $("<option value='" + data.airport_code + "' selected>" + data.airport_name + ", " + data.airport_code + "</option>");
        $('.search-to-set-val').empty().append(option);
        $(".search-to").select2({
            ajax: {
                url: '/get-lisit',
                type: 'POST',
                dataType: 'json',
                data: function (params) {
                    return {
                        message: params.term
                    };
                },
                processResults: function (data, params) {
                    return {
                        results: data.data
                    };
                },
                cache: true
            },
            placeholder: 'Search City or Airport',
            minimumInputLength: 1,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection
        });
    });
    
 

    $(".tripType").on('change', function () {
        if ($(this).val() == 'oneway') {
            if($("#returnDateCol").length){
                $(".return").val('');
                $("#returnDateCol").css('display', 'none');
            }else{
                $(".return").val('');
                $("#returnDate").css('display', 'none');
            }
        } else {
            if($("#returnDateCol").length){
                $("#returnDateCol").css('display', 'block');
            }else{
                $("#returnDate").css('display', 'block');
            }
        }
    });

    let departureDate;
    var date = new Date();
    date.setDate(date.getDate());
    $('#departure').datepicker({
        format: 'dd M yyyy',
        startDate: date,
    });
    $('#departure').datepicker('setDate', new Date('<?php echo $requestdata['departure']; ?>'));
    $('#return').datepicker({
        format: 'dd M yyyy',
        startDate: date,
    });
    $('#return').datepicker('setDate', new Date('<?php echo isset($requestdata['return']) ? $requestdata['return'] : ""; ?>'));

    $('#departure').on('changeDate', function () {
        departureDate = new Date($('#departure').val());
        $('#return').datepicker('destroy');
        $('#return').datepicker({
            format: 'dd M yyyy',
            startDate: departureDate
        });
    });


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
    $(".home-search-fm").on('submit', function (e) {
        $(".show-loader").show();
         $("#error-show").removeClass('show')
        $(".error-check").empty();
        e.preventDefault();
        // return false;
        var $this = $(this);
        $this.find('#for-msubmit').attr("disabled", true);
        var flightType = $this.find('[name="flight_type"]').val(),
                from = $this.find('[name="from"]').val(),
                to = $this.find('[name="to"]').val(),
                passengerClass = $this.find('[name="passenger-class"]').val(),
                departure = $this.find('[name="departure"]').val(),
                departureVal = new Date(departure).toJSON().slice(0, 10),
                returnVal = null,
                passengerAdult = $this.find('[name="passenger_adult"]').val(),
                passengerChild = $this.find('[name="passenger_child"]').val(),
                passengerInfant = $this.find('[name="passenger_infant"]').val(),
                actionUrl = $this.attr('action');
                if($this.find('[name="return"]').val()){
                    var returnData = $this.find('[name="return"]').val().trim();
                }
        if (returnData && returnData.length > 0) {
            returnVal = new Date(returnData).toJSON().slice(0, 10);
        } else {
            flightType = "oneway";
        }
        var parameters = '/' + passengerClass + '/' + flightType + '/' + from + '/' + to + '/' + departureVal + '/' + returnVal + '/' + passengerAdult + '/' + passengerChild + '/' + passengerInfant + '/' + '0';
        actionUrlFinal = actionUrl + parameters;
        // console.log(actionUrl);
        // console.log(actionUrlFinal);
        $.ajax({
            type: "GET",
            url: actionUrlFinal,
            dataType: "json",
            success: function (data) {
               $(".show-loader").hide();
               $("#error-show").hide();
               $(".error-check").empty();
                location.href = '/flight-search-listing' + parameters;
            },
            error: function (xhr, status, error) {
                $(".show-loader").hide();
                $(".error-check").empty();
                var res = $.parseJSON(xhr.responseText);
                if (!res.status) {
                    console.log(res);
                    var html = '';
                    if(res.message){
                        html += '<li>' + res.message + '</li>';
                    }
                    if(res.errors){
                        for (var i = 0; i < res.errors.length; i++) {
                            html += '<li>' + res.errors[i].detail + '</li>';
                        }
                    }
                    $(".error-check").append(html);
                    $("#error-show").addClass('show');
                }
                $(".home-search-fm").find('#for-msubmit').attr("disabled", false);
               // siyApp.ajaxInputError(error, $(".home-search-fm"));
            }
        });
        e.preventDefault();
    });
    
    $(".error-close").on('click', function(){
        $("#error-show").removeClass('show');
    })

});
</script>
@endpush