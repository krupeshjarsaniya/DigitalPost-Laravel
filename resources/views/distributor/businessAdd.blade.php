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

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form onsubmit="return false;" name="addBusinessForm" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_busi_name">
                        <lable for="busi_name">Name</lable>
                        <input type="text" name="busi_name" id="busi_name" class="form-control">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_busi_email">
                        <lable for="busi_email">Email</lable>
                        <input type="text" name="busi_email" id="busi_email" class="form-control">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_busi_mobile">
                        <lable for="busi_mobile">Mobile</lable>
                        <input type="text" name="busi_mobile" id="busi_mobile" class="form-control">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_busi_mobile_second">
                        <lable for="busi_mobile_second">Mobile 2</lable>
                        <input type="text" name="busi_mobile_second" id="busi_mobile_second" class="form-control">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_busi_website">
                        <lable for="busi_website">Website</lable>
                        <input type="text" name="busi_website" id="busi_website" class="form-control">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_busi_address">
                        <lable for="busi_address">Address</lable>
                        <input type="text" name="busi_address" id="busi_address" class="form-control">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_busi_logo">
                        <label for="busi_logo" class="form-label">Upload Logo</label>
                        <input type="file" onchange="changeFile(this)" name="busi_logo" id="busi_logo"
                            class="form-control"><br>
                        <img id="busi_logo_image" src="#" alt="your image"
                            style="display: none;width: 100px;height:100px;" />
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_busi_logo_dark">
                        <label for="busi_logo_dark" class="form-label">Upload Dark Logo</label>
                        <input type="file" onchange="changeFile(this)" name="busi_logo_dark" id="busi_logo_dark"
                            class="form-control"><br>
                        <img id="busi_logo_dark_image" src="#" alt="your image"
                            style="display: none;width: 100px;height:100px;" />
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_watermark_image">
                        <label for="watermark_image" class="form-label">Upload Watermark</label>
                        <input type="file" onchange="changeFile(this)" name="watermark_image" id="watermark_image"
                            class="form-control"><br>
                        <img id="watermark_image_image" src="#" alt="your image"
                            style="display: none;width: 100px;height:100px;" />
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_watermark_image_dark">
                        <label for="watermark_image_dark" class="form-label">Upload Dark Watermark</label>
                        <input type="file" onchange="changeFile(this)" name="watermark_image_dark"
                            id="watermark_image_dark" class="form-control"><br>
                        <img id="watermark_image_dark_image" src="#" alt="your image"
                            style="display: none;width: 100px;height:100px;" />
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_hashtag">
                        <lable for="hashtag">Hashtag</lable>
                        <input type="text" name="hashtag" id="hashtag" class="form-control">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_busi_facebook">
                        <lable for="busi_facebook">Facebook</lable>
                        <input type="text" name="busi_facebook" id="busi_facebook" class="form-control">
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_busi_twitter">
                        <lable for="busi_twitter">Twitter</lable>
                        <input type="text" name="busi_twitter" id="busi_twitter" class="form-control">
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_busi_instagram">
                        <lable for="busi_instagram">Instagram</lable>
                        <input type="text" name="busi_instagram" id="busi_instagram" class="form-control">
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_busi_linkedin">
                        <lable for="busi_linkedin">Linkedin</lable>
                        <input type="text" name="busi_linkedin" id="busi_linkedin" class="form-control">
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_busi_youtube">
                        <lable for="busi_youtube">You Tube</lable>
                        <input type="text" name="busi_youtube" id="busi_youtube" class="form-control">
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group err_business_category">
                        <div class="form-group err_business_category">
                            <label for="sel1">Select Category:</label>
                            <select class="form-control" id="business_category" name="business_category">
                                @foreach ($busi_cats as $busi_cat)
                                    <option value={{ $busi_cat->name }}>{{ $busi_cat->name }}</option>
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
                                <option value="{{ \App\Plan::$start_up_plan_id }}">Start Up Plan Rate</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
    <div class="card-footer">
        <button type="button" class="btn btn-success" id="add_business">Submit</button>
        <a href="{{ route('distributors.business') }}" class="btn btn-danger">Back</a>
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

            var form = document.addBusinessForm;
            var formData = new FormData(form);
            var url = '{{ route('distributors.businessInsert') }}';

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
                        alert(response.message);
                        return false;
                    }
                    alert(response.message);
                    window.location.href = '{{ route('distributors.business') }}'
                }
            });

        });
    </script>
@endsection
