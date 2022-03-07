@extends('admin.layouts.app')
@section('title', 'Push Notification')
@section('content')
<style type="text/css">
    .select2-container {
        width: 100% !important;
    }
</style>
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
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Scheduled Push Notification List
                <button class="btn btn-info btn-sm pull-right" id="add-notification"><i class="fas fa-plus"></i></button>
                </h4>
            </div>
            <div class="card-body">
                <div class="card-body">
                    <ul class="nav nav-pills nav-secondary m-4" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pending-notification-tab" data-toggle="pill" href="#pendingNotification" role="tab" aria-controls="pendingNotification" aria-selected="true">Pending Notification</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="completed-notification-tab" data-toggle="pill" href="#completedNotification" role="tab" aria-controls="completedNotification" aria-selected="true">Completed Notification</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content m-4 mt-2 mb-3" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pendingNotification" role="tabpanel" aria-labelledby="pending-notification-tab">
                        <div class="table-responsive">
                            <table class="display table table-striped table-hover text-center w-100" id="pending-notification-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>User Type</th>
                                        <th>Notification Type</th>
                                        <th>Notification For</th>
                                        <th>Title</th>
                                        <th>Message</th>
                                        <th>Image</th>
                                        <th>Is Scheduled</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="completedNotification" role="tabpanel" aria-labelledby="completed-notification-tab">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover text-center w-100" id="completed-notification-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>User Type</th>
                                    <th>Notification Type</th>
                                    <th>Notification For</th>
                                    <th>Title</th>
                                    <th>Message</th>
                                    <th>Image</th>
                                    <th>Is Scheduled</th>
                                    <th>Date</th>
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
    </div>
</div>

<div class="modal fade" id="addPushNotificationModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form name="addPushNotificationForm" id="addPushNotificationForm" enctype="multipart/form-data">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add Notification</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-check">
                                <div class="form-group err_user_type">
                                    <label for="user_type">Select Users:</label>
                                    <select class="form-control select2" id="user_type" name="user_type">
                                        <option>All</option>
                                        <option>Premium</option>
                                        <option>Free</option>
                                    </select>
                                </div> 
                                
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group err_notification_type">
                                <label for="notification_type">Notification Type:</label>
                                <select class="form-control select2" id="notification_type" name="notification_type">
                                    <option value="" disabled selected>Select Notification Type</option>
                                    <option value="1">Normal Business Categories</option>
                                    <option value="2">Political Business Categories</option>
                                    <option value="3">Festivals</option>
                                    <option value="4">Greetings</option>
                                    <option value="5">Offer</option>
                                </select>
                            </div>                            
                        </div>
                        <div class="col-6">
                            <div class="form-group err_notification_for">
                                <label for="notification_for">Notification For:</label>
                                <select class="form-control select2" id="notification_for" name="notification_for">
                                    <option value="" disabled selected>Select Notification For</option>
                                </select>
                            </div>                            
                        </div>
                        <div class="col-12">
                            <div class="form-group err_title">
                                <label>Enter Title</label><br>
                                <input type="text" class="form-control" id="title" name="title">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group err_message">
                                <label>Enter Message</label><br>
                                <textarea name="message" cols="70" rows="2" class="form-control" id="message"></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group err_image">
                                <label>Upload Image</label><br>
                                <input type="file" name="image" id="image" class="form-control">
                                <img id="image_view" src="#" alt="your image" height="100" width="100" style="display: none;"/>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="form-check">
                                <label>Schedule Notification?</label><br>
                                <label class="form-radio-label">
                                    <input class="form-radio-input" type="radio" name="is_scheduled" value="1" checked="" id="is_scheduled_true">
                                    <span class="form-radio-sign">Schedule</span>
                                </label>
                                <label class="form-radio-label ml-3">
                                    <input class="form-radio-input" type="radio" name="is_scheduled" value="0" id="is_scheduled_false">
                                    <span class="form-radio-sign">Send Now</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 date_wrapper">
                            <div class="form-group err_scheduled_date">
                                <label>Schedule Time</label><br>
                                <input type="datetime-local" class="form-control" name="scheduled_date" id="scheduled_date">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" on class="btn btn-primary" onclick="schedule_notification()">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editPushNotificationModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form name="editPushNotificationForm" id="editPushNotificationForm" enctype="multipart/form-data">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit Notification</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-check">
                                <input type="hidden" name="edit_id" id="edit_id" value="">
                                <div class="form-group err_edit_user_type">
                                    <label for="edit_user_type">Select Users:</label>
                                    <select class="form-control select2" id="edit_user_type" name="edit_user_type">
                                        <option>All</option>
                                        <option>Premium</option>
                                        <option>Free</option>
                                    </select>
                                </div> 
                                
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group err_edit_notification_type">
                                <label for="edit_notification_type">Notification Type:</label>
                                <select class="form-control select2" id="edit_notification_type" name="edit_notification_type">
                                    <option value="" disabled selected>Select Notification Type</option>
                                    <option value="1">Normal Business Categories</option>
                                    <option value="2">Political Business Categories</option>
                                    <option value="3">Festivals</option>
                                    <option value="4">Greetings</option>
                                    <option value="5">Offer</option>
                                </select>
                            </div>                            
                        </div>
                        <div class="col-6">
                            <div class="form-group err_edit_notification_for">
                                <label for="edit_notification_for">Notification For:</label>
                                <select class="form-control select2" id="edit_notification_for" name="edit_notification_for">
                                    <option value="" disabled selected>Select Notification For</option>
                                </select>
                            </div>                            
                        </div>
                        <div class="col-12">
                            <div class="form-group err_edit_title">
                                <label for="edit_title">Enter Title</label><br>
                                <input type="text" class="form-control" id="edit_title" name="edit_title">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group err_edit_message">
                                <label for="edit_message">Enter Message</label><br>
                                <textarea name="edit_message" cols="70" rows="2" class="form-control" id="edit_message"></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group err_image">
                                <label>Upload Image</label><br>
                                <input type="file" name="edit_image" id="edit_image" class="form-control">
                                <img id="edit_image_view" src="#" alt="your image" height="100" width="100" style="display: none;"/>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="form-check">
                                <label>Schedule Notification?</label><br>
                                <label class="form-radio-label">
                                    <input class="form-radio-input" type="radio" name="edit_is_scheduled" value="1" checked="" id="edit_is_scheduled_true">
                                    <span class="form-radio-sign">Schedule</span>
                                </label>
                                <label class="form-radio-label ml-3">
                                    <input class="form-radio-input" type="radio" name="edit_is_scheduled" value="0" id="edit_is_scheduled_false">
                                    <span class="form-radio-sign">Send Now</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 date_edit_wrapper">
                            <div class="form-group err_edit_scheduled_date">
                                <label>Schedule Time</label><br>
                                <input type="datetime-local" class="form-control" name="edit_scheduled_date" id="edit_scheduled_date">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" on class="btn btn-primary" onclick="schedule_notification_update()">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('js')
<script type="text/javascript" src="{{ url('/public/admin/js/user/push-notification.js?v='.rand()) }}"></script>
@endsection