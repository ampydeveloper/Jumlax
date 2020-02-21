@extends('frontend.layouts.app')

@section('nav')
@include('frontend.includes.nav')
@endsection

@section('title', app_name() . ' | ' . __('labels.frontend.passwords.reset_password_box_title'))

@section('content')
<section class="section-80 section-lg-120 solid-outer">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col col-sm-6 align-self-center">
                <div class="main-title">
                    <h2 class="text-ubold">@lang('labels.frontend.passwords.reset_password_box_title')</h2>
                    <hr class="divider divider-primary divider-80">
                </div>


                @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif

                {{ html()->form('POST', route('frontend.auth.password.reset'))->class('form-horizontal')->open() }}
                @include('includes.partials.messages')
                {{ html()->hidden('token', $token) }}

                <div class="form-wrap">
                    {{ html()->label(__('validation.attributes.frontend.email'))->for('email') }}

                    {{ html()->email('email')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.email'))
                                        ->attribute('maxlength', 191)
                                        ->required() }}
                </div><!--form-group-->

                <div class="form-wrap">
                    {{ html()->label(__('validation.attributes.frontend.password'))->for('password') }}

                    {{ html()->password('password')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.password'))
                                        ->required() }}
                </div><!--form-group-->

                <div class="form-wrap">
                    {{ html()->label(__('validation.attributes.frontend.password_confirmation'))->for('password_confirmation') }}

                    {{ html()->password('password_confirmation')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.password_confirmation'))
                                        ->required() }}
                </div><!--form-group-->

                <div class="form-wrap">
                    <!--{{ form_submit(__('labels.frontend.passwords.reset_password_button')) }}-->
                    <button class="button button-primary button-block button-sm" type="submit">Reset Password</button>
                </div><!--form-group-->
                {{ html()->form()->close() }}
            </div>
        </div>
    </div>
</section>
@endsection