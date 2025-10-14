@extends('layouts.inspinia')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2>Branches</h2>
    <ol class="breadcrumb">
      <li><a href="{{ url('/home') }}">Home</a></li>
      <li><a>Branches</a></li>
      <li class="active"><strong>Edit</strong></li>
    </ol>
  </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
  <div class="ibox float-e-margins">
    <div class="ibox-title"><h5>Edit Branch</h5></div>
    <div class="ibox-content">
      {!! Form::model($branch, ['method' => 'PATCH', 'route' => ['branches.update', $branch->id], 'class' => 'form-horizontal']) !!}

        <div class="form-group col-md-12">
          <div class="form-md-line-input col-md-4">
            <label class="control-label">Branch Code</label>
            <input type="text" name="branch_code" class="form-control" value="{{ $branch->branch_code }}" required>
          </div>

          <div class="form-md-line-input col-md-4">
            <label class="control-label">Street</label>
            <input type="text" name="street" class="form-control" value="{{ $branch->street }}" required>
          </div>
           <div class="form-md-line-input col-md-4">
            <label class="control-label">City</label>
            <input type="text" name="city" class="form-control" value="{{ $branch->city }}" required>
          </div>
        </div>

        <div class="form-group col-md-12">
         

          <div class="form-md-line-input col-md-4">
            <label class="control-label">State</label>
            <input type="text" name="state" class="form-control" value="{{ $branch->state }}" required>
          </div>

          <div class="form-md-line-input col-md-4">
            <label class="control-label">ZIP Code</label>
            <input type="text" name="zip_code" class="form-control" value="{{ $branch->zip_code }}" required>
          </div>

             <div class="form-md-line-input col-md-4">
            <label class="control-label">Country</label>
            <select name="country_id" class="form-control fstdropdown-select" required>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}" {{ $country->id == $branch->country_id ? 'selected' : '' }}>
                        {{ $country->name }}
                    </option>
                @endforeach
            </select>
            <div class="form-control-focus"></div>
        </div>
        </div>

        <div class="form-group col-md-12">
       


          <div class="form-md-line-input col-md-4">
            <label class="control-label">Contact</label>
            <input type="text" name="contact" class="form-control" value="{{ $branch->contact }}" required>
          </div>
        </div>

        <div class="hr-line-dashed"></div>
        <div class="form-group">
          <div class="col-sm-6 col-sm-offset-2">
            <a href="{{ route('branches.index') }}" class="btn btn-white">Cancel</a>
            <button class="btn btn-primary" type="submit">Update</button>
            <a href="{{ route('branches.index') }}"><button class="btn btn-danger" type="button">Back</button></a>
          </div>
        </div>

      {!! Form::close() !!}
    </div>
  </div>
</div>
@endsection
