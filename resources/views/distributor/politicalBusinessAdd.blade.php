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

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form onsubmit="return false;" name="addPoliticalBusinessForm" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_pb_name">
                        <lable for="pb_name">Name</lable>
                        <input type="text" name="pb_name" id="pb_name" class="form-control">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_pb_designation">
                        <lable for="pb_designation">Designation</lable>
                        <input type="text" name="pb_designation" id="pb_designation" class="form-control">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_busi_mobile">
                        <lable for="pb_mobile">Mobile</lable>
                        <input type="text" name="pb_mobile" id="pb_mobile" class="form-control">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_pb_mobile_second">
                        <lable for="pb_mobile_second">Mobile 2</lable>
                        <input type="text" name="pb_mobile_second" id="pb_mobile_second" class="form-control">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_pb_party_logo">
                        <label for="pb_party_logo" class="form-label">Upload Logo</label>
                        <input type="file" onchange="changeFile(this)" name="pb_party_logo" id="pb_party_logo"
                            class="form-control"><br>
                        <img id="pb_party_logo_image" src="#" alt="your image"
                            style="display: none;width: 100px;height:100px;" />
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_pb_party_logo_dark">
                        <label for="pb_party_logo_dark" class="form-label">Upload Dark Logo</label>
                        <input type="file" onchange="changeFile(this)" name="pb_party_logo_dark" id="pb_party_logo_dark"
                            class="form-control"><br>
                        <img id="pb_party_logo_dark_image" src="#" alt="your image"
                            style="display: none;width: 100px;height:100px;" />
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_pb_watermark">
                        <label for="pb_watermark" class="form-label">Upload Watermark</label>
                        <input type="file" onchange="changeFile(this)" name="pb_watermark" id="pb_watermark"
                            class="form-control"><br>
                        <img id="pb_watermark_image" src="#" alt="your image"
                            style="display: none;width: 100px;height:100px;" />
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_pb_watermark_dark">
                        <label for="pb_watermark_dark" class="form-label">Upload Watermark</label>
                        <input type="file" onchange="changeFile(this)" name="pb_watermark_dark" id="pb_watermark_dark"
                            class="form-control"><br>
                        <img id="pb_watermark_dark_image" src="#" alt="your image"
                            style="display: none;width: 100px;height:100px;" />
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_pb_left_image">
                        <label for="pb_left_image" class="form-label">Left Image</label>
                        <input type="file" onchange="changeFile(this)" name="pb_left_image" id="pb_left_image"
                            class="form-control"><br>
                        <img id="pb_left_image_image" src="#" alt="your image"
                            style="display: none;width: 100px;height:100px;" />
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_pb_right_image">
                        <label for="pb_right_image" class="form-label">Right Image</label>
                        <input type="file" onchange="changeFile(this)" name="pb_right_image" id="pb_right_image"
                            class="form-control"><br>
                        <img id="pb_right_image_image" src="#" alt="your image"
                            style="display: none;width: 100px;height:100px;" />
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_hashtag">
                        <lable for="hashtag">Hashtag</lable>
                        <input type="text" name="hashtag" id="hashtag" class="form-control">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_pb_facebook">
                        <lable for="pb_facebook">Facebook</lable>
                        <input type="text" name="pb_facebook" id="pb_facebook" class="form-control">
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_pb_twitter">
                        <lable for="pb_twitter">Twitter</lable>
                        <input type="text" name="pb_twitter" id="pb_twitter" class="form-control">
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_pb_instagram">
                        <lable for="pb_instagram">Instagram</lable>
                        <input type="text" name="pb_instagram" id="pb_instagram" class="form-control">
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_pb_linkedin">
                        <lable for="pb_linkedin">Linkedin</lable>
                        <input type="text" name="pb_linkedin" id="pb_linkedin" class="form-control">
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_pb_youtube">
                        <lable for="pb_youtube">You Tube</lable>
                        <input type="text" name="pb_youtube" id="pb_youtube" class="form-control">
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_pb_pc_id">
                        <div class="form-group err_pb_pc_id">
                            <label for="sel1">Select Category:</label>
                            <select class="form-control" id="pb_pc_id" name="pb_pc_id">
                                <option value="Select Category" disabled>Select Category</option>
                                @foreach ($busi_cats as $busi_cat)
                                    <option value={{ $busi_cat->pc_id }}>{{ $busi_cat->pc_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_select_plan">
                        <div class="form-group err_err_select_plan">
                            <label for="purc_plan_id">Select Plan:</label>
                            <select class="form-control" id="purc_plan_id" name="purc_plan_id">
                                <option value="Select Category" disabled>Select Plan</option>
                                <option value="{{ \App\Plan::$custom_plan_id }}">Custom Plan Rate</option>
                                <option value="{{ \App\Plan::$start_up_plan_id  }}">Start Up Plan Rate</option>
                                <option value="{{ \App\Plan::$combo_custom_plan_id }}">Combo Custom Plan Rate</option>
                                <option value="{{ \App\Plan::$combo_start_up_plan_id }}">Combo Start Up Plan Rate</option>
                            </select>
                        </div>
                    </div>
                </div>
        </div>
        </form>
    </div>
    <div class="card-footer">
        <button type="button" class="btn btn-success" id="add_business">Submit</button>
        <a href="{{ route('distributors.politicalBusiness') }}" class="btn btn-danger">Back</a>
    </div>

    </div>
@endsection

@section('js')
    <script>
        function changeFile(ele) {
            var img_id = $(ele).attr('id');
            var files = $(ele)[0].files;
            if (files.length) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#' + img_id + '_image').attr('src', e.target.result);
                    $('#' + img_id + '_image').show();
                }
                reader.readAsDataURL(files[0]);
            } else {
                $('#' + img_id + '_image').hide();
            }
        }

        $('#add_business').on('click', function(e) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var form = document.addPoliticalBusinessForm;
            var formData = new FormData(form);
            var url = '{{ route('distributors.politicalBusinessInsert') }}';

            $.ajax({
                type: 'POST',
                url: url,
                processData: false,
                contentType: false,
                dataType: 'json',
                data: formData,
                dataSrc: "",
                beforeSend: function() {
                    $('.loader-custom').css('display', 'block');
                    $('span.alerts').remove();
                },
                complete: function(data, status) {
                    $('.loader-custom').css('display', 'none');
                },

                success: function(response) {
                    if (response.status == 401) {
                        $.each(response.error1, function(index, value) {
                            if (value.length != 0) {
                                $('.err_' + index).append(
                                    '<span class="small alerts text-danger">' + value +
                                    '</span>');
                            }

                        });
                        return false;
                    }
                    if (!response.status) {
                        showSweetAlert('Political Business Insert',response.message,'error');
                        return false;
                    }

                    showSweetAlert('Political Business Insert',response.message,'success','{{ route('distributors.politicalBusiness') }}');
                }
            });

        });
    </script>
@endsection
