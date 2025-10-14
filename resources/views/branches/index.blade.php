@extends('layouts.inspinia')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2 style="color:#1AB394;"><strong>Branches</strong></h2>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}">Home</a> <i class="fa fa-play-circle" style="color:#1AB394;"></i></li>
      <li><a>Settings</a></li>
      <li class="active"><strong>Branches</strong></li>
    </ol>
  </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
  <div class="ibox float-e-margins">
    <div class="ibox-title">
      <div class="ibox-tools">

        <a href="{{route('branches.create')}}" class="btn btn-primary btn-xs active">Add Branch <i class="fa fa-plus"></i></a>
        <a href="{{ route('home') }}" class="btn btn-danger btn-xs active">Home <i class="fa fa-level-up"></i></a>
      </div>
    </div>
    <div class="ibox-content">
      <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover branches">
          <thead>
            <tr class="font-bold text-navy">
              <th>Branch Code</th>
              <th>City</th>
              <th>Country</th>
              <th>Contact</th>
              <th>Date Created</th>
              <th width="12%">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($branches as $branch)
              <tr>
                <td>{{$branch->branch_code}}</td>
                <td>{{$branch->city}}</td>
                <td>{{$branch->country_name}}</td>
                <td>{{$branch->contact}}</td>
                <td>{{ $branch->created_at ? $branch->created_at->format('Y-m-d') : '' }}</td>
                <td>
                  <a href="{{route('branches.edit',$branch->id)}}" class="btn btn-primary btn-xs">Edit</a>
                  {!! Form::open(['method'=>'DELETE','route'=>['branches.destroy',$branch->id],'style'=>'display:inline','onsubmit'=>'return ConfirmDelete()']) !!}
                    {!! Form::submit('Delete',['class'=>'btn btn-danger btn-xs']) !!}
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
@endsection

@section('scripts')
<script src="{{asset('inspinia/js/plugins/dataTables/datatables.min.js')}}"></script>
<script>
$(document).ready(function(){
  $('.branches').DataTable({
    pageLength:10,
    responsive:true,
    dom:'<"html5buttons"B>lTfgitp',
    buttons:['copy','csv','excel','pdf','print']
  });
});
</script>
@endsection
