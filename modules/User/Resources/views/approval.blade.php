@extends('admin.layouts.app')
@section('title', 'Users')
@section('content')

@php 
    use Illuminate\Support\Facades\Storage;
@endphp
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
            <a href="#">Approval</a>
        </li>
        {{-- <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Basic Form</a>
        </li> --}}
    </ul>
</div>
<div class="row">
   <!--  <div class="col-md-12" id="addCountry" style="display: none;">
        <div class="card">
            <div class="card-header">
                <div class="card-title" id="country-title">Create Country</div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <form id="countryform" name="countryform">
                            @csrf
                            <div class="form-group">
                                <label for="email2">Country Name</label>
                                <input type="text" class="form-control" id="country" placeholder="Enter Country Name" name="country">
                                <input type="hidden" id="country_id" name="id" value="">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-action text-right">
                <button class="btn btn-success" id="country-btn">Submit</button>&nbsp;&nbsp;
                <button class="btn btn-danger" id="view-country">Cancel</button>
            </div>
        </div>
    </div> -->
    <div class="col-md-12" id="Business">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Business Approval List
                <!-- <button class="btn btn-info btn-sm pull-right" id="add-country"><i class="fas fa-plus"></i></button> -->
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="display table table-striped table-hover text-center" id="Approval-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Business Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $count = 1; @endphp
                           @foreach($businesses as $business)
                            {{-- @for ($i = 0; $i < count($businesses); $i++) --}}
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>{{ $business->name }}</td>
                                    <td>
                                       
                                        <p>OLD : {{ $business->busi_name }}</p>
                                        <p>New : {{ $business->busi_name_new }}</p>
                                    </td>
                                    <td>
                                        <button type="button" onclick="approvebusiness('{{ $business->busi_id }}')" class="btn btn-primary">Approve</button>
                                        <button type="button" onclick="declinebusiness('{{ $business->busi_id }}')" class="btn btn-danger">Decline</button>
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
    <script type="text/javascript" src="{{ url('/public/admin/js/user/user.js?v='.rand()) }}"></script>
    <script>
        $(document).ready(function() {
            $('#Approval-table').DataTable().draw();
        });
    </script>
@endsection