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
                            <a>Users</a>
                        </li>
                        <li class="active">
                            <strong>Profile</strong>
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

                       
  <a class="btn btn-primary" href="{{ url('users/profile-edit') }}"> Edit Profile</a>

                          
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

                                    

                                      
                          </div>
                    </div>
                    
                </div>
            </div>
            </div>
  </div>



@endsection
