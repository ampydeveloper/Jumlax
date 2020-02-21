@extends('frontend.layouts.app')

@section('nav')
@include('frontend.includes.nav')
@endsection

@section('title', app_name() . ' | My Account')

@section('content')
<section class="container-fluid section-lg-120 gray-back">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-3">
                <div class="white-box profile-image-box">
                    <?php if ($logged_in_user->avatar_location != null) { ?>
                        <img src="{{URL::asset('/storage/'.$logged_in_user->avatar_location)}}" class="user-profile-image" />
                    <?php } else { ?>
                        <img src="{{URL::asset('/images/sample-profile.png')}}" class="user-profile-image" />
                    <?php } ?>
                    <?php
                    if (Auth::user()->roles[0]->name == 'executive') {
                        ?>
                        <p class="text-small-full">{{ $logged_in_user->organization_name }}</p>
                        <p class="text-grey">Retailer Profile</p>
                    <?php } else { ?>
                        <p class="text-small-full">{{ $logged_in_user->name }}</p>
                        <p class="text-grey">Personal Profile</p>
                    <?php } ?>
                </div>
            </div>

            <div class="col-sm-12 col-md-9">
                <div class="white-box profile-details-box" id="no-more-tables">
                    <h3>Profile
                        <a href="#" class="btn btn-line-blue"><i class="fas fa-edit"></i> Edit</a>
                    </h3>
                    <h4>Basic info, for a faster booking experience</h4>
                    <table class="table">
                        <?php
                        if (Auth::user()->roles[0]->name == 'executive') {
                            ?>
                            <tr>
                                <th>Retailer Name</th>
                                <td>{{ $logged_in_user->organization_name }}</td>
                            </tr>
                            <tr>
                                <th>Retailer Representative Name </th>
                                <td>{{ $logged_in_user->representative_name }}</td>
                            </tr>
                            <tr>
                                <th>@lang('labels.frontend.user.profile.email')</th>
                                <td>{{ $logged_in_user->email }}</td>
                            </tr>
                        <?php } else { ?>
                            <tr>
                                <th>@lang('labels.frontend.user.profile.name')</th>
                                <td>{{ $logged_in_user->name }}</td>
                            </tr>
                            <tr>
                                <th>@lang('labels.frontend.user.profile.email')</th>
                                <td>{{ $logged_in_user->email }}</td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th>Password</th>
                            <td>******  
                                <a href="#" class="change-pass"> Change Password?</a>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="white-box profile-update-box solid-outer">
                    {{ html()->modelForm($logged_in_user, 'POST', route('frontend.user.profile.update'))->class('form-horizontal')->attribute('enctype', 'multipart/form-data')->open() }}
                    @method('PATCH')

                    <h3>Edit Profile Details
                        <a href="#" class="btn btn-line-blue btn-back"><i class="fas fa-chevron-left"></i> Back</a>
                    </h3>
                    <div class="form-wrap">
                        {{ html()->label(__('validation.attributes.frontend.avatar'))->class('form-label-outside')->for('avatar') }}

                        <div>
                            <div class="form-wrap radio-inline-wrapper">
                                <label class="radio-inline">
                                    <input name="avatar_type" value="gravatar" type="radio" {{ $logged_in_user->avatar_type == 'gravatar' ? 'checked' : '' }} class="radio-custom">
                                    Gravatar
                                </label>
                                <label class="radio-inline">
                                    <input name="avatar_type" value="storage" type="radio" {{ $logged_in_user->avatar_type == 'storage' ? 'checked' : '' }} class="radio-custom">
                                    Upload
                                </label>
                            </div>

                            @foreach($logged_in_user->providers as $provider)
                            @if(strlen($provider->avatar))
                            <input type="radio" name="avatar_type" value="{{ $provider->provider }}" {{ $logged_in_user->avatar_type == $provider->provider ? 'checked' : '' }} /> {{ ucfirst($provider->provider) }}
                            @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="form-wrap hidden" id="avatar_location">
                        {{ html()->file('avatar_location')->class('') }}
                    </div>

                    <?php
                    if (Auth::user()->roles[0]->name == 'executive') {
                        ?>
                        <div class="form-wrap">
                            {{ html()->label('Retailer Name')->class('form-label-outside')->for('organization_name') }}
                            <input type="text" value="{{ $logged_in_user->organization_name }}" class="form-input" name="organization_name">
                        </div>

                        <div class="form-wrap">
                            {{ html()->label('Retailer Representative Name')->class('form-label-outside')->for('representative_name') }}
                            <input type="text" value="{{ $logged_in_user->representative_name }}" class="form-input" name="representative_name">
                        </div>      
                    <?php } else { ?>
                        <div class="form-wrap">
                            {{ html()->label(__('validation.attributes.frontend.first_name'))->class('form-label-outside')->for('first_name') }}
                            <input type="text" value="{{ $logged_in_user->first_name }}" class="form-input" name="first_name">
                        </div>

                        <div class="form-wrap">
                            {{ html()->label(__('validation.attributes.frontend.last_name'))->class('form-label-outside')->for('last_name') }}
                            <input type="text" value="{{ $logged_in_user->last_name }}" class="form-input" name="last_name">
                        </div>
                    <?php } ?>
                    @if ($logged_in_user->canChangeEmail())
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> @lang('strings.frontend.user.change_email_notice')
                    </div>

                    <div class="form-wrap">
                        {{ html()->label(__('validation.attributes.frontend.email'))->class('form-label-outside')->for('email') }}

                        {{ html()->email('email')
                        ->class('form-input')
                        ->placeholder(__('validation.attributes.frontend.email'))
                        ->attribute('maxlength', 191)
                        ->required() }}
                    </div>
                    @endif

                    <div class="form-wrap">
                        <button class="button button-primary button-sm" type="submit">Update</button>
                    </div>

                    {{ html()->closeModelForm() }}
                </div>

                <div class="white-box change-pass-box solid-outer">
                    <div class="alert password-error"></div>
                    <h3>Change Password
                        <a href="#" class="btn btn-line-blue btn-back"><i class="fas fa-chevron-left"></i> Back</a>
                    </h3>
                    <!--{{ html()->form('post', route('frontend.auth.update'))->class('form-horizontal')->open() }}-->
                    <form method="post" class="form-horizontal"  id="password">
                        <div class="form-wrap">
                            {{ html()->label(__('validation.attributes.frontend.old_password'))->class('form-label-outside')->for('old_password') }}

                            {{ html()->password('old_password')
                    ->class('form-input old-password')
                    ->placeholder(__('validation.attributes.frontend.old_password'))
                    ->autofocus()
                    ->required() }}
                        </div>

                        <div class="form-wrap">
                            {{ html()->label(__('validation.attributes.frontend.password'))->class('form-label-outside')->for('password') }}

                            {{ html()->password('password')
                    ->class('form-input new-password')
                    ->placeholder(__('validation.attributes.frontend.password'))
                    ->required() }}
                        </div>

                        <div class="form-wrap">
                            {{ html()->label(__('validation.attributes.frontend.password_confirmation'))->class('form-label-outside')->for('password_confirmation') }}

                            {{ html()->password('password_confirmation')
                    ->class('form-input confirm-password')
                    ->placeholder(__('validation.attributes.frontend.password_confirmation'))
                    ->required() }}
                        </div>

                        <div class="form-wrap">
                            <button class="button button-primary button-sm" id="pass-update">Update Password</button>
                        </div>
                    </form>
                    <!--{{ html()->form()->close() }}-->
                </div>
            </div>
        </div>
    </div>

</section>
@endsection

@push('after-scripts')
<script>
    $(function () {
        var avatar_location = $("#avatar_location");

        if ($('input[name=avatar_type]:checked').val() === 'storage') {
            avatar_location.show();
        } else {
            avatar_location.hide();
        }

        $('input[name=avatar_type]').change(function () {
            if ($(this).val() === 'storage') {
                avatar_location.show();
            } else {
                avatar_location.hide();
            }
        });

        $('.profile-details-box .btn-line-blue').on('click', function (e) {
            $('.profile-update-box').show();
            $('.profile-details-box').hide();
            e.preventDefault();
        });
        $('.profile-update-box .btn-back').on('click', function (e) {
            $('.profile-update-box').hide();
            $('.profile-details-box').show();
            e.preventDefault();
        });
        $('.profile-details-box .change-pass').on('click', function (e) {
            $('.change-pass-box').show();
            $('.profile-details-box').hide();
            e.preventDefault();
        });
        $('.change-pass-box .btn-back').on('click', function (e) {
            $('.change-pass-box').hide();
            $('.profile-details-box').show();
            e.preventDefault();
        });


        //ajex for password update
        $("#pass-update").on('click', function (e) {
            e.preventDefault();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var fileds = $('#password').serialize()
            $.ajax({
                url: '/update',
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: {_token: CSRF_TOKEN, old_password: $(".old-password").val(), new_password: $(".new-password").val(), confirm_password: $(".confirm-password").val()},
                dataType: 'JSON',
                success: function (data) {
                    if (data.status) {
                        $(".password-error").text('');
                        $(".password-error").removeClass('alert-danger');
                        $(".password-error").addClass('alert-success').text(data.message);
                        setTimeout(function () {
                            location.reload();
                        }, 2000);
                    } else {
                        $(".password-error").addClass('alert-danger').text(data.message);
                    }
                }
            });
        });

    });
</script>
@endpush
