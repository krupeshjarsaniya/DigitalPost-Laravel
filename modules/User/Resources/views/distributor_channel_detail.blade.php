@extends('admin.layouts.app')
@section('title', 'Distributor Channel')
@section('content')
<style type="text/css">
    .select2-container {
        width: 100% !important;
    }
</style>
<div class="page-header">
    <h4 class="page-title">Distributor Channel</h4>
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
            <a href="#">Distributor Channel</a>
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
                        <div class="card-title">
                            Distributor
                        </div>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('distributor_channel') }}" class="btn btn-danger float-right">Back</a>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <div class="row mb-4">

                    <div class="col-4">
                        <span style="font-size: 16px;">Status :
                        @if($distributor->status == 'pending')
                            <span="badge badge-secondary">Pending</span>
                        @elseif ($distributor->status == 'approved')
                            <span style="font-size: 12px;" class="badge badge-success">Approved</span>
                        @else
                            <span style="font-size: 12px;" class="badge badge-danger">Rejected</span>
                        @endif
                        </span>
                        <br />
                        <br />
                        <span style="font-size: 16px;">Frames Allowed :
                        @if($distributor->allow_add_frames)
                            <span style="font-size: 12px;" class="badge badge-success">True</span>
                        @else
                            <span style="font-size: 12px;" class="badge badge-danger">False</span>
                        @endif

                        </span>
                    </div>

                    <div class="col-4">
                        <div class="mt-2">
                            <span style="font-size: 16px;">Wallet Amount: <b id="distributor_balance">{{ $distributor->balance }}</b></span>
                        </div>
                    </div>

                    <div class="col-4 text-right">
                        <div class="mt-2">
                            <button onclick="editDistributor()" class="btn btn-primary float-right">Edit</button>
                        </div>
                    </div>

                </div>

                <hr />

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label>Aadhar Card Photo: </label><br />
                        @if(!empty($distributor->aadhar_card_photo))
                            <img width="150" height="150" src="{{ Storage::url($distributor->aadhar_card_photo) }}" />
                        @else
                            <b>Photo Not Available</b>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label>User Photo: </label><br />
                        @if(!empty($distributor->user_photo))
                            <img width="150" height="150" src="{{ Storage::url($distributor->user_photo) }}" />
                        @else
                            <b>Photo Not Available</b>
                        @endif
                    </div>
                    <div class="col-md-3">
                        <label>Digital Post App Name: </label>
                        <b>{{ $distributor->user->name }}</b>
                    </div>

                    <div class="col-md-3">
                        <label>Digital Post App Number: </label>
                        <b>{{ $distributor->user->mobile }}</b>
                    </div>

                    <div class="col-md-3">
                        <label>Distributor Name: </label>
                        <b>{{ $distributor->full_name }}</b>
                    </div>

                    <div class="col-md-3">
                        <label>Distributor Contact Number: </label>
                        <b>{{ $distributor->contact_number }}</b>
                    </div>

                </div>

                <div class="row mb-4">

                    <div class="col-md-3">
                        <label>Distributor Email: </label>
                        <b>{{ $distributor->email }}</b>
                    </div>

                    <div class="col-md-3">
                        <label>Distributor Area: </label>
                        <b>{{ $distributor->area }}</b>
                    </div>

                    <div class="col-md-3">
                        <label>Distributor City: </label>
                        <b>{{ $distributor->city }}</b>
                    </div>

                    <div class="col-md-3">
                        <label>Distributor State: </label>
                        <b>{{ $distributor->state }}</b>
                    </div>
                </div>

                <hr />

                <div class="row mb-4">

                    <div class="col-md-4">
                        <label>Distributor Current Work: </label>
                        <br />
                        <b>{{ $distributor->current_work }}</b>
                    </div>

                    <div class="col-md-4">
                        <label>Distributor Work Experience: </label>
                        <br />
                        <b>{{ $distributor->work_experience }}</b>
                    </div>

                    <div class="col-md-4">
                        <label>Distributor Skills: </label>
                        <br />
                        <b>{{ $distributor->skills }}</b>
                    </div>

                </div>

                <hr />

                <div class="row mb-4">

                    <div class="col-md-4">
                        <label>Distributor Referral Benefit: </label>
                        <br />
                        <b>{{ $distributor->referral_benefits }}</b>
                    </div>

                    <div class="col-md-4">
                        <label>Distributor Custom Plan Rate: </label>
                        <br />
                        <b>{{ $distributor->custom_plan_rate }}</b>
                    </div>

                    <div class="col-md-4">
                        <label>Distributor Startup Plan Rate: </label>
                        <br />
                        <b>{{ $distributor->start_up_plan_rate }}</b>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="distributorModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Edit Distributor</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form onsubmit="return false;" name="editDistributorForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group err_full_name">
                                <label for="full_name">Full Name</label>
                                <input type="text" id="full_name" value="{{ $distributor->full_name }}" name="full_name" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group err_email">
                                <label for="email">Email</label>
                                <input type="text" id="email" value="{{ $distributor->email }}" name="email" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group err_contact_number">
                                <label for="contact_number">Contact Number</label>
                                <input type="text" id="contact_number" value="{{ $distributor->contact_number }}" name="contact_number" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group err_area">
                                <label for="area">Area</label>
                                <input type="text" id="area" value="{{ $distributor->area }}" name="area" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group err_city">
                                <label for="city">City</label>
                                <input type="text" id="city" value="{{ $distributor->city }}" name="city" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group err_state">
                                <label for="state">State</label>
                                <input type="text" id="state" value="{{ $distributor->state }}" name="state" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group err_current_work">
                                <label for="current_work">Current Work</label>
                                <input type="text" id="current_work" value="{{ $distributor->current_work }}" name="current_work" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group err_work_experience">
                                <label for="work_experience">Work Experience</label>
                                <input type="text" id="work_experience" value="{{ $distributor->work_experience }}" name="work_experience" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group err_skills">
                                <label for="skills">Skills</label>
                                <input type="text" id="skills" value="{{ $distributor->skills }}" name="skills" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group err_referral_benefits">
                                <label for="referral_benefits">Referral Benefit</label>
                                <input type="text" id="referral_benefits" value="{{ $distributor->referral_benefits }}" name="referral_benefits" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group err_custom_plan_rate">
                                <label for="custom_plan_rate">Custom Plan Rate</label>
                                <input type="text" id="custom_plan_rate" value="{{ $distributor->custom_plan_rate }}" name="custom_plan_rate" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group err_start_up_plan_rate">
                                <label for="start_up_plan_rate">Startup Plan Rate</label>
                                <input type="text" id="start_up_plan_rate" value="{{ $distributor->start_up_plan_rate }}" name="start_up_plan_rate" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group err_status">
                                <label for="status">Status</label>
                                <select id="status" name="status" class="form-control">
                                    <option @if($distributor->status == 'pending') selected @endif>pending</option>
                                    <option @if($distributor->status == 'approved') selected @endif>approved</option>
                                    <option @if($distributor->status == 'rejected') selected @endif>rejected</option>
                                    <option @if($distributor->status == 'inactive') selected @endif>inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group err_allow_add_frames">
                                <label for="allow_add_frames">Frame Allowed</label>
                                <select id="allow_add_frames" name="allow_add_frames" class="form-control">
                                    <option value="1"@if($distributor->allow_add_frames) selected @endif>true</option>
                                    <option value="0"@if(!$distributor->allow_add_frames) selected @endif>false</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group err_aadhar_card_photo">
                                <label for="aadhar_card_photo">Aadhar Card</label>
                                <input type="file" id="aadhar_card_photo" name="aadhar_card_photo" class="form-control">

                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group err_user_photo">
                                <label for="user_photo">User Photo</label>
                                <input type="file" id="user_photo" name="user_photo" class="form-control">

                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="updateDistributor()">Submit</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@if($distributor->status != 'pending')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Transaction List
                    <button class="btn btn-info btn-sm pull-right" id="add-transaction"><i class="fas fa-plus"></i></button>
                    </h4>
                </div>
                <div class="table-responsive">
                    <table class="display table table-striped table-hover text-center w-100" id="transaction-table">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Type</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="transactionModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form name="addTransactionForm" id="addTransactionForm">
                    @csrf
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Add Transaction</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group err_amount">
                                    <label for="amount">Amount</label>
                                    <input type="text" id="amount" name="amount" placeholder="Enter Amount" class="form-control">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group err_type">
                                    <label for="type">Type</label>
                                    <select id="type" name="type" class="form-control">
                                        <option>deposit</option>
                                        <option>withdrawal</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group err_description">
                                    <label for="description">Description</label>
                                    <textarea type="text" id="description" name="description" placeholder="Enter Description" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success"  onclick="addTransaction()">Submit</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

<!-- Business List -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Business List
                <!-- <button class="btn btn-info btn-sm pull-right" id="add-transaction"><i class="fas fa-plus"></i></button> -->
                </h4>
            </div>
            <div class="table-responsive">
                <table class="display table table-striped table-hover text-center w-100" id="business-list-tabel">
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

<!-- Political Business Table -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Potical Business List
                <!-- <button class="btn btn-info btn-sm pull-right" id="add-transaction"><i class="fas fa-plus"></i></button> -->
                </h4>
            </div>
            <div class="table-responsive">
                <table class="display table table-striped table-hover text-center w-100" id="political-business-list-tabel">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Designation</th>
                            <th>Category</th>
                            <th>Logo</th>
                            <th>Watermark</th>
                            <th>Logo Dark</th>
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

<!-- Frame Table -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Frame List
                <!-- <button class="btn btn-info btn-sm pull-right" id="add-transaction"><i class="fas fa-plus"></i></button> -->
                </h4>
            </div>
            <div class="table-responsive">
                <table class="display table table-striped table-hover text-center w-100" id="frame_list_table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Business Name</th>
                            <th>Business Type</th>
                            <th>Frame</th>
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

<!-- Business Model -->
<div class="modal fade" id="businessModel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Edit Business</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <form onsubmit="return false;" name="editBusinessForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-6 ">
                                <div class="form-group err_busi_name">
                                    <lable for="busi_name">Name</lable>
                                    <input type="text" name="busi_name" id="busi_name" class="form-control">
                                    <input type="hidden" name="busi_id" id="busi_id" class="form-control">
                                </div>
                            </div>
                            <div class="col-6 ">
                                <div class="form-group err_busi_email">
                                    <lable for="busi_email">Email</lable>
                                    <input type="text" name="busi_email" id="busi_email" class="form-control">
                                </div>
                            </div>
                            <div class="col-6 ">
                                <div class="form-group err_busi_mobile">
                                    <lable for="busi_mobile">Mobile</lable>
                                    <input type="text" name="busi_mobile" id="busi_mobile" class="form-control">
                                </div>
                            </div>
                            <div class="col-6 ">
                                <div class="form-group err_busi_mobile_second">
                                    <lable for="busi_mobile_second">Mobile 2</lable>
                                    <input type="text" name="busi_mobile_second" id="busi_mobile_second" class="form-control">
                                </div>
                            </div>
                            <div class="col-6 ">
                                <div class="form-group err_busi_website">
                                    <lable for="busi_website">Website</lable>
                                    <input type="text" name="busi_website" id="busi_website" class="form-control">
                                </div>
                            </div>
                            <div class="col-6 ">
                                <div class="form-group err_busi_address">
                                    <lable for="busi_address">Address</lable>
                                    <input type="text" name="busi_address" id="busi_address" class="form-control">
                                </div>
                            </div>
                            <div class="col-6 ">
                                <div class="form-group err_busi_logo">
                                    <label for="busi_logo" class="form-label">Upload Logo</label>
                                    <input type="file" name="busi_logo" id="busi_logo" class="form-control"><br>
                                </div>
                                <img id="logoimg" src="#" alt="your image" style="display: none;width: 100px;height:100px;"/>
                            </div>
                            <div class="col-6 ">
                                <div class="form-group err_busi_logo_dark">
                                    <label for="busi_logo_dark" class="form-label">Upload Dark Logo</label>
                                    <input type="file" name="busi_logo_dark" id="busi_logo_dark" class="form-control"><br>
                                </div>
                                <img id="darklogoimg" src="#" alt="your image" style="display: none;width: 100px;height:100px;"/>
                            </div>
                            <div class="col-6">
                                <div class=" form-group err_watermark_image">
                                    <label for="watermark_image" class="form-label">Upload Watermark</label>
                                    <input type="file" name="watermark_image" id="watermark_image" class="form-control"><br>
                                </div>
                                    <img id="watermarkimg" src="#" alt="your image" style="display: none;width: 100px;height:100px;"/>
                            </div>

                            <div class="col-6 ">
                                <div class="form-group err_watermark_image_dark">
                                    <label for="watermark_image_dark" class="form-label">Upload Dark Watermark</label>
                                    <input type="file" name="watermark_image_dark" id="watermark_image_dark" class="form-control"><br>
                                </div>
                                    <img id="darkwatermarkimg" src="#" alt="your image" style="display: none;width: 100px;height:100px;"/>
                            </div>
                            <div class="col-6 ">
                                <div class="form-group err_hashtag">
                                    <lable for="hashtag">Hashtag</lable>
                                    <input type="text" name="hashtag" id="hashtag" class="form-control">
                                </div>
                            </div>
                            <div class="col-6 ">
                                <div class="form-group err_busi_facebook">
                                    <lable for="busi_facebook">Facebook</lable>
                                    <input type="text" name="busi_facebook" id="busi_facebook" class="form-control">
                                </div>
                            </div>

                            <div class="col-6 ">
                                <div class="form-group err_busi_twitter">
                                    <lable for="busi_twitter">Twitter</lable>
                                    <input type="text" name="busi_twitter" id="busi_twitter" class="form-control">
                                </div>
                            </div>

                            <div class="col-6 ">
                                <div class="form-group err_busi_instagram">
                                    <lable for="busi_instagram">Instagram</lable>
                                    <input type="text" name="busi_instagram" id="busi_instagram" class="form-control">
                                </div>
                            </div>

                            <div class="col-6 ">
                                <div class="form-group err_busi_linkedin">
                                    <lable for="busi_linkedin">Linkedin</lable>
                                    <input type="text" name="busi_linkedin" id="busi_linkedin" class="form-control">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group err_busi_youtube">
                                    <lable for="busi_youtube">You Tube</lable>
                                    <input type="text" name="busi_youtube" id="busi_youtube" class="form-control">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group err_business_category">
                                    <label for="sel1">Select Category:</label>
                                    <select class="form-control" id="business_category" name="business_category">
                                        <option value="Select Category" disabled>Select Category</option>
                                        @foreach($busi_cats as $busi_cat)
                                            <option value={{$busi_cat->name}}>{{$busi_cat->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success"  onclick="updateBusinessData()">Submit</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Business Model -->
<div class="modal fade" id="politicalBusinessModel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Edit Political Business</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <form onsubmit="return false;" name="editPoliticalBusinessForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-6 ">
                                <div class="form-group err_pb_name">
                                    <lable for="pb_name">Name</lable>
                                    <input type="text" name="pb_name" id="pb_name" class="form-control">
                                    <input type="hidden" name="pb_id" id="pb_id" class="form-control">
                                </div>
                            </div>
                            <div class="col-6 ">
                                <div class="form-group err_pb_designation">
                                    <lable for="pb_designation">Designation</lable>
                                    <input type="text" name="pb_designation" id="pb_designation" class="form-control">
                                </div>
                            </div>
                            <div class="col-6 ">
                                <div class="form-group err_	pb_mobile">
                                    <lable for="pb_mobile">Mobile</lable>
                                    <input type="text" name="pb_mobile" id="pb_mobile" class="form-control">
                                </div>
                            </div>
                            <div class="col-6 ">
                                <div class="form-group err_pb_mobile_second">
                                    <lable for="pb_mobile_second">Mobile 2</lable>
                                    <input type="text" name="pb_mobile_second" id="pb_mobile_second" class="form-control">
                                </div>
                            </div>

                            <div class="col-6 ">
                                <div class="form-group err_pb_party_logo">
                                    <label for="pb_party_logo" class="form-label">Upload Logo</label>
                                    <input type="file" name="pb_party_logo" id="pb_party_logo" class="form-control"><br>
                                </div>
                                <img id="logoimg" src="#" alt="your image" style="display: none;width: 100px;height:100px;"/>
                            </div>
                            <div class="col-6 ">
                                <div class="form-group err_pb_party_logo_dark">
                                    <label for="pb_party_logo_dark" class="form-label">Upload Dark Logo</label>
                                    <input type="file" name="pb_party_logo_dark" id="pb_party_logo_dark" class="form-control"><br>
                                </div>
                                <img id="darklogoimg" src="#" alt="your image" style="display: none;width: 100px;height:100px;"/>
                            </div>
                            <div class="col-6">
                                <div class=" form-group err_pb_watermark">
                                    <label for="pb_watermark" class="form-label">Upload Watermark</label>
                                    <input type="file" name="pb_watermark" id="pb_watermark" class="form-control"><br>
                                </div>
                                    <img id="watermarkimg" src="#" alt="your image" style="display: none;width: 100px;height:100px;"/>
                            </div>

                            <div class="col-6 ">
                                <div class="form-group err_pb_watermark_dark">
                                    <label for="pb_watermark_dark" class="form-label">Upload Dark Watermark</label>
                                    <input type="file" name="pb_watermark_dark" id="pb_watermark_dark" class="form-control"><br>
                                </div>
                            </div>
                            <div class="col-6 ">
                                <div class="form-group err_pb_left_image">
                                    <label for="pb_left_image" class="form-label">Upload Left Image</label>
                                    <input type="file" name="pb_left_image" id="pb_left_image" class="form-control"><br>
                                </div>
                            </div>
                            <div class="col-6 ">
                                <div class="form-group err_pb_pb_right_image">
                                    <label for="pb_pb_right_image" class="form-label">Upload Right Image</label>
                                    <input type="file" name="pb_pb_right_image" id="pb_pb_right_image" class="form-control"><br>
                                </div>
                            </div>
                            <div class="col-6 ">
                                <div class="form-group err_hashtag">
                                    <lable for="hashtag">Hashtag</lable>
                                    <input type="text" name="hashtag" id="hashtag" class="form-control">
                                </div>
                            </div>
                            <div class="col-6 ">
                                <div class="form-group err_pb_facebook">
                                    <lable for="pb_facebook">Facebook</lable>
                                    <input type="text" name="pb_facebook" id="pb_facebook" class="form-control">
                                </div>
                            </div>

                            <div class="col-6 ">
                                <div class="form-group err_pb_twitter">
                                    <lable for="pb_twitter">Twitter</lable>
                                    <input type="text" name="pb_twitter" id="pb_twitter" class="form-control">
                                </div>
                            </div>

                            <div class="col-6 ">
                                <div class="form-group err_pb_instagram">
                                    <lable for="pb_instagram">Instagram</lable>
                                    <input type="text" name="pb_instagram" id="pb_instagram" class="form-control">
                                </div>
                            </div>

                            <div class="col-6 ">
                                <div class="form-group err_pb_linkedin">
                                    <lable for="pb_linkedin">Linkedin</lable>
                                    <input type="text" name="pb_linkedin" id="pb_linkedin" class="form-control">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group err_pb_youtube">
                                    <lable for="pb_youtube">You Tube</lable>
                                    <input type="text" name="pb_youtube" id="pb_youtube" class="form-control">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group err_pb_pc_id">
                                    <label for="sel1">Select Category:</label>
                                    <select class="form-control" id="pb_pc_id" name="pb_pc_id">
                                        <option value="Select Category" disabled>Select Category</option>
                                        @foreach($pb_cats as $pb_cat)
                                            <option value={{$pb_cat->pc_id}}>{{$pb_cat->pc_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success"  onclick="updatePoliticalBusinessData()">Submit</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script>

var table = "";
var businessTable = "";
var politicalBusinessTable = "";


$(document).ready(function() {
    getTransactionList();
    getBusinessList();
    getPoliticalBusinessList();
    getFrameLists();
})

$('#add-transaction').click(function() {
    clearForm();
    $('#transactionModal').modal('show');
})

function editDistributor() {
    $('#distributorModal').modal('show');
}


function getTransactionList() {
    table = $('#transaction-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('distributor_channel.transactionList', ['id' => $distributor->id]) }}",
        columns: [
            {data: 'description', name: 'description'},
            {data: 'created_at', name: 'created_at'},
            {data: 'amount', name: 'amount'},
            {data: 'type', name: 'type'},
        ],
        order: [[1, 'desc']]
    });
}

function getFrameLists() {
    frameTable = $('#frame_list_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('distributor_channel.getFrameList', ['id' => $distributor->id]) }}",
        columns: [
            {data: 'DT_RowIndex', name: 'user_frames_id'},
            {data: 'business_name', name: 'business_name'},
            {data: 'business_type', name: 'business_type'},
            {data: 'frame_url', name: 'frame_url'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        order: [[1, 'desc']]
    });
}

function deleteFrame(ele){

    var id = $(ele).data('id');
   
    swal({
        title: 'Are you sure?',
        text: "Reject this request!",
        type: 'warning',
        buttons:{
            confirm: {
                text : 'Yes, Reject it!',
                className : 'btn btn-success'
            },
            cancel: {
                visible: true,
                className: 'btn btn-danger'
            }
        }
    }).then((result) => {
        if(result) {
            $.ajaxSetup({
                headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var url = '{{route('distributor_channel.deleteFrame')}}';

            $.ajax({
                type: 'post',
                url: url,
                dataType: 'json',
                data:{id},
                beforeSend: function ()
                {
                    $('.loader-custom').css('display','block');
                },
                complete: function (data, status)
                {
                    $('.loader-custom').css('display','none');
                },

                success: function (response)
                {
                    if(!response.status) {
                        alert(response.message);
                        return false;
                    }
                    frameTable.ajax.reload();
                    alert(response.message);
                }
            });
        }
    });

}

function getBusinessList() {
    businessTable = $('#business-list-tabel').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('distributor_channel.businessList', ['id' => $distributor->user_id]) }}",
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

function getPoliticalBusinessList() {
    politicalBusinessTable = $('#political-business-list-tabel').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('distributor_channel.politicalBusinessList', ['id' => $distributor->user_id])}}",
        columns: [
            {data: 'DT_RowIndex', name: 'pb_id'},
            {data: 'pb_name', name: 'pb_designation'},
            {data: 'pb_mobile', name: 'pb_mobile'},
            {data: 'pb_designation', name: 'pb_designation'},
            {data: 'category.pc_name', name: 'category.pc_name'},
            {data: 'pb_party_logo', name: 'pb_party_logo'},
            {data: 'pb_watermark', name: 'pb_watermark'},
            {data: 'pb_party_logo_dark', name: 'pb_party_logo_dark'},
            {data: 'pb_watermark_dark', name: 'pb_watermark_dark'},
            {data: 'pb_left_image', name: 'pb_left_image'},
            {data: 'pb_right_image', name: 'pb_right_image'},
            {data: 'is_premium', name: 'is_premium', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        order: [[1, 'desc']]
    });
}


function addTransaction(ele) {

    $('span.alerts').remove();

    var form = document.addTransactionForm;
    var formData = new FormData(form);

    var url = "{{ route('distributor_channel.addTransaction', ['id' => $distributor->id]) }}";
    $('.loader-custom').css('display','block');
    $.ajax({
        url: url,
        type: 'POST',
        processData: false,
        contentType: false,
        dataType: 'json',
        data: formData,
        dataSrc: "",
        success: function(response) {
            $('.loader-custom').css('display','none');
            if (response.status == 401)
            {
                $.each(response.error1, function (index, value) {
                    if (value.length != 0) {
                        $('.err_' + index).append('<span class="small alerts text-danger">' + value + '</span>');
                    }

                });
                return false;
            }
            if(!response.status) {
                alert(response.message);
                return false;
            }
            $('#distributor_balance').html(response.data.balance);
            $('#transactionModal').modal('hide');
            clearForm();
            table.ajax.reload();
        },
        error: function(error) {
            $('.loader-custom').css('display','none');
            console.log(error);

        }
    });

}

function editPoliticalBusinessData(ele)
{
    var id = $(ele).data('id');
    var url = "{{route('distributor_channel.getPoliticalBusiness')}}"

    $.ajaxSetup({
			headers: {
			    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}});
    $.ajax({
        url: url,
        type: 'POST',
        data: {id},
        dataType: 'json',
        success: function(response) {

            $('#politicalBusinessModel').modal('show');
            $('#pb_id').val(response.data.pb_id);
            $('#pb_name').val(response.data.pb_name);
            $('#pb_designation').val(response.data.pb_designation);
            $('#pb_mobile').val(response.data.pb_mobile);
            $('#pb_mobile_second').val(response.data.pb_mobile_second);
            $('#pb_pc_id').val(response.data.pb_pc_id);
            $('#hashtag').val(response.data.hashtag);
            $('#pb_facebook').val(response.data.pb_facebook);
            $('#pb_instagram').val(response.data.pb_instagram);
            $('#pb_linkedin').val(response.data.pb_linkedin);
            $('#pb_youtube').val(response.data.pb_youtube);
            $('#pb_pc_id').val(response.data.pb_pc_id);

        },
        error: function(error) {
            $('.loader-custom').css('display','none');
            console.log(error);
        }
    });
}
function editBusinessData(ele)
{
    var id = $(ele).data('id');
    var url = "{{route('distributor_channel.getBusiness')}}"

    $.ajaxSetup({
			headers: {
			    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}});
    $.ajax({
        url: url,
        type: 'POST',
        data: {id},
        dataType: 'json',
        success: function(response) {
            console.log(response.data);
            $('#businessModel').modal('show');
            $('#busi_id').val(response.data.busi_id);
            $('#busi_name').val(response.data.busi_name);
            $('#busi_email').val(response.data.busi_email);
            $('#busi_mobile').val(response.data.busi_mobile);
            $('#busi_mobile_second').val(response.data.busi_mobile_second);
            $('#busi_website').val(response.data.busi_website);
            $('#busi_address').val(response.data.busi_address);
            $('#hashtag').val(response.data.hashtag);
            $('#busi_facebook').val(response.data.busi_facebook);
            $('#busi_twitter').val(response.data.busi_twitter);
            $('#busi_instagram').val(response.data.busi_instagram);
            $('#busi_linkedin').val(response.data.busi_linkedin);
            $('#busi_youtube').val(response.data.busi_youtube);
            $('#business_category').val(response.data.business_category);
            $('#select_plan').val(response.data.select_plan);
        },
        error: function(error) {
            $('.loader-custom').css('display','none');
            console.log(error);
        }
    });
}

function updateBusinessData()
{
        $.ajaxSetup({
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var form = document.editBusinessForm;
        var formData = new FormData(form);
        var url = '{{route('distributor_channel.updateBusiness')}}';

        $.ajax({
        type: 'POST',
        url: url,
        processData: false,
        contentType: false,
        dataType: 'json',
        data: formData,
        dataSrc: "",
        beforeSend: function ()
        {
            $('.loader-custom').css('display','block');
        },
        complete: function (data, status)
        {
            $('.loader-custom').css('display','none');
        },

        success: function (response)
        {
            if (response.status == 401)
            {
                $.each(response.error1, function (index, value) {
                    if (value.length != 0) {
                        $('.err_' + index).append('<span class="small alerts text-danger">' + value + '</span>');
                    }

                });
                return false;
            }
            if(!response.status) {
                alert(response.message);
                return false;
            }
                $('#businessModel').modal('hide');
                alert(response.message);
                businessTable.ajax.reload();
        }
    });
}

function updatePoliticalBusinessData()
{
        $.ajaxSetup({
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var form = document.editPoliticalBusinessForm;
        var formData = new FormData(form);
        var url = '{{route('distributor_channel.updatePoliticalBusiness')}}';

        $.ajax({
        type: 'POST',
        url: url,
        processData: false,
        contentType: false,
        dataType: 'json',
        data: formData,
        dataSrc: "",
        beforeSend: function ()
        {
            $('.loader-custom').css('display','block');
        },
        complete: function (data, status)
        {
            $('.loader-custom').css('display','none');
        },

        success: function (response)
        {
            if (response.status == 401)
            {
                $.each(response.error1, function (index, value) {
                    if (value.length != 0) {
                        $('.err_' + index).append('<span class="small alerts text-danger">' + value + '</span>');
                    }

                });
                return false;
            }
            if(!response.status) {
                alert(response.message);
                return false;
            }

                $('#politicalBusinessModel').modal('hide');
                alert(response.message);
                politicalBusinessTable.ajax.reload();

            }
    });
}

function clearForm() {
    $('span.alerts').remove();
    $('#amount').val("");
    $('#type').val("deposit");
}

function updateDistributor() {
    $('span.alerts').remove();

    var form = document.editDistributorForm;
    var formData = new FormData(form);

    var url = "{{ route('distributor_channel.updateDistributor', ['id' => $distributor->id]) }}";
    $('.loader-custom').css('display','block');
    $.ajax({
        url: url,
        type: 'POST',
        processData: false,
        contentType: false,
        dataType: 'json',
        data: formData,
        dataSrc: "",
        success: function(response) {
            $('.loader-custom').css('display','none');
            if (response.status == 401)
            {
                $.each(response.error1, function (index, value) {
                    if (value.length != 0) {
                        $('.err_' + index).append('<span class="small alerts text-danger">' + value + '</span>');
                    }

                });
                return false;
            }
            if(!response.status) {
                alert(response.message);
                return false;
            }
            alert(response.message);
            location.reload(true);
        },
        error: function(error) {
            $('.loader-custom').css('display','none');
            console.log(error);

        }
    });
}

</script>
@endsection
