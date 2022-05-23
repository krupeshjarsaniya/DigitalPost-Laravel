<?php $__env->startSection('title', 'Users'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h4 class="page-title">Plan</h4>
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
            <a href="#">Plan</a>
        </li>
        
    </ul>
</div>

<?php
    use Illuminate\Support\Facades\Storage;
?>

<div class="row">
    <div class="col-md-12" id="updateplan" style="display: none;">
        <div class="card">
            <div class="card-header">
                <div class="card-title" id="country-title">Update Plan</div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <form id="plandata" name="plandata"  onsubmit="return false;" method="post" enctype='multipart/form-data'>
                            <?php echo csrf_field(); ?>
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
                                    <div class="form-group">
                                        <label for="bg_credit">BG Remove Credit</label>
                                        <input type="text" name="bg_credit" class="form-control" id="bg_credit" />
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

                            

                            
                            <div class="card-action text-right">
                                <button class="btn btn-success" type="submit" onclick="updateplan()" id="country-btn">Submit</button>&nbsp;&nbsp;
                                <button class="btn btn-danger"  type="button" onclick="cencelediting()">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

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
                                <th>BG Remove Credit</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($plan->plan_id); ?></td>
                                    <td><?php echo e($plan->plan_or_name); ?></td>
                                    <td><?php echo e($plan->plan_actual_price); ?></td>
                                    <td><?php echo e($plan->plan_validity); ?></td>
                                    <td><?php echo e($plan->plan_validity_type); ?></td>
                                    <td>
                                        <?php if($plan->plan_type == 1): ?>
                                            <p>Normal</p>
                                        <?php endif; ?>
                                        <?php if($plan->plan_type == 2): ?>
                                            <p>Political</p>
                                        <?php endif; ?>
                                        <?php if($plan->plan_type == 3): ?>
                                            <p>All</p>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php echo e($plan->new_or_renewal); ?>

                                    </td>
                                    <td>
                                        <?php echo e($plan->bg_credit); ?>

                                    </td>
                                    <td><img src="<?php echo e(Storage::url($plan->image)); ?>" height="100" width="100"></td>
                                    <td>
                                        <button onclick="getdataforupdateplan('<?php echo e($plan->plan_id); ?>')" class="btn btn-primary">update</button>
                                        <?php if($plan->status == 0): ?>
                                            &nbsp;&nbsp;<button class="btn btn-danger" id="user-block" onclick="blockUser(<?php echo e($plan->plan_id); ?>)">Block</button>
                                        <?php else: ?>
                                             &nbsp;&nbsp;<button class="btn btn-success" id="user-unblock" onclick="unblockUser(<?php echo e($plan->plan_id); ?>)">Unblock</button>
                                        <?php endif; ?>
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
    <script type="text/javascript" src="<?php echo e(url('/public/admin/js/user/plan.js?v='.rand())); ?>"></script>

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/digital-post/modules/Plan/Resources/views/index.blade.php ENDPATH**/ ?>