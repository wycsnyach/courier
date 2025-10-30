@extends('layouts.inspinia')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2 class="font-bold text-success" style="color:#1AB394;">System Settings</h2>
        <ol class="breadcrumb">
            <li><a href="{{ url('/home') }}">Home</a></li>
            <li class="active"><strong>Settings</strong></li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h5>Company Details</h5>
        </div>
        <div class="ibox-content">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('settings.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group col-md-4">
                            <label>Company Name</label>
                            <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $setting->company_name ?? '') }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $setting->email ?? '') }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $setting->phone ?? '') }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label>Street Address</label>
                            <input type="text" name="street_address" class="form-control" value="{{ old('street_address', $setting->street_address ?? '') }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label>City</label>
                            <input type="text" name="city" class="form-control" value="{{ old('city', $setting->city ?? '') }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label>Country</label>
                            <input type="text" name="country" class="form-control" value="{{ old('country', $setting->country ?? '') }}">
                        </div>
                    </div>
                

                
                    <div class="form-group col-md-4">
                        <label>Company Logo</label>
                        <div class="mb-3">
                            @if(!empty($setting->logo))
                                <img src="{{ asset('storage/' . $setting->logo) }}" class="img-fluid rounded mb-2" style="max-height: 70px;">
                            @else
                                <p class="text-muted">No logo uploaded yet</p>
                            @endif
                        </div>
                        <input type="file" name="logo" class="form-control">
                    </div>
                    </div>
                
                <div class="text-right mt-4">
                    <button type="submit" class="btn btn-xs btn-success">
                        <i class="fa fa-save"></i> Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Settings Table -->
    <div class="ibox">
        <div class="ibox-title">
            <h5>Saved Settings</h5>
        </div>
        <div class="ibox-content">

            <table id="settingsTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Company Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>Country</th>
                        <th>Logo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($allSettings as $index => $setting)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $setting->company_name }}</td>
                        <td>{{ $setting->email }}</td>
                        <td>{{ $setting->phone }}</td>
                        <td>{{ $setting->street_address }}</td>
                        <td>{{ $setting->city }}</td>
                        <td>{{ $setting->country }}</td>
                        <td>
                            @if($setting->logo)
                                <img src="{{ asset('storage/' . $setting->logo) }}" alt="Logo" style="height: 40px;">

                            @else
                                <span class="text-muted">No logo</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- DataTables + Export Buttons -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script>
$(document).ready(function() {
    var table = $('#settingsTable').DataTable({
        responsive: true,
        dom: '<"d-flex justify-content-between align-items-center mb-2"Bf>rtip',
        buttons: [
            { extend: 'excelHtml5', text: 'Export to Excel', className: 'btn btn-success btn-xs' },
            { extend: 'csvHtml5', text: 'Export to CSV', className: 'btn btn-info btn-xs' },
            { extend: 'pdfHtml5', text: 'Export to PDF', className: 'btn btn-danger btn-xs' },
            { extend: 'print', text: 'Print', className: 'btn btn-primary btn-xs' }
        ]
    });

    // Move the button container to the right side
    $('.dt-buttons').addClass('float-right');
});
</script>

<style>
/* Align DataTable header controls neatly */
.dataTables_wrapper .dt-buttons {
    float: right;
    margin-left: 10px;
}
.dataTables_filter {
    float: left !important;
    text-align: left !important;
}
</style>
@endsection
