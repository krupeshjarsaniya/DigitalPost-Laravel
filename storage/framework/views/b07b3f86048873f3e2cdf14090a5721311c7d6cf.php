
<?php $__env->startSection('title', 'Users'); ?>
<?php $__env->startSection('content'); ?>

<?php 
    use Illuminate\Support\Facades\Storage;
?>
<div class="page-header">
    <h4 class="page-title">User</h4>
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
            <a href="#">Approval</a>
        </li>
        
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
                            <?php echo csrf_field(); ?>
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
    <div class="col-md-12" id="Political-Business">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Political Business Approval List
                <!-- <button class="btn btn-info btn-sm pull-right" id="add-country"><i class="fas fa-plus"></i></button> -->
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="display table table-striped table-hover text-center" id="political-Approval-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Business Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1; ?>
                           <?php $__currentLoopData = $businesses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $business): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            
                                <tr>
                                    <td><?php echo e($count++); ?></td>
                                    <td><?php echo e($business->name); ?></td>
                                    <td>
                                       
                                        <p>OLD : <?php echo e($business->pb_name); ?></p>
                                        <p>New : <?php echo e($business->pbal_name); ?></p>
                                    </td>
                                    <td>
                                        <button type="button" onclick="approvebusiness('<?php echo e($business->pb_id); ?>')" class="btn btn-primary">Approve</button>
                                        <button type="button" onclick="declinebusiness('<?php echo e($business->pb_id); ?>')" class="btn btn-danger">Decline</button>
                                    </td>
                                </tr>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script type="text/javascript" src="<?php echo e(url('/public/admin/js/user/user-political.js?v='.rand())); ?>"></script>
    <script>
        $(document).ready(function() {
            $('#political-Approval-table').DataTable().draw();
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/digital-post/modules/User/Resources/views/politicalApproval.blade.php ENDPATH**/ ?>