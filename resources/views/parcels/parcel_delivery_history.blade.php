@extends('layouts.inspinia')

@section('content')
<div class="ibox">
    <div class="ibox-title">
        <h5>Parcel Delivery History - {{ $parcel->reference_number }}</h5>
    </div>

    <div class="ibox-content">
        <div class="mb-4">
            <p><strong>Recipient:</strong> {{ $parcel->recipient_name }}</p>
            <p><strong>Status:</strong> {!! $parcel->status_badge !!}</p>
            <p><strong>Collected By:</strong> {{ $parcel->collected_by ?? 'Not Yet Collected' }}</p>

            @if ($parcel->recipient_signature)
                <p><strong>Recipient Signature:</strong></p>
                <img src="{{ asset('storage/' . $parcel->recipient_signature) }}" 
                     alt="Signature" 
                     class="border rounded" 
                     width="200">
            @endif
        </div>

        <h5 class="mb-4 text-primary"><i class="fa fa-history"></i> Delivery Timeline</h5>

        @php
            use Carbon\Carbon;
            $groupedHistories = $parcel->deliveryHistories->groupBy(function($history) {
                $date = Carbon::parse($history->action_time)->startOfDay();
                if ($date->isToday()) return 'Today';
                elseif ($date->isYesterday()) return 'Yesterday';
                else return $date->format('d M Y');
            });
        @endphp

        @forelse ($groupedHistories as $date => $histories)
            <h6 class="text-muted mt-3 mb-2"><i class="fa fa-calendar"></i> {{ $date }}</h6>

            <div class="timeline">
                @foreach ($histories as $history)
                    <div class="timeline-item">
                        <div class="timeline-icon 
                            @if (Str::contains(strtolower($history->action), 'dispatch')) bg-warning 
                            @elseif (Str::contains(strtolower($history->action), 'delivered')) bg-success 
                            @elseif (Str::contains(strtolower($history->action), 'received')) bg-info 
                            @else bg-secondary @endif">
                            <i class="fa 
                                @if (Str::contains(strtolower($history->action), 'dispatch')) fa-truck 
                                @elseif (Str::contains(strtolower($history->action), 'delivered')) fa-check 
                                @elseif (Str::contains(strtolower($history->action), 'received')) fa-user 
                                @else fa-circle @endif">
                            </i>
                        </div>
                        <div class="timeline-content">
                            <span class="time text-muted">
                                {{ Carbon::parse($history->action_time)->format('h:i A') }}
                            </span>
                            <h6 class="mt-1 mb-1 text-dark">{{ $history->action }}</h6>
                            <p class="mb-1"><strong>By:</strong> {{ $history->user->name ?? 'System' }}</p>
                            <p class="text-muted mb-0">{{ $history->remarks }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @empty
            <p class="text-center text-muted mt-3">No history available for this parcel yet.</p>
        @endforelse

        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm mt-4">Back</a>
    </div>
</div>

<style>
    .timeline {
        position: relative;
        margin: 20px 0;
        padding-left: 40px;
        border-left: 2px solid #e0e0e0;
    }
    .timeline-item {
        position: relative;
        margin-bottom: 25px;
    }
    .timeline-icon {
        position: absolute;
        left: -24px;
        top: 0;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 0 4px rgba(0,0,0,0.2);
    }
    .timeline-content {
        background: #fafafa;
        border-radius: 8px;
        padding: 10px 15px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .bg-warning { background-color: #f0ad4e !important; }
    .bg-success { background-color: #1ab394 !important; }
    .bg-info { background-color: #23c6c8 !important; }
    .bg-secondary { background-color: #888 !important; }
</style>

<script>
    window.onload = function() {
        const timeline = document.querySelector('.timeline');
        if (timeline) timeline.scrollTop = timeline.scrollHeight;
    };
</script>
@endsection
