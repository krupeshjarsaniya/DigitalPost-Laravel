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
    <h4 class="page-title">Business</h4>
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
            <a href="#">Business</a>
        </li>
    </ul>
</div>

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h4>{{ $business->busi_name }}</h4>
    </div>
    <div class="card-body">
        <form onsubmit="return false;" name="editBusinessForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_busi_name">
                            <lable for="busi_name">Name</lable>
                            <input type="text" name="busi_name" id="busi_name" value="{{ $business->busi_name }}" class="form-control">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_busi_email">
                            <lable for="busi_email">Email</lable>
                            <input type="text" name="busi_email" id="busi_email" value="{{ $business->busi_email }}" class="form-control">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_busi_mobile">
                            <lable for="busi_mobile">Mobile</lable>
                            <input type="text" name="busi_mobile" id="busi_mobile" value="{{ $business->busi_mobile }}" class="form-control">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_busi_mobile_second">
                            <lable for="busi_mobile_second">Mobile 2</lable>
                            <input type="text" name="busi_mobile_second" id="busi_mobile_second" value="{{ $business->busi_mobile_second }}" class="form-control">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_busi_website">
                            <lable for="busi_website">Website</lable>
                            <input type="text" name="busi_website" id="busi_website" value="{{ $business->busi_website }}" class="form-control">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_busi_address">
                            <lable for="busi_address">Address</lable>
                            <input type="text" name="busi_address" id="busi_address" value="{{ $business->busi_address }}" class="form-control">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_busi_logo">
                            <label for="busi_logo" class="form-label">Upload Logo</label>
                            <input type="file" onchange="changeFile(this)" data-old-image="{{ Storage::url($business->busi_logo) }}" name="busi_logo" id="busi_logo" class="form-control"><br>
                            @if(empty($business->busi_logo))
                                <img id="busi_logo_image" src="#" alt="your image" style="display: none;width: 100px;height:100px;"/>
                            @else
                                <img id="busi_logo_image" src="{{ Storage::url($business->busi_logo) }}" alt="your image" style="width: 100px;height:100px;"/>
                            @endif
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_busi_logo_dark">
                            <label for="busi_logo_dark" class="form-label">Upload Dark Logo</label>
                            <input type="file" onchange="changeFile(this)" data-old-image="{{ Storage::url($business->busi_logo_dark) }}" name="busi_logo_dark" id="busi_logo_dark" class="form-control"><br>
                            @if(empty($business->busi_logo_dark))
                                <img id="busi_logo_dark_image" src="#" alt="your image" style="display: none;width: 100px;height:100px;"/>
                            @else
                                <img id="busi_logo_dark_image" src="{{ Storage::url($business->busi_logo_dark) }}" alt="your image" style="width: 100px;height:100px;"/>
                            @endif
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_watermark_image">
                                <label for="watermark_image" class="form-label">Upload Watermark</label>
                                <input type="file" onchange="changeFile(this)" data-old-image="{{ Storage::url($business->watermark_image) }}" name="watermark_image" id="watermark_image" class="form-control"><br>
                                @if(empty($business->watermark_image))
                                    <img id="watermark_image_image" src="#" alt="your image" style="display: none;width: 100px;height:100px;"/>
                                @else
                                    <img id="watermark_image_image" src="{{ Storage::url($business->watermark_image) }}" alt="your image" style="width: 100px;height:100px;"/>
                                @endif
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_watermark_image_dark">
                                <label for="watermark_image_dark" class="form-label">Upload Dark Watermark</label>
                                <input type="file" onchange="changeFile(this)" data-old-image="{{ Storage::url($business->watermark_image_dark) }}" name="watermark_image_dark" id="watermark_image_dark" class="form-control"><br>
                                @if(empty($business->watermark_image_dark))
                                    <img id="watermark_image_dark_image" src="#" alt="your image" style="display: none;width: 100px;height:100px;"/>
                                @else
                                    <img id="watermark_image_dark_image" src="{{ Storage::url($business->watermark_image_dark) }}" alt="your image" style="display: none;width: 100px;height:100px;"/>
                                @endif
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_hashtag">
                            <lable for="hashtag">Hashtag</lable>
                            <input type="text" name="hashtag" id="hashtag" value="{{ $business->hashtag }}" class="form-control">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_busi_facebook">
                            <lable for="busi_facebook">Facebook</lable>
                            <input type="text" name="busi_facebook" id="busi_facebook" value="{{ $business->busi_facebook }}" class="form-control">
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_busi_twitter">
                            <lable for="busi_twitter">Twitter</lable>
                            <input type="text" name="busi_twitter" id="busi_twitter" value="{{ $business->busi_twitter }}" class="form-control">
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_busi_instagram">
                            <lable for="busi_instagram">Instagram</lable>
                            <input type="text" name="busi_instagram" id="busi_instagram" value="{{ $business->busi_instagram }}" class="form-control">
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_busi_linkedin">
                            <lable for="busi_linkedin">Linkedin</lable>
                            <input type="text" name="busi_linkedin" id="busi_linkedin" value="{{ $business->busi_linkedin }}" class="form-control">
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_busi_youtube">
                            <lable for="busi_youtube">You Tube</lable>
                            <input type="text" name="busi_youtube" id="busi_youtube" value="{{ $business->busi_youtube }}" class="form-control">
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_business_category">
                            <div class="form-group err_business_category">
                                <label for="sel1">Select Category:</label>
                                <select class="form-control" id="business_category" name="business_category">
                                    <option value="Select Category" disabled>Select Category</option>
                                    @foreach($busi_cats as $busi_cat)
                                        <option @if($busi_cat->name == $business->business_category) selected @endif value="{{$busi_cat->name}}">{{$busi_cat->name}}</option>
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
                            <input type="hidden" name="business_id" id="business_id" value="{{ $business->busi_id }}">
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

@endsection

@section('js')
<script>
var table2 = "";
$(document).ready(function() {
    getBusinessUserList("{{ $business->busi_id }}");
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

    var form = document.editBusinessForm;
    var formData = new FormData(form);
    var url = '{{route('distributors.businessUpdate', ['id' => $business->busi_id])}}';

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
            url : "{{ route('distributors.businessUserList') }}",
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
    var url = '{{route('distributors.businessUserAdd')}}';

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
                url: "{{ route('distributors.businessUserDelete') }}",
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


</script>
@endsection
