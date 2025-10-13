@extends('layouts.inspinia')

@section('content')

<?php use App\Http\Controllers\Controller; ?>
<div class="row wrapper border-bottom white-bg page-heading">
<div class="col-lg-10">
    <h2 style="color:#1AB394;"><strong> Country Management | Upload</strong></h2>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('/home')}}">Home</a>
        </li>
        <li>
            <a>Country</a>
        </li>
        <li class="active">
            <strong>Upload</strong>
        </li>
    </ol>
</div>

</div>

  <div class="wrapper wrapper-content animated fadeInRight">   </div>

  <div class="row">
<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Upload Countries</h5>
            <div class="ibox-tools">
                <a href="{{Route('home')}}" class="btn btn-danger btn-xs active">Home <i class="fa fa-level-up"></i></a> 
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
          
            {!! Form::open(array('url' => 'post-upload-countries','method'=>'POST','enctype'=>'multipart/form-data')) !!}
                        <div class="form-body row"> 

                @if (count($errors) > 0)

                    <div class="alert alert-danger">


                      <ul>

                        @foreach ($errors->all() as $error)

                          <li>{{ $error }}</li>

                        @endforeach

                      </ul>

                    </div>

                  @endif   
                <div class="form-group"> <a href="{{asset('templates/countries.csv')}}"><label class="col-sm-2 control-label">Download template</label></a>

                    <div class="col-sm-10"> <p> The columns on your csv must be exactly as they are on the template.</p></div>
                </div>
                <div class="form-group"><label class="col-sm-2 control-label">File Upload:</label>

                    <div class="col-sm-10"> <input type="file" name="csv_file" class="form-control btn btn-primary" required=""></div>
                </div>

                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <button class="btn btn-white" type="reset">Cancel</button>
                        <button class="btn btn-primary" type="submit">Upload File</button>
                         <a href="{{Route('countries.index')}}"><button class="btn btn-danger" type="button">Back</button></a>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>



                              
@endsection