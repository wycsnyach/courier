@extends('layouts.inspinia')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2 style="color:#1AB394;"><strong>Parcel Management</strong></h2>
        <ol class="breadcrumb">
            <li><a href="{{url('/home')}}">Home</a></li>
            <li><a>Parcels</a></li>
            <li class="active"><strong>All Parcels</strong></li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">

<div class="row m-b-md">

    <!-- Ordered -->
    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
        <div class="ibox">
            <div class="ibox-title">
                <span class="label label-warning pull-right">Ordered</span>
                <h5>Ordered</h5>
            </div>
            <div class="ibox-content">
                <h3 class="no-margins">{{ $statusCounts['ordered'] }}</h3>
                <div class="stat-percent font-bold text-warning">{{ $statusCounts['ordered'] }} <i class="fa fa-cubes"></i></div>
                <small>Total Ordered Parcels</small>
            </div>
        </div>
    </div>

    <!-- Dispatched -->
    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
        <div class="ibox">
            <div class="ibox-title">
                <span class="label label-primary pull-right">Dispatched</span>
                <h5>Dispatched</h5>
            </div>
            <div class="ibox-content">
                <h3 class="no-margins">{{ $statusCounts['dispatched'] }}</h3>
                <div class="stat-percent font-bold text-primary">{{ $statusCounts['dispatched'] }} <i class="fa fa-truck"></i></div>
                <small>Total Dispatched Parcels</small>
            </div>
        </div>
    </div>

    <!-- Delivered -->
    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
        <div class="ibox">
            <div class="ibox-title">
                <span class="label label-success pull-right">Delivered</span>
                <h5>Delivered</h5>
            </div>
            <div class="ibox-content">
                <h3 class="no-margins">{{ $statusCounts['delivered'] }}</h3>
                <div class="stat-percent font-bold text-success">{{ $statusCounts['delivered'] }} <i class="fa fa-check-circle"></i></div>
                <small>Total Delivered Parcels</small>
            </div>
        </div>
    </div>

    <!-- Received -->
    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
        <div class="ibox">
            <div class="ibox-title">
                <span class="label label-info pull-right">Received</span>
                <h5>Received</h5>
            </div>
            <div class="ibox-content">
                <h3 class="no-margins">{{ $statusCounts['received'] }}</h3>
                <div class="stat-percent font-bold text-info">{{ $statusCounts['received'] }} <i class="fa fa-download"></i></div>
                <small>Total Received Parcels</small>
            </div>
        </div>
    </div>

    <!-- Returned -->
    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
        <div class="ibox">
            <div class="ibox-title">
                <span class="label label-danger pull-right">Returned</span>
                <h5>Returned</h5>
            </div>
            <div class="ibox-content">
                <h3 class="no-margins">{{ $statusCounts['returned'] }}</h3>
                <div class="stat-percent font-bold text-danger">{{ $statusCounts['returned'] }} <i class="fa fa-undo"></i></div>
                <small>Total Returned Parcels</small>
            </div>
        </div>
    </div>

</div>


    
    <div class="ibox">
        <div class="ibox-title">
            <h5>List of Parcels</h5>
            <div class="ibox-tools">
                <a href="{{ route('parcels.create') }}" class="btn btn-primary btn-xs">Add New <i class="fa fa-plus"></i></a>
                <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </div>
        </div>

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
                        <?php $paid=0; ?>

                        @foreach($parcels as $parcel)
                            <tr>
                                <td>{{ $parcel->reference_number }}</td>
                                <td>{{ $parcel->sender_name }}</td>
                                <td>{{ $parcel->recipient_name }}</td>
                                <td>{{ $parcel->fromBranch ? $parcel->fromBranch->branch_code : '' }}</td>
                                <td>{{ $parcel->toBranch ? $parcel->toBranch->branch_code : '' }}</td>
                               
                                <td>{{ number_format($parcel->price, 2) }}</td>
                                <td>{!! $parcel->status_badge !!}</td>
                                <td>{{ $parcel->created_at ? $parcel->created_at->format('Y-m-d') : '' }}</td>
                                <td>
                                    <a href="{{ route('parcels.edit', $parcel->id) }}" class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a>
                                    {!! Form::open(['method' => 'DELETE','route' => ['parcels.destroy', $parcel->id],'style'=>'display:inline']) !!}
                                        <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></button>
                                    {!! Form::close() !!}
                                </td>
                            </tr>

                             <?php  $paid+=$parcel->price;?>
                        @endforeach
                    </tbody>

                     <tfoot>
                            <td colspan="5" class="font-bold text-navy"><strong>Totals</strong></td>
                              
                            <td class="font-bold text-navy">Ksh {{number_format($paid,2)}}</td>
                                                  
                            <th colspan="7"></th>
                                                
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{asset('inspinia/js/plugins/dataTables/datatables.min.js')}}"></script>
<script>
$(document).ready(function(){
  $('.parcels').DataTable({
    pageLength:10,
    responsive:true,
    dom:'<"html5buttons"B>lTfgitp',
    buttons:['copy','csv','excel','pdf','print']
  });
});
</script>
@endsection
