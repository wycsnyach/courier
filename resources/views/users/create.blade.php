@extends('layouts.inspinia')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
<div class="col-lg-10">
    <h2>Users</h2>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('/home')}}">Home</a>
        </li>
        <li>
            <a>Users</a>
        </li>
        <li class="active">
            <strong>Create</strong>
        </li>
    </ol>
</div>

</div>

  <div class="wrapper wrapper-content animated fadeInRight">        

<div class="row">
<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Create User</h5>
            <div class="ibox-tools">
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

            @if (count($errors) > 0)

            <div class="alert alert-danger">


            <ul>

            @foreach ($errors->all() as $error)

            <li>{{ $error }}</li>

            @endforeach

            </ul>

            </div>

            @endif 
          
            {!! Form::open(array('route' => 'users.store','method'=>'POST','class'=>'form-horizontal')) !!}

            <div class="form-body row">
                    <div class="form-group col-md-12">   
                            <div class="form-md-line-input col-md-4"> 
                                 <label class="control-label" >First Name</label>
                                    <input type="text" name="first_name" class="form-control" placeholder="Enter First Name">
                                <div class="form-control-focus"> </div>

                            </div>
                           
                            <div class="form-md-line-input col-md-4"> 
                                 <label class="control-label" >Middle Name</label>
                                    <input type="text" name="middle_name" class="form-control" placeholder="Enter Middle Name">
                                <div class="form-control-focus"> </div>

                            </div>
                            <div class="form-md-line-input col-md-4"> 
                                 <label class="control-label" >Last Name</label>
                                    <input type="text" name="last_name" class="form-control" placeholder="Enter Last Name">
                                <div class="form-control-focus"> </div>

                            </div>
                        </div>
                        <div class="form-group col-md-12">  
                           
                            <div class="form-md-line-input col-md-6">
                        
                            <label class="control-label" >Email Address</label>
                            <input type="text" name="email" class="form-control" placeholder="Email">
                                <div class="form-control-focus"> </div>
                          
                        </div>    
                          <div class="form-md-line-input col-md-6">
                        
                            <label class="control-label" >Phone Number</label>
                            <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                <input type="text" name="phone_number" class="form-control" placeholder="Enter Phone Number">
                            </div>
                                    <div class="form-control-focus"> </div>
                              
                        </div>  
                    </div>

                    <div class="form-group col-md-12">  
                           
                        <div class="form-md-line-input col-md-6">                                
                           
                            <label class="control-label" >Role</label>
                                <select name="role_id"  class="form-control form-md-line-input fstdropdown-select">
                                    <option value="">Select Role ..</option>
                                    <option value=""></option>
                                    @foreach($roles as $role)                            
                                    <option value="{{$role->id}}">{{$role->name}} </option>
                                    @endforeach
                                </select>
                                 
                        </div>
                        <div class="form-md-line-input col-md-6">                                
                                   
                            <label class="control-label" >Status</label>
                                <select name="active"  class="form-control form-md-line-input fstdropdown-select">
                                    <option value="">Select Status ..</option>
                                    <option value="YES">YES</option>
                                    <option value="NO">N0</option>
                                </select>
                                 
                        </div>  
                    </div>
            </div> 
                
            </div>


                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <button class="btn btn-white" type="reset">Cancel</button>
                        <button class="btn btn-primary" type="submit">Save changes</button>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

</div>


                              
@endsection