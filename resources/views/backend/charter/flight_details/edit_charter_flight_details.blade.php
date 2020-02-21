@extends('backend.layouts.app')

@section('title', app_name() . ' | Edit Charter Flight Details')

@section('breadcrumb-links')
@endsection

@push('after-styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css" integrity="sha256-bLNUHzSMEvxBhoysBE7EXYlIrmo7+n7F4oJra1IgOaM=" crossorigin="anonymous" />
@endpush

@section('content')
<div class="card">
    <div class="card-body"> 
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    {{ __('Edit Charter Flight Details') }}
                </h4>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col">
                {{ html()->modelForm($charter_planes_details, 'PATCH', route('admin.flight-details-update', $charter_planes_details->id))->class('form-horizontal')->open() }}

                <div class="form-group row">
                    {{ html()->label(__('Select Plane'))->class('col-md-2 form-control-label')->for('name') }}

                    <div class="col-md-10">
                        <select class="form-control" name="plane_id" required>
                            <option value="0">Select Plane</option>
                            @foreach($charter_planes as $plane)
                            <option value="<?php echo $plane->id; ?>" <?php echo ($charter_planes_details['planes']->id == $plane->id) ? 'selected' : ''; ?>>
                                <?php echo $plane->name; ?>
                            </option>
                            @endforeach
                        </select>
                    </div><!--col-->
                </div><!--form-group-->
                <div class="form-group row">
                    {{ html()->label(__('From'))->class('col-md-2 form-control-label')->for('location') }}

                    <div class="col-md-10">
                        {{ html()->text('from')
                                    ->class('form-control')
                                    ->placeholder(__('Enter From'))
                                    ->attribute('maxlength', 191)
                                    ->required()
                                    ->autofocus() }}
                    </div><!--col-->
                </div><!--form-group-->

                <div class="form-group row">
                    {{ html()->label(__('To'))->class('col-md-2 form-control-label')->for('destination') }}

                    <div class="col-md-10">
                        {{ html()->text('to')
                                    ->class('form-control')
                                    ->placeholder(__('Enter To'))
                                    ->attribute('maxlength', 191)
                                    ->required()
                                    ->autofocus() }}
                    </div><!--col-->
                </div><!--form-group-->
                <div class="form-group row">
                    {{ html()->label(__('Departure Time'))->class('col-md-2 form-control-label')->for('departure_time') }}

                    <div class="col-md-5">
                        {{ html()->text('departure_date')
                                    ->class('form-control')
                            ->id('departure-date')
                                    ->placeholder(__('Departure Date'))
                                    ->attribute('maxlength', 191)
                            ->value(date('d M Y',strtotime($charter_planes_details->departure_time)))
                                    ->required()
                            ->readonly()
                                    ->autofocus() }}
                    </div><!--col-->
                    <div class="col-md-5">
                        {{ html()->text('departure_time')
                                    ->class('form-control')
                            ->id('departure-time')
                                    ->placeholder(__('08:00'))
                                    ->attribute('maxlength', 191)
                            ->value(date('h:i',strtotime($charter_planes_details->departure_time)))
                                    ->required()
                                    ->autofocus() }}
                    </div><!--col-->
                </div><!--form-group-->

                <div class="form-group row">
                    {{ html()->label(__('Arriving Time'))->class('col-md-2 form-control-label')->for('arriving_time') }}

                    <div class="col-md-5">
                        {{ html()->text('arriving_date')
                                    ->class('form-control')
                             ->id('arriving-date')
                                    ->placeholder(__('Arriving Date'))
                                    ->attribute('maxlength', 191)
                                    ->required()
                            ->value(date('d M Y',strtotime($charter_planes_details->arriving_time)))
                            ->readonly()
                                    ->autofocus() }}
                    </div><!--col-->
                    <div class="col-md-5">
                        {{ html()->text('arriving_time')
                                    ->class('form-control')
                             ->id('arriving-time')
                                    ->placeholder(__('08:00'))
                                    ->attribute('maxlength', 191)
                                    ->required()
                            ->value(date('h:i',strtotime($charter_planes_details->arriving_time)))
                                    ->autofocus() }}
                    </div><!--col-->
                </div><!--form-group-->

                <h5 class="card-title">
                    Fare/Class
                </h5>
                <div class="form-group row">
                    {{ html()->label(__('Economy'))->class('col-md-2 form-control-label')->for('Economy') }}

                    <div class="col-md-5">
                        {{ html()->text('economy_seat')
                                    ->class('form-control')
                                    ->placeholder(__('Seat'))
                                    ->attribute('maxlength', 191)
                                    ->required()
                                    ->autofocus() }}
                    </div><!--col-->
                    <div class="col-md-5">
                        {{ html()->text('economy_price')
                                    ->class('form-control')
                                    ->placeholder(__('Price'))
                                    ->attribute('maxlength', 191)
                                    ->required()
                                    ->autofocus() }}
                    </div><!--col-->
                </div><!--form-group-->
                <div class="form-group row">
                    {{ html()->label(__('Premium'))->class('col-md-2 form-control-label')->for('Premium') }}

                    <div class="col-md-5">
                        {{ html()->text('premium_seat')
                                    ->class('form-control')
                                    ->placeholder(__('Seat'))
                                    ->attribute('maxlength', 191)
                                    ->required()
                                    ->autofocus() }}
                    </div><!--col-->
                    <div class="col-md-5">
                        {{ html()->text('premium_price')
                                    ->class('form-control')
                                    ->placeholder(__('Price'))
                                    ->attribute('maxlength', 191)
                                    ->required()
                                    ->autofocus() }}
                    </div><!--col-->
                </div><!--form-group-->
                <div class="form-group row">
                    {{ html()->label(__('Business'))->class('col-md-2 form-control-label')->for('Business') }}

                    <div class="col-md-5">
                        {{ html()->text('business_seat')
                                    ->class('form-control')
                                    ->placeholder(__('Seat'))
                                    ->attribute('maxlength', 191)
                                    ->required()
                                    ->autofocus() }}
                    </div><!--col-->
                    <div class="col-md-5">
                        {{ html()->text('business_price')
                                    ->class('form-control')
                                    ->placeholder(__('Price'))
                                    ->attribute('maxlength', 191)
                                    ->required()
                                    ->autofocus() }}
                    </div><!--col-->
                </div><!--form-group-->
                <div class="form-group row">
                    {{ html()->label(__('First'))->class('col-md-2 form-control-label')->for('First') }}

                    <div class="col-md-5">
                        {{ html()->text('first_seat')
                                    ->class('form-control')
                                    ->placeholder(__('Seat'))
                                    ->attribute('maxlength', 191)
                                    ->required()
                                    ->autofocus() }}
                    </div><!--col-->
                    <div class="col-md-5">
                        {{ html()->text('first_price')
                                    ->class('form-control')
                                    ->placeholder(__('Price'))
                                    ->attribute('maxlength', 191)
                                    ->required()
                                    ->autofocus() }}
                    </div><!--col-->
                </div><!--form-group-->

                <h5 class="card-title">
                    Airport Details
                </h5>
                <div class="form-group row">
                    {{ html()->label(__('Airport Name'))->class('col-md-2 form-control-label')->for('airport_name') }}

                    <div class="col-md-10">
                        {{ html()->text('airport_name')
                                    ->class('form-control')
                                    ->placeholder(__('Airport Name'))
                                    ->attribute('maxlength', 191)
                                    ->required()
                                    ->autofocus() }}
                    </div><!--col-->
                </div><!--form-group-->
                <div class="form-group row">
                    {{ html()->label(__('Airport Code'))->class('col-md-2 form-control-label')->for('airport_code') }}

                    <div class="col-md-10">
                        {{ html()->text('airport_code')
                                    ->class('form-control')
                                    ->placeholder(__('Airport Code'))
                                    ->attribute('maxlength', 191)
                                    ->required()
                                    ->autofocus() }}
                    </div><!--col-->
                </div><!--form-group-->
                <div class="form-group row">
                    {{ html()->label(__('City'))->class('col-md-2 form-control-label')->for('city_name') }}

                    <div class="col-md-10">
                        {{ html()->text('city_name')
                                    ->class('form-control')
                                    ->placeholder(__('City'))
                                    ->attribute('maxlength', 191)
                                    ->required()
                                    ->autofocus() }}
                    </div><!--col-->
                </div><!--form-group-->
                <div class="form-group row">
                    {{ html()->label(__('Country'))->class('col-md-2 form-control-label')->for('country_name') }}

                    <div class="col-md-10">
                        {{ html()->text('country_name')
                                    ->class('form-control')
                                    ->placeholder(__('Country'))
                                    ->attribute('maxlength', 191)
                                    ->required()
                                    ->autofocus() }}
                    </div><!--col-->
                </div><!--form-group-->

                <div class="form-group row">
                    <div class="col-md-2">
                        <a href="{{url('/admin/flight-details')}}" class="btn btn-info">Back</a>
                    </div><!--col--> 
                    <div class="col-md-1">
                        <input type="submit" value="Save" class="btn btn-info">
                    </div><!--col-->
                </div><!--form-group-->

                {{ html()->closeModelForm() }}
            </div>
            <!--col-->
        </div>
        <!--row-->
    </div>
    <!--row-->
</div>
<!--card-body-->
</div>
<!--card-->
@endsection

@push('after-scripts')
@push('after-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha256-bqVeqGdJ7h/lYPq6xrPv/YGzMEb6dNxlfiTUHSgRCp8=" crossorigin="anonymous"></script>
<script>
$(document).ready(function () {
    var date = new Date();
    date.setDate(date.getDate());
    $('#departure-date').datepicker({
        format: 'dd M yyyy',
        startDate: date,
    });
    $('#departure-date').on('changeDate', function () {
        departureDate = new Date($('#departure-date').val());
        $('#arriving-date').datepicker('destroy');
        $('#arriving-date').datepicker({
            format: 'dd M yyyy',
            startDate: departureDate
        });
    });

    $('#arriving-date').datepicker({
        format: 'dd M yyyy',
        startDate: date,
    });
});
</script>
@endpush