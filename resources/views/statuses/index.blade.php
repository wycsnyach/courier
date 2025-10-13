@extends('layouts.inspinia')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
<div class="col-lg-10">
    <h2 style="color:#1AB394;"><strong>Status</strong></h2>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('/home')}}">Home</a>
            <i class="fa fa-play-circle" style="color:#1AB394;"></i>
        </li>
        <li>
            <a>Settings</a>
        </li>
        <li class="active">
            <strong>Status</strong>
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
             <a href="{{Route('statuses.create')}}" class="btn btn-primary btn-xs active">Add Status <i class="fa fa-plus"></i></a>
            
        </div>
    </div>
    <div class="ibox-content">

        <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover statuses" >
    <thead>
    <tr class="font-bold text-navy">
        <th>NAME</th>        
        
        <th width="12%">ACTIONS</th>
    </thead>
    <tbody>

          @foreach($statuses as $status)
                                                    <tr class="gradeX">
                                                    <td>{{$status->name}}</td>
                                                   

                                                    <td>
    <a href="{{route('statuses.edit',$status->id)}}"><button class="btn btn-primary  btn-xs active">Edit</button></a>

    

    {!! Form::open(['method' => 'DELETE','route' => ['statuses.destroy', $status->id],'style'=>'display:inline', 'onsubmit' => 'return ConfirmDelete()']) !!}
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
    $('.statuses').DataTable({
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