@extends('admin.layouts.app')
@section('title', 'Distributor Channel')
@section('content')
<style type="text/css">
    .select2-container {
        width: 100% !important;
    }
</style>
<div class="page-header">
    <h4 class="page-title">Distributor Channel</h4>
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
            <a href="#">Distributor Channel</a>
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
                <h4 class="card-title">Distributor Channel
                </h4>
            </div>
            <div class="table-responsive">
                <table class="display table table-striped table-hover text-center w-100" id="distributor-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact No</th>
                            <th>Current Work</th>
                            <th>Experience</th>
                            <th>Skill</th>
                            <th>Date</th>
                            {{--  <th>Area</th>
                            <th>City</th>
                            <th>State</th>  --}}
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

<div class="modal fade" id="distributorModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form name="distributorForm" id="distributorForm" enctype="multipart/form-data">
                @csrf
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add Frame</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <input type="hidden" name="id" id="id" value="">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group err_referral_benefits err_id">
                                <label for="referral_benefits">Referral Bonus</label>
                                <input type="text" id="referral_benefits" name="referral_benefits" class="form-control">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group err_start_up_plan_rate">
                                <label for="start_up_plan_rate">Startup Plan Rate</label>
                                <input type="text" id="start_up_plan_rate" name="start_up_plan_rate" class="form-control">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group err_custom_plan_rate">
                                <label for="custom_plan_rate">Custom Plan Rate</label>
                                <input type="text" id="custom_plan_rate" name="custom_plan_rate" class="form-control">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group err_combo_plan_rate">
                                <label for="combo_plan_rate">Combo Plan Rate</label>
                                <input type="text" id="combo_plan_rate" name="combo_plan_rate" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success"  onclick="approveDistributorRequest()">Submit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
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
            "ajax": "{{ route('distributor_channel.list') }}",
            "columns": [
                {data: 'full_name', name: 'full_name'},
                {data: 'email', name: 'email'},
                {data: 'contact_number', name: 'contact_number'},
                {data: 'current_work', name: 'current_work'},
                {data: 'work_experience', name: 'work_experience'},
                {data: 'skills', name: 'skills'},
                {data: 'created_at', name: 'created_at'},
                {{--  {data: 'area', name: 'area'},
                {data: 'city', name: 'city'},
                {data: 'state', name: 'state'},  --}}
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            order: [[6, 'desc']]
        });
    })

    function approveRequest(ele) {
        clearForm();
        var id = $(ele).attr('data-id');

        var url = "{{ route('distributor_channel.get') }}";
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
                if(!response.status) {
                    alert(response.message);
                    return false;
                }
                var data = response.data;
                $('#id').val(data.id);
                $('#referral_benefits').val(data.referral_benefits);
                $('#start_up_plan_rate').val(data.start_up_plan_rate);
                $('#custom_plan_rate').val(data.custom_plan_rate);
                $('#combo_plan_rate').val(data.combo_plan_rate);
                $('#distributorModal').modal('show');
            },
            error: function(error) {
                $('.loader-custom').css('display','none');
                console.log(error);
            }
        });

    }

    function approveDistributorRequest(ele) {

        $('span.alerts').remove();

        var form = document.distributorForm;

        var formData = new FormData(form);

        var url = "{{ route('distributor_channel.approve') }}";
        $('.loader-custom').css('display','block');
        $.ajax({
            url: url,
            type: 'POST',
            processData: false,
            contentType: false,
            dataType: 'json',
            data: formData,
            dataSrc: "",
            success: function(response) {
                $('.loader-custom').css('display','none');
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
                $('#distributorModal').modal('hide');
                clearForm();
                table.ajax.reload();
            },
            error: function(error) {
                $('.loader-custom').css('display','none');
                console.log(error);
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
                var url = "{{ route('distributor_channel.reject') }}";
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

    function clearForm() {
        $('span.alerts').remove();
        $('#id').val('');
        $('#referral_benefits').val("");
        $('#start_up_plan_rate').val("");
        $('#custom_plan_rate').val("");
    }


</script>
@endsection
