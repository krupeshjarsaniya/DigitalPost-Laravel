@extends('admin.layouts.app')
@section('title', 'Setting')
@section('content')
<div class="page-header">
    <h4 class="page-title">Setting</h4>
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
            <a href="#">Plan</a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12" id="updatecredit">
        <div class="card">
            <div class="card-header">
                <div class="card-title" id="country-title">Update Setting</div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <form id="countryform" name="countryform">
                            @csrf
                            <div class="row">
                            	<div class="col-md-4">
                        		  	<div class="form-group">
		                            	<input type="hidden" name="creditid" id="creditid" value="{{ $credit->setting_id }}">
		                                <label for="credit">Credit Value</label>
		                                <input type="text" class="form-control" id="credit" placeholder="Enter Plan Credit" value="<?php echo $credit->credit; ?>">
		                            </div>

                            	</div>
                            	<div class="col-md-2 mt-1 form-group">
                                    <button type="button" onclick="creditupdate('{{ $credit->credit }}')" class="btn mt-4 btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12" id="updatecredit">
        <div class="card">
            <div class="card-header">
                <div class="card-title" id="country-title">Renewal Reminder Setting</div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <form id="daysForm" name="daysForm" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="image">Image</label>
                                        <input type="file" class="form-control" name="image" id="image">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <img data-old="{{ asset($credit->renewal_image)}}" id="view_image" style="width: 150px;height: 150px" src="{{asset($credit->renewal_image)}}" />
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="days">Days Before</label>
                                        <input type="text" class="form-control" name="days" id="days" placeholder="Enter Days" value="<?php echo $credit->renewal_days; ?>">
                                    </div>

                                </div>
                                <div class="col-md-2 mt-1 form-group">
                                    <button type="button" onclick="daysUpdate()" class="btn mt-4 btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12" id="referral">
        <div class="card">
            <div class="card-header">
                <div class="card-title" id="country-title">Referral Setting</div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <form id="referralForm" name="referralForm" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="referral_amount">Referral Points</label>
                                        <input type="number" class="form-control" name="referral_amount" id="referral_amount" placeholder="Enter Referral Point" value="<?php echo $credit->referral_amount; ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="referral_subscription_amount">Referral Subscription Points</label>
                                        <input type="number" class="form-control" name="referral_subscription_amount" id="referral_subscription_amount" placeholder="Enter Referral Subscription Point" value="<?php echo $credit->referral_subscription_amount; ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="minimum_withdraw_amount">Minimum Withdraw Amount</label>
                                        <input type="number" class="form-control" name="minimum_withdraw_amount" id="minimum_withdraw_amount" placeholder="Enter Minimum Withdraw Amount" value="<?php echo $credit->minimum_withdraw_amount; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="image">Image</label>
                                        <input type="file" class="form-control" name="image" id="referralimage">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <img data-old="{{ asset($credit->referral_banner)}}" id="view_referral_image" style="width: 150px;height: 150px" src="{{asset($credit->referral_banner)}}" />
                                </div>
                                <div class="col-md-2 mt-1 form-group">
                                    <button type="button" onclick="referralUpdate()" class="btn mt-4 btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Privacy And Policy</div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <form  name="countryform">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea id="privacypolicy">{{ $credit->privacy_policy }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
            <div class="card-action text-right">
                <button class="btn btn-success" type="button" onclick="saveprivacy()" id="country-btn">Submit</button>&nbsp;&nbsp;
                <!-- <button class="btn btn-danger"  type="button" onclick="viewprivacy()">Cancel</button> -->
                <a href="{{ url('privacypolicy') }}" target="_blank" class="btn btn-secondary">Visit Page</a>

            </div>
        </div>
    </div>


    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Terms And Conditions</div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <form  name="countryform">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea id="termconditions">{{ $credit->terms_condition }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
            <div class="card-action text-right">
                <button class="btn btn-success" type="button" onclick="savetermconditions()" id="country-btn">Submit</button>&nbsp;&nbsp;
                <a href="{{ url('/termsandcondition') }}" target="_blank" class="btn btn-secondary">Visit Page</a>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Referral Policy</div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <form  name="referralform">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea id="referralpolicy">{{ $credit->referral_policy }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
            <div class="card-action text-right">
                <button class="btn btn-success" type="button" onclick="savereferralpolicy()" id="country-btn">Submit</button>&nbsp;&nbsp;
                <!-- <button class="btn btn-danger"  type="button" onclick="viewprivacy()">Cancel</button> -->
                <a href="{{ url('referralpolicy') }}" target="_blank" class="btn btn-secondary">Visit Page</a>

            </div>
        </div>
    </div>


    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title" id="country-title">What'sApp</div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <form id="countryform" name="countryform">
                            @csrf
                            <div class="row">
                            	<div class="col-md-4">
                        		  	<div class="form-group">
		                                <label for="credit">What'sApp Message</label>
		                                <input type="text" class="form-control" id="whatsapp" placeholder="Enter What'sApp" value="<?php echo $credit->whatsapp; ?>">
		                            </div>

                            	</div>
                            	<div class="col-md-2 mt-1 form-group">
                                    <button type="button" onclick="Whatsappupdate('{{ $credit->credit }}')" class="btn mt-4 btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
@section('js')
    <script type="text/javascript" src="{{ url('/public/admin/js/user/setting.js?v='.rand()) }}"></script>

  <!--   <script>
        $('#privacypolicy').trumbowyg('html', "{{ $credit->privacy_policy }}");


    </script> -->
@endsection