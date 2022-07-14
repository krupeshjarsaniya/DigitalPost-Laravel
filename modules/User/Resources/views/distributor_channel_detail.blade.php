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
                            <div class="form-group err_status">
                                <label for="status">Adhar Card</label>
                                <input type="file" id="adhar_card_photo" name="adhar_card_photo" class="form-control">
                                
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group err_status">
                                <label for="status">User Photo</label>
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

@endsection
@section('js')
<script>

var table = "";

$(document).ready(function() {
    getTransactionList();
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
