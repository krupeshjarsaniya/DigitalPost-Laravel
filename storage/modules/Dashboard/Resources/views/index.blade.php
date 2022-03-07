@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="row">
    <div class="col-sm-6 col-md-3">
        <a href="{{route('userlist')}}">
            <div class="card card-stats card-primary card-round">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="flaticon-users"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                                <p class="card-category">Today Users</p>
                                <h4 class="card-title">{{ $todayusers }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-md-3">
        <a href="{{route('userlist')}}">
            <div class="card card-stats card-primary card-round">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="flaticon-users"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                                <p class="card-category">Total Users</p>
                                <h4 class="card-title">{{ $totalusers }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-md-3">
        <a href="{{route('allpost')}}">
            <div class="card card-stats card-primary card-round">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="flaticon-users"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                                <p class="card-category">Today Post Download</p>
                                <h4 class="card-title">{{ $todayPostDownload }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-md-3">
        <a href="{{route('allpost')}}">
            <div class="card card-stats card-primary card-round">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="flaticon-users"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                                <p class="card-category">Total Post Download</p>
                                <h4 class="card-title">{{ $totalPostDownload }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-primary card-round">
            <div class="card-body">
                <div class="row">
                    <div class="col-5">
                        <div class="icon-big text-center">
                            <i class="flaticon-users"></i>
                        </div>
                    </div>
                    <div class="col-7 col-stats">
                        <div class="numbers">
                            <p class="card-category">Active Premium Package</p>
                            <h4 class="card-title">{{ $activePremimumPackages }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <a href="{{route('expiredplanlist')}}">
            <div class="card card-stats card-primary card-round">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="flaticon-users"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                                <p class="card-category">Expired Total Packages</p>
                                <h4 class="card-title">{{ $expiredPackages }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-primary card-round">
            <div class="card-body">
                <div class="row">
                    <div class="col-5">
                        <div class="icon-big text-center">
                            <i class="flaticon-users"></i>
                        </div>
                    </div>
                    <div class="col-7 col-stats">
                        <div class="numbers">
                            <p class="card-category">Today New Packages</p>
                            <h4 class="card-title">{{ $todayNewPackages }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-primary card-round">
            <div class="card-body">
                <div class="row">
                    <div class="col-5">
                        <div class="icon-big text-center">
                            <i class="flaticon-users"></i>
                        </div>
                    </div>
                    <div class="col-7 col-stats">
                        <div class="numbers">
                            <p class="card-category">Upcoming Renewal</p>
                            <h4 class="card-title">{{ $upcomingRenewal }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
</div>
<div class="row">
    {{-- @dd($activeplans); --}}
@if(Auth::user()->user_role == 1)
<div class="col-md-12">
    <div class="form-group">
      <label for="type">Select Purchase Type:</label>
      <select class="form-control" name="type" id="type">
        <option value="free">Free</option>
        <option value="premium">Premium</option>
      </select>
    </div>
</div>
    <div class="col-md-12" id="viewUserlist">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">User Purchase List</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="display table table-striped table-hover text-center" id="userpurchase-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>User Name</th>
                                <th>Mobile Number</th>
                                <th>Business Name</th>
                                <th>Plan Name</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @php $count = 1; @endphp
                            @foreach($activeplans as $activeplan)
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>{{ $activeplan->name }}</td>
                                    <td>{{ $activeplan->mobile }}</td>
                                    <td>{{ $activeplan->busi_name }}</td>
                                    <td>{{ $activeplan->plan_name }}</td>
                                    <td>{{ $activeplan->purc_start_date }}</td>
                                    
                                </tr>
                            @endforeach  --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endif
</div>
@endsection
@section('js')
    <script type="text/javascript" src="{{ url('/public/admin/js/user/setting.js?v=1') }}"></script>
@endsection