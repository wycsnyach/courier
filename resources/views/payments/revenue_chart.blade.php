@extends('layouts.inspinia')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2 class="font-bold text-success" style="color:#1AB394;">All Revenue</h2>
        <ol class="breadcrumb">
            <li><a href="{{ url('/home') }}">Home</a></li>
            <li><a>Revenue Per Branch</a></li>
            <li class="active"><strong>All Branches</strong></li>
        </ol>
    </div>
</div>

<div class="ibox">
    <div class="ibox-title">
        <div class="row align-items-center w-100">
            <!-- Title -->
            <div class="col-lg-4 col-md-12 mb-2 mb-lg-0 d-flex align-items-center">
                <h5 class="text-success mb-0">
                    <i class="fa fa-line-chart me-2"></i> Branch Daily Revenue
                </h5>
            </div>

            <!-- Filters Section -->
            <div class="col-lg-8 col-md-12">
                <div class="row align-items-center">
                    <!-- Branch Filter -->
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2 mb-md-0">
                        <label for="branchFilter" class="form-label text-muted fw-semibold mb-1">
                            <i class="fa fa-map-marker text-success me-1"></i> Filter by Branch
                        </label>
                        <select id="branchFilter" class="form-control form-control-sm border-success text-dark">
                            <option value="ALL">All Branches</option>
                            @foreach($branches as $branch)
                                <option value="{{ strtoupper($branch) }}">{{ strtoupper($branch) }}</option>
                            @endforeach
                            <option value="OTHER">Other</option>
                        </select>
                    </div>

                    <!-- Days Filter -->
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <label for="rangeFilter" class="form-label text-muted fw-semibold mb-1">
                            <i class="fa fa-calendar text-success me-1"></i> Filter by Days
                        </label>
                        <select id="rangeFilter" class="form-control form-control-sm border-success text-dark">
                            <option value="7">Last 7 Days</option>
                            <option value="14">Last 14 Days</option>
                            <option value="30" selected>Last 30 Days</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="ibox-content text-center">
        <div id="loadingMessage" class="text-muted mb-2">Loading chart...</div>

        <!-- Responsive Chart Container -->
        <div class="chart-container">
            <canvas id="revenueChart" data-url="{{ url('monthly-branch-revenue') }}"></canvas>
        </div>
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
.chart-container {
    position: relative;
    width: 100%;
    height: 60vh; /* takes 60% of viewport height */
    min-height: 300px;
}

@media (max-width: 768px) {
    .chart-container {
        height: 50vh;
    }
    .ibox-title h5 {
        font-size: 16px;
        text-align: center;
    }
    #branchFilter, #rangeFilter {
        width: 100%;
    }
    .ibox-title .form-label {
        font-size: 13px;
    }
}

/* Filters Styling */
#branchFilter, #rangeFilter {
    border-radius: 6px;
    transition: all 0.2s ease-in-out;
}

#branchFilter:focus, #rangeFilter:focus {
    border-color: #1AB394;
    box-shadow: 0 0 0 0.15rem rgba(26, 179, 148, 0.25);
    background-color: #f9fdfb;
    font-size: 15px;
    color: #000;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let chartInstance = null;

function getColor(branch) {
    const colors = {
        MBS: '#1AB394',
        KSM: '#1C84C6',
        ELD: '#F8AC59',
        NAI: '#ED5565',
        OTHER: '#23C6C8'
    };
    if (!colors[branch]) {
        const hash = [...branch].reduce((a, c) => a + c.charCodeAt(0), 0);
        colors[branch] = `hsl(${hash % 360}, 60%, 55%)`;
    }
    return colors[branch];
}

function loadChart(days = 30, branch = 'ALL') {
    const chartUrl = document.getElementById('revenueChart').dataset.url;
    const loadingMsg = document.getElementById('loadingMessage');
    loadingMsg.innerText = 'Loading chart...';

    fetch(`${chartUrl}?days=${days}`)
        .then(res => res.json())
        .then(data => {
            loadingMsg.innerText = '';

            const branches = Object.keys(data);
            const labels = [...new Set(Object.values(data).flat().map(d => d.date))].sort();
            const selectedBranches = branch === 'ALL' ? branches : [branch];

            const datasets = selectedBranches.map(b => ({
                label: b,
                data: labels.map(date => {
                    const record = data[b]?.find(d => d.date === date);
                    return record ? record.amount : 0;
                }),
                borderColor: getColor(b),
                backgroundColor: getColor(b) + '33',
                borderWidth: 2,
                fill: true,
                tension: 0.3,
                pointRadius: 3,
                pointHoverRadius: 6
            }));

            const ctx = document.getElementById('revenueChart').getContext('2d');
            if (chartInstance) chartInstance.destroy();

            chartInstance = new Chart(ctx, {
                type: 'line',
                data: { labels, datasets },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    resizeDelay: 200,
                    interaction: { mode: 'nearest', intersect: false },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                pointStyle: 'circle',
                                font: { size: window.innerWidth < 768 ? 10 : 13 }
                            }
                        },
                        title: {
                            display: true,
                            text: `Daily Revenue (${branch === 'ALL' ? 'All Branches' : branch}) - Last ${days} Days`,
                            color: '#333',
                            font: { 
                                size: window.innerWidth < 768 ? 14 : 18, 
                                weight: 'bold' 
                            }
                        },
                        tooltip: {
                            backgroundColor: '#1AB394',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            titleFont: { weight: 'bold', size: 13 },
                            bodyFont: { size: 13 },
                            padding: 10,
                            displayColors: false,
                            callbacks: {
                                title: (context) => `Date: ${context[0].label}`,
                                label: (context) => `Revenue: Ksh ${context.parsed.y.toLocaleString()}`
                            }
                        }
                    },
                    scales: {
                        x: {
                            title: { display: true, text: 'Date' },
                            ticks: { 
                                autoSkip: true, 
                                maxTicksLimit: window.innerWidth < 768 ? 6 : 10 
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: { display: true, text: 'Revenue (Ksh)' },
                            ticks: {
                                callback: value => 'Ksh ' + value.toLocaleString(),
                                font: { size: window.innerWidth < 768 ? 10 : 12 }
                            }
                        }
                    }
                }
            });
        })
        .catch(() => {
            loadingMsg.innerText = 'Failed to load data.';
        });
}

loadChart();

// Filter change listeners
document.getElementById('branchFilter').addEventListener('change', function() {
    loadChart(document.getElementById('rangeFilter').value, this.value);
});

document.getElementById('rangeFilter').addEventListener('change', function() {
    loadChart(this.value, document.getElementById('branchFilter').value);
});

// Resize listener for dynamic font resizing
window.addEventListener('resize', () => {
    if (chartInstance) {
        chartInstance.options.plugins.title.font.size = window.innerWidth < 768 ? 14 : 18;
        chartInstance.options.plugins.legend.labels.font.size = window.innerWidth < 768 ? 10 : 13;
        chartInstance.update();
    }
});
</script>
@endsection
