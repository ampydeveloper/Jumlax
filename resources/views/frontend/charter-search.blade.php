@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.general.home'))

@section('nav')
@include('frontend.includes.nav')
@endsection

@section('content')
<section class="container-fluid search-nav-form">
    <div class="container">
        <form class="small home-search-fm" action="{{url('charter-search')}}" method="post">
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
                <div class="col-sm-12 col-lg-10">
                    <div class="row main-row">
                        <input name="chartertype" value="oneway" type="hidden" class="chartertype">
                        <div class="col-sm-6 col-lg-3">
                            <label class="form-label-outside">From</label>
                            <div class="lisitng from-list">
                                <select class="form-input search-from-charter search-from-set-val-charter" name="charterfrom" value="{{$requestdata['charterfrom']}}">
                                    <option value="{{$requestdata['charterfrom']}}">{{$requestdata['charterfrom']}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <label class="form-label-outside">To</label>
                            <div class="lisitng from-list-to">
                                <select class="form-input search-to-charter search-to-set-val-charter" name="charterto" value="{{$requestdata['charterto']}}">
                                    <option value="{{$requestdata['charterto']}}">{{$requestdata['charterto']}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <label class="form-label-outside">Departure</label>
                            <input class="form-input form-control-has-validation form-control-last-child" type="text" data-constraints="@Required" id="charterdeparture" name="charterdeparture" value="{{$requestdata['charterdeparture']}}">
                        </div>
                        <div class="col-sm-6 col-lg-3 search-dividion-one">
                            <div class="col-sm-6">
                                <label class="form-label-outside">Class</label>
                                <select class="form-input" name="charterclass">
                                    <option value="1" <?php echo ($requestdata['charterclass'] == 1) ? 'selected' : ''; ?> >Economy</option>
                                    <option value="2" <?php echo ($requestdata['charterclass'] == 2) ? 'selected' : ''; ?> >Premium</option>
                                    <option value="3" <?php echo ($requestdata['charterclass'] == 3) ? 'selected' : ''; ?> >Business</option>
                                    <option value="4" <?php echo ($requestdata['charterclass'] == 4) ? 'selected' : ''; ?> >First</option>
                                </select>
                            </div>
                            <div class="col-sm-6 passengers-all-type">
                                <label class="form-label-outside">AD</label>
                                <label class="form-label-outside">CH</label>
                                <label class="form-label-outside">INF</label>
                                <input class="form-input form-control-has-validation form-control-last-child" type="text"  name="charteradult" value="<?php echo isset($requestdata['charteradult']) ? $requestdata['charteradult'] : 1; ?>" >
                                <input class="form-input form-control-has-validation form-control-last-child" type="text"  name="charterchild" value="<?php echo isset($requestdata['charterchild']) ? $requestdata['charterchild'] : 0; ?>" >
                                <input class="form-input form-control-has-validation form-control-last-child" type="text"  name="charterinfant" value="<?php echo isset($requestdata['charterinfant']) ? $requestdata['charterinfant'] : 0; ?>" >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-2 submit-fm-out">
                    <div class="submit-fm text-xl-right">
                        <button class="button button-primary button-sm button-naira button-naira-up" type="submit">
                            <span class="icon fas fa-search"></span>
                            <span>Search</span>
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
            <div class="col-sm-9">
                <div class="inset-xxl-right-80">
                    <?php
                    ?>
                    @if($status == 0)
                    <div class="search-null">
                        <h2 class="text-ubold search-heading">Sorry, No flights for this search</h2>
                        <p>We cannot find any flight for the arrival city of your search. Please modify your search criteria and try again.</p>
                        <a href="/" class="button button-primary button-sm button-naira button-naira-up popular-destination">Back</a>
                    </div>
                    @endif
                    
                    @if($status == 2) 
                    <div class="">
                        <h2 class="text-ubold search-heading">Suggested flight routes from {{$requestdata['charterfrom']}} to {{$requestdata['charterto']}}</h2>
                    </div>
                    <hr class="divider divider-lg-left divider-primary divider-80">
                    
                    @if(isset($result) && !empty($result))
                    @foreach($result as $key => $flight)
                    <?php
                    $count = 0;
                    $datetime1 = new DateTime($flight['departure_time']);
                    $datetime2 = new DateTime($flight['arriving_time']);
                    $interval = $datetime1->diff($datetime2);
                    $elapsed = $interval->format(' %hH%iM');
                    if ($requestdata['charterclass'] == 1) {
                        $fare = $flight->economy_price;
                        $ticket = 'Economy';
                        $seatsInCharter = $flight->economy_seat;
                    } else if ($requestdata['charterclass'] == 2) {
                        $fare = $flight->premium_price;
                        $ticket = 'Premium';
                        $seatsInCharter = $flight->premium_seat;
                    } else if ($requestdata['charterclass'] == 3) {
                        $fare = $flight->business_price;
                        $ticket = 'Business';
                        $seatsInCharter = $flight->business_seat;
                    } else if ($requestdata['charterclass'] == 4) {
                        $fare = $flight->first_price;
                        $ticket = 'First';
                        $seatsInCharter = $flight->first_seat;
                    }
                    if (count($flight->bookings)) {
                        if (count($flight->bookings[0]->passengers)) {
                            $bookedSeats = count($flight->bookings[0]->passengers) + 1;
                        } else {
                            $bookedSeats = 1;
                        }
                    } else {
                        $bookedSeats = 0;
                    }
                    $seatsAvailable = $seatsInCharter - $bookedSeats;
                    ?>
                    @if($seatsAvailable >= $requestdata['charteradult']+$requestdata['charterchild'])
                    <?php $count++; ?>
                    <ul class="list-tickets">

                        <li class="list-item">
                            <div class="list-item-inner">
                                <div class="list-item-main list-item-heading1">
                                    <div class="list-item-logo-outer">
                                        <div class="list-item-logo">
                                            <img src="{{URL::asset('/charter_logos/'.$flight->planes->charterDetails->logo)}}" alt="{{$flight->planes->charterDetails->name}}" class="charter_logo" />
                                            <p>
                                                {{$flight->planes->charterDetails->name}} <span>{{$flight->planes->plane_number}}</span>
                                            </p>
                                        </div>
                                    </div>      
                                    <div class="list-item-footer">
                                        <h5 class="text-bold list-item-price">LD {{$fare}}</h5>
                                        <form action="{{url('chartereview')}}" method="post" id="most-search">
                                            {!! csrf_field() !!}
                                            <input type="hidden" value="{{$flight}}" name="result">
                                            <input type="hidden" value="{{serialize($requestdata)}}" name="searchdata">
                                            @if(isset($return[$key]))
                                            <input type="hidden" value="{{$return[$key]}}" name="return">
                                            @endif
                                            <div class="submit-fm">
                                                <button class="button button-primary button-sm button-naira button-naira-up">
                                                    Book Now
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="list-item-main list-item-plane-details">
                                    <div class="plane-details">
                                        <span>Departure | </span>
                                        {{\Carbon\Carbon::parse($flight['departure_time'])->format('D, d M'). " | ".$flight->planes->charterDetails->name}} | {{$ticket}} Class | {{$seatsAvailable}} Seats Available
                                    </div> 
                                    @if(isset($return) && is_array($return))
                                    <div class="plane-details">
                                        <span>Return | </span> {{$flight->planes->charterDetails->name}}
                                        {{\Carbon\Carbon::parse($flight['departure_time'])->format('D, d M'). " | ".$flight->planes->charterDetails->name}} | {{$ticket}} Class | {{$seatsAvailable}} Seats Available
                                    </div> 
                                    @endif
                                </div> 

                                <div class="list-item-main list-item-flights">
                                    <hr class="divider divider-wide">
                                    <div class="list-item-top">
                                        <div class="list-item-content">
                                            <div class="list-item-content-left">
                                                <div class="text-bold text-base">{{ \Carbon\Carbon::parse($flight['departure_time'])->format('h:i A') }}</div>
                                                <span class="small d-block">{{$flight['from']}}</span>
                                                <span class="small d-block">{{$flight['airport_code']}}</span>
                                                <span class="small d-block">{{$flight['airport_name']}}</span>
                                            </div>
                                            <div class="list-item-content-line-wrapper small">
                                                <div class="list-item-content-line-top">
                                                    {{ $elapsed}}
                                                </div>
                                                <div class="list-item-content-line"></div>
                                                <div class="list-item-content-line-bottom text-info-dr">
                                                    non stop
                                                </div>
                                            </div>
                                            <div class="list-item-content-right">
                                                <div class="text-bold text-base">{{ \Carbon\Carbon::parse($flight['arriving_time'])->format('h:i A') }}</div>
                                                <span class="small d-block">{{$flight['to']}}</span>
                                                <span class="small d-block">{{$flight['airport_code']}}</span>
                                                <span class="small d-block">{{$flight['airport_name']}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if(isset($return) && is_array($return))
                            <?php
                            $datetime1 = new DateTime($return[$key]['departure_time']);
                            $datetime2 = new DateTime($return[$key]['arriving_time']);
                            $interval = $datetime1->diff($datetime2);
                            $returnelapsed = $interval->format(' %hH%iM');
                            ?>
                            <div class="list-item-inner">

                                <div class="list-item-main list-item-heading1">
                                    <div class="list-item-logo-outer">
                                        <div class="list-item-logo">
                                            <img src="{{URL::asset('/charter_logos/'.$return[$key]->planes->charterDetails->logo)}}" alt="{{$return[$key]->planes->charterDetails->name}}" class="charter_logo" />
                                            <p>
                                                {{$return[$key]->planes->charterDetails->name}} <span>{{$return[$key]->planes->plane_number}}</span>
                                            </p>
                                        </div>
                                    </div>      

                                    <div class="list-item-footer">
                                        @if(isset($return))
                                        <h5 class="text-bold list-item-price">LD {{$fare}}</h5>
                                        @endif
                                        <div class="submit-fm">
                                        </div>
                                    </div>
                                </div>

                                <div class="list-item-main list-item-flights">
                                    <hr class="divider divider-wide">
                                    <div class="list-item-top">
                                        <div class="list-item-content">
                                            <div class="list-item-content-left">
                                                <div class="text-bold text-base">{{ \Carbon\Carbon::parse($return[$key]['departure_time'])->format('h:i A') }}</div>
                                                <span class="small d-block">{{$return[$key]['from']}}</span>
                                                <span class="small d-block">{{$return[$key]['airport_code']}}</span>
                                                <span class="small d-block">{{$return[$key]['airport_name']}}</span>
                                            </div>
                                            <div class="list-item-content-line-wrapper small">
                                                <div class="list-item-content-line-top">
                                                    {{ $returnelapsed}}

                                                </div>
                                                <div class="list-item-content-line"></div>
                                                <div class="list-item-content-line-bottom text-info-dr">
                                                    non stop
                                                </div>
                                            </div>
                                            <div class="list-item-content-right">
                                                <div class="text-bold text-base">{{ \Carbon\Carbon::parse($return[$key]['arriving_time'])->format('h:i A') }}</div>
                                                <span class="small d-block">{{$return[$key]['to']}}</span>
                                                <span class="small d-block">{{$return[$key]['airport_code']}}</span>
                                                <span class="small d-block">{{$return[$key]['airport_name']}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            @endif
                        </li>
                    </ul>
                    @endif
                    @endforeach
                    @endif
                    @endif
                    
                    @if($count == 0)
                    <div class="search-null">
                        <h2 class="text-ubold search-heading">Sorry, No flights for this search</h2>
                        <p>We cannot find any flight for the arrival city of your search. Please modify your search criteria and try again.</p>
                        <a href="/" class="button button-primary button-sm button-naira button-naira-up popular-destination">Back</a>
                    </div>
                    @endif
                </div>

                @if(isset($result) && !empty($result))
                {!! $result->links() !!}
                @endif
            </div>

        </div>
    </div>
</section>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $(".search-from-charter").select2({
            ajax: {
                url: '/get-charter-from-lisit',
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
            placeholder: 'Search Charter Plane',
            minimumInputLength: 1,
            templateResult: formatCharterRepo,
            templateSelection: formatRepoCharterSelection
        });
        function formatCharterRepo(repo) {
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
            $container.find(".select2-result-repository__title").text(repo.from);
            $container.find(".select2-result-repository__description").text(repo['planes'].plane_number + ', ' + repo['planes'].name);
            return $container;
        }
        function formatRepoCharterSelection(repo) {
            return (repo.text != undefined) ? repo.text : 'Search Charter Plane';
        }
        $('.search-from-charter').on('select2:select', function (e) {
            var data = e.params.data;
            $(".search-from-charter").select2("destroy");
            var option = $("<option value='" + data.from + "' selected>" + data.from + "</option>");
            $('.search-from-set-val-charter').empty().append(option);
            $(".search-from-charter").select2({
                ajax: {
                    url: '/get-charter-from-lisit',
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
                placeholder: 'Search Charter Plane',
                minimumInputLength: 1,
                templateResult: formatCharterRepo,
                templateSelection: formatRepoCharterSelection
            });
        });

        $(".search-to-charter").select2({
            ajax: {
                url: '/get-charter-to-lisit',
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
            placeholder: 'Search Charter Plane',
            minimumInputLength: 1,
            templateResult: formatCharterToRepo,
            templateSelection: formatRepoCharterToSelection
        });
        //charter section
        function formatCharterToRepo(repo) {
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
            $container.find(".select2-result-repository__title").text(repo.to);
            $container.find(".select2-result-repository__description").text(repo['planes'].plane_number + ', ' + repo['planes'].name);
            return $container;
        }
        function formatRepoCharterToSelection(repo) {
            return (repo.text != undefined) ? repo.text : 'Search Charter Plane';
        }
        $('.search-to-charter').on('select2:select', function (e) {
            var data = e.params.data;
            $(".search-to-charter").select2("destroy");
            var option = $("<option value='" + data.to + "' selected>" + data.to + "</option>");
            $('.search-to-set-val-charter').empty().append(option);
            $(".search-to-charter").select2({
                ajax: {
                    url: '/get-charter-to-lisit',
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
                placeholder: 'Search Charter Plane',
                minimumInputLength: 1,
                templateResult: formatCharterToRepo,
                templateSelection: formatRepoCharterToSelection
            });
        });

        let departureDate;
        var date = new Date();
        date.setDate(date.getDate());
        $('#charterdeparture').datepicker({
            format: 'dd M yyyy',
            startDate: date,
        });
        $('#charterdeparture').datepicker('setDate', new Date('<?php echo $requestdata['charterdeparture']; ?>'));
    });
</script>
@endpush