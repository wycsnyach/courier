@extends('layouts.inspinia')

@section('content')

<div class="wrapper wrapper-content">  
    <h3 class="page-title" style="color:#1AB394"><strong class="text-uppercase">Welcome</strong>
                <small class="small text-titlecase">{{Auth::User()->first_name}} {{Auth::User()->middle_name}} {{Auth::User()->last_name}} </small>
            </h3>               

<div class="row">

        <!-- Users -->
    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right">Users</span>
                <h5 class="text-ellipsis">Users</h5>
            </div>
            <div class="ibox-content">
                <h3 class="no-margins">{{$user->users_count()}}</h3>
                <div class="stat-percent font-bold text-success">{{$user->users_count()}}<i class="fa fa-bolt"></i></div>
                <a href="{{Route('users.index')}}"><small>Users</small></a>
            </div>
        </div>
    </div>

        <!-- Branches -->
    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right">Branches</span>
                <h5 class="text-ellipsis">Branches</h5>
            </div>
            <div class="ibox-content">
                <h3 class="no-margins">{{$branch->branches_count()}}</h3>
                <div class="stat-percent font-bold text-success">{{$branch->branches_count()}}<i class="fa fa-bolt"></i></div>
                <a href="{{Route('branches.index')}}"><small>Branches</small></a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title d-flex justify-content-between align-items-center">
                <div class="row">
                    
                    <div class="col-xs-6">
                        <button id="prevMonth" class="btn btn-xs btn-success" data-month="{{ $prevMonth }}">← Prev</button>
                        <button id="nextMonth" class="btn btn-xs btn-success" data-month="{{ $nextMonth }}">Next →</button>
                    </div>
                    <div class="col-xs-6">
                        <h5 id="monthTitle">Parcels Summary ({{ $currentMonth }})</h5>
                    </div>
            </div>
            </div>
            <div class="ibox-content">
                <canvas id="parcelStatusChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let chartInstance;
    const ctx = document.getElementById('parcelStatusChart').getContext('2d');

    const chartConfig = {
        type: 'line',
        data: {
            labels: @json($dates),
            datasets: [
                {
                    label: 'Ordered',
                    data: @json(array_values($chartData['Ordered'] ?? [])),
                    borderColor: '#f8ac59',
                    tension: 0.3,
                    fill: false
                },
                {
                    label: 'Dispatched',
                    data: @json(array_values($chartData['Dispatched'] ?? [])),
                    borderColor: '#1c84c6',
                    tension: 0.3,
                    fill: false
                },
                {
                    label: 'Delivered',
                    data: @json(array_values($chartData['Delivered'] ?? [])),
                    borderColor: '#1ab394',
                    tension: 0.3,
                    fill: false
                },
                {
                    label: 'Received',
                    data: @json(array_values($chartData['Received'] ?? [])),
                    borderColor: '#23c6c8',
                    tension: 0.3,
                    fill: false
                },
                {
                    label: 'Returned',
                    data: @json(array_values($chartData['Returned'] ?? [])),
                    borderColor: '#ed5565',
                    tension: 0.3,
                    fill: false
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                title: {
                    display: true,
                    //text: 'Parcels by Status ({{ $currentMonth }})',
                    font: { size: 16 }
                }
            },
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0 } }
            }
        }
    };

    chartInstance = new Chart(ctx, chartConfig);

    function updateChart(month) {
        fetch(`{{ url('home') }}?month=${month}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById('monthTitle').innerText = `Parcels Summary (${data.currentMonth})`;
            document.getElementById('prevMonth').dataset.month = data.prevMonth;
            document.getElementById('nextMonth').dataset.month = data.nextMonth;

            chartInstance.data.labels = data.dates;
            chartInstance.data.datasets.forEach(dataset => {
                const label = dataset.label;
                dataset.data = data.chartData[label] ?? [];
            });
            chartInstance.options.plugins.title.text = `Parcels by Status (${data.currentMonth})`;
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

@endsection
