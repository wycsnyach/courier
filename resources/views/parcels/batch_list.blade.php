@extends('layouts.inspinia')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2 class="font-bold text-success" style="color:#1AB394;">Dispatched Batches</h2>
        <ol class="breadcrumb">
            <li><a href="{{ url('/home') }}">Home</a></li>
            <li><a>Dispatched</a></li>
            <li class="active"><strong>Dispatched Batches</strong></li>
        </ol>
        @include('includes.dispatches_header')
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title d-flex flex-wrap justify-content-between align-items-center p-3 bg-light"
             style="gap: 10px; border-bottom: 1px solid #e7eaec;">
             <div class="row col-lg-12">
                <div class="col-lg-10">
            <h3 class="mb-0 font-weight-bold text-muted">
                <i class="fa fa-truck text-success mr-2"></i> Dispatched Batches
            </h3>
            </div>
            <div class="col-lg-2">

            <div class="d-flex flex-wrap align-items-center" style="gap: 10px;">
                <form method="GET" action="{{ route('parcels.batchList') }}" class="form-inline">
                    <label for="filter" class="mr-2 mb-0 text-muted font-weight-semibold">Filter:</label>
                    <select name="filter" id="filter" class="form-control form-control-sm" style="min-width: 120px;"
                            onchange="this.form.submit()">
                        <option value="today" {{ $filter == 'today' ? 'selected' : '' }}>Today</option>
                        <option value="week" {{ $filter == 'week' ? 'selected' : '' }}>This Week</option>
                        <option value="month" {{ $filter == 'month' ? 'selected' : '' }}>This Month</option>
                        <option value="year" {{ $filter == 'year' ? 'selected' : '' }}>This Year</option>
                    </select>
                </form>

                
            </div>
        </div>
    </div>
            <a href="{{ route('parcels.batchDispatch') }}" class="btn btn-primary btn-xs shadow-sm">
                    <i class="fa fa-plus"></i> New Batch Dispatch
                </a>
        </div>

        <div class="ibox-content">
            @if($batches->isEmpty())
                <div class="alert alert-info text-center m-0">
                    <i class="fa fa-info-circle"></i> No batches have been dispatched yet.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover align-middle mb-0">
                        <thead class="thead-light bg-light">
                            <tr>
                                <th>Batch #</th>
                                <th>Dispatched By</th>
                                <th>Dispatched At</th>
                                <th>Total Parcels</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($batches as $batch)
                                <tr>
                                    <td><strong>{{ $batch->batch_number }}</strong></td>
                                    <td>{{ $batch->dispatched_by }}</td>
                                    <td>{{ $batch->dispatched_at ? \Carbon\Carbon::parse($batch->dispatched_at)->format('d M Y, h:i A') : 'N/A' }}</td>
                                    <td>{{ $batch->parcels_count }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('parcels.batchDetails', $batch->id) }}"
                                           class="btn btn-info btn-xs">
                                            <i class="fa fa-eye"></i> View Details
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
            @endif
        </div>
    </div>
</div>

{{-- Optional pagination styling to match Inspinia green --}}
<style>
.pagination .page-item.active .page-link {
    background-color: #1AB394;
    border-color: #1AB394;
    color: #fff;
}
.pagination .page-link {
    color: #1AB394;
}
.pagination .page-link:hover {
    background-color: #1AB394;
    color: #fff;
}
</style>

@endsection
