@extends('layouts.inspinia')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
<div class="col-lg-10">
    <h2>Roles</h2>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('/home')}}">Home</a>
        </li>
        <li>
            <a>Settings</a>
        </li>
        <li class="active">
            <strong>Roles</strong>
        </li>
    </ol>
</div>

</div>
<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
<div class="col-lg-12">
<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5></h5>
        <div class="ibox-tools">
             <a href="{{Route('roles.create')}}" class="btn btn-primary btn-sm active">Add New Role<i class="fa fa-plus"></i></a>
            
        </div>
    </div>
    <div class="ibox-content">

        <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover roles" >
    <thead>
    <tr>
        <th>Role</th>
        <th>Last Updated</th>
        <th width="20%">Actions</th>
    </thead>
    <tbody>

          @foreach($roles as $role)
                                                    <tr class="gradeX">
                                                    <td>{{$role->title}}</td>
                                                    <td>{{$role->updated_at}}</td> 

                                                    <td>
    <a href="{{route('roles.edit',$role->id)}}"><button class="btn btn-primary  btn-xs active">Edit Abilities</button></a>

    <a href="{{route('roles.show',$role->id)}}"><button class="btn btn-success btn-xs active">View Abilities</button></a>


    {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline', 'onsubmit' => 'return ConfirmDelete()']) !!}
    {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs active']) !!}
    {!! Form::close() !!}


                                                    </td>                                                 
                                                    </tr>
                                                @endforeach


   
      
 
    </tbody>
  
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
    $('.roles').DataTable({
        pageLength: 25,
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