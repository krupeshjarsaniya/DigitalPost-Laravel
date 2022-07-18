@extends('admin.layouts.app')
@section('title', 'Distributor Frame')
@section('content')
<style type="text/css">
    .select2-container {
        width: 100% !important;
    }
</style>
<div class="page-header">
    <h4 class="page-title">Distributor Frame</h4>
    <ul class="breadcrumbs">
        <li class="nav-home">
            <a href="{{ route('dashboard') }}">
                <i class="flaticon-home"></i>
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Distributor Frame</a>
        </li>
    </ul>
</div>
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Transaction List
                <button class="btn btn-info btn-sm pull-right" id="add-transaction"><i class="fas fa-plus"></i></button>
                </h4>
            </div>
            <div class="table-responsive">
                <table class="display table table-striped table-hover text-center w-100" id="frame-table">
                    <thead>
                        <tr>
                            <th>Distributor Name</th>
                            <th>Distributor Mobile</th>
                            <th>Frame</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script>

var table = "";


$(document).ready(function() {
    getFrameList();
})

function getFrameList() {
    table = $('#frame-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('distributor_frame.list') }}",
        columns: [
            {data: 'distributor.full_name', name: 'distributor.full_name'},
            {data: 'distributor.contact_number', name: 'distributor.contact_number'},
            {data: 'frame_url', name: 'frame_url'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action'},
        ],
        order: [[3, 'desc']]
    });
}

function updateBusinessData()
{
        $.ajaxSetup({
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var form = document.editBusinessForm;
        var formData = new FormData(form);
        var url = '{{route('distributor_channel.updateBusiness')}}';

        $.ajax({
        type: 'POST',
        url: url,
        processData: false,
        contentType: false,
        dataType: 'json',
        data: formData,
        dataSrc: "",
        beforeSend: function ()
        {
            $('.loader-custom').css('display','block');
        },
        complete: function (data, status)
        {
            $('.loader-custom').css('display','none');
        },

        success: function (response)
        {
            if (response.status == 401)
            {
                $.each(response.error1, function (index, value) {
                    if (value.length != 0) {
                        $('.err_' + index).append('<span class="small alerts text-danger">' + value + '</span>');
                    }

                });
                return false;
            }
            if(!response.status) {
                alert(response.message);
                return false;
            }
                $('#businessModel').modal('hide');
                alert(response.message);
                businessTable.ajax.reload();
        }
    });
}

</script>
@endsection
