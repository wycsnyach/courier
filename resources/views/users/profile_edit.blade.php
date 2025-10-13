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
                            <a>Profile</a>
                        </li>
                        <li class="active">
                            <strong>Edit</strong>
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

                        <a class="btn btn-primary" href="{{ url('users/profile') }}"> Back</a>


                            
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

  {!! Form::open(['method' => 'POST','url' => ['profile-update']]) !!}



  <div class="row">

    <div class="col-md-12">

            <div class="form-group">
                <strong>Name:</strong>
          {!! Form::text('name', $user->name, array('placeholder' => 'Name','class' => 'form-control')) !!}

            </div>

        </div>

   
      <div class="col-md-12">

            <div class="form-group">

                <strong>Email:</strong>

                {!! Form::text('email', $user->email, array('placeholder' => 'Email','class' => 'form-control')) !!}

            </div>

        </div>

        



     

       
        <div class="col-sm-12 text-center">
        <input type="hidden" name="id" value="{{$user->id}}" />
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


