@extends('layouts.inspinia')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2 style="color:#1AB394;"><strong> Branch Management</strong></h2>
    <ol class="breadcrumb">
      <li><a href="{{ url('/home') }}">Home</a></li>
      <li><a>Branches</a></li>
      <li class="active"><strong>Create</strong></li>
    </ol>
  </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight"></div>

<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>Create Branch</h5>
        <div class="ibox-tools">
         
          <a href="{{ route('home') }}" class="btn btn-danger btn-xs active">Home <i class="fa fa-level-up"></i></a>
          <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          <a class="close-link"><i class="fa fa-times"></i></a>
        </div>
      </div>

      <div class="ibox-content">
        {!! Form::open(['route' => 'branches.store', 'method' => 'POST', 'class' => 'form-horizontal']) !!}

          <div class="form-group col-md-12">
            <div class="form-md-line-input col-md-4">
              <label class="control-label">Branch Code</label>
              <input type="text" name="branch_code" class="form-control" value="{{ old('branch_code') }}" required placeholder="Enter Branch Code">
            </div>

            <div class="form-md-line-input col-md-4">
              <label class="control-label">Street</label>
              <input type="text" name="street" class="form-control" value="{{ old('street') }}" placeholder="Street address">
            </div>
            <div class="form-md-line-input col-md-4">
              <label class="control-label">City</label>
              <input type="text" name="city" class="form-control" value="{{ old('city') }}" required placeholder="City">
            </div>

          </div>

          <div class="form-group col-md-12">
            
            <div class="form-md-line-input col-md-4">
              <label class="control-label">State</label>
              <input type="text" name="state" class="form-control" value="{{ old('state') }}" required placeholder="State">
            </div>

            <div class="form-md-line-input col-md-4">
              <label class="control-label">ZIP Code</label>
              <input type="text" name="zip_code" class="form-control" value="{{ old('zip_code') }}" required placeholder="Zip / Postal Code">
            </div>

            <div class="form-md-line-input col-md-4">
              
                <label class="control-label">Country</label>
                <select name="country_id" class="form-control fstdropdown-select" required>
                    <option value="">-- Select Country --</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>
                <div class="form-control-focus"></div>
            

            </div>
          </div>

          <div class="form-group col-md-12">
            

            <div class="form-md-line-input col-md-4">
              <label class="control-label">Contact</label>
              <input type="text" name="contact" class="form-control" value="{{ old('contact') }}" required placeholder="Contact phone/email">
            </div>
          </div>

          <div class="hr-line-dashed"></div>

          <div class="form-group">
            <div class="col-sm-6 col-sm-offset-2">
              <button class="btn btn-white" type="reset">Cancel</button>
              <button class="btn btn-primary" type="submit">Save changes</button>
              <a href="{{ route('branches.index') }}"><button class="btn btn-danger" type="button">Back</button></a>
            </div>
          </div>

        {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>

@endsection
