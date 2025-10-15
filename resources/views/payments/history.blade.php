@extends('layouts.inspinia')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2 style="color:#1AB394;"><strong>Payment History</strong></h2>
        <ol class="breadcrumb">
            <li><a href="{{ url('/home') }}">Home</a></li>
            <li><a href="{{ route('payments.index') }}">Payments</a></li>
            <li class="active"><strong>Payment History</strong></li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-md-4">
            <div class="ibox">
                <div class="ibox-title">
                    <h5 class="font-bold text-navy">Payment Information</h5>
                </div>
                <div class="ibox-content">
                    <p><strong>Payment ID:</strong> {{ $payment->id }}</p>
                    <p><strong>Parcel:</strong> {{ $payment->parcel->reference_number }}</p>
                    <p><strong>Total Amount:</strong> {{ number_format($payment->amount, 2) }}</p>
                    <p><strong>Payment Mode:</strong> {{ $payment->paymentmode->name }}</p>
                    <p><strong>Transaction Ref:</strong> {{ $payment->transaction_reference ?? 'N/A' }}</p>
                    <p><strong>Payment Date:</strong> {{ $payment->payment_date->format('M j, Y H:i') }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="ibox">
                <div class="ibox-title">
                    <h5 class="font-bold text-navy">Payment History</h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr class="font-bold text-navy">
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Payment Mode</th>
                                    <th>Transaction Ref</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payment->histories as $history)
                                <tr>
                                    <td>{{ $history->payment_date->format('M j, Y H:i') }}</td>
                                    <td>{{ number_format($history->amount_paid, 2) }}</td>
                                    <td>{{ $history->paymentmode->name }}</td>
                                    <td>{{ $history->transaction_reference ?? 'N/A' }}</td>
                                    <td>{{ $history->notes }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="text-right">
                        <a href="{{ route('payments.index') }}" class="btn btn-xs btn-primary">Back to Payments</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection