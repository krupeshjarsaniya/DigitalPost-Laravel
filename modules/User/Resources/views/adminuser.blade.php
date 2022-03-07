@extends('admin.layouts.app')
@section('title', 'Admin User')
@section('content')

<style>
    .imageThumb {
  max-height: 75px;
  border: 2px solid;
  padding: 1px;
  cursor: pointer;
}
.pip {
  display: inline-block;
  margin: 10px 10px 0 0;
}
.remove {
  display: block;
  background: #444;
  border: 1px solid black;
  color: white;
  text-align: center;
  cursor: pointer;
}
.remove:hover {
  background: white;
  color: black;
}

</style>
<div class="page-header">
    <h4 class="page-title">Admin User</h4>
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
            <a href="#">Admin User</a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12" id="addfestival" style="display: none;">
        <div class="card">
            <div class="card-header">
                <div class="card-title" id="country-title">Add Admin User</div>
            </div>
            <form id="adminuser" name="adminuser" {{-- action={{route('addadminuser')}} --}} onsubmit="return false;" method="post" enctype='multipart/form-data'>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        
                            @csrf
                            <div class="row">
                                <div class="col-md-4 err_fullname">
                                    <input type="hidden" name="userid" id="userid" value="" placeholder="">
                                    <div class="form-group">
                                        <label for="fullname">Full Name</label>
                                        <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Enter full name" >
                                    </div>
                                </div>
                                <div class="col-md-4 err_email">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" class="form-control" id="email" placeholder="Enter Email" name="email" >
                                    </div>
                                </div> 
                                {{-- <div class="col-md-4 err_mobile">
                                    <div class="form-group">
                                        <label for="mobile">Phone</label>
                                        <input type="number" class="form-control" id="mobile" placeholder="Enter Phone" name="mobile" >
                                    </div>
                                </div> --}}
                                <div class="col-md-4">
                                    <div class="form-group err_userpassword">
                                        <label for="userpassword">Password</label>
                                        <input type="password" class="form-control" id="userpassword" placeholder="Enter Password" name="userpassword" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group err_con_password">
                                        <label for="con_password">Conform Password</label>
                                        <input type="password" class="form-control" id="con_password" placeholder="Enter Conform Password" name="con_password" >
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group err_user_role">
                                        <label for="sel1">Select Role:</label>
                                        <select class="form-control" name="user_role" id="user_role">
                                          <option value="">Select Role</option>
                                          <option value="1">Master Admin</option>
                                          <option value="2">Telecaller</option>
                                          <option value="3">Manager</option>
                                          <option value="4">Designer</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="col-md-6">
                                    <div class="form-group err_userimage">
                                        <label for="userimage">Image</label>
                                        <input type="file" class="form-control" onchange="readURL(this);" id="userimage" name="userimage" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <img id="blah" src="{{ asset('public/admin/logo/user-image.jpg')}}" alt="your image" height="100" width="100" />
                                    </div>
                                </div> --}}
                                
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-action text-right">
                <button class="btn btn-success" type="submit"  id="festival-btn" onclick="addadminuser()">Submit</button>&nbsp;&nbsp;
                <button class="btn btn-danger"  type="button" onclick="showfestivallist()">Cancel</button>
            </div>
             </form>
        </div>
    </div>
    <div class="col-md-12" id="viewfestival">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Admin User List
                <button type="button" onclick="showinsertform()" class="btn btn-info btn-sm pull-right" id="add-festival"><i class="fas fa-plus"></i></button>
                </h4>
            </div>
            <div class="card-body">
            
                <div class="table-responsive">
                    <table class="display table table-striped table-hover text-center" id="adminuser-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>User Role</th>
                                {{-- <th>Mobile</th> --}}
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
</div>
@endsection
@section('js')
    <script type="text/javascript" src="{{ url('/public/admin/js/user/adminuser.js?v='.rand()) }}"></script>
@endsection