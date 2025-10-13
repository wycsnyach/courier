@extends('layouts.inspinia')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2 style="color:#1AB394;"><strong>Email Management</strong></h2>
        <ol class="breadcrumb">
            <li><a href="{{ url('/home') }}">Home</a></li>
            <li><a>Emails</a></li>
            <li class="active"><strong>Create</strong></li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Create Email</h5>
                    <div class="ibox-tools">
                        <a href="{{ route('home') }}" class="btn btn-danger btn-xs active">Home <i class="fa fa-level-up"></i></a>
                        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#">Config option 1</a></li>
                            <li><a href="#">Config option 2</a></li>
                        </ul>
                        <a class="close-link"><i class="fa fa-times"></i></a>
                    </div>
                </div>
                <div class="ibox-content">
                    {!! Form::open(['route' => 'emails.send', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
                    <div class="form-group">
                        <label for="subject">Subject:</label>
                        <input type="text" class="form-control" id="subject" name="subject" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Message:</label>
                        <textarea class="form-control summernote" id="message" name="message" rows="10" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="recipient_type">Recipient Type:</label>
                        <select class="form-control" id="recipient_type" name="recipient_type" required>
                            <option value="">Select Recipient</option>
                            <option value="individual">Individual</option>
                            <option value="group">Group</option>
                            <option value="all">All</option>
                        </select>
                    </div>
                    <div class="form-group" id="recipient_id_div" style="display: none;">
                        <label for="recipient_id">Recipient:</label>
                        <select class="form-control" id="recipient_id" name="recipient_id">
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }} ({{ $client->email_address }})</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-reply"></i> Send Email</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.getElementById('recipient_type').addEventListener('change', function () {
        var recipientType = this.value;
        var recipientDiv = document.getElementById('recipient_id_div');

        if (recipientType === 'individual') {
            recipientDiv.style.display = 'block';
        } else {
            recipientDiv.style.display = 'none';
            document.getElementById('recipient_id').value = ''; // Clear selection
        }
    });

    $('form').on('submit', function () {
        $(this).find('button[type="submit"]').html('<i class="fa fa-spinner fa-spin"></i> Sending...');
    });

    $(document).ready(function() {
    $('.summernote').summernote({
        cleaner: {
            notTime: 2400, // Timeout for the cleaner
            action: 'both', // Use both button and auto cleaner
            newline: '<br>', // Use `<br>` instead of `<p>`
            notStyle: 'position:absolute;top:0;left:0;', // Ignore these styles
            icon: '<i class="note-icon">[Your Icon]</i>', // Cleaner icon
            keepHtmlTags: ['<b>', '<i>', '<u>', '<strong>', '<p>', '<br>'] // Allowed tags
        }
    });
});

</script>
@endsection
