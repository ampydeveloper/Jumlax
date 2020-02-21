@extends('backend.layouts.app')

@section('title', app_name() . ' | Charter Plane Management')

@section('breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    {{ __('Charter Plane Management') }}
                </h4>
            </div>
            <!--col-->

            <div class="col-sm-7">
                <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                    <a href="{{ route('admin.charter-plane-add') }}" class="btn btn-success ml-1" data-toggle="tooltip" title="Add Charter Plane">
                        Add Charter Plane</i>
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
                                <th>Seats</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($charter_planes as $planes)
                            <tr>
                                <td> {{ $planes->name }} </td>
                                <td> {{ $planes->plane_number }} </td>
                                <td> {{ $planes->seats }} </td>
                                <td> 
                                    <a href="{{ route('admin.charter-plane-edit', $planes->id) }}" class="btn btn-success ml-1" data-toggle="tooltip" title="Edit">
                                        Edit
                                    </a>
                                    <a href="{{ route('admin.charter-plane-delete', $planes->id) }}" class="btn btn-success ml-1" data-toggle="tooltip" title="Delete">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                            @endforeach
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
    $(document).ready(function() {
        // alrt()
        $('#example').DataTable();
    });
</script>
<!-- @endsection -->
<!-- <script src="custom/js/required/by/child"></script> -->
@endpush