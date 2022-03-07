@extends('admin.layouts.app')
@section('title', 'Custom Frames')
@section('content')
	<div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Custom Frame List
                </h4>
            </div>
            <div class="card-body">
                <ul class="nav nav-pills nav-secondary m-4" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-normal-business-pending-tab" data-toggle="pill" href="#normalBusinessPending" role="tab" aria-controls="normalBusinessPending" aria-selected="true">Normal Business Pending</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-normal-business-completed-tab" data-toggle="pill" href="#normalBusinessCompleted" role="tab" aria-controls="normalBusinessCompleted" aria-selected="false">Normal Business Completed</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-political-business-pending-tab" data-toggle="pill" href="#politicalBusinessPending" role="tab" aria-controls="politicalBusinessPending" aria-selected="true">Political Business Pending</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-political-business-completed-tab" data-toggle="pill" href="#politicalBusinessCompleted" role="tab" aria-controls="politicalBusinessCompleted" aria-selected="false">Political Business Completed</a>
                    </li>
                </ul>
                <div class="tab-content m-4 mt-2 mb-3" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="normalBusinessPending" role="tabpanel" aria-labelledby="pills-normal-business-pending-tab">
                        <div class="table-responsive">
                            <table class="display table table-striped table-hover text-center w-100" id="custom-frame-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>User</th>
                                        <th>Business</th>
                                        <th>Quantity</th>
                                        <th>Completed</th>
                                        <th>Remark</th>
                                        <th>Priority</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="normalBusinessCompleted" role="tabpanel" aria-labelledby="pills-normal-business-completed-tab">
                        <div class="table-responsive">
                            <table class="display table w-100 table-striped table-hover text-center" id="custom-frame-completed-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>User</th>
                                        <th>Business</th>
                                        <th>Quantity</th>
                                        <th>Completed</th>
                                        <th>Remark</th>
                                        <th>Priority</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="tab-pane fade" id="politicalBusinessPending" role="tabpanel" aria-labelledby="pills-political-business-pending-tab">
                        <div class="table-responsive">
                            <table class="display table table-striped table-hover text-center w-100" id="custom-frame-political-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>User</th>
                                        <th>Business</th>
                                        <th>Quantity</th>
                                        <th>Completed</th>
                                        <th>Remark</th>
                                        <th>Priority</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="politicalBusinessCompleted" role="tabpanel" aria-labelledby="pills-political-business-completed-tab">
                        <div class="table-responsive">
                            <table class="display table w-100 table-striped table-hover text-center" id="custom-frame-completed-political-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>User</th>
                                        <th>Business</th>
                                        <th>Quantity</th>
                                        <th>Completed</th>
                                        <th>Remark</th>
                                        <th>Priority</th>
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
        <div class="modal fade" id="addFrame">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form name="addCustomFrameForm" id="addCustomFrameForm" enctype="multipart/form-data">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Add Frame</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <input type="hidden" name="id" id="id" value="">
                            <input type="hidden" name="business_id" id="business_id" value="">
                            <input type="hidden" name="business_type" id="business_type" value="">
                            <div class="row">
                                <div class="col-10">
                                    <div class="form-group err_files err_id err_business_id err_business_type">
                                        <input type="file" id="files" multiple name="files[]" class="form-control photos">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group err_files err_id err_business_id err_business_type">
                                        <button type="button" class="btn btn-success"  onclick="addCustomFrame()">Submit</button>
                                    </div>
                                </div>
                            </div>

                            <div id="viewFrames" class="mt-4">
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="viewBusinessDetailModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form name="editBusinessForm" id="editBusinessForm" enctype="multipart/form-data">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Business Form</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <input type="hidden" name="edit_business_id" id="edit_business_id" value="">
                            <input type="hidden" name="edit_business_type" id="edit_business_type" value="">
                            <div class="form-group err_logo">
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label>Name :</label> <span style="word-break: break-all;" id='business_name' ></span>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label>Email :</label> <span style="word-break: break-all;" id='business_email' ></span>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label>Mobile :</label> <span style="word-break: break-all;" id='business_mobile' ></span>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label>Website :</label> <span style="word-break: break-all;" id='business_website' ></span>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label>Address :</label> <span style="word-break: break-all;" id='business_address' ></span>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label>Plan :</label> <span style="word-break: break-all;" id='business_plan' ></span>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label>Designation :</label> <span style="word-break: break-all;" id='business_designation' ></span>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label>Facebook :</label> <span style="word-break: break-all;" id='business_facebook' ></span>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label>Twitter :</label> <span style="word-break: break-all;" id='business_twitter' ></span>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label>Instgram :</label> <span style="word-break: break-all;" id='business_instgram' ></span>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label>Linkedin :</label> <span style="word-break: break-all;" id='business_linkedin' ></span>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label>Youtube :</label> <span style="word-break: break-all;" id='business_youtube' ></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group err_logo">
                                <label>Logo: </label>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="file" id="logo" name="logo" class="form-control photos">
                                    </div>
                                    <div class="col-6">
                                        <img style="width: 100px;height:100px;" id="business_logo" src=""/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group err_watermark">
                                <label>Watermark: </label>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="file" id="watermark" name="watermark" class="form-control photos">
                                    </div>
                                    <div class="col-6">
                                        <img style="width: 100px;height:100px;" id="business_watermark" src=""/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group err_leftimage" style="display: none;">
                                <label>Left Image: </label>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="file" id="leftimage" name="leftimage" class="form-control photos">
                                    </div>
                                    <div class="col-6">
                                        <img style="width: 100px;height:100px;" id="business_leftimage" src=""/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group err_rightimage" style="display: none;">
                                <label>Right Image: </label>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="file" id="rightimage" name="rightimage" class="form-control photos">
                                    </div>
                                    <div class="col-6">
                                        <img style="width: 100px;height:100px;" id="business_rightimage" src=""/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success"  onclick="editBusiness()">Submit</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript" src="{{ url('/public/admin/js/user/custom_frame.js?v='.rand()) }}"></script>
@endsection