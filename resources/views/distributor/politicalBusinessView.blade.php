<!DOCTYPE html>

<html lang="en">

@extends('distributor.layouts.app')

@section('content')

<style type="text/css">
    .select2-container {
        width: 100% !important;
    }
</style>
<div class="page-header">
    <h4 class="page-title">Political Business</h4>
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
            <a href="#">Political Business</a>
        </li>
    </ul>
</div>

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

<div class="card">
    <div class="card-body">
        <form onsubmit="return false;" name="editPoliticalBusinessForm" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_pb_name">
                    <lable for="pb_name">Name</lable>
                    <input type="text" name="pb_name" id="pb_name" value="{{ $business->pb_name }}" class="form-control">
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_pb_designation">
                    <lable for="pb_designation">Designation</lable>
                    <input type="text" name="pb_designation" id="pb_designation" value="{{ $business->pb_designation }}" class="form-control">
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_busi_mobile">
                    <lable for="pb_mobile">Mobile</lable>
                    <input type="text" name="pb_mobile" id="pb_mobile" value="{{ $business->pb_mobile }}" class="form-control">
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_pb_mobile_second">
                    <lable for="pb_mobile_second">Mobile 2</lable>
                    <input type="text" name="pb_mobile_second" id="pb_mobile_second" value="{{ $business->pb_mobile_second }}" class="form-control">
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_pb_party_logo">
                    <label for="pb_party_logo" class="form-label">Upload Logo</label>
                    <input type="file" data-old-image="{{ Storage::url($business->pb_party_logo) }}" onchange="changeFile(this)" name="pb_party_logo" id="pb_party_logo" class="form-control"><br>
                    @if(empty($business->pb_party_logo))
                        <img id="pb_party_logo_image" src="#" alt="your image" style="display: none;width: 100px;height:100px;"/>
                    @else
                        <img id="pb_party_logo_image" src="{{ Storage::url($business->pb_party_logo) }}" alt="your image" style="width: 100px;height:100px;"/>
                    @endif

                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_pb_party_logo_dark">
                    <label for="pb_party_logo_dark" class="form-label">Upload Dark Logo</label>
                    <input type="file" data-old-image="{{ Storage::url($business->pb_party_logo_dark) }}" onchange="changeFile(this)" name="pb_party_logo_dark" id="pb_party_logo_dark" class="form-control"><br>
                    @if(empty($business->pb_party_logo_dark))
                        <img id="pb_party_logo_dark_image" src="#" alt="your image" style="display: none;width: 100px;height:100px;"/>
                    @else
                        <img id="pb_party_logo_dark_image" src="{{ Storage::url($business->pb_party_logo_dark) }}" alt="your image" style="width: 100px;height:100px;"/>
                    @endif
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_pb_watermark">
                    <label for="pb_watermark" class="form-label">Upload Watermark</label>
                    <input type="file" data-old-image="{{ Storage::url($business->pb_watermark) }}" onchange="changeFile(this)" name="pb_watermark" id="pb_watermark" class="form-control"><br>
                    @if(empty($business->pb_watermark))
                        <img id="pb_watermark_image" src="#" alt="your image" style="display: none;width: 100px;height:100px;"/>
                    @else
                        <img id="pb_watermark_image" src="{{ Storage::url($business->pb_watermark) }}" alt="your image" style="width: 100px;height:100px;"/>
                    @endif
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_pb_watermark_dark">
                    <label for="pb_watermark_dark" class="form-label">Upload Watermark</label>
                    <input type="file" data-old-image="{{ Storage::url($business->pb_watermark_dark) }}" onchange="changeFile(this)" name="pb_watermark_dark" id="pb_watermark_dark" class="form-control"><br>
                    @if(empty($business->pb_watermark_dark))
                        <img id="pb_watermark_dark_image" src="#" alt="your image" style="display: none;width: 100px;height:100px;"/>
                    @else
                        <img id="pb_watermark_dark_image" src="{{ Storage::url($business->pb_watermark_dark) }}" alt="your image" style="width: 100px;height:100px;"/>
                    @endif
                </div>

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_pb_left_image">
                    <label for="pb_left_image" class="form-label">Left Image</label>
                    <input type="file" data-old-image="{{ Storage::url($business->pb_left_image) }}" onchange="changeFile(this)" name="pb_left_image" id="pb_left_image" class="form-control"><br>
                    @if(empty($business->pb_left_image))
                        <img id="pb_left_image_image" src="#" alt="your image" style="display: none;width: 100px;height:100px;"/>
                    @else
                        <img id="pb_left_image_image" src="{{ Storage::url($business->pb_left_image) }}" alt="your image" style="width: 100px;height:100px;"/>
                    @endif
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_pb_right_image">
                    <label for="pb_right_image" class="form-label">Right Image</label>
                    <input type="file" data-old-image="{{ Storage::url($business->pb_right_image) }}" onchange="changeFile(this)" name="pb_right_image" id="pb_right_image" class="form-control"><br>
                    @if(empty($business->pb_right_image))
                        <img id="pb_right_image_image" src="#" alt="your image" style="display: none;width: 100px;height:100px;"/>
                    @else
                        <img id="pb_right_image_image" src="{{ Storage::url($business->pb_right_image) }}" alt="your image" style="width: 100px;height:100px;"/>
                    @endif
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_hashtag">
                    <lable for="hashtag">Hashtag</lable>
                    <input type="text" name="hashtag" id="hashtag" value="{{ $business->hashtag }}" class="form-control">
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_pb_facebook">
                    <lable for="pb_facebook">Facebook</lable>
                    <input type="text" name="pb_facebook" id="pb_facebook" value="{{ $business->pb_facebook }}" class="form-control">
                </div>

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_pb_twitter">
                    <lable for="pb_twitter">Twitter</lable>
                    <input type="text" name="pb_twitter" id="pb_twitter" value="{{ $business->pb_twitter }}" class="form-control">
                </div>

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_pb_instagram">
                    <lable for="pb_instagram">Instagram</lable>
                    <input type="text" name="pb_instagram" id="pb_instagram" value="{{ $business->pb_instagram }}" class="form-control">
                </div>

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_pb_linkedin">
                    <lable for="pb_linkedin">Linkedin</lable>
                    <input type="text" name="pb_linkedin" id="pb_linkedin" value="{{ $business->pb_linkedin }}" class="form-control">
                </div>

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_pb_youtube">
                    <lable for="pb_youtube">You Tube</lable>
                    <input type="text" name="pb_youtube" id="pb_youtube" value="{{ $business->pb_youtube }}" class="form-control">
                </div>

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_pb_pc_id">
                    <div class="form-group err_pb_pc_id">
                        <label for="sel1">Select Category:</label>
                        <select class="form-control" id="pb_pc_id" name="pb_pc_id">
                            @foreach($busi_cats as $busi_cat)
                                <option @if($busi_cat->pc_id == $business->pb_pc_id) selected @endif value={{$busi_cat->pc_id}}>{{$busi_cat->pc_name}}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                </div>
        </form>
    </div>
    <div class="card-footer">
        <button type="button" class="btn btn-success" id="update_business">Submit</button>
    </div>
</div>

<div class="card">
    <!-- Modal Header -->
    <div class="card-header">
        <h4 class="card-title">Users
            <button class="btn btn-info btn-sm pull-right" id="add-user"><i class="fas fa-plus text-white"></i></button>
        </h4>
    </div>

    <!-- Modal body -->
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="display table table-striped table-hover text-center w-100" id="users-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Mobile</th>
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
</div>

<div class="modal fade" id="UsersModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add Users</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form onsubmit="return false" method="POST" name="addUserForm" id="addUserForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 form-group err_users">
                            <input type="hidden" name="business_id" id="business_id" value="{{ $business->pb_id }}">
                            <label for="users">Users Mobile Number (Comma(,) Separated)</label>
                            <input type="text" name="users" id="users" class="form-control">
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" onclick="addUserToBusiness()" class="btn btn-success">Submit</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@if(Auth::user()->distributor->allow_add_frames)
<div class="card">
    <!-- Modal Header -->
    <div class="card-header">
        <h4 class="card-title">Add Frames
        </h4>
    </div>

    <!-- Modal body -->
    <div class="card-body">
        <form onsubmit="return false" method="POST" name="addFrameForm" id="addFrameForm">
            @csrf
            <div class="row">
                <div class="col-md-9 form-group err_frames">
                    <input type="hidden" name="business_id" id="business_id" value="{{ $business->pb_id }}">
                    <label for="frames">Frames</label>
                    <input type="file" name="frames[]" id="frames" class="form-control">
                </div>
                <div class="col-md-3 form-group mt-4 text-right">
                    <button type="button" onclick="addFrameToBusiness()" class="btn btn-success">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endif

<div class="card">
    <!-- Modal Header -->
    <div class="card-header">
        <h4 class="card-title">Frames
        </h4>
    </div>

    <!-- Modal body -->
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="display table table-striped table-hover text-center w-100" id="frames-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Frame</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>

var table = "";
var table2 = "";
$(document).ready(function() {
    getBusinessUserList("{{ $business->pb_id }}");
    getBusinessFrameList("{{ $business->pb_id }}");
})

$('#add-user').on('click', function(e) {
    $('#UsersModal').modal('show');
})

$('#update_business').on('click', function(e) {

    $.ajaxSetup({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var form = document.editPoliticalBusinessForm;
    var formData = new FormData(form);
    var url = '{{route('distributors.politicalBusinessUpdate', ['id' => $business->pb_id])}}';

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
            $('span.alerts').remove();
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
                alert(response.message);
                location.reload();
            }
    });

});

function changeFile(ele) {
    var img_id = $(ele).attr('id');
    var oldImage = $(ele).data('old-image');
    var files = $(ele)[0].files;
    if (files.length) {
        var reader = new FileReader();
        reader.onload = function (e) {
           $('#' + img_id + '_image').attr('src', e.target.result);
           $('#' + img_id + '_image').show();
        }
       reader.readAsDataURL(files[0]);
    }
    else {
        $('#' + img_id + '_image').attr('src',oldImage);
        $('#' + img_id + '_image').show();
    }
}

function getBusinessUserList(id) {
    if(table2 != "") {
        table2.destroy();
    }
    table2 = $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url : "{{ route('distributors.politicalBusinessUserList') }}",
            data: {id}
        },
        columns: [
            {data: 'DT_RowIndex', name: 'id'},
            {data: 'user.name', name: 'user.name'},
            {data: 'user.mobile', name: 'user.mobile'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
    });
}

function addUserToBusiness() {
    $.ajaxSetup({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var form = document.addUserForm;
    var formData = new FormData(form);
    var url = '{{route('distributors.politicalBusinessUserAdd')}}';

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
            $('span.alerts').remove();
            $('#users').val("");
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
            alert(response.message);
            table2.ajax.reload();
            $('#UsersModal').modal('hide');
        }
    });
}

function removeUserFromBusiness(ele) {
    var id = $(ele).data('id');
    var business_id = $('#business_id').val();
    swal({
        title: 'Are you sure?',
        text: "Remove this user!",
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
            $('.loader-custom').css('display','block');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('distributors.politicalBusinessUserDelete') }}",
                type: 'POST',
                data: {id, business_id},
                success: function (data) {
                    if(data.status) {
                        table2.ajax.reload();
                        alert(data.message)
                    }
                    else {
                        alert(data.message)
                    }
                    $('.loader-custom').css('display','none');
                }
            });
        }
        else {
            swal.close();
        }
    });
}

function getBusinessFrameList(id) {
    if(table != "") {
        table.destroy();
    }
    table = $('#frames-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url : "{{ route('distributors.politicalBusinessFrameList') }}",
            data: {id}
        },
        columns: [
            {data: 'DT_RowIndex', name: 'date_added'},
            {data: 'frame_url', name: 'frame_url'},
        ],
    });
}

function addFrameToBusiness() {
    $.ajaxSetup({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var form = document.addFrameForm;
    var formData = new FormData(form);
    var url = '{{route('distributors.politicalBusinessFrameAdd')}}';

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
            $('span.alerts').remove();
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
            $('#frames').val("");
            alert(response.message);
        }
    });
}

</script>
@endsection
