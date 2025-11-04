 @extends('layouts.inspinia')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2 class="font-bold text-success" style="color:#1AB394;">All Dispatched Batches</h2>
        <ol class="breadcrumb">
            <li><a href="{{ url('/home') }}">Home</a></li>
            <li><a>Delivered</a></li>
            <li class="active"><strong>All Batches</strong></li>
        </ol>
        @include('includes.dispatches_header')
    </div>
</div>

<div class="ibox">
    <div class="ibox-title">
        <h5>Delivered Parcels Awaiting Recipient Collection</h5>
    </div>
    <div class="ibox-content">

        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover deliveredParcels">
                <thead>
                    <tr class="font-bold text-navy">
                        <th>Reference</th>
                        <th>Recipient Name</th>
                        <th>Destination Branch</th>
                        <th>Delivered At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($parcels as $parcel)
                    <tr>
                        <td>{{ $parcel->reference_number }}</td>
                        <td>{{ $parcel->recipient_name }}</td>
                        <td>{{ $parcel->toBranch->branch_code ?? 'N/A' }}</td>
                        <td>{{ $parcel->created_at ? \Carbon\Carbon::parse($parcel->created_at)->format('d M Y, h:i A') : 'N/A' }}</td>
                        <td>
                            <a href="{{ route('parcels.recipientReceipt', $parcel->id) }}" class="btn btn-xs btn-success">
                                Receive
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection

@section('scripts')

<!-- DataTables Core -->
<script src="{{ asset('inspinia/js/plugins/dataTables/datatables.min.js') }}"></script>

<!-- DataTables Buttons Extension -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script>
$(document).ready(function(){
    $('.deliveredParcels').DataTable({
        pageLength: 10,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [
            { extend: 'copy', className: 'btn btn-sm btn-outline-secondary' },
            { extend: 'csv', title: 'Delivered_Parcels', className: 'btn btn-sm btn-outline-primary' },
            { extend: 'excel', title: 'Delivered_Parcels', className: 'btn btn-sm btn-outline-success' },
            { extend: 'pdf', title: 'Delivered_Parcels', className: 'btn btn-sm btn-outline-danger' },
            { extend: 'print', className: 'btn btn-sm btn-outline-info',
                customize: function (win){
                    $(win.document.body)
                        .addClass('white-bg')
                        .css('font-size', '10px');
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
