@extends('layouts.inspinia')

@section('content')
<div class="ibox">
    <div class="ibox-title">
        <h5>Delivery Receipt - {{ $batch->batch_number }}</h5>
    </div>
    <div class="ibox-content">
        <p><strong>Dispatched By:</strong> {{ $batch->dispatched_by }}</p>
        <p><strong>Dispatched At:</strong> {{ $batch->dispatched_at }}</p>

        <h5>Parcels in this Batch</h5>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Reference</th>
                    <th>Recipient</th>
                    <th>Destination Branch</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($batch->parcels as $parcel)
                <tr>
                    <td>{{ $parcel->reference_number }}</td>
                    <td>{{ $parcel->recipient_name }}</td>
                    <td>{{ $parcel->toBranch->branch_code ?? 'N/A' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <form method="POST" action="{{ route('parcels.confirmDeliveryReceipt', $batch->id) }}">
            @csrf
            <button type="submit" class="btn btn-xs btn-primary">Confirm Delivery to Branch</button>
        </form>
    </div>
</div>
@endsection
