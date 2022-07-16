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
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Political Business List
                    <a href="{{ route('distributors.politicalBusinessAdd') }}" class="btn btn-info btn-sm pull-right"><i class="fas fa-plus text-white"></i></a>
                </h4>
            </div>
            <div class="table-responsive">
                <table class="display table table-striped table-hover text-center w-100" id="business-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Mobile</th>
                            <th>Category</th>
                            <th>Logo</th>
                            <th>Logo Dark</th>
                            <th>Watermark</th>
                            <th>Watermark Dark</th>
                            <th>Left Image</th>
                            <th>Right Image</th>
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


@endsection

@section('js')
<script>

var table = "";

$(document).ready(function() {
    getBusinessList();
})

function getBusinessList() {
    table = $('#business-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('distributors.politicalBusinessList', ['id' => Auth::user()->distributor->id]) }}",
        columns: [
            {data: 'DT_RowIndex', name: 'busi_id'},
            {data: 'pb_name', name: 'pb_name'},
            {data: 'pb_designation', name: 'pb_designation'},
            {data: 'pb_mobile', name: 'pb_mobile'},
            {data: 'category.pc_name', name: 'category.pc_name'},
            {data: 'pb_party_logo', name: 'pb_party_logo'},
            {data: 'pb_party_logo_dark', name: 'pb_party_logo_dark'},
            {data: 'pb_watermark', name: 'pb_watermark'},
            {data: 'pb_watermark_dark', name: 'pb_watermark_dark'},
            {data: 'pb_left_image', name: 'pb_left_image'},
            {data: 'pb_right_image', name: 'pb_right_image'},
            {data: 'is_premium', name: 'is_premium', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        order: [[1, 'desc']]
    });
}

</script>
@endsection
