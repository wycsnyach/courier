@extends('layouts.inspinia')

@section('content')
<div class="ibox">
    <div class="ibox-title">
        <h5>Recipient Receipt - {{ $parcel->reference_number }}</h5>
    </div>
    <div class="ibox-content">
        <p><strong>Recipient Name:</strong> {{ $parcel->recipient_name }}</p>
        <p><strong>Delivered At Branch:</strong> {{ $parcel->delivered_at ? \Carbon\Carbon::parse($parcel->delivered_at)->format('d M Y, h:i A') : 'N/A' }}</p>

        <form method="POST" action="{{ route('parcels.confirmRecipientReceipt', $parcel->id) }}">
            @csrf

            <div class="form-group">
                <label><strong>Recipient Signature:</strong></label><br>
                <canvas id="signature-pad" width="400" height="200" style="border:1px solid #ccc; border-radius: 8px;"></canvas><br>
                <button type="button" class="btn btn-sm btn-secondary" id="clear">Clear</button>
                <input type="hidden" name="signature" id="signature">
            </div>

            <button type="submit" class="btn btn-success mt-2">Confirm Receipt</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
    const canvas = document.getElementById('signature-pad');
    const signaturePad = new SignaturePad(canvas);
    const clearBtn = document.getElementById('clear');
    const signatureInput = document.getElementById('signature');

    clearBtn.addEventListener('click', () => signaturePad.clear());

    document.querySelector('form').addEventListener('submit', function (e) {
        if (!signaturePad.isEmpty()) {
            signatureInput.value = signaturePad.toDataURL();
        } else {
            e.preventDefault();
            alert('Please provide a signature before confirming receipt.');
        }
    });
</script>
@endsection
