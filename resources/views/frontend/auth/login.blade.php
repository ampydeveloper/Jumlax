@extends('frontend.layouts.app')

@section('nav')
@include('frontend.includes.nav')
@endsection

@section('title', app_name() . ' | Login')

@section('content')
<section class="section-80 section-lg-120 solid-outer">
    <div class="container">
        <div class="row row-offset-2 justify-content-sm-center">
            <div class="col-md-8 col-lg-6 col-xl-4">
                <div class="main-title">
                    <h2 class="text-ubold">Login</h2>
                    <hr class="divider divider-primary divider-80">
                </div>

                {{ html()->form('POST', route('frontend.auth.login.post'))->open() }}
                @include('includes.partials.messages')

                <div class="form-wrap">
                    {{ html()->label(__('validation.attributes.frontend.email'))->for('email') }}

                    {{ html()->email('email')
                    ->class('form-input')
                    ->attribute('maxlength', 191)
                    ->required() }}
                </div>
                <div class="form-wrap">
                    {{ html()->label(__('validation.attributes.frontend.password'))->for('password') }}
                    {{ html()->password('password')
                        ->class('form-input')
                        ->required() }}
                </div>
                <div class="form-wrap forgot-link">
                    <a href="{{ route('frontend.auth.password.reset') }}">@lang('labels.frontend.passwords.forgot_password')</a>
                </div><!--form-group-->

                <input type="submit" class="button button-primary button-block button-sm" value="login" >
                <br>
                Don't have a account ? <a href="/register">signup here</a>

                {{ html()->form()->close() }}
            </div>
        </div>
    </div>
</section>
@endsection

@push('after-scripts')
@if(config('access.captcha.registration'))
@captchaScripts
@endif
@endpush



