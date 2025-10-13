@extends('layouts.theme')
@section('content')



<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Users</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index.html">Home</a>
                        </li>
                        <li>
                            <a>Users</a>
                        </li>
                        <li class="active">
                            <strong>Show</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

          </div>
</div>



<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Show User</h5>                       

                        <div class="ibox-tools">

                        <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>


                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#">Config option 1</a>
                                </li>
                                <li><a href="#">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                         <div class="row">
                               <div class="col-xs-12 col-sm-12 col-md-12">

                                          <div class="form-group">

                                              <strong>Name:</strong>

                                              {{ $user->name }}

                                          </div>

                                      </div>

                                      <div class="col-xs-12 col-sm-12 col-md-12">

                                          <div class="form-group">

                                              <strong>Email:</strong>

                                              {{ $user->email }}

                                          </div>

                                      </div>

                                      <div class="col-xs-12 col-sm-12 col-md-12">

                                          <div class="form-group">

                                              <strong>Roles:</strong>

                                              @if(!empty($user->roles))

                                        @foreach($user->roles as $v)

                                          <label class="label label-success">{{ $v->display_name }}</label>

                                        @endforeach

                                      @endif

                                          </div>

                                      </div>
                          </div>
                    </div>
                    
                </div>
            </div>
            </div>
  </div>



@endsection
