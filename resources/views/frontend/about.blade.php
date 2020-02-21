@extends('frontend.layouts.app')

@section('title', app_name() . ' | About')

@push('after-styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"/>
@endpush


@section('content')
<section class="bg-image-06 header-back-outer">
    @include('frontend.includes.nav')
    <div class="breadcrumb-wrapper header-back">
        <div class="overlay"></div>
        <div class="container context-dark section-30 section-xl-top-120">
            <h1 class="text-ubold">About</h1>
        </div>
    </div>
</section>

<section class="section-80 section-lg-120">
    <div class="container container-wide text-xl-left">
        <div class="row row-50 justify-content-xl-between">
            <div class="col-xl-6 order-xl-1">
                <div class="img-wrap">
                    <img class="img-responsive center-block" src="images/background-08.jpg" alt="">
                </div>
            </div>
            <div class="col-xl-6">
                <h2 class="text-ubold">A Few Words About Us</h2>
                <hr class="divider divider-lg-left divider-primary divider-80">
                <p class="big text-base">Jumlax is the world’s first inspirational travel search service that focuses on what’s really important: your Interests and your Budget!</p>
                <p>How practical is an amazing weekend break for skiing if what you really look forward is relaxing on a sandy beach?
                    How good a great destination can be, if it’s too expensive to get there? Jumlax offers an innovative and useful online experience, 
                    so you can find your perfect destination in just a couple of clicks!</p>
            </div>
        </div>
    </div>
</section>

<section class="section-80 section-xl-120 bg-image-01 context-dark about-founder-outer">
    <div class="container container-wide">
        <div class="row">
            <div class="col-lg-7 col-xxl-5 col-lg-preffix-4 col-xxl-preffix-5">
                <blockquote class="quote">
                    <p>
                        <q>Jumlax was designed to help people discover new places, get to know new people, and just to enjoy traveling. 
                            Our booking system helps modern travelers easily book new tickets without any unnecessary queues and waiting. 
                            You just need to make a couple of clicks and you’re ready to go!</q>
                    </p>
                    <p>
                        <cite class="text-gray">John Smith, founder</cite>
                    </p>
                </blockquote>
            </div>
        </div>
    </div>
</section>

<section class="section-80 section-lg-120 bg-gray-lighter about-testi-outer">
    <div class="container container-wide">
        <h2 class="text-ubold">Testimonials</h2>
        <hr class="divider divider-primary divider-80">

        <div class="owl-carousel owl-theme">
            <div class="item">
                <blockquote class="quote-boxed">
                    <p>
                        <q>Thank you for making it so easy. I really love the way I can view the itinerary and put payment info on the same page!</q>
                    </p>
                    <div class="unit unit-spacing-xs flex-row align-items-center">
                        <div class="unit-left"><img class="img-circle img-responsive center-block" src="https://livedemo00.template-help.com/wt_61270/images/user-02.jpg" width="70" height="70" alt=""></div>
                        <div class="unit-body">
                            <div class="text-base text-bold">Steven Butler</div>
                            <div class="text-gray text-italic">regular customer</div>
                        </div>
                    </div>
                </blockquote>
            </div>
            <div class="item">
                <blockquote class="quote-boxed">
                    <p>
                        <q>I am so impressed that you would do such a thing as lower my ticket price when the fare dropped, even when I've already paid for it.</q>
                    </p>
                    <div class="unit unit-spacing-xs flex-row align-items-center">
                        <div class="unit-left"><img class="img-circle img-responsive center-block" src="https://livedemo00.template-help.com/wt_61270/images/user-02.jpg" width="70" height="70" alt=""></div>
                        <div class="unit-body">
                            <div class="text-base text-bold">Amber Barnett</div>
                            <div class="text-gray text-italic">regular customer</div>
                        </div>
                    </div>
                </blockquote>
            </div>
            <div class="item">
                <blockquote class="quote-boxed">
                    <p>
                        <q>I found your web site very easy to use. The entire process was very quick, and the price of my ticket was very affordable.</q>
                    </p>
                    <div class="unit unit-spacing-xs flex-row align-items-center">
                        <div class="unit-left"><img class="img-circle img-responsive center-block" src="https://livedemo00.template-help.com/wt_61270/images/user-02.jpg" width="70" height="70" alt=""></div>
                        <div class="unit-body">
                            <div class="text-base text-bold">Crystal Moreno</div>
                            <div class="text-gray text-italic">regular customer</div>
                        </div>
                    </div>
                </blockquote>
            </div>
            <div class="item">
                <blockquote class="quote-boxed">
                    <p>
                        <q>Thank you for making it so easy. I really love the way I can view the itinerary and put payment info on the same page!</q>
                    </p>
                    <div class="unit unit-spacing-xs flex-row align-items-center">
                        <div class="unit-left"><img class="img-circle img-responsive center-block" src="https://livedemo00.template-help.com/wt_61270/images/user-02.jpg" width="70" height="70" alt=""></div>
                        <div class="unit-body">
                            <div class="text-base text-bold">Steven Butler</div>
                            <div class="text-gray text-italic">regular customer</div>
                        </div>
                    </div>
                </blockquote>
            </div>
            <div class="item">
                <blockquote class="quote-boxed">
                    <p>
                        <q>I am so impressed that you would do such a thing as lower my ticket price when the fare dropped, even when I've already paid for it.</q>
                    </p>
                    <div class="unit unit-spacing-xs flex-row align-items-center">
                        <div class="unit-left"><img class="img-circle img-responsive center-block" src="https://livedemo00.template-help.com/wt_61270/images/user-02.jpg" width="70" height="70" alt=""></div>
                        <div class="unit-body">
                            <div class="text-base text-bold">Amber Barnett</div>
                            <div class="text-gray text-italic">regular customer</div>
                        </div>
                    </div>
                </blockquote>
            </div>
        </div>

    </div>
</section>
@endsection

@push('after-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
@if(config('access.captcha.contact'))
@captchaScripts
@endif
<script type="text/javascript">
//    $('.about-testi-outer .owl-carousel').owlCarousel({
////        loop: true,
//        margin: 0,
//        nav: true,
//        items: 3,
//        responsive: {
//            0: {
//                items: 1
//            },
//            600: {
//                items: 3
//            },
//            1000: {
//                items: 3
//            }
//        }
//    });
</script>
@endpush