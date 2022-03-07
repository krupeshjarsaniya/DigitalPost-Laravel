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
    <script type="text/javascript" src="{{ url('/public/admin/js/user/setting.js') }}"></script>

  <!--   <script>
        $('#privacypolicy').trumbowyg('html', "{{ $credit->privacy_policy }}");


    </script> -->
@endsection