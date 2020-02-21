@extends('backend.layouts.app')

@section('title', app_name() . ' | Charter Details')

@section('breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="card-title mb-0">
                    {{ __('Charter Details') }} 
                </h4>
            </div>
            <!--col-->
            <!--col-->
        </div>
        <!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table id="basic-table" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Airline Name</th>
                                <th>Airline Logo</th>
                                <th>Airline Code</th>
                                <th>Country</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($charter_details) > 0)
                            @foreach($charter_details as $cDetails)
                            <tr>
                                <td> {{ $cDetails->name }} </td>
                                <td>  
                                    <?php if(!empty($cDetails->logo)){ ?>
                                    <img src="{{URL::asset('/charter_logos/'.$cDetails->logo)}}" alt="" class="charter_logo" />
                                    <?php } ?>
                                </td>
                                <td> {{ $cDetails->code }} </td>
                                <td> {{ $cDetails->country }} </td>
                                <td> 
                                    <a href="{{ route('admin.edit-charter-details', $cDetails->id) }}" class="btn btn-success ml-1" data-toggle="tooltip" title="Edit">
                                        Edit
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
    #basic-table_filter {
        float: right;
    }
    #basic-table_paginate {
        float: right;
    }
    .charter_logo{
        height: 30px;
        display: block;
    }
</style>

@push('scripts')
<script>
    $(document).ready(function () {
        $('#basic-table').DataTable();
    });
</script>
@endpush