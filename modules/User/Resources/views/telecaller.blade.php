@extends('admin.layouts.app')
@section('title', 'Telecaller')
@section('content')
<style type="text/css">
    .select2-container {
        width: 100% !important;
    }
</style>
<div class="page-header">
    <h4 class="page-title">Telecaller</h4>
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
            <a href="#">Telecaller</a>
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
                <div class="row">
                    <div class="col-6">
                        <h4 class="card-title">Telecaller List
                        </h4>
                    </div>
                    <div class="col-6">
                        <div class="text-right">
                            <button class="btn btn-primary btn-sm" onclick="openTransferUserModal()">Transfer User</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="display table table-striped table-hover text-center" id="telecaller-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Assigned Users</th>
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

<div class="modal fade" id="assigneUserModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Assigne User</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form name="assigneUserForm" id="assigneUserForm" enctype="multipart/form-data">
                    <input type="hidden" name="telecaller_id" id="telecaller_id" value="">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group err_date">
                                <label>Select Date</label><br>
                                <input type="date" onchange="getUserByDate(this)" class="form-control" id="date" name="date">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group err_date">
                                <label>Limit</label><br>
                                <input type="number" onchange="getUserByDate(this)" class="form-control" id="limit" name="limit">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group err_users">
                                <label>Select Users <span id="total_user"></span></label><br>
                                <select name='users[]' multiple id="users" class="form-control">
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group err_date">
                                <label>Follow-Up Date</label><br>
                                <input type="date" class="form-control" id="follow_up_date" name="follow_up_date">
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="button" class="btn btn-success"  onclick="assigneUserAdd()">Submit</button>
                        </div>
                    </div>
                </form>
                <div class="my-2">
                    <div class="form-group">
                        <label for="change_status">Select Status:</label>
                        <select class="form-control" id="change_status" onchange="changeStatus(this)">
                            <option value="">All</option>
                            <option value="0">New Lead</option>
                            <option value="1">Hold</option>
                            <option value="2">Intersted but not now</option>
                            <option value="3">Payment Details shared</option>
                            <option value="4">Call Back</option>
                            <option value="5">Trail Request</option>
                            <option value="6">Not Intersted</option>
                            <option value="7">Complete</option>
                        </select>
                    </div>
                </div>
                <div class="table-responsive mt-2">
                    <table class="display table table-striped table-hover text-center w-100" id="assigne-user-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Follow-Up Date</th>
                                <th>Status</th>
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

<div class="modal fade" id="transferUserModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Transfer User</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form name="transferUserForm" id="transferUserForm" onsubmit="return false;">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group err_from_telecaller">
                                <label for="from_telecaller">From:</label>
                                <select class="form-control" name="from_telecaller" id="from_telecaller">
                                    @foreach($telecallers as $telecaller)
                                        <option value="{{$telecaller->id}}">{{$telecaller->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group err_to_telecaller">
                                <label for="to_telecaller">From:</label>
                                <select class="form-control" name="to_telecaller" id="to_telecaller">
                                    @foreach($telecallers as $telecaller)
                                        <option value="{{$telecaller->id}}">{{$telecaller->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 text-right">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary" onclick="transferUser()">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
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
<script type="text/javascript" src="{{ url('/public/admin/js/user/telecaller.js?v='.rand()) }}"></script>
@endsection