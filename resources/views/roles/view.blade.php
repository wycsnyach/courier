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
                   
        <div class="ibox-tools">           

           <label class="col-md-3"> Role Name </label>  
                                        
                                           
        <input type="text" name="rolename" class="col-md-6" value="{{$role->name}}" onChange="update_rolename('{{$role->id}}',this.value)" disabled> 
          
           <a href="{{Route('roles.index')}}"><button class="btn btn-primary" type="button">Back</button></a>                                 
            
        </div>
    </div>
    <div class="ibox-content">

        <div class="table-responsive">
<table class="table table-striped table-bordered table-hover roles" >
    <thead>
        <tr>
            <th class="all">Model</th>
            <th class="all">Create</th>
            <th class="all">View</th>
            <th class="all">Edit</th>
            <th class="all">Delete</th>
            
        </tr>
    </thead>
        <tbody>

        @foreach($mos as $mo)

        
            <tr>
            <td> 
            <label>{{$mo->friendly}}</label>                                            
           <input type="hidden" name="mo[]" value="{{$mo->name}}">
            </td>
            <td><label class="mt-checkbox">
                    <input type="checkbox" name="{{$mo->name}}[]" value="Create" onchange="update_role('{{$role->id}}','{{$mo->name}}','Create')" {{Controller::can_model($mo->name,"Create",$role)}} disabled> 
                    <span></span>
                </label></td>
            <td><label class="mt-checkbox">
                    <input type="checkbox" name="{{$mo->name}}[]" value="View" onchange="update_role('{{$role->id}}','{{$mo->name}}','View')" {{Controller::can_model($mo->name,"View",$role)}} disabled>
                    <span></span>
                </label></td>
            <td><label class="mt-checkbox">
                    <input type="checkbox" name="{{$mo->name}}[]" value="Edit" onchange="update_role('{{$role->id}}','{{$mo->name}}','Edit')" {{Controller::can_model($mo->name,"Edit",$role)}} disabled>
                    <span></span>
                </label>
            </td>
             <td><label class="mt-checkbox">
                    <input type="checkbox" name="{{$mo->name}}[]" value="Delete" onchange="update_role('{{$role->id}}','{{$mo->name}}','Delete')" {{Controller::can_model($mo->name,"Delete",$role)}} disabled>
                    <span></span>
                </label>
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



function update_role(role_id,model,action){

  

   $.ajax({

        url     : "{{ url('update-permission')}}",
        method  : 'post',
        data    : {

       role_id:role_id,
         model:model,
        action:action

        },
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success : function(response){
           
          
        }
    });
    
} 

function update_rolename(role_id,rolename){

  

   $.ajax({

        url     : "{{ url('update-role')}}",
        method  : 'post',
        data    : {

       role_id:role_id,
       rolename:rolename,
      

        },
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success : function(response){
           
          
        }
    });
    
} 

</script>

@endsection

