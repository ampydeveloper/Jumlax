@extends('backend.layouts.app')

@section('title', app_name() . ' | All Booking')

@section('breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="card-title mb-0">
                    {{ __('All Booking') }} 
                </h4>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table id="basic-table" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Booking ID</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Passengers Count</th>
                                <th>Payment</th>
                                <th>Grand Total</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
//                            dd($charter_bookings);
                            ?>
                            @if(count($charter_bookings) > 0)
                            @foreach($charter_bookings as $all_charters)
                            @foreach($all_charters['all_planes'] as $all_plane)
                            @foreach($all_plane['flight_details'][0]['booking_details'] as $booking_details)
                            <tr>
                            <?php $passengers_count = count($booking_details['passengers']) + 1; ?>
                                <td> {{ $booking_details['booking_reference'] }} </td>
                                <td> {{ $booking_details['from'] }} </td>
                                <td> {{ $booking_details['to'] }} </td>
                                <td> {{ $passengers_count }} </td>
                                <td> {{ $booking_details['payment_method'] }} </td>
                                <td> LD {{ $booking_details['price'] }} </td>
                                <td> 
                                    <a href="{{ route('admin.charter-booking-details', $booking_details['id']) }}" class="btn btn-success ml-1" data-toggle="tooltip" title="View">
                                        View
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            @endforeach
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

@push('after-scripts')
<script>
    $(document).ready(function () {
        $('#basic-table').DataTable();
    });
</script>
@endpush