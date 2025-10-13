@extends('layouts.inspinia')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
<div class="col-lg-12">
    <h2 style="color:#1AB394;"><strong>Email Management</strong></h2>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('/home')}}">Home</a>
            <i class="fa fa-play-circle" style="color:#1AB394;"></i>
        </li>
        <li>
            <a>Email</a>
        </li>
        <li class="active">
            <strong>Email Details</strong>
        </li>
    </ol>
    <p>
        
    </p>
   
</div>

</div>
<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
<div class="col-lg-12">
<div class="ibox float-e-margins" style="border: 2px solid #1AB394; padding: 15px;">
    <div class="ibox-title">
        <h5></h5>
        <div class="ibox-tools">
            <a href="{{ url()->previous() }}" class="btn btn-primary btn-xs active">Back <i class="fa fa-level-up"></i></a>
             <a href="{{Route('home')}}" class="btn btn-danger btn-xs active">Home <i class="fa fa-home"></i></a> 
            
        </div>
    </div>
    <div class="ibox-content">

        <div class="table-responsive">
    <h3 style="color:#1AB394;">Email Content Details</h3>
    <hr>
    <form>
        
        <div class="form-row">
            <div class="form-group col-md-3 border p-2">
                <label for="subject">Subject</label>
                <input type="text" class="form-control" id="subject" value="{{ $emails->subject }}"  readonly>
            </div>
            <div class="form-group col-md-3 border p-2">
                <label for="recipient">Recipient Address</label>
                <input type="email" class="form-control" id="recipient" value="{{ $emails->recipient }}" readonly>
            </div>
            <div class="form-group col-md-3 border p-2">
                <label for="sender">Sender</label>
                <input type="text" class="form-control" id="sender" value="{{ $emails->sender }}" readonly>
            </div>
            <div class="form-group col-md-3 border p-2">
                <label for="created_at">Date</label>
                <input type="text" class="form-control" id="created_at" value="{{ $emails->created_at->format('d-m-Y') }}" readonly>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12 border p-2">
                <label for="message">Message</label>
                <textarea class="form-control" id="message" rows="8" readonly>{{ $emails->message }}</textarea>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-3 border p-2">
                <label for="status">Status</label>
                <input type="text" class="form-control" id="status" value="{{ $emails->status }}" readonly>
            </div>
            
        </div>        
        
    <hr>

  </form>

</div>
</div>
</div>
</div>
</div>
</div>

@endsection
