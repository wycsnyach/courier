@extends('layouts.inspinia')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2 style="color:#1AB394;"><strong>Create Payment</strong></h2>
        <ol class="breadcrumb">
            <li><a href="{{ url('/home') }}">Home</a></li>
            <li><a href="{{ route('payments.index') }}">Payments</a></li>
            <li class="active"><strong>Create</strong></li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Create New Payment</h5>
            <div class="ibox-tools">
                <a href="{{ route('payments.index') }}" class="btn btn-danger btn-xs">Back <i class="fa fa-level-up"></i></a>
                <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                <a class="close-link"><i class="fa fa-times"></i></a>
            </div>
        </div>
        <div class="ibox-content">
            {!! Form::open(['route' => 'payments.store', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
            <div class="row">
           <div class="col-lg-6">
                <div class="form-group">
                   <div class="col-sm-12">
                    <label>Parcel *</label>
                    <div>
                        <select name="parcel_id" id="parcel_id" class="form-control fstdropdown-select" required onchange="fetchParcelDetails()">
                            <option value="">-- Select Parcel --</option>
                            @foreach($parcels as $parcel)
                                <option value="{{ $parcel->id }}" data-price="{{ $parcel->price }}">
                                    {{ $parcel->reference_number }} - {{ $parcel->sender_name }} to {{ $parcel->recipient_name }} ({{ number_format($parcel->price, 2) }})
                                </option>
                            @endforeach
                        </select>
                        @if($parcels->isEmpty())
                            <div class="alert alert-warning mt-2">
                                <i class="fa fa-exclamation-triangle"></i> No pending parcels available for payment.
                            </div>
                        @else
                            <small class="text-muted">Showing only parcels with Pending status</small>
                        @endif
                    </div>
                </div>
                </div>


                <!-- Parcel Details Display -->
                <div class="row" id="parcelDetails" style="display: none;">
                    <div class="col-md-12">
                        <div class="alert alert-info">
                            <h4>Parcel Payment Summary</h4>
                            <div class="row">
                                <div class="col-md-3">
                                    <strong>Total Price:</strong> <span id="totalPrice">0.00</span>
                                </div>
                                <div class="col-md-3">
                                    <strong>Already Paid:</strong> <span id="totalPaid">0.00</span>
                                </div>
                                <div class="col-md-3">
                                    <strong>Remaining:</strong> <span id="remainingAmount">0.00</span>
                                </div>
                                <div class="col-md-3">
                                    <strong>Current Status:</strong> <span id="currentStatus">-</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>

                <div class="col-lg-6">

                    <div class="form-group">
                        <label>Amount to Pay *</label>
                        <div >
                            <input type="number" name="amount" id="amount" step="0.01" class="form-control" required placeholder="Enter amount to pay">
                            <small class="text-muted" id="amountHelp">Enter the payment amount</small>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Payment Mode *</label>
                        <div>
                            <select name="paymentmode_id" class="form-control fstdropdown-select" required>
                                <option value="">-- Select Payment Mode --</option>
                                @foreach($paymentmodes as $mode)
                                    <option value="{{ $mode->id }}">{{ $mode->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Transaction Reference</label>
                        <div>
                            <input type="text" name="transaction_reference" class="form-control" placeholder="e.g., Mpesa Mobile Money ID, Bank Transfer Ref, etc.">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Payment Date</label>
                        <div>
                            <input type="datetime-local" name="payment_date" class="form-control" value="{{ now()->format('Y-m-d\TH:i') }}">
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div>
                            <a href="{{ route('payments.index') }}" class="btn btn-white">Cancel</a>
                            <button class="btn btn-primary" type="submit" {{ $parcels->isEmpty() ? 'disabled' : '' }}>Create Payment</button>
                        </div>
                    </div>
                </div>

            {!! Form::close() !!}
        </div>
    </div>
    </div>
</div>

<script>
function fetchParcelDetails() {
    const parcelId = document.getElementById('parcel_id').value;
    const parcelDetails = document.getElementById('parcelDetails');
    const amountInput = document.getElementById('amount');
    const amountHelp = document.getElementById('amountHelp');
    
    if (parcelId) {
        fetch(`/get-parcel-price/${parcelId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show parcel details
                    parcelDetails.style.display = 'block';
                    
                    // Update display
                    document.getElementById('totalPrice').textContent =  parseFloat(data.price).toFixed(2);
                    document.getElementById('totalPaid').textContent =  parseFloat(data.total_paid).toFixed(2);
                    document.getElementById('remainingAmount').textContent =  parseFloat(data.remaining).toFixed(2);
                    document.getElementById('currentStatus').textContent = data.status_text;
                    
                    // Set max amount to remaining balance
                    amountInput.max = data.remaining;
                    amountInput.value = data.remaining > 0 ? data.remaining : 0;
                    
                    // Update help text
                    if (data.remaining > 0) {
                        amountHelp.textContent = `You can pay up to ${parseFloat(data.remaining).toFixed(2)}. Full payment will change parcel status to "In Transit".`;
                        amountHelp.className = 'text-info';
                    } else {
                        amountHelp.textContent = 'This parcel is already fully paid. Any additional payment will be recorded as overpayment.';
                        amountHelp.className = 'text-warning';
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    } else {
        parcelDetails.style.display = 'none';
        amountInput.value = '';
        amountHelp.textContent = 'Enter the payment amount';
        amountHelp.className = 'text-muted';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    fetchParcelDetails();
});
</script>

<style>
.hr-line-dashed {
    border-top: 1px dashed #e7eaec;
    margin: 20px 0;
}
.alert-info {
    background-color: #f4f8fa;
    border-color: #5bc0de;
    color: #31708f;
}
.btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}
</style>
@endsection