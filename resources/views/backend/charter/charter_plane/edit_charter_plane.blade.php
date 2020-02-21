@extends('backend.layouts.app')

@section('title', app_name() . ' | Edit Charter Plane Details')

@section('breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    {{ __('Edit Charter Plane Details') }}
                </h4>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col">
                {{ html()->modelForm($charter_plane_details, 'PATCH', route('admin.charter-plane-update', $charter_plane_details->id))->class('form-horizontal')->open() }}

<!--                <div class="form-group row">
                    {{ html()->label(__('Charter'))->class('col-md-2 form-control-label')->for('Charter') }}
                    <div class="col-md-10">
                        <select class="form-control" name="charter_details_id">
                            <?php 
//                            foreach ($charter_details as $details) { ?>
                                <option value="<?php // echo $details->id; ?>" <?php // echo ($charter_plane_details['CharterDetails']->id == $details->id)?'selected':''; ?>>
                                    <?php // echo $details->name; ?>
                                </option>
                                <?php
//                            }
                            ?>
                        </select>
                    </div>col
                </div>-->

                <div class="form-group row">
                    {{ html()->label(__('Plane Name'))->class('col-md-2 form-control-label')->for('name') }}

                    <div class="col-md-10">
                        {{ html()->text('name')
                                    ->class('form-control')
                                    ->placeholder(__('Enter Plane Name'))
                                    ->attribute('maxlength', 191)
                                    ->required()
                                    ->autofocus() }}
                    </div><!--col-->
                </div><!--form-group-->

                <div class="form-group row">
                    {{ html()->label(__('Plane Number'))->class('col-md-2 form-control-label')->for('plane_number') }}

                    <div class="col-md-10">
                        {{ html()->text('plane_number')
                                    ->class('form-control')
                                    ->placeholder(__('Enter Plane Number'))
                                    ->attribute('maxlength', 191)
                                    ->required()
                                    ->autofocus() }}
                    </div><!--col-->
                </div><!--form-group-->

                <div class="form-group row">
                    {{ html()->label(__('Seats'))->class('col-md-2 form-control-label')->for('seats') }}

                    <div class="col-md-10">
                        {{ html()->text('seats')
                                    ->class('form-control')
                                    ->placeholder(__('Enter Seats'))
                                    ->attribute('maxlength', 191)
                                    ->required()
                                    ->autofocus() }}
                    </div><!--col-->
                </div><!--form-group-->
                <div class="form-group row">
                    <div class="col-md-2">
                        <a href="{{url('/admin/charter-plane')}}" class="btn btn-info">Back</a>
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

@endsection