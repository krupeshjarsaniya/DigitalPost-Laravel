@extends('admin.layouts.app')
@section('title', 'Push Notification')
@section('content')
<div class="page-header">
    <h4 class="page-title">Push Notification</h4>
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
            <a href="#">Push Notification</a>
        </li>
    </ul>
</div>
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
<div class="row">
    <div class="col-md-12" id="addnotification">
        <form action="{{ url('user/sendpushnotification') }}" name="notificationForm" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
            @csrf
            <div class="card">
                <div class="card-header">
                    <div class="card-title" id="notification-title">Send Push Notification</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-check">
                                            <label>Select Users</label><br>
                                            <label class="form-radio-label">
                                                <input class="form-radio-input" type="radio" name="usertype" value="all" checked="">
                                                <span class="form-radio-sign">All</span>
                                            </label>
                                            <label class="form-radio-label ml-3">
                                                <input class="form-radio-input" type="radio" name="usertype" value="premium">
                                                <span class="form-radio-sign">Premium</span>
                                            </label>
                                            <label class="form-radio-label ml-3">
                                                <input class="form-radio-input" type="radio" name="usertype" value="free">
                                                <span class="form-radio-sign">Free</span>
                                            </label>
                                        </div>
                                    </div>
                            
                                    <div class="col-lg-9 col-md-9">
                                        <div class="form-group">
                                            <label>Enter Discription</label><br>
                                            <textarea name="discription" cols="70" rows="5" class="form-control" id="descriptionbox"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <label>Upload Image</label><br>
                                            <input type="file" class="form-control" onchange="readURL(this,'bannerimg');" id="fimage" name="image">
                                            <img id="image" src="#" alt="your image" height="100" width="100" style="display: none;"/>
                                        </div>
                                    </div>
                                </div>
                                
                            
                        </div>
                    </div>
                </div>
                <div class="card-action text-right">
                    <button class="btn btn-success" type="submit" id="send-notification">Submit</button>&nbsp;&nbsp;
                    <!-- <button class="btn btn-danger" id="view-country">Cancel</button> -->
                </div>
            </div>
        </form>
    </div>

</div>

@endsection
@section('js')
    <script type="text/javascript" src="{{ url('/public/admin/js/user/pushnotification.js?v='.rand()) }}"></script>
@endsection