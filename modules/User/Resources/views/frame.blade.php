@extends('admin.layouts.app')
@section('title', 'Frame')
@section('content')
<style type="text/css">
    .select2-container {
        width: 100% !important;
    }
</style>
<div class="page-header">
    <h4 class="page-title">Frame</h4>
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
            <a href="#">Frame</a>
        </li>
    </ul>
</div>
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
@if(session()->has('error'))
    <div class="alert alert-danger">
        {{ session()->get('error') }}
    </div>
@endif
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Frame List
                <button class="btn btn-info btn-sm pull-right" id="add-frame"><i class="fas fa-plus"></i></button>
                </h4>
            </div>
            <div class="table-responsive">
                <table class="display table table-striped table-hover text-center w-100" id="frame-table">
                    <thead>
                        <tr>
                            <th>Frame</th>
                            <th>Type</th>
                            <th>Is Active</th>
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

<div class="modal fade" id="addFrameModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form name="addFrameForm" id="addFrameForm">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add Frame</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group err_frame_image">
                                <label for="frame_image">Frame Image</label>
                                <input type="file" class="form-control" id="frame_image" name="frame_image" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group err_frame_type">
                                <label for="frame_type">Frame Type</label>
                                <select class="form-control" id="frame_type" name="frame_type" required>
                                    <option value="Business">Business</option>
                                    <option value="Photo">Photo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success"  onclick="addFrame()">Submit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editFrameModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form name="editFrameForm" id="editFrameForm">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit Frame</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="edit_id" value>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group err_edit_frame_image">
                                <label for="edit_frame_image">Frame Image</label>
                                <input type="file" class="form-control" id="edit_frame_image" name="edit_frame_image">
                            </div>
                        </div>
                        <div class="col-6">
                            <img id="image_view" src="#" alt="your image" height="100" width="100" >
                        </div>
                        <div class="col-md-6">
                            <div class="form-group err_edit_frame_type">
                                <label for="edit_frame_type">Frame Type</label>
                                <select class="form-control" id="edit_frame_type" name="edit_frame_type" required>
                                    <option value="Business">Business</option>
                                    <option value="Photo">Photo</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group err_edit_is_active">
                                <label for="edit_is_active">Is Active</label>
                                <select class="form-control" id="edit_is_active" name="edit_is_active" required>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success"  onclick="updateFrame()">Submit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('js')
<script type="text/javascript" src="{{ url('/public/admin/js/user/frame.js?v='.rand()) }}"></script>
@endsection