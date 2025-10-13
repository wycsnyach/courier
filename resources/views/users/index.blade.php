@extends('layouts.inspinia')
@section('content')
<?php use App\Http\Controllers\Controller; ?>
     <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2 style="color:#1AB394;"><strong>Users</strong></h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{url('/home')}}">Home</a>
                            <i class="fa fa-play-circle" style="color:#1AB394;"></i>
                        </li>
                        <li>
                            <a>Users</a>
                        </li>
                        <li class="active">
                            <strong>All</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
      </div>
      <div class="row">
            <p>
              
            </p>
        </div>

             <!-- 
        USERS COUNT START
        ---------------------------------------------------------------------------------------------------------------------------
        -->
        <div class="wrapper  animated fadeInRight">
              <div class="row">
                @if(Bouncer::can('Create_User')) 
                
                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-success pull-right">All Users</span>
                            <h5>All Users</h5>
                        </div>
                        <div class="ibox-content">
                            <h3 class="no-margins"> {{$user->users_count()}}</h3>
                            <div class="stat-percent font-bold text-success"> {{$user->users_count()}} <i class="fa fa-bolt"></i></div>
                            <a href="{{Route('users.index')}}"><small>Users</small></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">Active Users</span>
                            <h5>Active Users</h5>
                        </div>
                        <div class="ibox-content">
                            <h4 class="no-margins">{{$user->total_active_members()}}</h4>
                            <div class="stat-percent font-bold text-info"> {{$user->total_active_members()}} <i class="fa fa-level-up"></i></div>
                            <a href="{{Route('users.index')}}"><small>Users</small></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">Inactive Users</span>
                            <h5>Inactive Users</h5>
                        </div>
                        <div class="ibox-content">
                            <h4 class="no-margins">{{$user->total_inactive_members()}}</h4>
                            <div class="stat-percent font-bold text-info"> {{$user->total_inactive_members()}} <i class="fa fa-level-up"></i></div>
                            <a href="{{Route('users.index')}}"><small>Users</small></a>
                        </div>
                    </div>
                </div>

                 @endif 
             </div>
         </div>
         <!-- 
         END ========================================================================================================================
          -->   
            
            
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">

                     <div class="ibox-tools">
                          <a class="btn btn-primary btn-xs" href="{{ route('users.create')}}">Register <i class="fa fa-plus"></i></a>
                        

                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#">Config option 1</a>
                                </li>
                                <li><a href="#">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
<table class="table table-striped table-bordered table-hover users" >
      <thead>
    <tr class="font-bold text-navy">

            <th>USER ID</th>
            <th>FULL NAME</th>
            <th>EMAIL</th>
            <th>PHONE</th>
            <th>ROLE</th>
            <th>STATUS</th>
            <th width="12%">ACTIONS</th>
          
        </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
        <td>{{$user->id}}</td>
        <td>{{$user->first_name}} {{$user->middle_name}} {{$user->last_name}}</td>
        <td>{{$user->email}}</td>
        <td>{{$user->phone_number}}</td>
        <td>{{substr($user->getRoles(), 2, -2)}}</td>
        <td>{{$user->active}}</td>
        <td>
<a href="{{route('users.edit',$user->id)}}"><button class="btn btn-warning btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i></button></a>

<a href="{{url('users/password-reset/'.$user->email.'/'.$user->id)}}" onClick ='return ConfirmReset()'><button class="btn btn-primary btn-xs"><i class="fa fa-unlock" aria-hidden="true"></i></button></a>


{!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline', 'onsubmit' => 'return ConfirmDelete()']) !!}
<button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>         
{!! Form::close() !!}

                        </td>                                                   
                        </tr>
                    @endforeach
                
                    </tbody>
                    <tfoot>                   
                    
                    </tfoot>
                    </table>
                        </div>                      

                    </div>
                </div>
            </div>
            </div>
        </div>
        

@endsection

@section('scripts')

<script src="{{asset('inspinia/js/plugins/dataTables/datatables.min.js')}}"></script>
<script>
$(document).ready(function(){
    $('.users').DataTable({
        pageLength: 10,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [
            { extend: 'copy'},
            {extend: 'csv'},
            {extend: 'excel', title: 'ExampleFile'},
            {extend: 'pdf', title: 'ExampleFile'},

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

@endsection
