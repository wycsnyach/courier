@extends('layouts.inspinia')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
<div class="col-lg-10">
    <h2>Countries</h2>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('/home')}}">Home</a>
        </li>
        <li>
            <a>Countries</a>
        </li>
        <li class="active">
            <strong>Edit</strong>
        </li>
    </ol>
</div>

</div>

  <div class="wrapper wrapper-content animated fadeInRight">        

<div class="row">
<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Edit Country</h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-wrench"></i>
                </a>
                <ul class="dropdown-menu dropdown-country">
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
          
      
            {!! Form::model($country, ['method' => 'PATCH','route' => ['countries.update', $country->id],'class'=>'form-horizontal']) !!}
                <div class="form-group">
                    <label class="col-sm-2 control-label">Name</label>

                    <div class="col-sm-10"> 
                        <input type="text" name="name" class="form-control"  value="{{$country->name}}">
                    </div>
                </div>

                 <div class="form-group">
                    <label class="col-sm-2 control-label">Country Code</label>

                    <div class="col-sm-10"> 
                        <input type="text" name="ccode" class="form-control"  value="{{$country->ccode}}">
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