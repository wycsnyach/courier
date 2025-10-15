@extends('layouts.inspinia')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2>Parcels</h2>
    <ol class="breadcrumb">
      <li><a href="{{ url('/home') }}">Home</a></li>
      <li><a>Parcels</a></li>
      <li class="active"><strong>Edit</strong></li>
    </ol>
  </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
  <div class="ibox float-e-margins">
    <div class="ibox-title"><h5>Edit Parcel</h5></div>
    <div class="ibox-content">
      {!! Form::model($parcel, ['method' => 'PATCH', 'route' => ['parcels.update', $parcel->id], 'class' => 'form-horizontal']) !!}

        <div class="form-group col-md-12">
          <div class="form-md-line-input col-md-4">
            <label class="control-label">Reference Number</label>
            <input type="text" name="reference_number" class="form-control" value="{{ $parcel->reference_number }}" readonly>
          </div>

          <div class="form-md-line-input col-md-4">
            <label class="control-label">Parcel Type</label>
            <select name="type" class="form-control" required>
              <option value="1" {{ $parcel->type == 1 ? 'selected' : '' }}>Outgoing</option>
              <option value="2" {{ $parcel->type == 2 ? 'selected' : '' }}>Incoming</option>
            </select>
          </div>

          <div class="form-md-line-input col-md-4">
            <label class="control-label">Status</label>
            <select name="status" class="form-control">
                <option value="">-- Select Status --</option>
                <option value="0" {{ $parcel->status == 0 ? 'selected' : '' }}>Pending</option>
                <option value="1" {{ $parcel->status == 1 ? 'selected' : '' }}>In Transit</option>
                <option value="2" {{ $parcel->status == 2 ? 'selected' : '' }}>Delivered</option>
                <option value="3" {{ $parcel->status == 3 ? 'selected' : '' }}>Returned</option>

            </select>
          </div>
        </div>

        <div class="form-group col-md-12">
          <div class="form-md-line-input col-md-4">
            <label class="control-label">Sender Name</label>
            <input type="text" name="sender_name" class="form-control" value="{{ $parcel->sender_name }}" required>
          </div>

          <div class="form-md-line-input col-md-4">
            <label class="control-label">Sender Address</label>
            <input type="text" name="sender_address" class="form-control" value="{{ $parcel->sender_address }}" required>
          </div>

          <div class="form-md-line-input col-md-4">
            <label class="control-label">Sender Contact</label>
            <input type="text" name="sender_contact" class="form-control" value="{{ $parcel->sender_contact }}" required>
          </div>
        </div>

        <div class="form-group col-md-12">
          <div class="form-md-line-input col-md-4">
            <label class="control-label">Recipient Name</label>
            <input type="text" name="recipient_name" class="form-control" value="{{ $parcel->recipient_name }}" required>
          </div>

          <div class="form-md-line-input col-md-4">
            <label class="control-label">Recipient Address</label>
            <input type="text" name="recipient_address" class="form-control" value="{{ $parcel->recipient_address }}" required>
          </div>

          <div class="form-md-line-input col-md-4">
            <label class="control-label">Recipient Contact</label>
            <input type="text" name="recipient_contact" class="form-control" value="{{ $parcel->recipient_contact }}" required>
          </div>
        </div>

        <div class="form-group col-md-12">
          <div class="form-md-line-input col-md-4">
            <label class="control-label">From Branch</label>
            <select name="from_branch_id" class="form-control fstdropdown-select" required>
              @foreach($branches as $branch)
                <option value="{{ $branch->id }}" {{ $branch->id == $parcel->from_branch_id ? 'selected' : '' }}>
                  {{ $branch->branch_code }} - {{ $branch->city }}
                </option>
              @endforeach
            </select>
            <div class="form-control-focus"></div>
          </div>

          <div class="form-md-line-input col-md-4">
            <label class="control-label">To Branch</label>
            <select name="to_branch_id" class="form-control fstdropdown-select" required>
              @foreach($branches as $branch)
                <option value="{{ $branch->id }}" {{ $branch->id == $parcel->to_branch_id ? 'selected' : '' }}>
                  {{ $branch->branch_code }} - {{ $branch->city }}
                </option>
              @endforeach
            </select>
            <div class="form-control-focus"></div>
          </div>

          <div class="form-md-line-input col-md-4">
            <label class="control-label">Weight (Kg)</label>
            <input type="text" name="weight" class="form-control" value="{{ $parcel->weight }}" required>
          </div>
        </div>

        <div class="form-group col-md-12">
          <div class="form-md-line-input col-md-4">
            <label class="control-label">Height (cm)</label>
            <input type="text" name="height" class="form-control" value="{{ $parcel->height }}" required>
          </div>

          <div class="form-md-line-input col-md-4">
            <label class="control-label">Width (cm)</label>
            <input type="text" name="width" class="form-control" value="{{ $parcel->width }}" required>
          </div>

          <div class="form-md-line-input col-md-4">
            <label class="control-label">Length (cm)</label>
            <input type="text" name="length" class="form-control" value="{{ $parcel->length }}" required>
          </div>
        </div>

        <div class="form-group col-md-12">
          <div class="form-md-line-input col-md-4">
            <label class="control-label">Price</label>
            <input type="number" name="price" class="form-control" value="{{ $parcel->price }}" step="0.01" required>
          </div>

          <div class="form-md-line-input col-md-4">
            <label class="control-label">Status</label>
            <input type="number" name="price" class="form-control" value="{{ $parcel->price }}" step="0.01" required>
          </div>
        </div>

        <div class="hr-line-dashed"></div>
        <div class="form-group">
          <div class="col-sm-6 col-sm-offset-2">
            <a href="{{ route('parcels.index') }}" class="btn btn-white">Cancel</a>
            <button class="btn btn-primary" type="submit">Update</button>
            <a href="{{ route('parcels.index') }}"><button class="btn btn-danger" type="button">Back</button></a>
          </div>
        </div>

      {!! Form::close() !!}
    </div>
  </div>
</div>
@endsection
