@extends('admin.layouts.app')
@section('title', 'Popup')
@section('content')
<style type="text/css">
    .select2-container {
        width: 100% !important;
    }
</style>
<div class="page-header">
    <h4 class="page-title">Popup</h4>
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
            <a href="#">Popup</a>
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
                <h4 class="card-title">Popup List
                <button class="btn btn-info btn-sm pull-right" id="add-popup"><i class="fas fa-plus"></i></button>
                </h4>
            </div>
            <div class="table-responsive">
                <table class="display table table-striped table-hover text-center w-100" id="popup-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>User Type</th>
                            <th>Start Date</th>
                            <th>End Date</th>
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

<div class="modal fade" id="addPopupModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form name="addPopupForm" id="addPopupForm" enctype="multipart/form-data">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add Popup</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group err_image">
                                <input type="file" id="image" name="image" class="form-control photos">
                            </div>
                        </div>
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
                            <div class="form-group err_start_date">
                                <label>Start Date</label><br>
                                <input type="date" class="form-control" id="start_date" name="start_date">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group err_end_date">
                                <label>End Date</label><br>
                                <input type="date" class="form-control" id="end_date" name="end_date">
                            </div>
                        </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success"  onclick="addPopup()">Submit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="editPopupModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form name="editPopupForm" id="editPopupForm" enctype="multipart/form-data">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit Popup</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="edit_id" value>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group err_edit_image">
                                <input type="file" id="edit_image" name="edit_image" class="form-control photos">
                            </div>
                        </div>
                        <div class="col-6">
                            <img id="image_view" src="#" alt="your image" height="100" width="100" >
                        </div>
                        <div class="col-12">
                            <div class="form-check">
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
                            <div class="form-group err_edit_start_date">
                                <label>Start Date</label><br>
                                <input type="date" class="form-control" id="edit_start_date" name="edit_start_date">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group err_edit_end_date">
                                <label>End Date</label><br>
                                <input type="date" class="form-control" id="edit_end_date" name="edit_end_date">
                            </div>
                        </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success"  onclick="updatePopup()">Submit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('js')
<script type="text/javascript" src="{{ url('/public/admin/js/user/popup.js?v='.rand()) }}"></script>
@endsection