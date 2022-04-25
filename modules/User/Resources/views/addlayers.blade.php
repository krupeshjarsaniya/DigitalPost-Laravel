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

<div class="card">
    <div class="card-header">
        <h4 class="card-title">Frame</h4>
    </div>
    <div class="card-body">
        <div class="row">
        <div class="col-md-4">
            <input type="hidden"  id="frame_id" value="{{ $frame->id }}">
            <img src="{{ $frame->frame_image }}" id="loading" height="100px" width="100px">
        </div>
        <div class="col-md-4">
            <label>Frame Type: </label>
            <b>{{ $frame->frame_type }}</b>
        </div>
        <div class="col-md-4">
            <label>Status: </label>
            @if($frame->is_active == 1)
                <b>Active</b>
            @else
                <b>Inactive</b>
            @endif
        </div>

        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Components List
                <button class="btn btn-info btn-sm pull-right" id="add-components"><i class="fas fa-plus"></i></button>
                </h4>
            </div>
            <div class="table-responsive">
                <table class="display table table-striped table-hover text-center w-100" id="components-table">
                    <thead>
                        <tr>
                            <th>Component For</th>
                            <th>Image</th>
                            <th>Pos X</th>
                            <th>Pos Y</th>
                            <th>Height</th>
                            <th>Width</th>
                            <th>Order</th>
                            <th>Field Three</th>
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

<div class="modal fade" id="addComponentModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form name="addComponentForm" id="addComponentForm">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add Component</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" name="frame_id" id="frame_id" value="{{ $frame->id }}">
                            <div class="form-group err_image_for">
                                <label>Component For</label>
                                <select class="form-control" name="image_for" id="image_for">
                                    <option value="0">Other</option>
                                    @foreach ($image_fields as $field)
                                        <option value="{{ $field->id }}">{{ $field->field_value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group err_order_">
                                <label>Order</label>
                                <input type="number" class="form-control" name="order_" id="order_">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group err_pos_x">
                                <label>Pos X</label>
                                <input type="number" class="form-control" name="pos_x" id="pos_x">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group err_pos_y">
                                <label>Pos Y</label>
                                <input type="number" class="form-control" name="pos_y" id="pos_y">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group err_height">
                                <label>Height</label>
                                <input type="number" class="form-control" name="height" id="height">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group err_width">
                                <label>Width</label>
                                <input type="number" class="form-control" name="width" id="width">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group err_field_three">
                                <label>Field Three</label>
                                <select class="form-control" name="field_three" id="field_three">
                                    <option value="unlocked">unlocked</option>
                                    <option value="locked">locked</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6" id="stkr_path_wrapper">
                            <div class="form-group err_stkr_path">
                                <label>Image</label>
                                <input type="file" class="form-control" name="stkr_path" id="stkr_path">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success"  onclick="addComponent()">Submit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editComponentModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form name="editComponentForm" id="editComponentForm">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit Component</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="edit_id" id="edit_id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group err_edit_image_for">
                                <label>Component For</label>
                                <select class="form-control" name="edit_image_for" id="edit_image_for">
                                    <option value="0">Other</option>
                                    @foreach ($image_fields as $field)
                                        <option value="{{ $field->id }}">{{ $field->field_value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group err_edit_order_">
                                <label>Order</label>
                                <input type="number" class="form-control" name="edit_order_" id="edit_order_">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group err_edit_pos_x">
                                <label>Pos X</label>
                                <input type="number" class="form-control" name="edit_pos_x" id="edit_pos_x">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group err_edit_pos_y">
                                <label>Pos Y</label>
                                <input type="number" class="form-control" name="edit_pos_y" id="edit_pos_y">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group err_edit_height">
                                <label>Height</label>
                                <input type="number" class="form-control" name="edit_height" id="edit_height">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group err_edit_width">
                                <label>Width</label>
                                <input type="number" class="form-control" name="edit_width" id="edit_width">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group err_edit_field_three">
                                <label>Field Three</label>
                                <select class="form-control" name="edit_field_three" id="edit_field_three">
                                    <option value="unlocked">unlocked</option>
                                    <option value="locked">locked</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6" id="edit_stkr_path_wrapper">
                            <div class="form-group err_edit_stkr_path">
                                <label>Image</label>
                                <input type="file" class="form-control" name="edit_stkr_path" id="edit_stkr_path">
                            </div>
                            <img src="" id="edit_stkr_path_img" width="100" height="100">
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success"  onclick="updateComponent()">Submit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Text List
                <button class="btn btn-info btn-sm pull-right" id="add-text"><i class="fas fa-plus"></i></button>
                </h4>
            </div>
            <div class="table-responsive">
                <table class="display table table-striped table-hover text-center w-100" id="text-table">
                    <thead>
                        <tr>
                            <th>Text For</th>
                            <th>Text Color</th>
                            <th>Pos X</th>
                            <th>Pos Y</th>
                            <th>Height</th>
                            <th>Width</th>
                            <th>Order</th>
                            <th>Field Four</th>
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

<div class="modal fade" id="addTextModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form name="addTextForm" id="addTextForm">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add Text</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" name="frame_id" id="frame_id" value="{{ $frame->id }}">
                            <div class="form-group err_text_for">
                                <label>Component For</label>
                                <select class="form-control" name="text_for" id="text_for">
                                    <option value="">Select</option>
                                    @foreach ($text_fields as $field)
                                        <option value="{{ $field->id }}">{{ $field->field_value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group err_text_color">
                                <label>Text Color</label>
                                <input type="text" class="form-control" name="text_color" id="text_color">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group err_order_">
                                <label>Order</label>
                                <input type="number" class="form-control" name="order_" id="text_order_">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group err_pos_x">
                                <label>Pos X</label>
                                <input type="number" class="form-control" name="pos_x" id="text_pos_x">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group err_pos_y">
                                <label>Pos Y</label>
                                <input type="number" class="form-control" name="pos_y" id="text_pos_y">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group err_height">
                                <label>Height</label>
                                <input type="number" class="form-control" name="height" id="text_height">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group err_width">
                                <label>Width</label>
                                <input type="number" class="form-control" name="width" id="text_width">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group err_field_four">
                                <label>Field Three</label>
                                <select class="form-control" name="field_four" id="text_field_four">
                                    <option value="unlocked">unlocked</option>
                                    <option value="locked">locked</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success"  onclick="addText()">Submit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editTextModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form name="editTextForm" id="editTextForm">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit Text</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" name="edit_text_id" id="edit_text_id">
                            <div class="form-group err_edit_text_for">
                                <label>Component For</label>
                                <select class="form-control" name="edit_text_for" id="edit_text_for">
                                    <option value="">Select</option>
                                    @foreach ($text_fields as $field)
                                        <option value="{{ $field->id }}">{{ $field->field_value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group err_edit_text_color">
                                <label>Text Color</label>
                                <input type="text" class="form-control" name="edit_text_color" id="edit_text_color">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group err_edit_order_">
                                <label>Order</label>
                                <input type="number" class="form-control" name="edit_order_" id="edit_text_order_">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group err_edit_pos_x">
                                <label>Pos X</label>
                                <input type="number" class="form-control" name="edit_pos_x" id="edit_text_pos_x">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group err_edit_pos_y">
                                <label>Pos Y</label>
                                <input type="number" class="form-control" name="edit_pos_y" id="edit_text_pos_y">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group err_edit_height">
                                <label>Height</label>
                                <input type="number" class="form-control" name="edit_height" id="edit_text_height">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group err_edit_width">
                                <label>Width</label>
                                <input type="number" class="form-control" name="edit_width" id="edit_text_width">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group err_edit_field_four">
                                <label>Field Four</label>
                                <select class="form-control" name="edit_field_four" id="edit_text_field_four">
                                    <option value="unlocked">unlocked</option>
                                    <option value="locked">locked</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success"  onclick="updateText()">Submit</button>
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
