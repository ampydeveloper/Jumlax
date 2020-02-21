@extends('frontend.layouts.app')

@section('nav')
@include('frontend.includes.nav')
@endsection

@section('title', app_name() . ' | Reset Password')

@section('content')
<section class="section-80 section-lg-120 solid-outer">
    <div class="container">
        <div class="row row-offset-2 justify-content-sm-center">
            <div class="col-md-8 col-lg-6 col-xl-4">
                <div class="main-title">
                    <h2 class="text-ubold">Reset Password</h2>
                    <hr class="divider divider-primary divider-80">
                </div>

                @include('includes.partials.messages')
                <form class="text-left" method="post" action="{{route('frontend.auth.password.email.post')}}">
                    {!! csrf_field() !!}
                    <div class="form-wrap">
                        {{ html()->label(__('validation.attributes.frontend.email'))->for('email') }}

                        {{ html()->email('email')
             ->class('form-input')
             ->attribute('maxlength', 191)
             ->required() }}
                    </div> 
                    <div class="form-wrap">
                        <button class="button button-primary button-block button-sm" type="submit">Send password reset link</button>
                    </div> 
                </form>
            </div>
        </div>
    </div>
</section>
@endsection