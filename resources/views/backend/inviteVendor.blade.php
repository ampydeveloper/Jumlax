@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@section('content')
       <section class="section-80 section-lg-120">
        <div class="container">
          <div class="row row-offset-2 justify-content-sm-center">
            <div class="col-md-8 col-lg-6 col-xl-4">
              <!-- RD Mailform-->
              <form class="" method="post" action="{{route('admin.inviteVendor.post')}}">
                  {!! csrf_field() !!}
                  <div class="form-wrap">
                {{ html()->label(__('validation.attributes.frontend.first_name'))->for('first_name') }}

                {{ html()->text('first_name')
                    ->class('form-input')
                   
                    ->attribute('maxlength', 191)
                    ->required()}}
                </div>
                  <div class="form-wrap">
                  {{ html()->label(__('validation.attributes.frontend.last_name'))->for('last_name') }}

                {{ html()->text('last_name')
                    ->class('form-input')
                    
                    ->attribute('maxlength', 191)
                    ->required() }}
                </div>
                <div class="form-wrap">
                {{ html()->label(__('validation.attributes.frontend.email'))->for('email') }}

                {{ html()->email('email')
                    ->class('form-input')
                    ->attribute('maxlength', 191)
                    ->required() }}
                </div>
                  
                <button class="button button-primary button-block button-sm" type="submit">login</button>
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