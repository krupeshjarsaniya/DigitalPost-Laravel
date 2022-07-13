<?php $__env->startSection('title', 'Distributor Channel'); ?>
<?php $__env->startSection('content'); ?>
<style type="text/css">
    .select2-container {
        width: 100% !important;
    }
</style>
<div class="page-header">
    <h4 class="page-title">Distributor Channel</h4>
    <ul class="breadcrumbs">
        <li class="nav-home">
            <a href="<?php echo e(route('dashboard')); ?>">
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
<?php if(session()->has('message')): ?>
    <div class="alert alert-success">
        <?php echo e(session()->get('message')); ?>

    </div>
<?php endif; ?>

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
                        <a href="<?php echo e(route('distributor_channel')); ?>" class="btn btn-danger float-right">Back</a>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <div class="row mb-4">

                    <div class="col-4">
                        <span style="font-size: 16px;">Status :
                        <?php if($distributor->status == 'pending'): ?>
                            <span="badge badge-secondary">Pending</span>
                        <?php elseif($distributor->status == 'approved'): ?>
                            <span style="font-size: 12px;" class="badge badge-success">Approved</span>
                        <?php else: ?>
                            <span style="font-size: 12px;" class="badge badge-danger">Rejected</span>
                        <?php endif; ?>
                        </span>
                    </div>

                    <div class="col-4">
                        <div class="mt-2">
                            <span style="font-size: 16px;">Wallet Amount: <b id="distributor_balance"><?php echo e($distributor->balance); ?></b></span>
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
                        <b><?php echo e($distributor->user->name); ?></b>
                    </div>

                    <div class="col-md-3">
                        <label>Digital Post App Number: </label>
                        <b><?php echo e($distributor->user->mobile); ?></b>
                    </div>

                    <div class="col-md-3">
                        <label>Distributor Name: </label>
                        <b><?php echo e($distributor->full_name); ?></b>
                    </div>

                    <div class="col-md-3">
                        <label>Distributor Contact Number: </label>
                        <b><?php echo e($distributor->contact_number); ?></b>
                    </div>

                </div>

                <div class="row mb-4">

                    <div class="col-md-3">
                        <label>Distributor Email: </label>
                        <b><?php echo e($distributor->email); ?></b>
                    </div>

                    <div class="col-md-3">
                        <label>Distributor Area: </label>
                        <b><?php echo e($distributor->area); ?></b>
                    </div>

                    <div class="col-md-3">
                        <label>Distributor City: </label>
                        <b><?php echo e($distributor->city); ?></b>
                    </div>

                    <div class="col-md-3">
                        <label>Distributor State: </label>
                        <b><?php echo e($distributor->state); ?></b>
                    </div>
                </div>

                <hr />

                <div class="row mb-4">

                    <div class="col-md-4">
                        <label>Distributor Current Work: </label>
                        <br />
                        <b><?php echo e($distributor->current_work); ?></b>
                    </div>

                    <div class="col-md-4">
                        <label>Distributor Work Experience: </label>
                        <br />
                        <b><?php echo e($distributor->work_experience); ?></b>
                    </div>

                    <div class="col-md-4">
                        <label>Distributor Skills: </label>
                        <br />
                        <b><?php echo e($distributor->skills); ?></b>
                    </div>

                </div>

                <hr />

                <div class="row mb-4">

                    <div class="col-md-4">
                        <label>Distributor Referral Benefit: </label>
                        <br />
                        <b><?php echo e($distributor->referral_benefits); ?></b>
                    </div>

                    <div class="col-md-4">
                        <label>Distributor Custom Plan Rate: </label>
                        <br />
                        <b><?php echo e($distributor->custom_plan_rate); ?></b>
                    </div>

                    <div class="col-md-4">
                        <label>Distributor Startup Plan Rate: </label>
                        <br />
                        <b><?php echo e($distributor->start_up_plan_rate); ?></b>
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
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group err_full_name">
                                <label for="full_name">Full Name</label>
                                <input type="text" id="full_name" value="<?php echo e($distributor->full_name); ?>" name="full_name" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group err_email">
                                <label for="email">Email</label>
                                <input type="text" id="email" value="<?php echo e($distributor->email); ?>" name="email" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group err_contact_number">
                                <label for="contact_number">Contact Number</label>
                                <input type="text" id="contact_number" value="<?php echo e($distributor->contact_number); ?>" name="contact_number" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group err_area">
                                <label for="area">Area</label>
                                <input type="text" id="area" value="<?php echo e($distributor->area); ?>" name="area" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group err_city">
                                <label for="city">City</label>
                                <input type="text" id="city" value="<?php echo e($distributor->city); ?>" name="city" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group err_state">
                                <label for="state">State</label>
                                <input type="text" id="state" value="<?php echo e($distributor->state); ?>" name="state" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group err_current_work">
                                <label for="current_work">Current Work</label>
                                <input type="text" id="current_work" value="<?php echo e($distributor->current_work); ?>" name="current_work" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group err_work_experience">
                                <label for="work_experience">Work Experience</label>
                                <input type="text" id="work_experience" value="<?php echo e($distributor->work_experience); ?>" name="work_experience" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group err_skills">
                                <label for="skills">Skills</label>
                                <input type="text" id="skills" value="<?php echo e($distributor->skills); ?>" name="skills" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group err_referral_benefits">
                                <label for="referral_benefits">Referral Benefit</label>
                                <input type="text" id="referral_benefits" value="<?php echo e($distributor->referral_benefits); ?>" name="referral_benefits" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group err_custom_plan_rate">
                                <label for="custom_plan_rate">Custom Plan Rate</label>
                                <input type="text" id="custom_plan_rate" value="<?php echo e($distributor->custom_plan_rate); ?>" name="custom_plan_rate" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group err_start_up_plan_rate">
                                <label for="start_up_plan_rate">Startup Plan Rate</label>
                                <input type="text" id="start_up_plan_rate" value="<?php echo e($distributor->start_up_plan_rate); ?>" name="start_up_plan_rate" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group err_status">
                                <label for="status">Status</label>
                                <select id="status" name="status" class="form-control">
                                    <option <?php if($distributor->status == 'pending'): ?> selected <?php endif; ?>>pending</option>
                                    <option <?php if($distributor->status == 'approved'): ?> selected <?php endif; ?>>approved</option>
                                    <option <?php if($distributor->status == 'rejected'): ?> selected <?php endif; ?>>rejected</option>
                                    <option <?php if($distributor->status == 'inactive'): ?> selected <?php endif; ?>>inactive</option>
                                </select>
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

<?php if($distributor->status != 'pending'): ?>
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
                    <?php echo csrf_field(); ?>
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
<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
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
        ajax: "<?php echo e(route('distributor_channel.transactionList', ['id' => $distributor->id])); ?>",
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

    var url = "<?php echo e(route('distributor_channel.addTransaction', ['id' => $distributor->id])); ?>";
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

    var url = "<?php echo e(route('distributor_channel.updateDistributor', ['id' => $distributor->id])); ?>";
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/digital-post/modules/User/Resources/views/distributor_channel_detail.blade.php ENDPATH**/ ?>