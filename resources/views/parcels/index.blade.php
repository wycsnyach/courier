@extends('layouts.inspinia')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2 style="color:#1AB394;"><strong>Parcel Management</strong></h2>
        <ol class="breadcrumb">
            <li><a href="{{ url('/home') }}">Home</a></li>
            <li><a>Parcels</a></li>
            <li class="active"><strong>All Parcels</strong></li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <!-- Status Cards -->
    <div class="row m-b-md">
        @foreach ([
            'booked' => ['label' => 'Booked', 'class' => 'warning', 'icon' => 'fa-cubes'],
            'waiting' => ['label' => 'Waiting', 'class' => 'secondary', 'icon' => 'fa-hourglass-half'],
            'dispatched' => ['label' => 'Dispatched', 'class' => 'primary', 'icon' => 'fa-truck'],
            'delivered' => ['label' => 'Delivered', 'class' => 'success', 'icon' => 'fa-check-circle'],
            'received' => ['label' => 'Received', 'class' => 'info', 'icon' => 'fa-download'],
            'returned' => ['label' => 'Returned', 'class' => 'danger', 'icon' => 'fa-undo'],
        ] as $key => $data)

            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="ibox">
                    <div class="ibox-title">
                        <span class="label label-{{ $data['class'] }} pull-right">{{ $data['label'] }}</span>
                        <h5>{{ $data['label'] }}</h5>
                    </div>
                    <div class="ibox-content">
                        <h3 class="no-margins">{{ $statusCounts[$key] }}</h3>
                        <div class="stat-percent font-bold text-{{ $data['class'] }}">
                            {{ $statusCounts[$key] }} <i class="fa {{ $data['icon'] }}"></i>
                        </div>
                        <small>Total {{ $data['label'] }} Parcels</small>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Filter + Navigation -->
    <div class="ibox">
        <div class="ibox-title d-flex flex-wrap justify-content-between align-items-center p-3" style="gap: 10px;">
            <!-- Title -->
            <div class="row col-lg-12">
            <div class="col-xs-3">

                <h5>LIST OF PARCELS</h5>
            </div>
       

            <!-- Controls Wrapper -->
            <div class="d-flex flex-wrap align-items-center justify-content-end" style="gap: 10px;">
                <div class="col-xs-3">

                <!-- Filter Dropdown -->
                <form method="GET" action="{{ route('parcels.index') }}" class="filter-form">
                    <label for="filter">FILTER:</label>
                    <select name="filter" id="filter" onchange="this.form.submit()">
                        <option value="today" {{ $filter == 'today' ? 'selected' : '' }}>Today</option>
                        <option value="week" {{ $filter == 'week' ? 'selected' : '' }}>This Week</option>
                        <option value="month" {{ $filter == 'month' ? 'selected' : '' }}>This Month</option>
                        <option value="year" {{ $filter == 'year' ? 'selected' : '' }}>This Year</option>
                    </select>
                </form>

            </div>
            <div class="col-xs-3">

                <!-- Date Navigation -->
                <form method="GET" action="{{ route('parcels.index') }}" class="form-inline mb-0">
                    <input type="hidden" name="filter" value="day">
                    <div class="d-flex align-items-center" style="gap: 8px;">
                        <button type="submit" name="date" value="{{ \Carbon\Carbon::parse($date)->subDay()->toDateString() }}" class="btn btn-success btn-xs border" >
                            <i class="fa fa-chevron-left"></i> Previous
                        </button>

                        <span class="font-weight-bold text-navy text-nowrap">
                            {{ \Carbon\Carbon::parse($date)->format('F j, Y') }}
                        </span>

                        @if(\Carbon\Carbon::parse($date)->lt(today()))
                            <button type="submit" name="date" value="{{ \Carbon\Carbon::parse($date)->addDay()->toDateString() }}" class="btn btn-success btn-xs border">
                                Next <i class="fa fa-chevron-right" ></i>
                            </button>
                        @endif
                    </div>
                </form>

                </div>
                <div class="col-xs-3">
                    <a href="{{ route('parcels.create') }}" class="btn btn-primary btn-xs d-flex align-items-center">
                    <i class="fa fa-plus mr-1"></i> Add New
                </a>
            </div>

            </div>

       
        </div>
           
                
        </div>
        <p></p>


        <!-- Table Section -->
        <div class="ibox-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover parcels">
                    <thead>
                        <tr class="font-bold text-navy">
                            <th>Reference #</th>
                            <th>Sender</th>
                            <th>Recipient</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $paid = 0; @endphp
                        @foreach($parcels as $parcel)
                            <tr>
                                <td>{{ $parcel->reference_number }}</td>
                                <td>{{ $parcel->sender_name }}</td>
                                <td>{{ $parcel->recipient_name }}</td>
                                <td>{{ $parcel->fromBranch->branch_code ?? '' }}</td>
                                <td>{{ $parcel->toBranch->branch_code ?? '' }}</td>
                                <td>{{ number_format($parcel->price, 2) }}</td>
                                <td>{!! $parcel->status_badge !!}</td>
                                <td>{{ optional($parcel->created_at)->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ route('parcels.edit', $parcel->id) }}" class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a>
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['parcels.destroy', $parcel->id], 'style' => 'display:inline']) !!}
                                        <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    {!! Form::close() !!}
                                    <a href="{{ route('parcels.deliveryHistory', $parcel->id) }}" class="btn btn-xs btn-info">
    View History
</a>

                                </td>
                            </tr>
                            @php $paid += $parcel->price; @endphp
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="font-bold text-navy"><strong>Totals</strong></td>
                            <td class="font-bold text-navy">Ksh {{ number_format($paid, 2) }}</td>
                            <td colspan="3"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .filter-form {
        display: flex;
        align-items: center;
        gap: 5px;
        margin-bottom: 0;
    }
    .filter-form label {
        margin: 0;
        font-size: 13px;
        color: #6c757d;
        font-weight: 600;
    }
    .filter-form select {
        height: 28px !important;
        padding: 2px 6px !important;
        font-size: 13px !important;
        line-height: 1.2;
    }
</style>

@endsection

@section('scripts')
<script src="{{ asset('inspinia/js/plugins/dataTables/datatables.min.js') }}"></script>
<script>
$(document).ready(function() {
    $('.parcels').DataTable({
        pageLength: 10,
        responsive: true,
        lengthChange: true,
        ordering: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        language: {
            paginate: {
                previous: "<i class='fa fa-chevron-left'></i>",
                next: "<i class='fa fa-chevron-right'></i>"
            },
            lengthMenu: "Show _MENU_ entries per page",
            info: "Showing _START_ to _END_ of _TOTAL_ parcels"
        }
    });
});
</script>
@endsection
