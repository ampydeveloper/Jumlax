@extends('backend.layouts.app')

@section('title', app_name() . ' | Edit Charter Details')

@section('breadcrumb-links')
@endsection

@section('content')
<style type="text/css">
    .charter_logo{
        width: 150px;
        display: block;
        margin-top: 15px;
    }
</style>
<div class="card">
    <div class="card-body"> 
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    {{ __('Edit Charter Details') }}
                </h4>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col">
                {{ html()->modelForm($charter_details, 'PATCH', route('admin.update-charter-details', $charter_details->id))->class('form-horizontal')->attribute('enctype', 'multipart/form-data')->open() }}
                <div class="form-group row">
                    {{ html()->label(__('Company Name'))->class('col-md-2 form-control-label')->for('Company Name') }}
                    <div class="col-md-10">
                        {{ html()->text('name')
                                    ->class('form-control')
                                    ->placeholder(__('Enter Company Name'))
                                    ->attribute('maxlength', 191)
                                    ->required()
                                    ->autofocus() }}
                    </div><!--col-->
                </div><!--form-group-->
                <div class="form-group row">
                    {{ html()->label(__('Company Logo'))->class('col-md-2 form-control-label')->for('Company Logo') }}

                    <div class="col-md-10">
                        {{ html()->file('logo')
                                    ->autofocus() }}
                        <img src="{{URL::asset('/charter_logos/'.$charter_details->logo)}}" alt="" class="charter_logo" />
                    </div><!--col-->
                </div><!--form-group-->
                <div class="form-group row">
                    {{ html()->label(__('Airline Code'))->class('col-md-2 form-control-label')->for('Airline Code') }}

                    <div class="col-md-10">
                        {{ html()->text('code')
                                    ->class('form-control')
                                    ->placeholder(__('Enter Airline Code'))
                                    ->attribute('maxlength', 191)
                                    ->required()
                                    ->autofocus() }}
                    </div><!--col-->
                </div><!--form-group-->
                <div class="form-group row">
                    {{ html()->label(__('Country'))->class('col-md-2 form-control-label')->for('Country') }}

                    <div class="col-md-10">
                        {{ html()->text('country')
                                    ->class('form-control')
                                    ->placeholder(__('Enter Country'))
                                    ->attribute('maxlength', 191)
                                    ->required()
                                    ->autofocus() }}
                    </div><!--col-->
                </div><!--form-group-->

                <div class="form-group row">
                    <div class="col-md-2">
                        <a href="{{url('/admin/charter-details')}}" class="btn btn-info">Back</a>
                    </div><!--col--> 
                    <div class="col-md-1">
                        <input type="submit" value="Update" class="btn btn-info">
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
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script> 

<script type="text/javascript" src="{{ asset('js/jquery.datetimepicker.js') }}"></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>-->
<script>
$(document).ready(function () {

    $("#arriving-time").datetimepicker({
        formart: 'Y-m-d H:i:s',
        minDate: new Date()
    });

    $("#departure-time").datetimepicker({
        formart: 'Y-m-d H:i:s',
        minDate: new Date()
    });

});
</script>
@endsection 