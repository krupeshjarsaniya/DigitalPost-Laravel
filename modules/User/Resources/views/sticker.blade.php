@extends('admin.layouts.app')
@section('title', 'Sticker')
@section('content')
<style type="text/css">
    .select2-container {
        width: 100% !important;
    }
</style>
<div class="page-header">
    <h4 class="page-title">Sticker</h4>
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
            <a href="#">Sticker</a>
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
                <h4 class="card-title">Sticker Category List
                <button class="btn btn-info btn-sm pull-right" id="add-sticker-category"><i class="fas fa-plus"></i></button>
                </h4>
            </div>
            <div class="table-responsive">
                <table class="display table table-striped table-hover text-center w-100" id="sticker-category-table">
                    <thead>
                        <tr>
                            <th>Category</th>
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

<div class="modal fade" id="addStickerCategoryModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form name="addStickerCategoryForm" id="addStickerCategoryForm">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add Category</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group err_name">
                                <label>Name</label><br>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group err_order_number">
                                <label>Order</label><br>
                                <input type="number" class="form-control" id="order_number" name="order_number">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success"  onclick="addStickerCategory()">Submit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editStickerModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form name="editStickerForm" id="editStickerForm">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit Category</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="edit_id" value>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group err_edit_name">
                                <label>Name</label><br>
                                <input type="text" class="form-control" id="edit_name" name="edit_name">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group err_edit_order_number">
                                <label>Order</label><br>
                                <input type="number" class="form-control" id="edit_order_number" name="edit_order_number">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success"  onclick="updateStickerCategory()">Submit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addStickerModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add Sticker</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form name="addStickerForm" id="addStickerForm" enctype="multipart/form-data">
                    <input type="hidden" name="category_id" id="category_id" value="">
                    <div class="row">
                        <div class="col-10">
                            <div class="form-group err_files">
                                <input type="file" id="files" multiple name="files[]" class="form-control photos">
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <button type="button" class="btn btn-success"  onclick="addSticker()">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="display table table-striped table-hover text-center w-100" id="sticker-table">
                        <thead>
                            <tr>
                                <th>Sticker</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script type="text/javascript" src="{{ url('/public/admin/js/user/sticker.js?v='.rand()) }}"></script>
@endsection