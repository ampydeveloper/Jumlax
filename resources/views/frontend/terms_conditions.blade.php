@extends('frontend.layouts.app')

@section('title', app_name() . ' | Terms & Conditions')

@section('content')
<section class="bg-image-06 header-back-outer">
    @include('frontend.includes.nav')
    <div class="breadcrumb-wrapper header-back">
        <div class="overlay"></div>
        <div class="container context-dark section-30 section-xl-top-120">
            <h1 class="text-ubold">Terms & Conditions</h1>
        </div>
    </div>
</section>

<section class="section-80 section-lg-120">
    <div class="container container-wide text-xl-left">
        <div class="row row-50 justify-content-xl-between">
            <div class="col-sm-12">
                <p>You can contact us any way that is convenient for you. We are available 24/7 via fax or email. You can also use a quick contact form below or visit our office personally. We would be happy to answer your questions.</p>
            </div>
        </div>
    </div>
</section>
@endsection