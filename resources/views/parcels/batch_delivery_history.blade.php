@extends('layouts.inspinia')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2 class="font-bold text-success" style="color:#1AB394;">Delivered Batches & History</h2>
        <ol class="breadcrumb">
            <li><a href="{{ url('/home') }}">Home</a></li>
            <li><a>Parcels</a></li>
            <li class="active"><strong>Delivery History</strong></li>
        </ol>
        @include('includes.dispatches_header')
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title bg-light">
            <h3 class="mb-0 font-weight-bold text-muted">
                <i class="fa fa-truck text-success mr-2"></i> Delivered Batches
            </h3>
        </div>
        <div class="ibox-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="thead-light bg-light">
                        <tr>
                            <th>Batch #</th>
                            <th>Dispatched By</th>
                            <th>Delivered At</th>
                            <th>Total Parcels</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($batches as $batch)
                        <tr>
                            <td>{{ $batch->batch_number }}</td>
                            <td>{{ $batch->dispatched_by }}</td>
                            <td>{{ \Carbon\Carbon::parse($batch->delivered_at)->format('d M Y, h:i A') }}</td>
                            <td>{{ $batch->parcels_count }}</td>
                            <td class="text-center">
                                <a href="{{ route('parcels.batchDetails', $batch->id) }}" class="btn btn-xs btn-info">
                                    <i class="fa fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $batches->links() }}
            </div>
        </div>
    </div>

    {{-- HISTORY LOGS --}}
    <div class="ibox mt-4">
        <div class="ibox-title bg-light">
            <h3 class="mb-0 font-weight-bold text-muted">
                <i class="fa fa-history text-success mr-2"></i> Delivery Action History
            </h3>
        </div>
        <div class="ibox-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="thead-light bg-light">
                        <tr>
                            <th>#</th>
                            <th>Batch #</th>
                            <th>Action</th>
                            <th>User</th>
                            <th>Time</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($histories as $history)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $history->batch->batch_number ?? '-' }}</td>
                            <td>{{ $history->action }}</td>
                            <td>{{ $history->user->first_name ?? '-' }} {{ $history->user->middle_name ?? '-' }} {{ $history->user->last_name ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($history->action_time)->format('d M Y, h:i A') }}</td>
                            <td>{{ $history->remarks ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $histories->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
