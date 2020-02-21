@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.frontend.contact.box_title'))

@section('content')
<section class="bg-image-06 header-back-outer">
    @include('frontend.includes.nav')
    <div class="breadcrumb-wrapper header-back">
        <div class="overlay"></div>
        <div class="container context-dark section-30 section-xl-top-120">
            <h1 class="text-ubold">Contact Us</h1>
        </div>
    </div>
</section>

<section class="section-top-80 section-lg-top-0 google-map-abs-section">
    <div class="container container-wide text-lg-left">
        <div class="row row-50 row-lg-0 justify-content-xl-between">
            <div class="col-lg-8 col-xl-7 section-lg-80 section-xl-120">
                <h2 class="text-ubold">Get in Touch</h2>
                <hr class="divider divider-md-left divider-primary divider-80">
                <p>You can contact us any way that is convenient for you. We are available 24/7 via fax or email. You can also use a quick contact form below or visit our office personally. We would be happy to answer your questions.</p>
                <form class="text-left solid-outer" method="post" action="{{route('frontend.contact.send')}}" novalidate="novalidate">
                    {!! csrf_field() !!}
                    <div class="row row-20">
                        <div class="col-sm-12">
                            @include('includes.partials.messages')
                        </div>
                        <div class="col-md-6">
                            <div class="form-wrap">
                                <label class="form-label-outside" for="contact-name">First name</label>
                                <input class="form-input form-input-gray" id="contact-name" type="text" name="name" data-constraints="@Required">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-wrap">
                                <label class="form-label-outside" for="contact-surname">Last name</label>
                                <input class="form-input form-input-gray" id="contact-surname" type="text" name="surname" data-constraints="@Required">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-wrap">
                                <label class="form-label-outside" for="contact-email">E-mail</label>
                                <input class="form-input form-input-gray" id="contact-email" type="email" name="email" data-constraints="@Required @Email">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-wrap">
                                <label class="form-label-outside" for="contact-phone">Phone</label>
                                <input class="form-input form-input-gray" id="contact-phone" type="text" name="phone" data-constraints="@Required @Integer">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-wrap">
                                <label class="form-label-outside" for="contact-message">Message</label>
                                <textarea class="form-input form-input-gray" id="contact-message" name="message" data-constraints="@Required"></textarea>
                            </div>
                            <div class="form-wrap">
                                <button class="button button-primary button-sm" style="min-width: 140px;" type="submit">Send</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xxl-4 col-xl-5 col-lg-4 section-lg-80 section-xl-120">
                <div class="row row-40 row-lg-60 text-left">
                    <div class="col-sm-6 col-lg-12">
                        <h5 class="text-bold hr-title">Phones</h5>
                        <div class="unit unit-spacing-xxs flex-row">
                            <div class="unit-left"><span class="fas fa-phone"></span></div>
                            <div class="unit-body">
                                <div><a class="text-gray" href="tel:#">+218 91 001 9311</a></div>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-12">
                        <h5 class="text-bold hr-title">E-mail</h5>
                        <div class="unit unit-spacing-xxs flex-row">
                            <div class="unit-left"><span class="fas fa-envelope"></span></div>
                            <div class="unit-body">
                                <div><a class="text-gray" href="mailto:#">info@jumlax.com</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-12">
                        <h5 class="text-bold hr-title">Address</h5>
                        <div class="unit unit-spacing-xxs flex-row">
                            <div class="unit-left"><span class="fas fa-map-marker"></span></div>
                            <div class="unit-body">
                                <div><a class="text-gray" href="#">Tripoli - Andalus District / Andalus Gate Complex (Office No. 37)</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 social-fabs">
                        <h5 class="text-bold hr-title">Socials</h5>
                        <ul class="list-inline">
                            <li><a class="fab fa-facebook" href="#"></a></li>
                            <li><a class="fab fa-twitter-square" href="#"></a></li>
                            <li><a class="fab fa-pinterest-square" href="#"></a></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection

@push('after-scripts')
@if(config('access.captcha.contact'))
@captchaScripts
@endif
@endpush