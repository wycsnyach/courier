@extends('layouts.inspinia')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2 style="color:#1AB394;"><strong>Parcel Dispatch</strong></h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/home') }}">Home</a>
                <i class="fa fa-play-circle" style="color:#1AB394;"></i>
            </li>
            <li><a href="{{ route('parcels.index') }}">Parcels</a></li>
            <li class="active"><strong>Batch Dispatch</strong></li>
        </ol>
        @include('includes.dispatches_header')
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox float-e-margins">
        <div class="ibox-title d-flex justify-content-between align-items-center">
            <div class="row col-lg-12">
                <div class="col-lg-10">
                <h5><strong>Batch Dispatch</strong></h5>
            </div>
            <div class="col-lg-2">
                <a href="{{ url('batches') }}" class="btn btn-xs btn-danger active">
                    <i class="fa fa-level-up"></i> Back
                </a>
            </div>
            </div>
        </div>

        <div class="ibox-content">
            <form method="POST" action="{{ route('parcels.dispatchBatch') }}">
                @csrf

                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover waitingParcels">
                        <thead>
                            <tr class="font-bold text-navy">
                                <th><input type="checkbox" id="selectAll"></th>
                                <th>Ref #</th>
                                <th>Sender</th>
                                <th>Recipient</th>
                                <th>Quantity</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($waitingParcels as $parcel)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="parcel_ids[]" value="{{ $parcel->id }}">
                                    </td>
                                    <td>{{ $parcel->reference_number }}</td>
                                    <td>{{ $parcel->sender_name }}<br><small>{{ $parcel->sender_contact }}</small></td>
                                    <td>{{ $parcel->recipient_name }}<br><small>{{ $parcel->recipient_contact }}</small></td>
                                    <td>{{ $parcel->quantity }}</td>
                                    <td>{{ $parcel->description }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No parcels currently waiting for dispatch.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fa fa-truck"></i> Dispatch Selected Parcels
                    </button>
                    <button type="reset" class="btn btn-secondary btn-sm">
                        <i class="fa fa-refresh"></i> Clear Selection
                    </button>
                </div>
            </form>
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

    // DataTable initialization
    $('.waitingParcels').DataTable({
        pageLength: 10,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [
            { extend: 'copy', className: 'btn btn-sm btn-outline-secondary' },
            { extend: 'csv', title: 'Waiting_Parcels', className: 'btn btn-sm btn-outline-primary' },
            { extend: 'excel', title: 'Waiting_Parcels', className: 'btn btn-sm btn-outline-success' },
            { extend: 'pdf', title: 'Waiting_Parcels', className: 'btn btn-sm btn-outline-danger' },
            { extend: 'print', className: 'btn btn-sm btn-outline-info',
                customize: function (win){
                    $(win.document.body).addClass('white-bg').css('font-size', '10px');
                    $(win.document.body).find('table').addClass('compact').css('font-size', 'inherit');
                }
            }
        ]
    });

    // Select/Deselect all checkboxes
    $('#selectAll').on('change', function(){
        $('input[name="parcel_ids[]"]').prop('checked', $(this).prop('checked'));
    });
});
</script>

@endsection
