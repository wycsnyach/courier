@extends('layouts.inspinia')

@section('content')

<div class="wrapper wrapper-content">
    <div class="page-header mb-4">
        <h3 class="page-title text-success fw-bold text-uppercase" style="color:#1AB394">
            Welcome
            <small class="text-muted text-capitalize d-block d-sm-inline">
                {{ Auth::user()->first_name }} {{ Auth::user()->middle_name }} {{ Auth::user()->last_name }}
            </small>
        </h3>
    </div>

    <!-- Summary Cards -->
<!--     <div class="row g-3">
       
        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
            <div class="ibox">
                <div class="ibox-title">
                    <span class="label label-success float-end">Users</span>
                    <h5 class="text-truncate">Users</h5>
                </div>
                <div class="ibox-content text-center">
                    <h3 class="no-margins">{{ $user->users_count() }}</h3>
                    <div class="stat-percent font-bold text-success">
                        {{ $user->users_count() }} <i class="fa fa-bolt"></i>
                    </div>
                    <a href="{{ route('users.index') }}"><small>View Users</small></a>
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
            <div class="ibox">
                <div class="ibox-title">
                    <span class="label label-success float-end">Branches</span>
                    <h5 class="text-truncate">Branches</h5>
                </div>
                <div class="ibox-content text-center">
                    <h3 class="no-margins">{{ $branch->branches_count() }}</h3>
                    <div class="stat-percent font-bold text-success">
                        {{ $branch->branches_count() }} <i class="fa fa-bolt"></i>
                    </div>
                    <a href="{{ route('branches.index') }}"><small>View Branches</small></a>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Parcel Status Cards -->
    <div class="row m-b-md mt-4">
        @foreach ([
            'booked' => ['label' => 'Booked', 'class' => 'warning', 'icon' => 'fa-cubes'],
            'waiting' => ['label' => 'Waiting', 'class' => 'secondary', 'icon' => 'fa-hourglass-half'],
            'dispatched' => ['label' => 'Dispatched', 'class' => 'primary', 'icon' => 'fa-truck'],
            'delivered' => ['label' => 'Delivered', 'class' => 'success', 'icon' => 'fa-check-circle'],
            'received' => ['label' => 'Received', 'class' => 'info', 'icon' => 'fa-download'],
            'returned' => ['label' => 'Returned', 'class' => 'danger', 'icon' => 'fa-undo'],
        ] as $key => $data)
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="ibox" data-bs-toggle="tooltip" title="Total {{ $data['label'] }} parcels recorded this month">
                    <div class="ibox-title text-center">
                        <span class="label label-{{ $data['class'] }} float-end">{{ $data['label'] }}</span>
                    </div>
                    <div class="ibox-content text-center">
                        <i class="fa {{ $data['icon'] }} fa-2x text-{{ $data['class'] }}" style="margin-bottom: 10px;"></i>
                        <h3 class="no-margins">{{ $statusCounts[$key] }}</h3>
                        <small>Total {{ $data['label'] }} Parcels</small>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Charts Section -->
    <div class="row mt-4">
        <!-- Parcels Chart -->
        <div class="col-12 col-lg-12 mb-4">
            <div class="ibox">
                <div class="ibox-title d-flex flex-wrap justify-content-between align-items-center">
                    <div class="d-flex flex-wrap gap-2">
                        <button id="prevMonth" class="btn btn-xs btn-success" data-month="{{ $prevMonth }}">← Prev</button>
                        <button id="nextMonth" class="btn btn-xs btn-success" data-month="{{ $nextMonth }}">Next →</button>
                    </div>
                    <h5 id="monthTitle" class="mt-2 mt-sm-0 text-success fw-bold">Parcels Summary ({{ $currentMonth }})</h5>
                </div>
                <div class="ibox-content">
                    <div class="chart-container" style="position: relative; height: 40vh; width: 100%;">
                        <canvas id="parcelStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second Chart Placeholder -->
        <!-- <div class="col-12 col-lg-6 mb-4">
            <div class="ibox">
                <div class="ibox-title d-flex flex-wrap justify-content-between align-items-center">
                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn btn-xs btn-success">← Prev</button>
                        <button class="btn btn-xs btn-success">Next →</button>
                    </div>
                    <h5 class="mt-2 mt-sm-0 text-success fw-bold">Parcels Summary (Future Data)</h5>
                </div>
                <div class="ibox-content">
                    <div class="chart-container" style="position: relative; height: 40vh; width: 100%;">
                        <canvas id="secondChart"></canvas>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</div>

<!-- Chart JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let chartInstance;
    const ctx = document.getElementById('parcelStatusChart').getContext('2d');

    const chartConfig = {
        type: 'line',
        data: {
            labels: @json($dates),
            datasets: [
                { label: 'Ordered', data: @json(array_values($chartData['Ordered'] ?? [])), borderColor: '#f8ac59', tension: 0.3, fill: false },
                { label: 'Waiting Dispatch', data: @json(array_values($chartData['Waiting'] ?? [])), borderColor: '#a0a0a0', tension: 0.3, fill: false },
                { label: 'Dispatched', data: @json(array_values($chartData['Dispatched'] ?? [])), borderColor: '#1c84c6', tension: 0.3, fill: false },
                { label: 'Delivered', data: @json(array_values($chartData['Delivered'] ?? [])), borderColor: '#1ab394', tension: 0.3, fill: false },
                { label: 'Received', data: @json(array_values($chartData['Received'] ?? [])), borderColor: '#23c6c8', tension: 0.3, fill: false },
                { label: 'Returned', data: @json(array_values($chartData['Returned'] ?? [])), borderColor: '#ed5565', tension: 0.3, fill: false }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top' },
                title: { display: true, font: { size: 16 } }
            },
            scales: { 
                y: { beginAtZero: true, ticks: { precision: 0 } },
                x: { ticks: { autoSkip: true, maxTicksLimit: 15 } }
            }
        }
    };

    chartInstance = new Chart(ctx, chartConfig);

    function updateChart(month) {
        fetch(`{{ url('home') }}?month=${month}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(res => res.json())
        .then(data => {
            document.getElementById('monthTitle').innerHTML = 
                `<span class='text-success'>Parcels Summary</span> (${data.currentMonth})`;
            document.getElementById('prevMonth').dataset.month = data.prevMonth;
            document.getElementById('nextMonth').dataset.month = data.nextMonth;

            chartInstance.data.labels = data.dates;
            chartInstance.data.datasets.forEach(dataset => {
                dataset.data = data.chartData[dataset.label] ?? [];
            });
            chartInstance.update();
        });
    }

    document.getElementById('prevMonth').addEventListener('click', function() {
        updateChart(this.dataset.month);
    });
    document.getElementById('nextMonth').addEventListener('click', function() {
        updateChart(this.dataset.month);
    });
</script>

<style>
    /* Make ibox responsive and neat */
    .ibox {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .ibox-title h5 {
        font-size: 14px;
    }

    .ibox-content h3 {
        font-size: 1.8rem;
    }

    /* Adjust spacing and text on small screens */
    @media (max-width: 768px) {
        .page-title {
            font-size: 1.3rem;
        }
        .ibox-content h3 {
            font-size: 1.5rem;
        }
        .btn-xs {
            font-size: 0.7rem;
            padding: 2px 6px;
        }
        #parcelStatusChart, #secondChart {
            height: 300px !important;
        }
    }
</style>

@endsection
