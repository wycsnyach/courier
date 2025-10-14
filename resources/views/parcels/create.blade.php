@extends('layouts.inspinia')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2 style="color:#1AB394;"><strong>Parcel Management</strong></h2>
    <ol class="breadcrumb">
      <li><a href="{{ url('/home') }}">Home</a></li>
      <li><a>Parcels</a></li>
      <li class="active"><strong>Create</strong></li>
    </ol>
  </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
  <div class="ibox float-e-margins">
    <div class="ibox-title">
      <h5>Create Parcel</h5>
      <div class="ibox-tools">
        <a href="{{ route('parcels.index') }}" class="btn btn-danger btn-xs">Back <i class="fa fa-level-up"></i></a>
        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
        <a class="close-link"><i class="fa fa-times"></i></a>
      </div>
    </div>

    <div class="ibox-content">
      {!! Form::open(['route' => 'parcels.store', 'method' => 'POST', 'class' => 'form-horizontal']) !!}

      <div class="form-group col-md-12">
        <div class="col-md-4">
          <label>Reference Number</label>
          <input type="text" name="reference_number" class="form-control" required>
        </div>

        <div class="col-md-4">
          <label>Parcel Type</label>
          <select name="type" class="form-control" required>
            <option value="">-- Select Type --</option>
            <option value="1">Outgoing</option>
            <option value="2">Incoming</option>
          </select>
        </div>

        <div class="col-md-4">
          <label>Price</label>
          <input type="number" name="price" step="0.01" class="form-control" required>
        </div>
      </div>

      <div class="form-group col-md-12">
        <div class="col-md-4">
          <label>Sender Name</label>
          <input type="text" name="sender_name" class="form-control" required>
        </div>
        <div class="col-md-4">
          <label>Sender Address</label>
          <input type="text" name="sender_address" class="form-control" required>
        </div>
        <div class="col-md-4">
          <label>Sender Contact</label>
          <input type="text" name="sender_contact" class="form-control" required>
        </div>
      </div>

      <div class="form-group col-md-12">
        <div class="col-md-4">
          <label>Recipient Name</label>
          <input type="text" name="recipient_name" class="form-control" required>
        </div>
        <div class="col-md-4">
          <label>Recipient Address</label>
          <input type="text" name="recipient_address" class="form-control" required>
        </div>
        <div class="col-md-4">
          <label>Recipient Contact</label>
          <input type="text" name="recipient_contact" class="form-control" required>
        </div>
      </div>

      <div class="form-group col-md-12">
        <div class="col-md-4">
          <label>From Branch</label>
          <select name="from_branch_id" class="form-control" required>
            <option value="">-- Select Branch --</option>
            @foreach($branches as $branch)
              <option value="{{ $branch->id }}">{{ $branch->branch_code }} - {{ $branch->city }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-4">
          <label>To Branch</label>
          <select name="to_branch_id" class="form-control" required>
            <option value="">-- Select Branch --</option>
            @foreach($branches as $branch)
              <option value="{{ $branch->id }}">{{ $branch->branch_code }} - {{ $branch->city }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-4">
          <label>Weight (Kg)</label>
          <input type="text" name="weight" class="form-control" required>
        </div>
      </div>

      <div class="form-group col-md-12">
        <div class="col-md-4">
          <label>Height (cm)</label>
          <input type="text" name="height" class="form-control" required>
        </div>
        <div class="col-md-4">
          <label>Width (cm)</label>
          <input type="text" name="width" class="form-control" required>
        </div>
        <div class="col-md-4">
          <label>Length (cm)</label>
          <input type="text" name="length" class="form-control" required>
        </div>
      </div>

      <div class="hr-line-dashed"></div>
      <div class="form-group">
        <div class="col-sm-6 col-sm-offset-2">
          <button class="btn btn-white" type="reset">Cancel</button>
          <button class="btn btn-primary" type="submit">Save Parcel</button>
          <a href="{{ route('parcels.index') }}"><button class="btn btn-danger" type="button">Back</button></a>
        </div>
      </div>

      {!! Form::close() !!}
    </div>
  </div>
</div>
@endsection
