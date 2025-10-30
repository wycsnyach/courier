<!DOCTYPE html>
<html>
<head>
    <title>Dispatched Batches Report</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #1AB394; color: white; }
        h2 { color: #1AB394; text-align: center; margin-bottom: 10px; }
        .header { text-align: center; }
        .company-logo { width: 100px; margin-bottom: 10px; }
        .company-info { font-size: 12px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="header">
        @if($settings && $settings->logo && file_exists(public_path('storage/' . $settings->logo)))
            <img src="{{ public_path('storage/' . $settings->logo) }}" class="company-logo" alt="Company Logo">
        @endif
        <div class="company-info">
            <strong>{{ $settings->company_name ?? 'Company Name' }}</strong><br>
            {{ $settings->email ?? '' }} | {{ $settings->phone ?? '' }}<br>
            {{ $settings->street_address ?? '' }}
        </div>
    </div>

    <h2>Dispatched Batches Report</h2>

    <table>
        <thead>
            <tr>
                <th>Batch #</th>
                <th>Dispatched By</th>
                <th>Dispatched At</th>
                <th>Total Parcels</th>
            </tr>
        </thead>
        <tbody>
            @foreach($batches as $batch)
            <tr>
                <td>{{ $batch->batch_number }}</td>
                <td>{{ $batch->dispatched_by }}</td>
                <td>{{ $batch->dispatched_at ? \Carbon\Carbon::parse($batch->dispatched_at)->format('d M Y, h:i A') : 'N/A' }}</td>
                <td>{{ $batch->parcels_count }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
