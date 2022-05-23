
<?php $__env->startSection('title', 'Custom Frames'); ?>
<?php $__env->startSection('content'); ?>
	<div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Withdraw Request List
                </h4>
            </div>
            <div class="card-body">
                <ul class="nav nav-pills nav-secondary m-4" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pending-tab" data-toggle="pill" href="#pendingRequest" role="tab" aria-controls="pendingRequest" aria-selected="true">Pending Request</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="completed-tab" data-toggle="pill" href="#completedRequest" role="tab" aria-controls="completedRequest" aria-selected="false">Completed Request</a>
                    </li>
                </ul>
                <div class="tab-content m-4 mt-2 mb-3" id="pills-tabContent">

                    <div class="tab-pane fade show active" id="pendingRequest" role="tabpanel" aria-labelledby="pending-tab">
                        <div class="table-responsive">
                            <table class="display table table-striped table-hover text-center w-100" id="pending-request-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>User</th>
                                        <th>Mobile No.</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="completedRequest" role="tabpanel" aria-labelledby="completed-tab">
                        <div class="table-responsive">
                            <table class="display table table-striped table-hover text-center w-100" id="completed-request-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>User</th>
                                        <th>Mobile No.</th>
                                        <th>Amount</th>
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
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script type="text/javascript" src="<?php echo e(url('/public/admin/js/user/withdraw-request.js?v='.rand())); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/digital-post/modules/User/Resources/views/withdraw-request.blade.php ENDPATH**/ ?>