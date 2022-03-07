@extends('admin.layouts.app')
@section('title', 'Users')
@section('content')
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
            <a href="#">Permissions</a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card-title">Permissions</div>
                    </div>
                </div>
            </div>
            <form id="permission_form" name="permission_form" onsubmit="return false;" method="post">
                <div class="card-body">
                    <div class="form-group row">
                        <select name="user_role" id="user_role" onchange="permissionChange()" class="form-control col-lg-3 ml-1">
                            <option value="" selected disabled>Select User Role</option>
                            <option value="2">Telecaller</option>
                            <option value="3">Manager</option>
                            <option value="4">Designer</option>
                        </select>
                    </div>
                    <hr>
                    <div id="permission_view">
                    </div>
                </div>
                <div class="card-action text-right">
                    <button class="btn btn-success" type="submit" style="display: none;" id="updatePermissionButton" onclick="updatepermission()">Submit</button>&nbsp;&nbsp;
            </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('js')
    <script type="text/javascript" src="{{ url('/public/admin/js/user/permission.js?v='.rand()) }}"></script>
@endsection