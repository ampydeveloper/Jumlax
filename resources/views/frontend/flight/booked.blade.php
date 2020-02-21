@extends('frontend.layouts.app')

@section('nav')
@include('frontend.includes.nav')
@endsection

@section('title', app_name() . ' | Flight Booked')

@section('content')
<section class="container-fluid gray-back itinerary-outer traveller-details-outer">
    <div class="container">
        <div class="row">

            <div class="col-sm-12 col-md-12 itinerary-box booked-box">
                <div class="white-box text-center">

                    <div class="trips-box">
                        <div class="tab-content">
                            <div class="tab-pane clearfix">
                                <div class="icon">
                                    <i class="fa fa-suitcase-rolling"></i>
                                </div>
                                <div class="desc">
                                    <h5>Ticket Booked! Your tickets have been booked successfully.</h5>
                                    <small>You can find your ticket along with complete booking details in your email.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <ul class="">
                        <li>
                            <a href="{{ route('frontend.index') }}" class="button button-primary button-sm button-naira button-naira-up popular-destination" >
                                <span class="icon fas fa-home"></span>
                                <span>Back to Home</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection