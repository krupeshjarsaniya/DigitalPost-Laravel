@extends('admin.layouts.app')
@section('title', 'Background Remove Request')
@section('content')
<style type="text/css">
    .select2-container {
        width: 100% !important;
    }
</style>
<div class="page-header">
    <h4 class="page-title">Background Remove Request</h4>
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
            <a href="#">Background Remove Request</a>
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
                <h4 class="card-title">Background Remove Request
                </h4>
            </div>
            <div class="table-responsive">
                <table class="display table table-striped table-hover text-center w-100" id="bg-request-table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Business Type</th>
                            <th>Business</th>
                            <th>Mobile</th>
                            <th>Remove Logo</th>
                            <th>Remove Watermark</th>
                            <th>Remove Dark Logo</th>
                            <th>Remove Dark Watermark</th>
                            <th>Remove Left Image</th>
                            <th>Remove Right Image</th>
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

<div class="modal fade" id="edit-normal-images-modal" tabindex="-1" role="dialog" aria-labelledby="editNormalImagesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Images</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="edit-normal-images-form" name="editNormalImageForm" method="post" onsubmit="return false" enctype="multipart/form-data" >
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id" value="" />
                    <div class="row">
                        <div class="col-6 form-group err_logo">
                            <label for="logo">Logo</label>
                            <input type="file" name="logo" id="logo" class="form-control" accept="image/*" />
                            <img id="logo_img" src="" class="" width="100" height="100" />
                        </div>
                        <div class="col-6 form-group err_logodark">
                            <label for="logodark">Dark Logo</label>
                            <input type="file" name="logodark" id="logodark" class="form-control" accept="image/*" />
                            <img id="logodark_img" src="" class="" width="100" height="100" />
                        </div>
                        <div class="col-6 form-group err_watermarkdark">
                            <label for="watermark">Watermark</label>
                            <input type="file" name="watermark" id="watermark" class="form-control" accept="image/*" />
                            <img id="watermark_img" src="" class="" width="100" height="100" />
                        </div>
                        <div class="col-6 form-group err_watermark">
                            <label for="watermarkdark">Dark Watermark</label>
                            <input type="file" name="watermarkdark" id="watermarkdark" class="form-control" accept="image/*" />
                            <img id="watermarkdark_img" src="" class="" width="100" height="100" />
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-success"  onclick="updateBusinessImages()">Submit</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="edit-political-images-modal" tabindex="-1" role="dialog" aria-labelledby="editPoliticalImagesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Images</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="edit-political-images-form" name="editPoliticalImageForm" method="post" onsubmit="return false" enctype="multipart/form-data" >
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_political_id" value="" />
                    <div class="row">
                        <div class="col-6 form-group err_politicallogo">
                            <label for="politicallogo">Logo</label>
                            <input type="file" name="politicallogo" id="politicallogo" class="form-control" accept="image/*" />
                            <img id="politicallogo_img" src="" class="" width="100" height="100" />
                        </div>
                        <div class="col-6 form-group err_politicallogodark">
                            <label for="politicallogodark">Dark Logo</label>
                            <input type="file" name="politicallogodark" id="politicallogodark" class="form-control" accept="image/*" />
                            <img id="politicallogodark_img" src="" class="" width="100" height="100" />
                        </div>
                        <div class="col-6 form-group err_politicalwatermark">
                            <label for="politicalwatermark">Watermark</label>
                            <input type="file" name="politicalwatermark" id="politicalwatermark" class="form-control" accept="image/*" />
                            <img id="politicalwatermark_img" src="" class="" width="100" height="100" />
                        </div>
                        <div class="col-6 form-group err_politicalwatermarkdark">
                            <label for="politicalwatermarkdark">Dark Watermark</label>
                            <input type="file" name="politicalwatermarkdark" id="politicalwatermarkdark" class="form-control" accept="image/*" />
                            <img id="politicalwatermarkdark_img" src="" class="" width="100" height="100" />
                        </div>
                        <div class="col-6 form-group err_politicalleft">
                            <label for="politicalleft">Left Image</label>
                            <input type="file" name="politicalleft" id="politicalleft" class="form-control" accept="image/*" />
                            <img id="politicalleft_img" src="" class="" width="100" height="100" />
                        </div>
                        <div class="col-6 form-group err_politicalright">
                            <label for="politicalright">Right Image</label>
                            <input type="file" name="politicalright" id="politicalright" class="form-control" accept="image/*" />
                            <img id="politicalright_img" src="" class="" width="100" height="100" />
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-success"  onclick="updatePoliticalBusinessImages()">Submit</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script>
    var table = "";
    $(document).ready(function() {
        table = $('#bg-request-table').DataTable({
            processing: true,
            serverSide: true,
            "ajax": "{{ route('bg-request-list') }}",
            "columns": [
                {data: 'user_id', name: 'user_id'},
                {data: 'business_type', name: 'business_type'},
                {data: 'business_id', name: 'business_id'},
                {data: 'mobile', name: 'business_id'},
                {data: 'remove_logo', name: 'remove_logo'},
                {data: 'remove_watermark', name: 'remove_watermark'},
                {data: 'remove_logo_dark', name: 'remove_logo_dark'},
                {data: 'remove_watermark_dark', name: 'remove_watermark_dark'},
                {data: 'remove_left_image', name: 'remove_left_image'},
                {data: 'remove_right_image', name: 'remove_right_image'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });
    })

    function removeRequest(ele) {
        var id = $(ele).attr('data-id');

        swal({
            title: 'Are you sure?',
            text: "Remove this request!",
            type: 'warning',
            buttons:{
                confirm: {
                    text : 'Yes, Remove it!',
                    className : 'btn btn-success'
                },
                cancel: {
                    visible: true,
                    className: 'btn btn-danger'
                }
            }
        }).then((result) => {
            if(result) {
                var url = "{{ route('bg-request-remove') }}";
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

    function editImages(ele) {
        $('#logo').val("");
        $('#logodark').val("");
        $('#watermark').val("");
        $('#watermarkdark').val("");
        $('#politicallogo').val("");
        $('#politicallogodark').val("");
        $('#politicalwatermark').val("");
        $('#politicalwatermarkdark').val("");
        $('#politicalleft').val("");
        $('#politicalright').val("");

        var id = $(ele).attr('data-id');
        var url = "{{ route('bg-request-edit') }}";
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

                    var data = response.data;
                    if(data.business_type == '1') {
                        $('#edit_id').val(data.business_id);
                        $('#logo_img').attr('src',data.business.busi_logo);
                        $('#logodark_img').attr('src',data.business.busi_logo_dark);
                        $('#watermark_img').attr('src',data.business.watermark_image);
                        $('#watermarkdark_img').attr('src',data.business.watermark_image_dark);
                        $('#edit-normal-images-modal').modal('show');
                    } else {
                        $('#edit_political_id').val(data.business_id);
                        $('#politicallogo_img').attr('src',data.politicalBusiness.pb_party_logo);
                        $('#politicallogodark_img').attr('src',data.politicalBusiness.pb_party_logo_dark);
                        $('#politicalwatermark_img').attr('src',data.politicalBusiness.pb_watermark);
                        $('#politicalwatermarkdark_img').attr('src',data.politicalBusiness.pb_watermark_dark);
                        $('#politicalleft_img').attr('src',data.politicalBusiness.pb_left_image);
                        $('#politicalright_img').attr('src',data.politicalBusiness.pb_right_image);
                        $('#edit-political-images-modal').modal('show');
                    }

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

    function updateBusinessImages() {
        var id = $('#edit_id').val();
        var url = "{{ route('bg-request-update-normal') }}";
        var form = document.editNormalImageForm;
        var formData = new FormData(form);
        formData.append('_token', "{{ csrf_token() }}");

        $('.loader-custom').css('display','block');
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                $('.loader-custom').css('display','none');
                if(response.status == true) {
                    $('#edit-normal-images-modal').modal('hide');
                    table.ajax.reload();
                    $('#logo').val("");
                    $('#logodark').val("");
                    $('#watermark').val("");
                    $('#watermarkdark').val("");
                    $('#politicallogo').val("");
                    $('#politicallogodark').val("");
                    $('#politicalwatermark').val("");
                    $('#politicalwatermarkdark').val("");
                    $('#politicalleft').val("");
                    $('#politicalright').val("");
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

    function updatePoliticalBusinessImages() {
        var id = $('#edit_id').val();
        var url = "{{ route('bg-request-update-political') }}";
        var form = document.editPoliticalImageForm;
        var formData = new FormData(form);
        formData.append('_token', "{{ csrf_token() }}");

        $('.loader-custom').css('display','block');
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                $('.loader-custom').css('display','none');
                if(response.status == true) {
                    $('#edit-political-images-modal').modal('hide');
                    table.ajax.reload();
                    $('#logo').val("");
                    $('#logodark').val("");
                    $('#watermark').val("");
                    $('#watermarkdark').val("");
                    $('#politicallogo').val("");
                    $('#politicallogodark').val("");
                    $('#politicalwatermark').val("");
                    $('#politicalwatermarkdark').val("");
                    $('#politicalleft').val("");
                    $('#politicalright').val("");
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


</script>
@endsection
