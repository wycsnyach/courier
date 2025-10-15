@extends('layouts.inspinia')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2 style="color:#1AB394;"><strong>Edit Payment</strong></h2>
        <ol class="breadcrumb">
            <li><a href="{{ url('/home') }}">Home</a></li>
            <li><a href="{{ route('payments.index') }}">Payments</a></li>
            <li class="active"><strong>Edit</strong></li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Edit Payment #{{ $payment->id }}</h5>
            <div class="ibox-tools">
                <a href="{{ route('payments.index') }}" class="btn btn-danger btn-xs">Back <i class="fa fa-level-up"></i></a>
                <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                <a class="close-link"><i class="fa fa-times"></i></a>
            </div>
        </div>
        <div class="ibox-content">
            {!! Form::model($payment, ['route' => ['payments.update', $payment->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
            
            <div class="form-group">
                <label class="col-sm-2 control-label">Parcel</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" value="{{ $payment->parcel->reference_number ?? 'N/A' }} - {{ $payment->parcel->sender_name ?? 'N/A' }} to {{ $payment->parcel->recipient_name ?? 'N/A' }} (₵{{ number_format($payment->parcel->price ?? 0, 2) }})" readonly style="background-color: #f8f9fa;">
                    <small class="text-muted">Parcel cannot be changed after creation</small>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Amount *</label>
                <div class="col-sm-10">
                    <input type="number" name="amount" step="0.01" class="form-control" value="{{ old('amount', $payment->amount) }}" required>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Payment Mode *</label>
                <div class="col-sm-10">
                    <select name="paymentmode_id" class="form-control" required>
                        <option value="">-- Select Payment Mode --</option>
                        @foreach($paymentmodes as $mode)
                            <option value="{{ $mode->id }}" {{ $payment->paymentmode_id == $mode->id ? 'selected' : '' }}>
                                {{ $mode->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Transaction Reference</label>
                <div class="col-sm-10">
                    <input type="text" name="transaction_reference" class="form-control" value="{{ old('transaction_reference', $payment->transaction_reference) }}">
                </div>
            </div>

            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <div class="col-sm-4 col-sm-offset-2">
                    <a href="{{ route('payments.index') }}" class="btn btn-white">Cancel</a>
                    <button class="btn btn-primary" type="submit">Update Payment</button>
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
</div>

<style>
.hr-line-dashed {
    border-top: 1px dashed #e7eaec;
    margin: 20px 0;
}
</style>
@endsection