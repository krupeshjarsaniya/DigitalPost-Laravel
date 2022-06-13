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
            <a href="#">Business</a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12" id="editBusiness" style="display: none;">
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
                        <lable for="business_name">Name</lable>
                        <input type="hidden" name="business_id" id="business_id" class="form-control">
                        <input type="text" name="business_name" id="business_name" class="form-control">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group">
                        <lable for="business_mobile">Mobile</lable>
                        <input type="text" name="business_mobile" id="business_mobile" class="form-control">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group">
                        <lable for="business_designation">Designation</lable>
                        <input type="text" name="business_designation" id="business_designation" class="form-control">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                         <div class="form-group ">
                          <label for="sel1">Select Category:</label>
                          <select class="form-control" id="bcategory_list" name="political_category">
                            <option value="" selected="selected" disabled>Select Category</option>
                            @foreach($political_category as $value)

                                <option value="{{$value->pc_id}}">{{$value->pc_name}}</option>

                            @endforeach
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
                        <input type="file" name="logo" id="logo" class="form-control"><br>
                        <img id="logoimg" src="#" alt="your image" style="display: none;width: 100px;height:100px;"/>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group">
                        <label for="logodark" class="form-label">Upload Dark Logo</label>
                        <input type="file" name="logodark" id="logodark" class="form-control"><br>
                        <img id="logodarkimg" src="#" alt="your image" style="display: none;width: 100px;height:100px;"/>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group">
                        <label for="watermark" class="form-label">Upload Watermark</label>
                        <input type="file" name="watermark" id="watermark" class="form-control"><br>
                        <img id="watermarkimg" src="#" alt="your image" style="display: none;width: 100px;height:100px;"/>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group">
                        <label for="watermarkdark" class="form-label">Upload Dark Watermark</label>
                        <input type="file" name="watermarkdark" id="watermarkdark" class="form-control"><br>
                        <img id="watermarkdarkimg" src="#" alt="your image" style="display: none;width: 100px;height:100px;"/>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group">
                        <label for="left" class="form-label">Upload Left Image</label>
                        <input type="file" name="logo" id="left" class="form-control"><br>
                        <img id="leftimg" src="#" alt="your image" style="display: none;width: 100px;height:100px;"/>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group">
                        <label for="right" class="form-label">Upload Right Image</label>
                        <input type="file" name="logo" id="right" class="form-control"><br>
                        <img id="rightimg" src="#" alt="your image" style="display: none;width: 100px;height:100px;"/>
                    </div>

                </div>
            </div>
            <div class="card-action">
                <button class="btn btn-success" onclick="UpdateBusiness()">Submit</button>
                <button class="btn btn-danger" onclick="back()">Cancel</button>
            </div>
        </div>
    </div>
    <div class="col-md-12" id="viewDetail">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card-title" id="country-title">Business Information</div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label for="carrier-drpdwn" class="form-label col-lg-1">Filter By Purchase</label>
                    <select name="carrier_id" id="carrier-drpdwn" class="form-control col-lg-3 ml-1">
                        <option value="">Get All</option>
                        <option value="By Admin">By Admin</option>
                        <option value="By User">By User</option>
                        <option value="Not Purchase">Not Purchase</option>
                    </select>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="display table table-striped table-hover text-center" id="business-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Designation</th>
                                {{-- <th>Website</th>
                                <th>Address</th> --}}
                                <th>logo</th>
                                <th>Watermark</th>
                                <th>logo Dark</th>
                                <th>Watermark Dark</th>
                                <th>Left Image</th>
                                <th>Right Image</th>
                                {{-- <th>Purchase Source</th> --}}
                                <th>Purchase Date</th>
                                <th>Purchase Plan</th>
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
              <button type="button" class="btn btn-success" onclick="purchaseplanpolitical()">purchase</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>

      </div>
  </div>
</div>

@endsection
@section('js')
    <script type="text/javascript" src="{{ url('/public/admin/js/user/politicalbusinesslist.js?v='.rand()) }}"></script>
@endsection
