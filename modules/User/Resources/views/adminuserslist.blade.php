@extends('admin.layouts.app')
@section('title', 'Admin User List')
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
    <h4 class="page-title">User</h4>
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
            <a href="#">User</a>
        </li>
    </ul>
</div>
<div class="row">
  <div class="col-md-12" id="editBusiness" style="display: none;">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <div class="card-title" id="editBusinessName">Edit Business</div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group">
                    <lable for="business_name">Name</lable>
                    <input type="hidden" name="business_id" id="business_id" class="form-control">
                    <input type="hidden" name="user_id" id="user_id" class="form-control">
                    <input type="text" name="business_name" id="business_name" class="form-control">
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group">
                    <lable for="business_email">Email</lable>
                    <input type="text" name="business_email" id="business_email" class="form-control">
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group">
                    <lable for="business_mobile">Mobile</lable>
                    <input type="text" name="business_mobile" id="business_mobile" class="form-control">
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group">
                    <lable for="business_mobile">Mobile 2</lable>
                    <input type="text" name="business_mobile_second" id="business_mobile_second" class="form-control">
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group">
                    <lable for="business_website">Website</lable>
                    <input type="text" name="business_website" id="business_website" class="form-control">
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group">
                    <lable for="business_address">Address</lable>
                    <input type="text" name="business_address" id="business_address" class="form-control">
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group">
                    <label for="logo" class="form-label">Upload Logo</label>
                    <input type="file" name="logo" id="logo" class="form-control"><br>
                    <img id="logoimg" src="#" alt="your image" style="display: none;width: 100px;height:100px;"/>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group">
                        <label for="logo" class="form-label">Upload Watermark</label>
                        <input type="file" name="watermark" id="watermark" class="form-control"><br>
                        <img id="watermarkimg" src="#" alt="your image" style="display: none;width: 100px;height:100px;"/>
                    </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group">
                   <div class="form-group ">
                      <label for="sel1">Select Category:</label>
                      <select class="form-control" id="bcategory_list" name="business_category">
                        
                      </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-action">
            <button class="btn btn-success" onclick="UpdateBusiness()">Submit</button>
            <button class="btn btn-danger" onclick="back()">Cancel</button>
        </div>
    </div>
  </div>
    <div class="col-md-12" id="editPoliticalBusiness" style="display: none;">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card-title">Edit Business</div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group">
                        <lable for="political_business_name">Name</lable>
                        <input type="hidden" name="political_business_id" id="political_business_id" class="form-control">
                        <input type="text" name="political_business_name" id="political_business_name" class="form-control">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group">
                        <lable for="political_business_mobile">Mobile</lable>
                        <input type="text" name="political_business_mobile" id="political_business_mobile" class="form-control">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group">
                        <lable for="political_business_designation">Designation</lable>
                        <input type="text" name="political_business_designation" id="political_business_designation" class="form-control">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                         <div class="form-group ">
                          <label for="sel1">Select Category:</label>
                          <select class="form-control" id="political_list" name="political_category">
                            <option value="" selected="selected" disabled>Select Category</option>
                          </select>
                        </div>   
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group">
                        <lable for="fb_url">Facebook</lable>
                        <input type="text" name="fb_url" id="fb_url" class="form-control">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group">
                        <lable for="twitter_url">Twitter</lable>
                        <input type="text" name="twitter_url" id="twitter_url" class="form-control">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group">
                        <lable for="instagram_url">Instagram</lable>
                        <input type="text" name="instagram_url" id="instagram_url" class="form-control">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group">
                        <lable for="linkedin_url">LinkedIn</lable>
                        <input type="text" name="linkedin_url" id="linkedin_url" class="form-control">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group">
                        <lable for="youtube_url">Youtube</lable>
                        <input type="text" name="youtube_url" id="youtube_url" class="form-control">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group">
                        <label for="logo" class="form-label">Upload Logo</label>
                        <input type="file" name="logo" id="political_logo" class="form-control"><br>
                        <img id="political_logoimg" src="#" alt="your image" style="display: none;width: 100px;height:100px;"/>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group">
                        <label for="watermark" class="form-label">Upload Watermark</label>
                        <input type="file" name="logo" id="political_watermark" class="form-control"><br>
                        <img id="political_watermarkimg" src="#" alt="your image" style="display: none;width: 100px;height:100px;"/>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group">
                        <label for="left" class="form-label">Upload Left Image</label>
                        <input type="file" name="logo" id="political_left" class="form-control"><br>
                        <img id="political_leftimg" src="#" alt="your image" style="display: none;width: 100px;height:100px;"/>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group">
                        <label for="right" class="form-label">Upload Right Image</label>
                        <input type="file" name="logo" id="political_right" class="form-control"><br>
                        <img id="political_rightimg" src="#" alt="your image" style="display: none;width: 100px;height:100px;"/>
                    </div>
		            
                </div>
            </div>
            <div class="card-action">
                <button class="btn btn-success" onclick="UpdatePoliticalBusiness()">Submit</button>
                <button class="btn btn-danger" onclick="backToPoliticalList()">Cancel</button>
            </div>
        </div>
    </div>
  <div class="col-md-12" id="edituser" style="display: none;">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card-title" id="country-title">User Information</div>
                    </div>
                    <div class="col-md-6">
                       {{-- <h3>Set Status</h3> --}}
                      <div class="row float-right">
                        <div class="col-md-8 ">
                         <div class="form-group ">
                            <label for="sel1">Select Status:</label>
                            <select class="form-control" id="tel_status" onchange="ChangeStatus(this)">
                              <option value="">Select Status</option>
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
                        <div class="col-md-2">
                          <button class="btn btn-danger" type="button" onclick="backuser()">Back</button>
                          
                        </div>
                      </div>
                       
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-lg-3">
                       <h3>Name</h3>
                       <div id="uname"></div>
                    </div>
                    <div class="col-md-3 col-lg-3">
                       <h3>Email</h3>
                       <div id="uemail"></div>
                    </div>
                    <div class="col-md-2 col-lg-2">
                       <h3>Mobile</h3>
                       <div id="umobile"></div>
                    </div>
                    <div class="col-md-2 col-lg-2">
                       <h3>Status</h3>
                       <div id="ustatus"></div>
                    </div>
                    <div class="col-md-2 col-lg-2">
                       <h3>View Refferal</h3>
                       <div id="ref_userlistbtn"></div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                          <label for="comment">Comment:</label>
                          <textarea class="form-control" rows="4" id="comment"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="date">Next Follow-Up Date:</label>
                            <input type="date" class="form-control" id='date'>
                        </div>
                        <button type="button" onclick="insertcommentvalue(this)" id="insert_comment" class="btn btn-primary btn-sm">Comment Submit</button>
                    </div>
                </div>
            </div>
        </div>
      <div class="card mt-3">
            <ul class="nav nav-pills nav-secondary m-4" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-normal-tab" data-toggle="pill" href="#pills-normal" role="tab" aria-controls="pills-normal" aria-selected="true">Normal Business</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-political-tab" data-toggle="pill" href="#pills-political" role="tab" aria-controls="pills-political" aria-selected="false">Political Business</a>
                </li>
            </ul>
            <div class="tab-content m-4 mt-2 mb-3" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-normal" role="tabpanel" aria-labelledby="pills-normal-tab">
                    <div class="card-header">
                        <h4 class="card-title">Business Information
                            @if(Auth::user()->user_role == 1)
                            <button type="button" onclick="showBusiness()" class="btn btn-info btn-sm pull-right" id="add-business"><i class="fas fa-plus"></i></button>
                            @endif
                        </h4>
                    </div> 
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display table table-striped table-hover text-center" id="business-table" style=" width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Website</th>
                                        <th>Address</th>
                                        <th>Logo</th>
                                        <th>Watermark</th>
                                        <th>Purchase Source</th>
                                        <th>Plan Name And End Date</th>
                                        <th>Purchase Plan</th>
                                        <th>Action</th>
                                        <th>Remove Business</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="pills-political" role="tabpanel" aria-labelledby="pills-political-tab">
                    <div class="text-center mt-3 mt-2">
                        <h2>Business Information
                        @if(Auth::user()->user_role == 1)
                            <button type="button" onclick="showPoliticalBusiness()" class="btn btn-info btn-sm pull-right" id="add-political-business"><i class="fas fa-plus"></i></button>
                        @endif
                        </h2>
                    </div>
                    <div class="table-responsive">
                        <table class="display table table-striped table-hover text-center" id="political-business-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Designation</th>
                                    <th>logo</th>
                                    <th>Watermark</th>
                                    <th>Left Image</th>
                                    <th>Right Image</th>
                                    <th>Purchase Date</th>
                                    @if(Auth::user()->user_role == 1)
                                    <th>Purchase Plan</th>
                                    <th>Action</th>
                                    @else
                                    <th></th>
                                    <th></th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
   
      
    </div>
      @if(Auth::user()->user_role == 1) 
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card-title" id="country-title">Add Frame</div>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-danger float-right" type="button" onclick="backuser()">Back</button>
                    </div>
                </div>
            </div>
          <div class="text-center card-body mt-3 mt-2"></div>
              <div class="row form-group">
                  <div class="col-md-3">
                      <label for="frame" class="form-label">Upload Frame</label>
                      <input type="file" name="frame" id="frame" class="form-control"><br>
                      <img id="blah" src="#" alt="your image" style="display: none;"/>
                  </div>
                    <div class="col-md-3">
                        <label for="business_type" class="form-label">Business Type</label>
                        <select name="business_type" id="business_type" class="form-control">
                            <option value="1">Normal Business</option>
                            <option value="2">Political Business</option>
                        </select>
                    </div>
                  <div class="col-md-3">
                      <label for="businessid" class="form-label">Select Business</label>
                      <select name="businessid" id="businessid" class="form-control">
                      
                      </select>
                  </div>
                  <div class="col-md-4">
                      <button class="btn btn-primary" onclick="AddFrame()" style="margin-top: 5%;">Add</button>
                  </div>
              </div>
                  <hr>
              <div class="table-responsive">
                  <table class="display table table-striped table-hover text-center" id="frame-list">
                      <thead>
                          <tr>
                              <th>No</th>
                              <th>Business</th>
                              <th>Frame</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                      </tbody>
                  </table>
              </div>

          <div class="card-action text-right">
              <button class="btn btn-danger float-right" type="button" onclick="backuser()">Back</button>
          </div>
        </div>
      @endif
    </div>
    <div class="col-md-12" id="viewUser">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">User List
                {{-- <button type="button" onclick="showinsertform()" class="btn btn-info btn-sm pull-right" id="add-User"><i class="fas fa-plus"></i></button> --}}
                </h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group err_status">
                            <label>Status </label><br>
                            <select name='status' id="status" onchange="getnewusertable()" class="form-control">
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
                    <div class="col-6">
                        <div class="form-group err_status">
                            <label>Date Filter </label><br>
                            <input type="date" name="datefilter" class="form-control" id="datefilter" onchange="getnewusertable()">
                        </div>
                    </div>
                </div>
                {{-- <ul class="nav nav-pills">
                  <li class="nav-item">
                    <a class="nav-link active" data-toggle="pill" href="#new">New</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#hold">Hold</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#complete">Complete</a>
                  </li>
                </ul> --}}
                <div class="tab-content mt-3">
                  <div class="tab-pane active" id="new">
                    <div class="table-responsive">
                        <table class="display table table-striped table-hover text-center" id="adminuser-tablelist">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Comment</th>
                                    <th>Next follow up date</th>
                                    <th>Select User</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="hold">
                    <div class="table-responsive">
                        <table class="display table table-striped table-hover text-center" id="holdadminuser-tablelist" style=" width: 100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Comment</th>
                                    <th>Next follow up date</th>
                                    <th>Select User</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                  </div>
                  <div class="tab-pane  fade" id="complete">
                    <div class="table-responsive">
                        <table class="display table table-striped table-hover text-center" id="completeadminuser-tablelist" style=" width: 100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Comment</th>
                                    <th>Next follow up date</th>
                                    <th>Select User</th>
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
    </div>
    <div class="col-md-12" id="CommentList" style="display: none;">
    
        <div class="card mt-3">
            <div class="card-header">
                <div class="row">
              <div class="col-md-6">
                  <div class="card-title">User Comment List</div>
              </div>
              <div class="col-md-6">
                  <button class="btn btn-danger float-right" type="button" onclick="backuser()">Back</button>
              </div>
          </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="display table table-striped table-hover text-center" id="comment-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Commet</th>
                                <th>Date</th>
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
<div class="modal fade" id="myModal">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">

      <!-- Modal Header -->
          <div class="modal-header">
              <h4 class="modal-title">Reffer UserList</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
              <div class="table-responsive">
                  <table class="display table table-striped table-hover text-center" id="user-reff-list">
                      <thead>
                          <tr>
                              <th>No</th>
                              <th>Name</th>
                              <th>Email</th>
                              <th>Mobile</th>
                              <th>View</th>
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
<div class="modal fade" id="myPlan">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">

      <!-- Modal Header -->
          <div class="modal-header">
              <h4 class="modal-title">Plan List</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
              <div class="form-group ">
                <label for="sel1">Select Plan:</label>
                <select class="form-control" id="planlist">
                  
                </select>
              </div>
          </div>
          <input type="hidden" name="" id="pur_id" value="">

          <!-- Modal footer -->
          <div class="modal-footer">
              <button type="button" class="btn btn-success" onclick="purchaseplan()">purchase</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>

      </div>
  </div>
</div>
@endsection
@section('js')
    <script type="text/javascript" src="{{ url('/public/admin/js/user/adminuserlist.js?v='.rand()) }}"></script>
    <script type="text/javascript" src="{{ url('/public/admin/js/user/admin-user-political.js?v='.rand()) }}"></script>
@endsection