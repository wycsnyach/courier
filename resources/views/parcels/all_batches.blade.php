@extends('layouts.inspinia')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2 class="font-bold text-success" style="color:#1AB394;">All Dispatched Batches</h2>
        <ol class="breadcrumb">
            <li><a href="{{ url('/home') }}">Home</a></li>
            <li><a>Dispatched</a></li>
            <li class="active"><strong>All Batches</strong></li>
        </ol>
        @include('includes.dispatches_header')
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">

    <div class="ibox">
        <div class="ibox-title d-flex flex-wrap justify-content-between align-items-center p-3 bg-light"
             style="gap: 10px; border-bottom: 1px solid #e7eaec;">

            <h3 class="mb-0 font-weight-bold text-muted">
                <i class="fa fa-archive text-success mr-2"></i> All Dispatched Batches
            </h3>

            <a href="{{ route('parcels.batchDispatch') }}" class="btn btn-primary btn-xs shadow-sm">
                <i class="fa fa-plus"></i> New Batch Dispatch
            </a>
        </div>

        <div class="ibox-content">

            {{-- Filters --}}
            <form method="GET" action="{{ route('parcels.allBatches') }}" class="mb-4">
                <div class="row align-items-end">

                    {{-- Date Range --}}
                    <div class="col-md-3 mb-2">
                        <label class="font-weight-semibold text-muted">Date Range:</label>
                        <div class="d-flex">
                            <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control form-control-sm">
                            <span class="mx-1 text-muted">to</span>
                            <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control form-control-sm">
                        </div>
                    </div>

                    {{-- Month Range --}}
                    <div class="col-md-3 mb-2">
                        <label class="font-weight-semibold text-muted">Month Range:</label>
                        <div class="d-flex">
                            <input type="month" name="start_month" value="{{ request('start_month') }}" class="form-control form-control-sm">
                            <span class="mx-1 text-muted">to</span>
                            <input type="month" name="end_month" value="{{ request('end_month') }}" class="form-control form-control-sm">
                        </div>
                    </div>

                    {{-- Batch Search --}}
                    <div class="col-md-3 mb-2">
                        <label class="font-weight-semibold text-muted">Search by Batch #:</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Enter batch number..." class="form-control form-control-sm">
                    </div>

                    {{-- Submit --}}
                    <div class="col-md-2 mb-2">
                        <button type="submit" class="btn btn-success btn-sm w-100">
                            <i class="fa fa-filter"></i> Apply Filters
                        </button>
                    </div>

                    {{-- Reset --}}
                    <div class="col-md-1 mb-2">
                        <a href="{{ route('parcels.allBatches') }}" class="btn btn-secondary btn-sm w-100">
                            <i class="fa fa-refresh"></i>
                        </a>
                    </div>
                </div>
            </form>

            {{-- Table --}}
            @if($batches->isEmpty())
                <div class="alert alert-info text-center">
                    <i class="fa fa-info-circle"></i> No batches found for the selected filters.
                </div>
            @else
                <div class="d-flex justify-content-end mb-3" style="gap: 10px;">
                    <a href="{{ route('parcels.export', ['type' => 'excel']) }}" class="btn btn-success btn-sm shadow-sm">
                        <i class="fa fa-file-excel-o"></i> Export to Excel
                    </a>
                    <a href="{{ route('parcels.export', ['type' => 'pdf']) }}" class="btn btn-danger btn-sm shadow-sm">
                        <i class="fa fa-file-pdf-o"></i> Export to PDF
                    </a>
                    <button onclick="window.print()" class="btn btn-secondary btn-sm shadow-sm">
                        <i class="fa fa-print"></i> Print
                    </button>
                </div>


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
                                    <td>
                                        {{ $batch->dispatched_at ? \Carbon\Carbon::parse($batch->dispatched_at)->format('d M Y, h:i A') : 'N/A' }}
                                    </td>
                                    <td>{{ $batch->parcels_count }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('parcels.batchDetails', $batch->id) }}" class="btn btn-info btn-xs">
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
            @endif
        </div>
    </div>
</div>

{{-- Pagination and Table Style --}}
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
label {
    font-size: 0.9rem;
}
</style>

@endsection
