@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.general.home'))

@section('content')
<section class="section-80 section-lg-120">
        <div class="container">
          <div class="row row-offset-2 justify-content-sm-center">
            <div class="col-md-8 col-lg-6 col-xl-4">
              <form class="" method="post" action="{{route('frontend.user.changePassword.post')}}">
                  {!! csrf_field() !!}
                <div class="form-wrap">
                    {{ html()->label(__('validation.attributes.frontend.password'))->for('password') }}
                    {{ html()->password('password')
                        ->class('form-input')
                        ->required() }}
                </div>
                <div class="form-wrap">
                 {{ html()->label(__('validation.attributes.frontend.password_confirmation'))->for('password_confirmation') }}

                {{ html()->password('password_confirmation')
                    ->class('form-input')
                    ->required() }}
                </div>
                  
                <button class="button button-primary button-block button-sm" type="submit">Submit</button>
              </form>
            </div>
          </div>
        </div>
      </section>
@endsection