@extends('layouts.inspinia')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2 style="color:#1AB394;"><strong>Batch Management</strong></h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{url('/home')}}">Home</a>
                <i class="fa fa-play-circle" style="color:#1AB394;"></i>
            </li>
            <li>
                <a href="{{ route('parcels.index') }}">Parcels</a>
            </li>
            <li class="active">
                <strong>Batch Details</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h5>Batch Details - {{ $batch->batch_number }}</h5>
            <div class="ibox-tools">
                <a href="{{ url('batches') }}" class="btn btn-danger btn-xs active">
                    Back <i class="fa fa-level-up"></i>
                </a>
            </div>
        </div>

        <div class="ibox-content">
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Batch Number:</strong> {{ $batch->batch_number }}
                </div>
                <div class="col-md-4">
                    <strong>Dispatched By:</strong> {{ $batch->dispatched_by }}
                </div>
                <div class="col-md-4">
                    <strong>Dispatched At:</strong> 
                    {{ $batch->dispatched_at ? $batch->dispatched_at->format('d M Y, h:i A') : 'N/A' }}
                </div>
            </div>

            <hr>

            <h5><strong>Dispatched Parcels</strong></h5>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover batch_details">
                    <thead>
                        <tr class="font-bold text-navy">
                            <th>Reference #</th>
                            <th>Sender</th>
                            <th>Recipient</th>
                            <th>From Branch</th>
                            <th>To Branch</th>
                            <th>Quantity</th>
                            <th>Description</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($batch->parcels as $parcel)
                        <tr class="gradeX">
                            <td>{{ $parcel->reference_number }}</td>
                            <td>{{ $parcel->sender_name }}<br><small>{{ $parcel->sender_contact }}</small></td>
                            <td>{{ $parcel->recipient_name }}<br><small>{{ $parcel->recipient_contact }}</small></td>
                            <td>{{ $parcel->fromBranch->branch_code ?? 'N/A' }}</td>
                            <td>{{ $parcel->toBranch->branch_code ?? 'N/A' }}</td>
                            <td>{{ $parcel->quantity }}</td>
                            <td>{{ $parcel->description }}</td>
                            <td>{!! $parcel->status_badge !!}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<!-- Include DataTables core -->
<script src="{{asset('inspinia/js/plugins/dataTables/datatables.min.js')}}"></script>

<!-- Include DataTables Buttons Extensions -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script>
$(document).ready(function(){
    $('.batch_details').DataTable({
        pageLength: 10,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [
            { extend: 'copy', className: 'btn btn-sm btn-outline-secondary' },
            { extend: 'csv', title: 'Batch_{{ $batch->batch_number }}', className: 'btn btn-sm btn-outline-primary' },
            { extend: 'excel', title: 'Batch_{{ $batch->batch_number }}', className: 'btn btn-sm btn-outline-success' },
            { extend: 'pdf', title: 'Batch_{{ $batch->batch_number }}', className: 'btn btn-sm btn-outline-danger' },
            { extend: 'print', className: 'btn btn-sm btn-outline-info',
                customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');
                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            }
        ]
    });
});
</script>

@endsection
