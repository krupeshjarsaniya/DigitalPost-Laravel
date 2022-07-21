@extends('distributor.layouts.app')
@section('title', 'Referral User')
@section('content')
<style type="text/css">
    .select2-container {
        width: 100% !important;
    }
</style>
<div class="page-header">
    <h4 class="page-title">Referral User</h4>
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
            <a href="#">Referral User</a>
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
                <h4 class="card-title">Referral User List</h4>
            </div>
            <div class="card-body">
                <div class="card-body">
                    <table class="display table table-striped table-hover text-center w-100" id="referral-user-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Mobile</th>
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



@endsection
@section('js')

<script>
    var table = "";
    $(document).ready(function() {
        getReferralUsersList();
      
    })

    function getReferralUsersList() {
        table = $('#referral-user-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('distributors.referralUserList')}}",
            columns: [
                {data: 'DT_RowIndex', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'mobile', name: 'mobile'},
                {data: 'created_at', name: 'created_at'},
            ],
            order: [[1, 'desc']]
        });
    }
    

</script>

@endsection
