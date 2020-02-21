@extends('backend.layouts.app')

@section('title', app_name() . ' | Charter Flight Management')

@section('breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    {{ __('Charter Flight Management') }} 
                </h4>
            </div>

            <div class="col-sm-7">
                <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                    <a href="{{ route('admin.flight-details-add') }}" class="btn btn-success ml-1" data-toggle="tooltip" title="Add Charter Flight">
                        Add Charter Flight Details</i>
                    </a>
                </div>
            </div>
            <!--col-->
        </div>
        <!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Plane Name</th>
                                <th>Plane Number</th>
                                <th>From</th>
                                <th>To</th>
                                <th>departure Time</th>
                                <th>Arrival Time</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($charter_planes_details) && count($charter_planes_details) > 0)
                            @foreach($charter_planes_details as $pDetails)
                            <tr>
                                <td> {{ $pDetails->planes->name }} </td>
                                <td> {{ $pDetails->planes->plane_number }} </td>
                                <td> {{ $pDetails->from }} </td>
                                <td> {{ $pDetails->to }} </td>
                                <td> {{ $pDetails->departure_time }} </td>
                                <td> {{ $pDetails->arriving_time }} </td>
                                <td> 
                                    <a href="{{ route('admin.flight-details-edit', $pDetails->id) }}" class="btn btn-success ml-1" data-toggle="tooltip" title="Edit">
                                        Edit
                                    </a>
                                    <a href="{{ route('admin.flight-details-delete', $pDetails->id) }}" class="btn btn-success ml-1" data-toggle="tooltip" title="Delete">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
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

<style>
    #example_filter {
        float: right;
    }

    #example_paginate {
        float: right;
    }
</style>

<!-- @section('script') -->
@push('scripts')

<script>
    $(document).ready(function () {
        // alrt()
        $('#example').DataTable();
    });
</script>
<!-- @endsection -->
<!-- <script src="custom/js/required/by/child"></script> -->
@endpush