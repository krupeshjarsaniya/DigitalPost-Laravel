@extends('admin.layouts.app')
@section('title', 'Music Category')
@section('content')
<style type="text/css">
    .select2-container {
        width: 100% !important;
    }
</style>
<div class="page-header">
    <h4 class="page-title">Music Category</h4>
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
            <a href="#">Music Category</a>
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
                <h4 class="card-title">Music Category List
                <button class="btn btn-info btn-sm pull-right" id="add-music-category"><i class="fas fa-plus"></i></button>
                </h4>
            </div>
            <div class="table-responsive">
                <table class="display table table-striped table-hover text-center w-100" id="music-category-table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Order</th>
                            <th>Status</th>
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

<div class="modal fade" id="music-category-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Music Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="music-category-form" name="musicCategoryForm" method="POST" onsubmit="return false;">
                <div class="modal-body">
                    <div class="form-group err_category">
                        <label for="category">Category</label>
                        <input type="text" class="form-control" id="category" name="category" placeholder="Enter Category">
                    </div>
                    <div class="form-group err_order_number">
                        <label for="order_number">Order</label>
                        <input type="number" class="form-control" id="order_number" name="order_number" placeholder="Enter Order">
                    </div>
                    <div class="form-group err_is_active">
                        <label for="is_active">Status</label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option value="">Select Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success"  onclick="addMusicCategory()">Submit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="edit-music-category-modal" aria-labelledby="edit-music-category-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Music Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="edit-music-category-form" name="editMusicCategoryForm" method="POST" onsubmit="return false;">
                <input type="hidden" id="edit_id" name="id" value="" />
                <div class="modal-body">
                    <div class="form-group err_edit_category">
                        <label for="edit_category">Category</label>
                        <input type="text" class="form-control" id="edit_category" name="category" placeholder="Enter Category">
                    </div>
                    <div class="form-group err_edit_order_number">
                        <label for="edit_order_number">Category</label>
                        <input type="text" class="form-control" id="edit_order_number" name="order_number" placeholder="Enter Order">
                    </div>
                    <div class="form-group err_edit_is_active">
                        <label for="edit_is_active">Status</label>
                        <select name="is_active" id="edit_is_active" class="form-control">
                            <option value="">Select Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success"  onclick="updateMusicCategory()">Submit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('js')
<script type="text/javascript" src="{{ url('/public/admin/js/user/musicCategory.js?v='.rand()) }}"></script>
@endsection
