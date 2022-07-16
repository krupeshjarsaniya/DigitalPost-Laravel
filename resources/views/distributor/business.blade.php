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

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Business List
                    <a href="{{ route('distributors.businessAdd') }}" class="btn btn-info btn-sm pull-right" id="add-transaction"><i class="fas fa-plus text-white"></i></a>
                </h4>
            </div>
            <div class="table-responsive">
                <table class="display table table-striped table-hover text-center w-100" id="business-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Category</th>
                            <th>Logo</th>
                            <th>Watermark</th>
                            <th>Logo Dark</th>
                            <th>Watermark Dark</th>
                            <th>Premium</th>
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

<div class="modal fade" id="UsersModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Users</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form onsubmit="return false" method="POST" name="addUserForm" id="addUserForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 form-group err_users">
                                <input type="hidden" name="business_id" id="business_id" value="">
                                <label for="users">Users Mobile Number (Comma(,) Separated)</label>
                                <input type="text" name="users" id="users" class="form-control">
                            </div>
                            <div class="col-md-12 form-group text-right">
                                <button type="button" onclick="addUserToBusiness()" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    </form>
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

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>

var table = "";
var table2 = "";

$(document).ready(function() {
    getBusinessList();
})

function getBusinessList() {
    table = $('#business-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('distributors.businessList', ['id' => Auth::user()->distributor->id]) }}",
        columns: [
            {data: 'DT_RowIndex', name: 'busi_id'},
            {data: 'busi_name', name: 'busi_name'},
            {data: 'busi_email', name: 'busi_email'},
            {data: 'busi_mobile', name: 'busi_mobile'},
            {data: 'business_category', name: 'business_category'},
            {data: 'busi_logo', name: 'busi_logo'},
            {data: 'watermark_image', name: 'watermark_image'},
            {data: 'busi_logo_dark', name: 'busi_logo_dark'},
            {data: 'watermark_image_dark', name: 'watermark_image_dark'},
            {data: 'is_premium', name: 'is_premium', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        order: [[1, 'desc']]
    });
}

</script>
@endsection
