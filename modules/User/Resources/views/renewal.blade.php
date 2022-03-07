@extends('admin.layouts.app')
@section('title', 'Renewal')
@section('content')
<style type="text/css">
    .select2-container {
        width: 100% !important;
    }
</style>
<div class="page-header">
    <h4 class="page-title">Renewal</h4>
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
            <a href="#">Renewal</a>
        </li>
    </ul>
</div>
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
<div class="row">
    <select class="d-none" id="telecaller_list">
            <option disabled selected>Select Telecaller</option>
            @foreach($telecallers as $telecaller)
                <option value="{{$telecaller->id}}">{{$telecaller->name}}</option>
            @endforeach
        </select>
    <div class="col-4">
        <div class="form-group">
            <label for="type">Select Type:</label>
            <select class="form-control" id="type" name="type" onchange="getRenewalPlanList()">
                <option value="1">Upcomming</option>
                <option value="2">Expired</option>
            </select>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label for="type">Select Status:</label>
            <select class="form-control" id="filter_status" name="filter_status" onchange="getRenewalPlanList()">
                <option value="">All</option>
                <option value="0">New Lead</option>
                <option value="1">Hold</option>
                <option value="2">Intersted but not now</option>
                <option value="3">Payment Details shared</option>
                <option value="4">Call Back</option>
                <option value="5">Trail Request</option>
                <option value="6">Not Intersted</option>
                <option value="7">Complete</option>
                <option value="8">Expired</option>
                <option value="9">Cancelled</option>
            </select>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group err_follow_up_date">
            <label>Follow Up Date</label><br>
            <input type="date" class="form-control" onchange="getRenewalPlanList()" id="filter_follow_up_date" name="filter_follow_up_date">
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Renewal List
                </h4>
            </div>
            <div class="table-responsive">
                <table class="display table table-striped table-hover text-center" id="renewal-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Business Type</th>
                            <th>Business Name</th>
                            <th>Plan Name</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Telecaller</th>
                            <th>Telecaller Status</th>
                            <th>Next Follow Up Date</th>
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

<div class="modal fade" id="assigneTelecallerModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Assigne Telecaller</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form name="assigneTelecallerForm" id="assigneTelecallerForm">
                    <input type="hidden" name="user_id" id="user_id">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group err_telecaller_id">
                                <label for="telecaller_id">Select Telecaller</label><br>
                                <select name='telecaller_id' id="telecaller_id" class="form-control">
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group err_follow_up_date">
                                <label>Follow-Up Date</label><br>
                                <input type="date" class="form-control" id="follow_up_date" name="follow_up_date">
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="button" class="btn btn-success"  onclick="assigneTelecallerAdd()">Submit</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewDetailModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Business Detail</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <h3 class="text-center">Add Comment</h3>
                <form name="addBusinessCommentForm" id="addBusinessCommentForm" onsubmit="return false;">
                    <input type="hidden" name="purc_id" id="purc_id" value="">
                    <input type="hidden" name="business_id" id="business_id" value="">
                    <input type="hidden" name="business_type" id="business_type" value="">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group err_status">
                                <label>Select Status</label>
                                <select type="date" class="form-control" name="status" id="status">
                                    <option value="0">New Lead</option>
                                    <option value="1">Hold</option>
                                    <option value="2">Intersted but not now</option>
                                    <option value="3">Payment Details shared</option>
                                    <option value="4">Call Back</option>
                                    <option value="5">Trail Request</option>
                                    <option value="6">Not Intersted</option>
                                    <option value="7">Complete</option>
                                    <option value="8">Expired</option>
                                    <option value="9">Cancelled</option>
                                </select> 
                            </div>
                        </div>
                        <div class="col-6">
                            <label>Next Follow Up Date</label>
                            <div class="form-group err_follow_up_date">
                                <input type="date" class="form-control" name="business_follow_up_date" id="business_follow_up_date">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group err_comment">
                                <label>Comment</label>
                                <textarea class="form-control" row="3" name="comment" id="comment"></textarea>
                            </div>
                        </div>
                        <div class="col-12 text-right">
                            <div class="form-group">
                                <button type="button" class="btn btn-success"  onclick="addBusinessComment()">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
                <hr />
                <h3 class="text-center">Comments History</h3>
                <div id="viewComments">
                </div>
                <hr />
                <h3 class="text-center">Purchase History</h3>
                <div>
                    <div class="table-responsive">
                        <table class="display table table-striped table-hover text-center" id="purchase-list">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Plan Name</th>
                                    <th>Purchase Date</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Cencal Date</th>
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

@endsection
@section('js')
<script type="text/javascript" src="{{ url('/public/admin/js/user/renewal.js?v='.rand()) }}"></script>

<script type="text/javascript">
    var purchaseListTable = "";
    function viewDetails(ele) {
        var purc_id = $(ele).data('id');
        getBusinessComment(purc_id);
    }

    function addBusinessComment() {
        $('span.alerts').remove();

        var form = document.addBusinessCommentForm;

        var formData = new FormData(form);

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }});

        $.ajax({
            type: 'POST',
            url: APP_URL + '/renewal/addBusinessComment',
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
            success: function (data)
            {
                if (data.status == 401)
                {
                    $.each(data.error1, function (index, value) {
                        if (value.length != 0) {
                            $('.err_' + index).append('<span class="small alerts text-danger">' + value + '</span>');
                        }

                    });
                }

                if (data.status == 1)
                {
                    var purc_id = $('#purc_id').val();
                    $('#comment').val('');
                    $('#business_follow_up_date').val(null);
                    getBusinessComment(purc_id);
                    getRenewalPlanList();
                }
            }
        });
    }

    function getBusinessComment(purc_id) {
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }});
        $.ajax({
            type: 'POST',
            url: APP_URL + '/renewal/getBusinessComment',
            dataType: 'json',
            data: {purc_id},
            beforeSend: function ()
            {
                $('.loader-custom').css('display','block');
            },
            complete: function (data, status)
            {
                $('.loader-custom').css('display','none');
            },
            success: function (data)
            {
                $('#viewComments').html(data.commentData);
                $('#purc_id').val(data.purc_id);
                $('#business_type').val(data.business_type);
                $('#business_id').val(data.business_id);
                $('#status').val(data.status);
                getPurchaseHistory(data.business_type, data.business_id);
                $('#viewDetailModal').modal('show');
            }
        })

    }

    function getPurchaseHistory(business_type, business_id) {
        if(purchaseListTable != "") {
            purchaseListTable.destroy();
        }
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }});
        purchaseListTable = $('#purchase-list').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: APP_URL+'/renewal/getPurchaseHistory',
                type: "POST",
                data: { business_type, business_id}
            },
            columns: [
                {data: 'DT_RowIndex', name: 'pph_purc_id'},
                {data: 'plan_or_name', name: 'plan.plan_or_name'},
                {data: 'pph_purc_createdat', name: 'pph_purc_createdat'},
                {data: 'pph_purc_start_date', name: 'pph_purc_start_date'},
                {data: 'pph_purc_end_date', name: 'pph_purc_end_date'},
                {data: 'pph_cencal_date', name: 'pph_cencal_date'},
            ]
        });
    }

    function assigneTelecaller(ele) {
        user_id = $(ele).data('id');
        $('#user_id').val(user_id);
        $('#telecaller_id').html('');
        $('#telecaller_id').val('');
        $('#follow_up_date').val(null);
        var telecallerList = $('#telecaller_list').html();
        $('#telecaller_id').html(telecallerList);
        $('#assigneTelecallerModal').modal('show');
    }

    function assigneTelecallerAdd() {
        $('span.alerts').remove();

        var form = document.assigneTelecallerForm;

        var formData = new FormData(form);

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }});

        $.ajax({
            type: 'POST',
            url: APP_URL + '/user/allpostassigneTelecallerAdd',
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
            success: function (data)
            {
                if (data.status == 401)
                {
                    $.each(data.error1, function (index, value) {
                        if (value.length != 0) {
                            $('.err_' + index).append('<span class="small alerts text-danger">' + value + '</span>');
                        }

                    });
                }
                if(data.status == 0) {
                    alert(data.message);
                }
                if(data.status == 1) {
                    $('#user_id').html("");
                    $('#telecaller_id').html('');
                    $('#telecaller_id').val('');
                    $('#follow_up_date').val(null);
                    $('#assigneTelecallerModal').modal('hide');
                    getRenewalPlanList();
                }
            }
        });
    }
</script>

@endsection