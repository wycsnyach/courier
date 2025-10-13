@extends('layouts.inspinia')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
<div class="col-lg-10">
    <h2 style="color:#1AB394;"><strong>Email Management</strong></h2>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('/home')}}">Home</a>
            <i class="fa fa-play-circle" style="color:#1AB394;"></i>
        </li>
        <li>
            <a>Settings</a>
        </li>
        <li class="active">
            <strong>Email</strong>
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
             <a href="{{Route('emails.create')}}" class="btn btn-primary btn-xs active">Add Email <i class="fa fa-plus"></i></a>
             <a href="{{Route('home')}}" class="btn btn-danger btn-xs active">Home <i class="fa fa-level-up"></i></a> 
            
        </div>
    </div>
    <div class="ibox-content">

        <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover emails" >
    <thead>
    <tr class="font-bold text-navy">
        <th>SUBJECT</th> 
        <th>RECIPIENT</th>
        <th>SENDER</th>   
        <TH>EMAIL</TH>    
        <th>SENT AT</th>
        
        <th width="6%">ACTIONS</th>
    </thead>
    <tbody>

        @foreach($emails as $email)
                <tr class="gradeX">
                    <td>{{ $email->subject }}</td>
                    <td>{{ $email->recipient }}</td>
                    <td>{{ $email->sender }}</td>
                    <td>{{ ucfirst($email->message) }}</td>
                    <td width="8%">{{ $email->created_at->format('d-m-Y') }}</td>

                    <td>
    <a href="{{route('emails.show',$email->id)}}" target="blank"><button class="btn btn-xs btn-success active"><i class="fa fa-eye" aria-hidden="true" title="View Mail"> View</i></button></a>
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
    $('.emails').DataTable({
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
