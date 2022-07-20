@extends('distributor.layouts.app')
@section('title', 'Upcoming Renewals')
@section('content')
<style type="text/css">
    .select2-container {
        width: 100% !important;
    }
</style>
<div class="page-header">
    <h4 class="page-title">Upcoming Renewals</h4>
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
            <a href="#">Upcoming Renewals</a>
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
                <h4 class="card-title">Upcoming Renewals List</h4>
            </div>
            <div class="card-body">
                <div class="card-body">
                    <ul class="nav nav-pills nav-secondary m-4" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="normal-business-tab" data-toggle="pill" href="#pendingNotification" role="tab" aria-controls="pendingNotification" aria-selected="true">Normal Business</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="political-business-tab" data-toggle="pill" href="#completedNotification" role="tab" aria-controls="completedNotification" aria-selected="true">Political Business</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content m-4 mt-2 mb-3" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pendingNotification" role="tabpanel" aria-labelledby="normal-business-tab">
                        <div class="table-responsive">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Expire Plan</h4>
                                </div>
                                <div class="card-body">
                                    <table class="display table table-striped table-hover text-center w-100" id="normal-business-expire-plan-table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Business Name</th>
                                                <th>Mobile</th>
                                                <th>Plan Name</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Upcoming Expire Plan</h4>
                                </div>
                                <div class="card-body">
                                    <table class="display table table-striped table-hover text-center w-100" id="normal-business-upcoming-expire-plan-table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Business Name</th>
                                                <th>Mobile</th>
                                                <th>Plan Name</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
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
                    <div class="tab-pane fade" id="completedNotification" role="tabpanel" aria-labelledby="political-business-tab">
                        <div class="table-responsive">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Expire Plan</h4>
                                </div>
                                <div class="card-body">
                                    <table class="display table table-striped table-hover text-center w-100" id="political-business-expire-plan-table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Business Name</th>
                                                <th>Mobile</th>
                                                <th>Plan Name</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Upcoming Expire Plan</h4>
                                </div>
                                <div class="card-body">
                                    <table class="display table table-striped table-hover text-center w-100" id="political-business-upcoming-expire-plan-table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Business Name</th>
                                                <th>Mobile</th>
                                                <th>Plan Name</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
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
            <form name="purchasePlanForm" onsubmit="return false;" enctype="multipart/form-data">
                @csrf
                <div class="form-group ">
                      <label for="purc_plan_id">Select Plan:</label>
                      <select class="form-control" id="purc_plan_id" name="purc_plan_id">
                          <option value="Select Category" disabled>Select Plan</option>
                          <option value="{{ \App\Plan::$custom_plan_id }}">Custom Plan Rate</option>
                          <option value="{{ \App\Plan::$start_up_plan_id }}">Start Up Plan Rate</option>
                      </select>
                </div>
                <input type="hidden" name="business_id" id="business_id" value="">
                <input type="hidden" name="business_type" id="business_type" value="">

            </form>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
              <button type="button" class="btn btn-success" onclick="purchasePlan()">purchase</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>

      </div>
  </div>
</div>

@endsection
@section('js')

<script>
    var normalBusinessExpireTable = "";
    var normalBusinessUpcomingPlanExpireTable = "";
    var politicalBusinessExpireTable = "";
    var politicalBusinessUpcomingPlanExpireTable = "";
    $(document).ready(function() {
        getBusinessExpirePlanList();
        getBusinessUpcomingExpirePlanList();
        getPoliticalBusinessExpirePlanList();
        getPoliticalBusinessUpcomingExpirePlanList();
    })

    function getBusinessExpirePlanList() {
        normalBusinessExpireTable = $('#normal-business-expire-plan-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('distributors.normalBusinessExpirePlan' )}}",
            columns: [
                {data: 'DT_RowIndex', name: 'busi_id'},
                {data: 'busi_name', name: 'busi_name'},
                {data: 'busi_mobile', name: 'busi_mobile'},
                {data: 'plan_or_name', name: 'plan_or_name'},
                {data: 'purc_start_date', name: 'purc_start_date'},
                {data: 'purc_end_date', name: 'purc_end_date'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            order: [[1, 'desc']]
        });
    }
    function getBusinessUpcomingExpirePlanList() {
        normalBusinessUpcomingPlanExpireTable = $('#normal-business-upcoming-expire-plan-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('distributors.normalBusinessUpcomingExpirePlan' )}}",
            columns: [
                {data: 'DT_RowIndex', name: 'busi_id'},
                {data: 'busi_name', name: 'busi_name'},
                {data: 'busi_mobile', name: 'busi_mobile'},
                {data: 'plan_or_name', name: 'plan_or_name'},
                {data: 'purc_start_date', name: 'purc_start_date'},
                {data: 'purc_end_date', name: 'purc_end_date'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            order: [[1, 'desc']]
        });
    }
    function getPoliticalBusinessExpirePlanList() {
        politicalBusinessExpireTable = $('#political-business-expire-plan-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('distributors.politicalBusinessExpirePlan' )}}",
            columns: [
                {data: 'DT_RowIndex', name: 'pb_id'},
                {data: 'pb_name', name: 'pb_name'},
                {data: 'pb_mobile', name: 'pb_mobile'},
                {data: 'plan_or_name', name: 'plan_or_name'},
                {data: 'purc_start_date', name: 'purc_start_date'},
                {data: 'purc_end_date', name: 'purc_end_date'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            order: [[1, 'desc']]
        });
    }
    function getPoliticalBusinessUpcomingExpirePlanList() {
        politicalBusinessUpcomingPlanExpireTable = $('#political-business-upcoming-expire-plan-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('distributors.politicalBusinessUpcomingExpirePlan' )}}",
            columns: [
                {data: 'DT_RowIndex', name: 'pb_id'},
                {data: 'pb_name', name: 'pb_name'},
                {data: 'pb_mobile', name: 'pb_mobile'},
                {data: 'plan_or_name', name: 'plan_or_name'},
                {data: 'purc_start_date', name: 'purc_start_date'},
                {data: 'purc_end_date', name: 'purc_end_date'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            order: [[1, 'desc']]
        });
    }

    function purchaseplans(ele)
    {
        var id = $(ele).data('id');
        $('#business_id').val(id);
        var business_type = $(ele).data('type');
        $('#business_type').val(business_type);
        $('#myPlan').modal('show');
    }

    function purchasePlan()
    {
        swal({
        title: 'Are you sure?',
        text: "Purchase this business",
        type: 'warning',
        buttons:{
            confirm: {
                text : 'Yes, Approv it!',
                className : 'btn btn-success'
            },
            cancel: {
                visible: true,
                className: 'btn btn-danger'
            }
        }
        }).then((block) => {
            if (block)
            {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var form = document.purchasePlanForm;
                var formData = new FormData(form);
                var url = '{{ route('distributors.purchasePlan') }}';

                $.ajax({
                    type: 'POST',
                    url: url,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    data: formData,
                    dataSrc: "",
                    beforeSend: function() {
                        $('.loader-custom').css('display', 'block');
                        $('span.alerts').remove();
                    },
                    complete: function(data, status) {
                        $('.loader-custom').css('display', 'none');
                    },

                    success: function(response) {
                        if (response.status == 401) {
                            $.each(response.error1, function(index, value) {
                                if (value.length != 0) {
                                    $('.err_' + index).append(
                                        '<span class="small alerts text-danger">' + value +
                                        '</span>');
                                }

                            });
                            return false;
                        }
                        if (!response.status) {
                            alert(response.message);
                            return false;
                        }
                        alert(response.message);
                        $('#myPlan').modal('hide');
                        normalBusinessExpireTable.ajax.reload();
                        normalBusinessUpcomingPlanExpireTable.ajax.reload();
                        politicalBusinessExpireTable.ajax.reload();
                        politicalBusinessUpcomingPlanExpireTable.ajax.reload();
                    }
                });

            }
            else
            {
                swal.close();
            }
        });
    }

</script>

@endsection
