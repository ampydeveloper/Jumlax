@extends('frontend.layouts.app')

@section('nav')
@include('frontend.includes.nav')
@endsection

@section('title', app_name() . ' | Charter Register')

@section('content')
<section class="section-80 section-lg-120 solid-outer">
    <div class="container">
        <div class="row row-offset-2 justify-content-sm-center">
            <div class="col-md-8 col-lg-6 col-xl-4">
                <div class="main-title">
                    <h2 class="text-ubold">Charter Register</h2>
                    <hr class="divider divider-primary divider-80">
                </div>

                <form class="text-left"  method="post" action="{{ url('/register') }}">
                    {!! csrf_field() !!}

                    <input type="hidden" name="account_type" value="1"/>
                    <div class="form-wrap">
                        {{ html()->label('Charter Name')->for('charter_name') }}

                        {{ html()->text('charter_name')
                    ->class('form-input')
                    ->attribute('maxlength', 191)
                        }}
                        @if ($errors->has('charter_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('charter_name') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-wrap">
                        {{ html()->label(__('validation.attributes.frontend.first_name'))->for('first_name') }}

                        {{ html()->text('first_name')
                    ->class('form-input')
                    ->attribute('maxlength', 191)
                        }}
                        @if ($errors->has('first_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('first_name') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-wrap">
                        {{ html()->label(__('validation.attributes.frontend.last_name'))->for('last_name') }}

                        {{ html()->text('last_name')
                    ->class('form-input')
                    ->attribute('maxlength', 191)
                        }}
                        @if ($errors->has('last_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('last_name') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-wrap">
                        {{ html()->label(__('validation.attributes.frontend.email'))->for('email') }}

                        {{ html()->email('email')
                    ->class('form-input')
                    ->attribute('maxlength', 191)
                        }}
                        @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div> 

                    <div class="form-wrap">
                        {{ html()->label(__('validation.attributes.frontend.password'))->for('password') }}
                        {{ html()->password('password')
                        ->class('form-input')
                        ->required() }}
                        @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-wrap">
                        {{ html()->label(__('validation.attributes.frontend.password_confirmation'))->for('password_confirmation') }}

                        {{ html()->password('password_confirmation')
                    ->class('form-input')
                    ->required() }}
                        @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-wrap">
                        {{ html()->label('Country')->for('country') }}

                        {{ html()->text('country')
                    ->class('form-input')
                    ->attribute('maxlength', 191)
                        }}
                        @if ($errors->has('country'))
                        <span class="help-block">
                            <strong>{{ $errors->first('country') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-wrap">
                        <button class="button button-primary button-block button-sm" type="submit">Register Now</button>
                    </div>
                </form>
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

@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $('#account_type').on('select2:select', function (e) {
            var data = e.params.data;
            if (data.id == 3) {
                $('.organization_outer').hide();
                $('.customer_outer').show();
            } else {
                $('.organization_outer').show();
                $('.customer_outer').hide();
            }
            console.log(data);
        });
    });
</script>
@endpush
