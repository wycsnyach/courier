@extends('layouts.inspinia')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2 style="color:#1AB394;"><strong>Payment Management</strong></h2>
        <ol class="breadcrumb">
            <li><a href="{{ url('/home') }}">Home</a></li>
            <li><a>Payments</a></li>
            <li class="active"><strong>All Payments</strong></li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h5>List of Payments</h5>
            <div class="ibox-tools">
                <a href="{{ route('payments.create') }}" class="btn btn-primary btn-xs">Add New <i class="fa fa-plus"></i></a>
                <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </div>
        </div>

        <div class="ibox-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover payments">
                    <thead>
                        <tr class="font-bold text-navy">
                            <th>ID</th>
                            <th>Parcel Reference</th>
                            <th>Sender → Recipient</th>
                            <th>Payment Mode</th>
                            <th>Amount</th>
                            <th>Payment Date</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $totalAmount = 0; ?>

                        @foreach($payments as $payment)
                            <tr>
                                <td>{{ $payment->id }}</td>
                                <td>{{ $payment->parcel->reference_number ?? 'N/A' }}</td>
                                <td>
                                    {{ $payment->parcel->sender_name ?? 'N/A' }} → 
                                    {{ $payment->parcel->recipient_name ?? 'N/A' }}
                                </td>
                                <td>{{ $payment->paymentMode->name ?? 'N/A' }}</td>
                                <td>{{ number_format($payment->amount, 2) }}</td>
                                <td>
                                    @if($payment->payment_date instanceof \Carbon\Carbon)
                                        {{ $payment->payment_date->format('Y-m-d H:i') }}
                                    @else
                                        {{ \Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d H:i') }}
                                    @endif
                                </td>
                                <td>{{ $payment->created_at ? $payment->created_at->format('Y-m-d') : '' }}</td>
                                <td>
                                     <a href="{{ route('payments.history', $payment->id) }}" class="btn btn-xs btn-info" title="Payment History">
                                            <i class="fa fa-history"></i>
                                        </a>
                                    <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a>
                                    {!! Form::open(['method' => 'DELETE','route' => ['payments.destroy', $payment->id],'style'=>'display:inline']) !!}
                                        <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></button>
                                    {!! Form::close() !!}
                                </td>
                            </tr>

                            <?php $totalAmount += $payment->amount; ?>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="4" class="font-bold text-navy"><strong>Totals</strong></td>
                            <td class="font-bold text-navy">{{ number_format($totalAmount, 2) }}</td>
                            <th colspan="5"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('inspinia/js/plugins/dataTables/datatables.min.js') }}"></script>
<script>
$(document).ready(function(){
  $('.payments').DataTable({
    pageLength: 10,
    responsive: true,
    dom: '<"html5buttons"B>lTfgitp',
    buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
    ],
    order: [[0, 'desc']] // Sort by ID descending (newest first)
  });
});
</script>
@endsection