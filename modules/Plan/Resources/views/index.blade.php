@extends('admin.layouts.app')
@section('title', 'Users')
@section('content')
<div class="page-header">
    <h4 class="page-title">Plan</h4>
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
        {{-- <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Basic Form</a>
        </li> --}}
    </ul>
</div>

@php
    use Illuminate\Support\Facades\Storage;
@endphp

<div class="row">
    <div class="col-md-12" id="updateplan" style="display: none;">
        <div class="card">
            <div class="card-header">
                <div class="card-title" id="country-title">Update Plan</div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <form id="plandata" name="plandata" {{-- action={{route('addadminuser')}} --}} onsubmit="return false;" method="post" enctype='multipart/form-data'>
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group err_planname">
                                        <input type="hidden" name="planid" id="planid" value="">
                                        <label for="planname">Plan Name</label>
                                        <input type="text" class="form-control" id="planname" placeholder="Enter Plan Name" name="planname">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group err_validity">
                                        <label for="validity">Validity</label>
                                        <input type="text" class="form-control" id="validity" placeholder="Enter validity" name="validity">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group err_validitytime">
                                        <label for="validitytime">Select Validity Time</label>
                                        <select name="validitytime" class="form-control" id="validitytime">
                                            <option value="days">Days</option>
                                            <!--<option value="month">Month</option>-->
                                            <!--<option value="year">Year</option>-->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group err_price">
                                        <label for="price">Price</label>
                                        <input type="text" class="form-control" id="price" placeholder="Enter Price" name="price">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group err_orderno">
                                        <label for="orderno">Order No</label>
                                        <input type="text" class="form-control" id="orderno" placeholder="Enter Order No" name="orderno">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                    <label for="plantype">Select Plan type</label>
                                    <select name="plantype" class="form-control" id="plantype">
                                            <option value="1">Normal</option>
                                            <option value="2">Political</option>
                                            <option value="3">All</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                    <label for="new_or_renewal">Select New/Renewal</label>
                                    <select name="new_or_renewal" class="form-control" id="new_or_renewal">
                                            <option value="new">New</option>
                                            <option value="renewal">Renewal</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group err_image">
                                        <label for="fimage">Image</label>
                                        <input type="file" class="form-control" onchange="readURL(this);" id="fimage" name="image">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                </div>
                                <div class="col-md-4">
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <img id="blah" src="#" id="fimage" alt="your image" height="100" width="100" />
                                    </div>
                                </div>
                            </div>
                          
                            {{-- <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="actualprice">Actual Price</label>
                                        <input type="text" class="form-control" id="actualprice" placeholder="Enter Actual Price" name="actualprice">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="currentprice">Current Price</label>
                                        <input type="text" class="form-control" id="currentprice" placeholder="Enter Current Price" name="currentprice">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="discount">Discount</label>
                                        <input type="text" class="form-control" id="discount" placeholder="Enter Discount(%)" name="discount">
                                    </div>
                                </div>
                            </div> --}}

                            {{-- <div class="form-group">
                            <label for="addinformation">Add Information</label></div>
                            <div id="addinformation">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <input type="text" class="form-control information" placeholder="Add Information">
                                        </div>
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <button type="button" onclick="addbox()" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="card-action text-right">
                                <button class="btn btn-success" type="submit" onclick="updateplan()" id="country-btn">Submit</button>&nbsp;&nbsp;
                                <button class="btn btn-danger"  type="button" onclick="cencelediting()">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- <div class="card-action text-right">
                <button class="btn btn-success" type="button" onclick="updateplan()" id="country-btn">Submit</button>&nbsp;&nbsp;
                <button class="btn btn-danger"  type="button" onclick="cencelediting()">Cancel</button>
            </div> --}}
        </div>
    </div>
    <div class="col-md-12" id="viewplans">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Plan List
                <button class="btn btn-info btn-sm pull-right" id="add-country"onclick="show()"><i class="fas fa-plus"></i></button>
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="display table table-striped table-hover text-center" id="user-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Actual Price</th>
                                <th>Validity</th>
                                <th>Validity Time</th>
                                <th>Plan Type</th>
                                <th>New/Renewal</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($plans as $plan)
                                <tr>
                                    <td>{{ $plan->plan_id }}</td>
                                    <td>{{ $plan->plan_or_name }}</td>
                                    <td>{{ $plan->plan_actual_price }}</td>
                                    <td>{{ $plan->plan_validity }}</td>
                                    <td>{{ $plan->plan_validity_type }}</td>
                                    <td>
                                        @if($plan->plan_type == 1)
                                            <p>Normal</p>
                                        @endif
                                        @if($plan->plan_type == 2)
                                            <p>Political</p>
                                        @endif
                                        @if($plan->plan_type == 3)
                                            <p>All</p>
                                        @endif
                                    </td>
                                    <td>
                                        {{$plan->new_or_renewal}}
                                    </td>
                                    <td><img src="{{ Storage::url($plan->image) }}" height="100" width="100"></td>
                                    <td>
                                        <button onclick="getdataforupdateplan('{{ $plan->plan_id }}')" class="btn btn-primary">update</button>
                                        @if($plan->status == 0)
                                            &nbsp;&nbsp;<button class="btn btn-danger" id="user-block" onclick="blockUser({{ $plan->plan_id }})">Block</button>
                                        @else 
                                             &nbsp;&nbsp;<button class="btn btn-success" id="user-unblock" onclick="unblockUser({{ $plan->plan_id }})">Unblock</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
    <script type="text/javascript" src="{{ url('/public/admin/js/user/plan.js?v='.rand()) }}"></script>

    </script>
@endsection