@extends('frontend.layouts.app')
@extends('frontend.includes.nav')
@section('title', app_name() . ' | ' . __('labels.frontend.contact.box_title'))

@section('content')
<section class="section-top-80 section-lg-top-0 google-map-abs-section">
        <div class="container text-lg-left">
          <div class="row row-50 row-lg-0 justify-content-xl-between">
            <div class="col-lg-8 col-xl-4 section-lg-80 section-xl-120">
               @if($logged_in_user->avatar_location != '')
                        <div class="user-img">
                            <img src="{{ asset('storage/'.$logged_in_user->avatar_location) }}" class="avatar img-circle img-thumbnail" alt="avatar" style="border-radius: 50%;"></div>
                        @else 
                        <div class="user-img">
                        <img src="{{ $logged_in_user->picture }}" class="avatar img-circle img-thumbnail" alt="avatar" style="border-radius: 50%;"></div>
                        @endif
                        <span> {{{ isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->email }}} </span>
                        <span>Personal Profile</span>
            </div>
            <div class="col-xxl-4 col-xl-5 col-lg-4 section-lg-80 section-xl-120">
              <div class="row row-40 row-lg-60 text-left">
                <div class="col-sm-6 col-lg-12">
                  <h5 class="text-bold hr-title">Profile</h5>
                  <p>Basic Info, for a faster booking experience</p>
                  
                  <span>Name</span>
                </div>
                <div class="col-sm-6 col-lg-12">
                  <h5 class="text-bold hr-title">E-mail</h5>
                  <div class="unit unit-spacing-xxs flex-row">
                    <div class="unit-left"><span class="icon icon-sm text-info-dr mdi mdi-email-outline"></span></div>
                    <div class="unit-body">
                      <div><a class="text-gray" href="mailto:#">info@jumlax.com</a></div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-lg-12">
                  <h5 class="text-bold hr-title">Address</h5>
                  <div class="unit unit-spacing-xxs flex-row">
                    <div class="unit-left"><span class="icon icon-sm text-info-dr mdi mdi-map-marker"></span></div>
                    <div class="unit-body">
                      <div><a class="text-gray" href="#">Tripoli - Andalus District / Andalus Gate Complex (Office No. 37)</a></div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <h5 class="text-bold hr-title">Socials</h5>
                  <ul class="list-inline">
                    <li><a class="icon text-gray icon-xxs fa-facebook" href="#"></a></li>
                    <li><a class="icon text-gray icon-xxs fa-twitter" href="#"></a></li>
                    <li><a class="icon text-gray icon-xxs fa-pinterest-p" href="#"></a></li>
                    <li><a class="icon text-gray icon-xxs fa-vimeo" href="#"></a></li>
                    <li><a class="icon text-gray icon-xxs fa-google-plus" href="https://plus.google.com/u/0/117616422700848151321"></a></li>
                    <li><a class="icon text-gray icon-xxs fa-rss" href="#"></a></li>
                  </ul>
                </div>
              </div>
            </div>
           
          </div>
        </div>
      </section>
@endsection

@push('after-scripts')
   
@endpush