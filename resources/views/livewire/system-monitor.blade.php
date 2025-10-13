<div wire:poll.10s>
    <div class="row wrapper border-bottom white-bg page-heading">
    <div class="ibox">
        <h2 style="color:#1AB394;"><strong>Server Resource Monitor</strong></h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{url('/home')}}">Home</a>
                <i class="fa fa-play-circle" style="color:#1AB394;"></i>
            </li>
            
            <li class="active">
                <strong>Server Utilization</strong>
            </li>
        </ol>
        
    </div>
  

    <!-- <h4 class="m-b-md">Server Resource Monitor</h4> -->

   @if($alerts)
        <div class="alert alert-warning">
            @foreach(array_unique($alerts) as $alert)
                <p>{{ $alert }}</p>
            @endforeach
        </div>
    @endif


    <div class="ibox">
        <div class="ibox-title"><h5>Disk Usage</h5></div>
        <div class="ibox-content">
            <p>{{ $diskUsage['used'] }} GB used / {{ $diskUsage['free'] }} GB free</p>
            <div class="progress progress-striped active">
                <div class="progress-bar progress-bar-danger" style="width: {{ $diskUsage['percent'] }}%">
                    {{ $diskUsage['percent'] }}%
                </div>
            </div>
        </div>
    </div>

    <div class="ibox">
        <div class="ibox-title"><h5>RAM Usage</h5></div>
        <div class="ibox-content">
            <p>{{ $memoryUsage['used'] }} MB used / {{ $memoryUsage['available'] }} MB available</p>
            <div class="progress progress-striped active">
                <div class="progress-bar progress-bar-info" style="width: {{ $memoryUsage['percent'] }}%">
                    {{ $memoryUsage['percent'] }}%
                </div>
            </div>
        </div>
    </div>

    <div class="ibox">
        <div class="ibox-title"><h5>CPU Load (1-min)</h5></div>
        <div class="ibox-content">
            <p>Load: {{ $cpuLoad }}</p>
            <div class="progress progress-striped active">
                <div class="progress-bar progress-bar-success" style="width: {{ min($cpuLoad * 20, 100) }}%">
                    {{ $cpuLoad }}
                </div>
            </div>
        </div>
    </div>
</div>
</div>