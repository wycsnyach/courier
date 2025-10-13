@extends('layouts.inspinia')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
<div class="col-lg-10">
    <h2 style="color:#1AB394;"><strong>SMS Management</strong></h2>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('/home')}}">Home</a>
            <i class="fa fa-play-circle" style="color:#1AB394;"></i>
        </li>
        <li>
            <a>Settings</a>
        </li>
        <li class="active">
            <strong>SMS</strong>
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
             <a href="{{Route('smses.create')}}" class="btn btn-primary btn-xs active">Add SMS <i class="fa fa-plus"></i></a>
            
             <a href="{{Route('home')}}" class="btn btn-danger btn-xs active">Home <i class="fa fa-level-up"></i></a> 
            
        </div>
    </div>
    <div class="ibox-content">

        <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover sms_record" >
    <thead>
    <tr class="font-bold text-navy">
        
        <th>FULL NAME</th>       
        <th>PHONE</th>
        <th>CONTRIBUTION AMOUNT</th> 
        <th width="12%">ACTIONS</th>
    </thead>
    <tbody>

          @foreach($sms_records as $sms_record)
                                                    <tr class="gradeX">
                                                    <td>{{$sms_record->first_name}} {{$sms_record->last_name}}</td>
                                                    <td>{{$sms_record->phone_number}}</td> 
                                                    <td>{{$sms_record->contribution_amount}}</td>

                                                    <td width="8%">
   <a href="#" target="blank"><button class="btn btn-xs btn-success active"><i class="fa fa-eye" aria-hidden="true" title="View SMS"></i></button></a>                                                
   


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
    $('.sms_record').DataTable({
        pageLength: 10,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [
            { extend: 'copy'},
            {extend: 'csv'},
            {extend: 'excel', title: 'Examplesms_record'},
            {extend: 'pdf', title: 'Examplesms_record'},

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