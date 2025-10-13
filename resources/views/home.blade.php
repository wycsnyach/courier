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


</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


</div>
@endsection
