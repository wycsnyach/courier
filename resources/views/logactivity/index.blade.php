@extends('layouts.inspinia')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
<div class="col-lg-12">
    <h2 style="color:#1AB394;"><strong>Log Activity Management</strong></h2>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('/home')}}">Home</a>
            <i class="fa fa-play-circle" style="color:#1AB394;"></i>
        </li>
        
        <li class="active">
            <strong>Log Activity</strong>
        </li>
    </ol>
    
</div>

</div>
<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
<div class="col-lg-6">
<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5></h5>
        <div class="ibox-tools">
            <a href="{{Route('home')}}" class="btn btn-danger btn-xs active">Home <i class="fa fa-level-up"></i></a> 
            
        </div>
    </div>
    <div class="ibox-content">

        <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover logActivities">
        <thead>
            <tr class="font-bold text-navy">
                <th>#</th>
                <th>USER</th>
                <th>LOGIN TIME</th>
                <th>LOGOUT TIME</th>
                <th>IP ADDRESS</th>
                <th>COUNTRY</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logActivities as $log)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $log->firstname }} {{ $log->middlename }} {{ $log->lastname }}</td>
                    <td>{{ $log->login_time }}</td>
                    <td>{{ $log->logout_time }}</td>
                    <td>{{ $log->ip_address }}</td>
                    <td>{{ $log->country }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
 </div>

    </div>
</div>
</div>

<div class="col-lg-6">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5 style="color:#1AB394;">Logins This Month</h5>
        </div>
        <div class="ibox-content">
            <canvas id="loginsChart" height="225"></canvas>
        </div>
    </div>
</div>

</div>
</div>

                              
@endsection

@section('scripts')

<script src="{{asset('inspinia/js/plugins/dataTables/datatables.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function(){
    $('.logActivities').DataTable({
        pageLength: 10,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [
            { extend: 'copy'},
            {extend: 'csv'},
            {extend: 'excel', title: 'Exampletransferin'},
            {extend: 'pdf', title: 'Exampletransferin'},

            {extend: 'print',
             customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
            }
            }
        ]

    });

});

</script>

<script>
    const ctx = document.getElementById('loginsChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($plotLabels),
            datasets: [
                {
                    label: 'Daily Logins',
                    data: @json($plotData),
                    borderColor: 'rgba(26, 179, 148, 1)',
                    backgroundColor: 'rgba(26, 179, 148, 0.3)',
                    fill: true,
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true
                }
                /*title: {
                    display: true,
                    text: 'Logins This Month'
                }*/
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Day Of The Month'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Logins Count'
                    }
                }
            }
        }
    });
</script>


@endsection