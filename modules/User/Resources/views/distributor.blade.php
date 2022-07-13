@extends('admin.layouts.app')
@section('title', 'Distributor')
@section('content')
<style type="text/css">
    .select2-container {
        width: 100% !important;
    }
</style>
<div class="page-header">
    <h4 class="page-title">Distributor</h4>
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
            <a href="#">Distributor</a>
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
                <h4 class="card-title">Distributor
                </h4>
            </div>
            <div class="table-responsive">
                <table class="display table table-striped table-hover text-center w-100" id="distributor-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>City</th>
                            <th>Current Work</th>
                            <th>Contact No</th>
                            <th>Email</th>
                            <th>Status</th>
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
        table = $('#distributor-table').DataTable({
            processing: true,
            serverSide: true,
            "ajax": "{{ route('distributor.list') }}",
            "columns": [
                {data: 'name', name: 'name'},
                {data: 'city', name: 'city'},
                {data: 'current_work', name: 'current_work'},
                {data: 'contact_no', name: 'contact_no'},
                {data: 'email', name: 'email'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });
    })

    function approveRequest(ele) {
        var id = $(ele).attr('data-id');

        swal({
            title: 'Are you sure?',
            text: "Approve this request!",
            type: 'warning',
            buttons:{
                confirm: {
                    text : 'Yes, Approve it!',
                    className : 'btn btn-success'
                },
                cancel: {
                    visible: true,
                    className: 'btn btn-danger'
                }
            }
        }).then((result) => {
            if(result) {
                var url = "{{ route('distributor.approve') }}";
                var data = {
                    id: id,
                    _token: "{{ csrf_token() }}"
                }
                $('.loader-custom').css('display','block');
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        $('.loader-custom').css('display','none');
                        if(response.status == true) {
                            table.ajax.reload();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(error) {
                        $('.loader-custom').css('display','none');
                        console.log(error);
                    }
                });
            }
        });

    }

    function rejectRequest(ele) {
        var id = $(ele).attr('data-id');

        swal({
            title: 'Are you sure?',
            text: "Reject this request!",
            type: 'warning',
            buttons:{
                confirm: {
                    text : 'Yes, Reject it!',
                    className : 'btn btn-success'
                },
                cancel: {
                    visible: true,
                    className: 'btn btn-danger'
                }
            }
        }).then((result) => {
            if(result) {
                var url = "{{ route('distributor.reject') }}";
                var data = {
                    id: id,
                    _token: "{{ csrf_token() }}"
                }
                $('.loader-custom').css('display','block');
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        $('.loader-custom').css('display','none');
                        if(response.status == true) {
                            table.ajax.reload();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(error) {
                        $('.loader-custom').css('display','none');
                        console.log(error);
                    }
                });
            }
        });

    }


</script>
@endsection
