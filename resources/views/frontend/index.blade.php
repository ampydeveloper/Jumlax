@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.general.home'))

@section('content')

@if (\Session::has('most'))
<div class="alert alert-danger most">
    <ul>
        <li>{!! \Session::get('most') !!}</li>
    </ul>
</div>
@endif
<div class="page text-center animated" style="animation-duration: 500ms;">
    <section class="swiper-slide-wrapper">
        <div class="swiper-container swiper-slider swiper-container-horizontal swiper-container-fade" data-simulate-touch="false" data-autoplay="3500" data-slide-effect="fade">
            <div class="swiper-wrapper" style="transition-duration: 0ms;">
                <div class="swiper-slide swiper-slide-active" data-slide-bg="images/background-08.jpg" data-swiper-slide-index="1" style="background-image: url(&quot;images/background-08.jpg&quot;); background-size: cover;   transform: translate3d(-2538px, 0px, 0px); opacity: 1; transition-duration: 0ms;">

                </div>
            </div>
            <div class="swiper-onSlider header-back-outer">
                @include('frontend.includes.nav')
                <div class="container container-wide section-70 section-xxl-top-200 section-xxl-bottom-220">
                    <div class="row justify-content-sm-center">
                        <div class="col-sm-12 col-md-11 col-lg-10">
                            <div class="responsive-tabs text-lg-left nav-custom-dark view-animate fadeInUpSmall active" data-type="horizontal" style="display: block; width: 100%;">
                                  
                                <ul class="nav-custom-tabs resp-tabs-list">
                                    <li class="nav-item resp-tab-item resp-tab-active" aria-controls="tab_item-0" role="tab">
                                        <i class="fas fa-plane fa-rotate-270"></i>
                                        <span>Flights</span></li>
                                    <li class="nav-item resp-tab-item" aria-controls="tab_item-1" role="tab">
                                        <i class="fas fa-plane fa-rotate-270"></i>
                                        <span>Charter Plane</span></li>
                                </ul>
                              
                                <div class="resp-tabs-container nav-custom-tab nav-custom-wide">
                                    
                                    <div class="resp-tab-content" aria-labelledby="tab_item-0">
                                        <form class="small home-search-fm amadeus-flight-search" action="{{url('flight-search')}}" method="get">
                                           <div class="alert alert-danger" id="errors" style="display:none"></div>
                                            {!! csrf_field() !!}
                                            @if(session()->has('message'))
                                            <div class="alert alert-danger">
                                                {{ session()->get('message') }}
                                            </div>
                                            @endif

                                            @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            @endif
                                          
                                            <div class="row-20 row-md-23">
                                                <div class="col-lg-8 padding-remove round-one-way">
                                                    <div class="form-wrap radio-inline-wrapper">
                                                        <label class="radio-inline">
                                                            <input name="flight_type" value="round" type="radio" checked="" class="radio-custom">
                                                            Round Trip
                                                        </label>
                                                        <label class="radio-inline">
                                                            <input name="flight_type" value="oneway" type="radio" class="radio-custom">
                                                            One Way
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="col-12 padding-remove">
                                                    <div class="row-20 column-full-marg">
                                                        <div class="column-35 float-left">
                                                            <div class="form-wrap">
                                                                <label class="form-label-outside">From</label>
                                                                <div class="lisitng from-list">
                                                                    <select class="form-input search-from search-from-set-val" name="from" value="{{old('from')}}" required>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="column-35 float-left">
                                                            <div class="form-wrap">
                                                                <label class="form-label-outside">To</label>
                                                                <div class="lisitng from-list-to">
                                                                    <select class="form-input search-to search-to-set-val" name="to" id="xyz" value="{{old('to')}}" required>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="column-30 float-left">
                                                            <div class="form-wrap">
                                                                <label class="form-label-outside">Cabin Class</label>
                                                                <select class="form-input" name="passenger_class">
                                                                    <option value="ECONOMY">Economy</option>
                                                                    <option value="PREMIUM_ECONOMY">Premium</option>
                                                                    <option value="BUSINESS">Business</option>
                                                                    <option value="FIRST">First</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="depart-return-fm">
                                                    <div>
                                                        <div class="col-sm-12 col-md-6 col-lg-3 float-left">
                                                            <div class="form-wrap">
                                                                <label class="form-label-outside">Departure</label>
                                                                <?php $date1 = date('Y-m-d'); $tomorrow = date('y-m-d',strtotime($date1 . "+1 days")); ?>
                                                                <input class="form-input form-control-last-child" type="text"  name="departure" autocomplete="off" id="departure" min="<?php echo $date1 ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-6 col-lg-3 float-left" id="return-area">
                                                            <div class="form-wrap">
                                                                <label class="form-label-outside">Return</label>
                                                                <input class="form-input form-control-last-child return" type="text" id="return" autocomplete="off" name="return" min="<?php echo $date1 ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-12 col-lg-6 float-left passenger-list">
                                                            <div class="col-sm-4 float-left">
                                                                <div class="form-wrap">
                                                                    <label class="form-label-outside">Adults (12y +)</label>
                                                                    <div class="stepper ">
                                                                        <input name="passenger_adult" class="form-input stepper-input form-control-has-validation" type="number" min="1" max="9" value="1" data-constraints="@Numeric">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4 float-left">
                                                                <div class="form-wrap">
                                                                    <label class="form-label-outside">Children (2y - 12y)</label>
                                                                    <div class="stepper">
                                                                        <input name="passenger_child" class="form-input stepper-input form-control-has-validation" type="number" min="0" max="10" value="0" data-constraints="@Numeric">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4 float-left">
                                                                <div class="form-wrap">
                                                                    <label class="form-label-outside">Infants (below 2y)</label>
                                                                    <div class="stepper">
                                                                        <input name="passenger_infant" class="form-input stepper-input form-control-has-validation" type="number" min="0" max="10" value="0" data-constraints="@Numeric">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="submit-fm text-xl-right">
                                                    <button class="button button-primary button-sm button-naira button-naira-up">
                                                        <span class="icon fas fa-search"></span>
                                                        <span>Search  <i class="fa fa-spinner fa-spin show-loader" style="display:none"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="resp-tab-content" aria-labelledby="tab_item-1">
                                        <form class="small home-search-fm" action="{{url('charter-search')}}" method="post">
                                            {!! csrf_field() !!}
                                            @if(session()->has('message'))
                                            <div class="alert alert-danger">
                                                {{ session()->get('message') }}
                                            </div>
                                            @endif
                                            @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            @endif
                                            <div class="row-20 row-md-23">
                                                <!--                                                <div class="col-lg-8 padding-remove round-one-way">
                                                                                                    <div class="form-wrap radio-inline-wrapper">
                                                                                                        <label class="radio-inline">
                                                                                                            <input name="chartertype" value="round" type="radio" checked="" class="radio-custom chartertype">
                                                                                                            Round Trip
                                                                                                        </label>
                                                                                                        <label class="radio-inline">
                                                                                                            <input name="chartertype" value="oneway" type="radio" class="radio-custom chartertype">
                                                                                                            One Way
                                                                                                        </label>
                                                                                                    </div>
                                                                                                </div>-->
                                                <input name="chartertype" value="oneway" type="hidden" class="chartertype">
                                                <div class="clearfix"></div>
                                                <div class="col-12 padding-remove">
                                                    <div class="row-20 column-full-marg">
                                                        <div class="column-35 float-left">
                                                            <div class="form-wrap">
                                                                <label class="form-label-outside">From</label>
                                                                <div class="lisitng from-list">
                                                                    <select class="form-input search-from-charter search-from-set-val-charter" name="charterfrom" required>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="column-35 float-left">
                                                            <div class="form-wrap">
                                                                <label class="form-label-outside">To</label>
                                                                <div class ="lisitng from-list-to">
                                                                    <select class="form-input search-to-charter search-to-set-val-charter" name="charterto" required>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="column-30 float-left">
                                                            <div class="form-wrap">
                                                                <label class="form-label-outside">Cabin Class</label>
                                                                <select class="form-input" name="charterclass">
                                                                    <option value="1">Economy</option>
                                                                    <option value="2">Premium</option>
                                                                    <option value="3">Business</option>
                                                                    <option value="4">First</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="depart-return-fm">
                                                    <div>
                                                        <div class="col-sm-12 col-md-12 col-lg-6 float-left">
                                                            <div class="form-wrap">
                                                                <label class="form-label-outside">Departure</label>
                                                                <input class="form-input form-control-last-child" type="text" id="charterdeparture"  name="charterdeparture" min="<?php echo date('y-m-d'); ?>" required>
                                                            </div>
                                                        </div>
                                                        <!--                                                        <div class="col-sm-12 col-md-6 col-lg-3 float-left" id="return-charter">
                                                                                                                    <div class="form-wrap">
                                                                                                                        <label class="form-label-outside">Return</label>
                                                                                                                        <input class="form-input form-control-last-child charterreturn" type="type" id="charterreturn" min="<?php // echo date('y-m-d');        ?>" name="charterreturn">
                                                                                                                    </div>
                                                                                                                </div>-->
                                                        <div class="col-sm-12 col-md-12 col-lg-6 float-left passenger-list">
                                                            <div class="col-sm-4 float-left">
                                                                <div class="form-wrap">
                                                                    <label class="form-label-outside">Adults (12y +)</label>
                                                                    <div class="stepper ">
                                                                        <input name="charteradult" class="form-input stepper-input form-control-has-validation" type="number" min="1" max="10" value="1" data-constraints="@Numeric">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4 float-left">
                                                                <div class="form-wrap">
                                                                    <label class="form-label-outside">Children (2y - 12y)</label>
                                                                    <div class="stepper">
                                                                        <input name="charterchild" class="form-input stepper-input form-control-has-validation" type="number" min="0" max="10" value="0" data-constraints="@Numeric">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4 float-left">
                                                                <div class="form-wrap">
                                                                    <label class="form-label-outside">Infants (below 2y)</label>
                                                                    <div class="stepper">
                                                                        <input name="charterinfant" class="form-input stepper-input form-control-has-validation" type="number" min="0" max="10" value="0" data-constraints="@Numeric">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="submit-fm text-xl-right">
                                                    <button class="button button-primary button-sm button-naira button-naira-up">
                                                        <span class="icon fas fa-search"></span>
                                                        <span>Search</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
    </section>
    <section class="section-80" style="border-bottom:2px solid #1f2746">
        <div class="container container-wide">
            <h2 class="text-ubold">Popular Destinations</h2>
            <hr class="divider divider-primary divider-80">
        </div>
        <div class="row row-60 isotope-wrap">
            <!-- Isotope Content-->
            <div class="col-12">
                <div class="row no-gutters isotope isotope-no-padding isotope--loaded" data-isotope-layout="masonry" data-isotope-group="gallery" style="position: relative; height: 557.922px;">
                    <div class="col-12 col-md-6 col-lg-4 col-xl-1-5 isotope-item" data-filter="Type 1" style="position: absolute; left: 0px; top: 0px;">
                        <a class="thumbnail-variant-4" href="javascript:void(0);" data-city="BCN"><img class="img-responsive center-block thumbnail-image" src="images/post-35.jpg" alt="">
                            <div class="caption">
                                <h3 class="text-ubold">Barcelona</h3>
                                <p>The cultural, commercial, and financial center of Northern California.</p>
                                <div class="thumbnail-link"></div>
                            </div></a></div>
                    <div class="col-12 col-md-6 col-lg-4 col-xl-1-5 isotope-item" data-filter="Type 2" style="position: absolute; left: 253px; top: 0px;">
                        <a class="thumbnail-variant-4" href="javascript:void(0);" data-city="LCY"><img class="img-responsive center-block thumbnail-image" src="images/post-36.jpg" alt="">
                            <div class="caption">
                                <h3 class="text-ubold">London</h3>
                                <p>The cultural, commercial, and financial center of Northern California.</p>
                                <div class="thumbnail-link"></div>
                            </div></a></div>
                    <div class="col-12 col-md-6 col-lg-4 col-xl-1-5 isotope-item" data-filter="Type 3" style="position: absolute; left: 507px; top: 0px;">
                        <a class="thumbnail-variant-4" href="javascript:void(0);" data-city="NYC"><img class="img-responsive center-block thumbnail-image" src="images/post-37.jpg" alt="">
                            <div class="caption">
                                <h3 class="text-ubold">New York</h3>
                                <p>The cultural, commercial, and financial center of Northern California.</p>
                                <div class="thumbnail-link"></div>
                            </div></a></div>
                    <div class="col-12 col-md-6 col-lg-4 col-xl-1-5 isotope-item" data-filter="Type 4" style="position: absolute; left: 761px; top: 0px;">
                        <a class="thumbnail-variant-4" href="javascript:void(0);" data-city="FCO"><img class="img-responsive center-block thumbnail-image" src="images/post-38.jpg" alt="">
                            <div class="caption">
                                <h3 class="text-ubold">Rome</h3>
                                <p>The cultural, commercial, and financial center of Northern California.</p>
                                <div class="thumbnail-link"></div>
                            </div></a></div>
                    <div class="col-12 col-md-6 col-lg-4 col-xl-1-5 isotope-item" data-filter="Type 1" style="position: absolute; left: 1015px; top: 0px;">
                        <a class="thumbnail-variant-4" href="javascript:void(0);" data-city="CDG"><img class="img-responsive center-block thumbnail-image" src="images/post-39.jpg" alt="">
                            <div class="caption">
                                <h3 class="text-ubold">Paris</h3>
                                <p>The cultural, commercial, and financial center of Northern California.</p>
                                <div class="thumbnail-link"></div>
                            </div></a></div>
                    <div class="col-12 col-md-6 col-lg-4 col-xl-1-5 isotope-item" data-filter="Type 3" style="position: absolute; left: 0px; top: 185px;">
                        <a class="thumbnail-variant-4" href="javascript:void(0);" data-city="SYD"><img class="img-responsive center-block thumbnail-image" src="images/post-40.jpg" alt="">
                            <div class="caption">
                                <h3 class="text-ubold">Blue Mountains</h3>
                                <p>The cultural, commercial, and financial center of Northern California.</p>
                                <div class="thumbnail-link"></div>
                            </div></a></div>
                    <div class="col-12 col-md-6 col-lg-4 col-xl-1-5 isotope-item" data-filter="Type 4" style="position: absolute; left: 507px; top: 185px;">
                        <a class="thumbnail-variant-4" href="javascript:void(0);" data-city="TXL"><img class="img-responsive center-block thumbnail-image" src="images/post-42.jpg" alt="">
                            <div class="caption">
                                <h3 class="text-ubold">Berlin</h3>
                                <p>The cultural, commercial, and financial center of Northern California.</p>
                                <div class="thumbnail-link"></div>
                            </div></a></div>
                    <div class="col-12 col-md-6 col-lg-4 col-xl-1-5 isotope-item" data-filter="Type 2" style="position: absolute; left: 761px; top: 185px;">
                        <a class="thumbnail-variant-4" href="javascript:void(0);" data-city="HKT"><img class="img-responsive center-block thumbnail-image" src="images/post-43.jpg" alt="">
                            <div class="caption">
                                <h3 class="text-ubold">Phuket</h3>
                                <p>The cultural, commercial, and financial center of Northern California.</p>
                                <div class="thumbnail-link"></div>
                            </div></a></div>
                    <div class="col-12 col-md-6 col-lg-4 col-xl-1-5 isotope-item" data-filter="Type 1" style="position: absolute; left: 507px; top: 371px;">
                        <a class="thumbnail-variant-4" href="javascript:void(0);" data-city="XVQ"><img class="img-responsive center-block thumbnail-image" src="images/post-41.jpg" alt="">
                            <div class="caption">
                                <h3 class="text-ubold">Venice</h3>
                                <p>The cultural, commercial, and financial center of Northern California.</p>
                                <div class="thumbnail-link"></div>
                            </div></a></div>
                    <div class="col-12 col-md-6 col-lg-4 col-xl-1-5 isotope-item" data-filter="Type 4" style="position: absolute; left: 253px; top: 371px;">
                        <a class="thumbnail-variant-4" href="javascript:void(0);" data-city="SFO"><img class="img-responsive center-block thumbnail-image" src="images/post-44.jpg" alt="">
                            <div class="caption">
                                <h3 class="text-ubold">San Francisco</h3>
                                <p>The cultural, commercial, and financial center of Northern California.</p>
                                <div class="thumbnail-link"></div>
                            </div></a></div>
                    <div class="col-12 col-md-6 col-lg-4 col-xl-1-5 isotope-item" data-filter="Type 1" style="position: absolute; left: 1015px; top: 371px;">
                        <a class="thumbnail-variant-4" href="javascript:void(0);" data-city="AYT"><img class="img-responsive center-block thumbnail-image" src="images/post-45.jpg" alt="">
                            <div class="caption">
                                <h3 class="text-ubold">Mediterranean</h3>
                                <p>The cultural, commercial, and financial center of Northern California.</p>
                                <div class="thumbnail-link"></div>
                            </div></a></div>
                </div>
            </div>
        </div>
        <div class="most-search">
            <form action="{{url('flight-search')}}" method="get" id="most-search">
                <div class="alert"></div>
                {!! csrf_field() !!}
                <?php
                $var = date('Y-m-d');
                $var_subtracted_date = date('Y-m-d', strtotime('+2 days', strtotime($var)));
                ?>
                <input type="hidden" value="1" name="popular_destination">
                <input type="hidden" value="TIP" name="from">
                <input type="hidden" value="BOM" name="to" class="city">
                <input type="hidden" value="oneway" name="flight_type">
                <input type="hidden" value="<?php echo $var_subtracted_date ?>" name="departure">
                <input type="hidden" value="<?php echo date('Y'); ?>" name="period">
                <input type="hidden" value="1" name="passenger_adult">
                <input type="hidden" value="0" name="passenger_child">
                <input type="hidden" value="0" name="passenger_infant">
                <input type="hidden" value="ECONOMY" name="passenger_class">
                <input type="hidden" value="analytics.travelers.score" name="sort">
                <input type="hidden" value="10" name="max">
                <div class="submit-fm">
                    <button class="button button-primary button-sm button-naira button-naira-up popular-destination" data-city="BOM">
                        <span class="icon fas fa-search"></span>
                        <span>find tickets</span>
                    </button>
                </div>
            </form>
        </div>
        <hr>
    </section>
    <section class="section-80 our-advantage">
        <div class="container container-wide">
            <hr>
            <h2 class="view-animate fadeInUpBigger delay-04 text-ubold active">Our Advantages</h2>
            <hr class="view-animate fadeInUpBigger delay-06 divider divider-primary divider-80 active">
            <div class="row row-50">
                <div class="col-md-6 col-lg-3 icon-box view-animate fadeInUpSmall delay-08 active">
                    <span class="icon icon-lg text-primary-grad icon-primary icon-circle">
                        <i class="fas fa-plane fa-rotate-270"></i>
                    </span>

                    <h5 class="text-bold">The Most Reliable<br class="d-none d-lg-block">Airlines</h5>
                    <hr class="divider divider-50">
                    <p class="inset-xxl-left-40 inset-xxl-right-40">We cooperate only with the most reliable airlines who can boast the perfect reputation.</p>
                </div>
                <div class="col-md-6 col-lg-3 icon-box view-animate fadeInUpSmall delay-08 active">
                    <span class="icon icon-lg text-primary-grad icon-primary icon-circle">
                        <i class="fas fa-user-friends"></i>
                    </span>
                    <h5 class="text-bold">More Than 7M Visitors<br class="d-none d-lg-block">Each Month</h5>
                    <hr class="divider divider-50">
                    <p class="inset-xxl-left-40 inset-xxl-right-40">More than 7 million people use our services to find and book airline tickets.</p>
                </div>
                <div class="col-md-6 col-lg-3 icon-box view-animate fadeInUpSmall delay-08 active">
                    <span class="icon icon-lg text-primary-grad icon-primary icon-circle">
                        <i class="fas fa-search"></i>
                    </span>
                    <h5 class="text-bold">User-Friendly<br class="d-none d-lg-block">Search System</h5>
                    <hr class="divider divider-50">
                    <p class="inset-xxl-left-40 inset-xxl-right-40">Convenient and fast search for airline tickets, hotels and cars.</p>
                </div>
                <div class="col-md-6 col-lg-3 icon-box view-animate fadeInUpSmall delay-08 active">
                    <span class="icon icon-lg text-primary-grad icon-primary icon-circle" >
                        <i class="fas fa-calendar-check"></i>
                    </span>
                    <h5 class="text-bold">Fast and Reliable<br class="d-none d-lg-block">Ticket Booking</h5>
                    <hr class="divider divider-50">
                    <p class="inset-xxl-left-40 inset-xxl-right-40">We provide reliable ticket booking system, which is also perfect for first-time travellers.</p>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-image-05 context-dark section-70" style="background-color: #1f2746">
        <div class="container parallax-scene-wrapper">
            <div class="row justify-content-sm-center">
                <div class="col-xl-6 col-lg-8 wow fadeInUp" data-wow-delay="0.1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInUp;">
                    <h1 class="text-spacing-60 text-ubold p">24/7 Support</h1>
                    <p class="big">Our Support Service is available 24 hours a day, 7 days a week to help you buy your tickets.</p><a class="button button-primary" href="/contact">get in touch</a>
                </div>
            </div>
        </div>

    </section>
    @endsection
    <style>
        .toast {
    position: absolute;
    opacity: 1 !important;
    z-index: 999999;
    right: 0;
    top: 50%;
}
    </style>
    @push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            let departureDate, returnDate;
            var date = new Date();
            date.setDate(date.getDate()+1);
            $('#departure').datepicker({
                format: 'dd M yyyy',
                startDate: date,
            });

  $('#departure').datepicker('setDate', date);
            //$('#departure').datepicker('setDate', new Date());
            $('#return').datepicker({
                format: 'dd M yyyy',
                startDate: date,
            });
            $('#charterdeparture').datepicker({
                format: 'dd M yyyy',
                startDate: date,
            });
            $('#charterdeparture').datepicker('setDate', new Date());
            $('#charterreturn').datepicker({
                format: 'dd M yyyy',
                startDate: date,
            });
            $('#departure').on('changeDate', function () {
                departureDate = new Date($('#departure').val());
                $('#return').datepicker('destroy');
                $('#return').datepicker({
                    format: 'dd M yyyy',
                    startDate: departureDate
                });
            });
            $('#charterdeparture').on('changeDate', function () {
                departureDate = new Date($('#charterdeparture').val());
                $('#charterreturn').datepicker('destroy');
                $('#charterreturn').datepicker({
                    format: 'dd M yyyy',
                    startDate: departureDate
                });
            });
//            $('#return').on('changeDate', function () {
//                returnDate = new Date($('#return').val());
//                $('#departure').datepicker('destroy');
//                $('#departure').datepicker({
//                    format: 'mm-dd-yyyy',
//                    startDate: date,
//                    endDate: returnDate
//                });
//            });

            //change round trip
            $(".radio-custom").on('change', function () {
                if ($(this).val() == 'oneway') {
                    $(".return").val('');
                    $("#return-area").hide();
                    $('#return').removeAttr('required');
                } else {
                    $("#return-area").show();
                    $("#return").prop('required', true);
                }
            });
            $(".chartertype").on('change', function () {
                if ($(this).val() == 'oneway') {
                    $(".charterreturn").val('');
                    $("#return-charter").hide();
                } else {
                    $("#return-charter").show();
                }
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
            $(".search-from").data('select2').$dropdown.find(':input.select2-search__field').attr('placeholder', 'Form');
            $(".search-to").data('select2').$dropdown.find(':input.select2-search__field').attr('placeholder', 'To');
            //charter section
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
            //charter section
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
                console.log(repo);
                return (repo.from != undefined) ? repo.from : 'Search Charter Plane';
            }

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
                return (repo.to != undefined) ? repo.to : 'Search Charter Plane';
            }

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
                return (repo.city_name != undefined) ? repo.city_name + ', ' + repo.country_name : 'Search City or Airport';
            }

            $('.search-from').on('select2:select', function (e) {
                var data = e.params.data;
                var $option = $("<option selected></option>").val(data.airport_code).text(data.airport_name);
                $('.search-from-set-val').empty().append($option);
            });
            $('.search-to').on('select2:select', function (e) {
                var data = e.params.data;
                var $option = $("<option selected></option>").val(data.airport_code).text(data.airport_name);
                $('.search-to-set-val').empty().append($option);
            });
            //charter section
            $('.search-from-charter').on('select2:select', function (e) {
                var data = e.params.data;
                var $option = $("<option selected></option>").val(data.from).text(data.from);
                $('.search-from-set-val-charter').empty().append($option);
            });
            $('.search-to-charter').on('select2:select', function (e) {
                var data = e.params.data;
                var $option = $("<option selected></option>").val(data.to).text(data.to);
                $('.search-to-set-val-charter').empty().append($option);
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $(".thumbnail-variant-4").on('click', function (e) {
                $("#most-search").find('.alert-danger').text('');
                $("#most-search").find('.alert').removeClass('alert-danger');
                $(".city").val($(this).attr('data-city'));
                e.preventDefault();
                // return false;
                var $this = $("#most-search");
                var flightType = $this.find('[name="flight_type"]').val(),
                        from = $this.find('[name="from"]').val(),
                        to = $this.find('[name="to"]').val(),
                        passengerClass = $this.find('[name="passenger_class"]').val(),
                        departure = $this.find('[name="departure"]').val(),
                        departureVal = new Date(departure).toJSON().slice(0, 10),
                        returnVal = null,
                        passengerAdult = $this.find('[name="passenger_adult"]').val(),
                        passengerChild = $this.find('[name="passenger_child"]').val(),
                        passengerInfant = $this.find('[name="passenger_infant"]').val(),
                        actionUrl = $this.attr('action');
               
                        flightType = "oneway";
                
                var parameters = '/' + passengerClass + '/' + flightType + '/' + from + '/' + to + '/' + departureVal + '/' + returnVal + '/' + passengerAdult + '/' + passengerChild + '/' + passengerInfant + '/' + '0';
                actionUrlFinal = actionUrl + parameters;
                // console.log(actionUrl);
                // console.log(actionUrlFinal);
                 $.ajax({
                     type: "GET",
                     url: actionUrlFinal,
                     dataType: "json",
                     success: function (data) {
                         console.log(data);
                        location.href = 'flight-search-listing' + parameters;
                     },
                     error: function (xhr, status, error) {
                          var res = $.parseJSON(xhr.responseText);
                          if(!res.status){
                            $("#most-search").find('.alert').addClass('alert-danger').text(res.message);
                          }
                         siyApp.ajaxInputErrorAmadeus(res, $("#most-search"));
                     }
                 });
                 e.preventDefault();
            });
            
           
            $(".amadeus-flight-search").on('submit', function (e) {
                $("#errors").text('').removeClass('alert-danger').hide();
                $(".show-loader").show();
                e.preventDefault();
                // return false;
                var $this = $(this);
                $this.find('.submit-fm button').attr("disabled", true);
                var flightType = $this.find('[name="flight_type"]').val(),
                        from = $this.find('[name="from"]').val(),
                        to = $this.find('[name="to"]').val(),
                        passengerClass = $this.find('[name="passenger_class"]').val(),
                        departure = $this.find('[name="departure"]').val(),
                        departureVal = new Date(departure).toJSON().slice(0, 10),
                        returnVal = null,
                        passengerAdult = $this.find('[name="passenger_adult"]').val(),
                        passengerChild = $this.find('[name="passenger_child"]').val(),
                        passengerInfant = $this.find('[name="passenger_infant"]').val(),
                        actionUrl = $this.attr('action');
                var returnData = $this.find('[name="return"]').val().trim();
                if(returnData && returnData.length > 0){
                    returnVal = new Date(returnData).toJSON().slice(0, 10);
                }else{
                    flightType = "oneway";
                }
                var parameters = '/' + passengerClass + '/' + flightType + '/' + from + '/' + to + '/' + departureVal + '/' + returnVal + '/' + passengerAdult + '/' + passengerChild + '/' + passengerInfant + '/' + '0';
                actionUrlFinal = actionUrl + parameters;
               
                 $.ajax({
                     type: "GET",
                     url: actionUrlFinal,
                     dataType: "json",
                     success: function (data) {
                          $(".show-loader").hide();
                       location.href = 'flight-search-listing' + parameters;
                     },
                     error: function (xhr, status, error) {
                          $(".show-loader").hide();
                          $("#errors").show(); 
                         var res = $.parseJSON(xhr.responseText);
                       
                         $(".amadeus-flight-search").find('.submit-fm button').attr("disabled", false);
                         siyApp.ajaxInputErrorAmadeus(res, $(".amadeus-flight-search"));
                          if(res.message === 'No itinerary found for requested segment!'){
                             $("#errors").addClass('alert-danger').text(res.message).show();
                        }
                     }
                 });
                 e.preventDefault();
            });
        });
    </script>
    @endpush
