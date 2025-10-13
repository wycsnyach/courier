@extends('layouts.inspinia')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Users</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index.html">Home</a>
                        </li>
                        <li>
                            <a>Password</a>
                        </li>
                        <li class="active">
                            <strong>Change</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

          </div>
</div>


<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                                             

                        <div class="ibox-tools">


                            
                        </div>
                    </div>
                    <div class="ibox-content">

                     

                                 @if (count($errors) > 0)

    <div class="alert alert-danger">

      <strong>Whoops!</strong> There were some problems with your input.<br><br>

      <ul>

        @foreach ($errors->all() as $error)

          <li>{{ $error }}</li>

        @endforeach

      </ul>

    </div>

  @endif



  {!! Form::open(['method' => 'POST','url' => ['users/password-update']]) !!}



  <div class="row">

    <div class="col-md-12">

            <div class="form-group">
                <strong>Current Password:</strong>
         <input " type="password" class="form-control" name="current_password" required>

            </div>

        </div>

         <div class="col-md-12" id="pwd-container1">

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="control-label">Password</label>

                
                    <input id="password" type="password" class="form-control pass1" name="password" required>

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                
            </div>
            <div class="form-group">
                <div class="pwstrength_viewport_progress"></div>
            </div>

        </div>


      <div class="col-md-12">

             

        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
            <label for="password-confirm" class="control-label">Confirm Password</label>
            
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                @endif
            
        </div>

        </div>     

       
        <div class="col-sm-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>

        </div>

  </div>

  {!! Form::close() !!}
  </div><!-- Main row -->

                                   

                    </div>
                    
                </div>
            </div>
            
  </div>


@endsection


