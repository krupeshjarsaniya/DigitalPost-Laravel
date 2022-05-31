<?php $__env->startSection('title', 'Donwload-Limit'); ?>
<?php $__env->startSection('content'); ?>

<div class="page-header">
    <h4 class="page-title">Donwload Limit</h4>
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
            <a href="#">Donwload Limit</a>
        </li>
    </ul>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title">Photo Download Limit</h4>
    </div>
    <form name="downloadLimitForm" id="downloadLimitForm" method="POST" onsubmit="return false">
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <div class="form-group err_business_photo_limit">
                        <label for="business_photo_limit">Business Photo Limit</label>
                        <input type="text" class="form-control" name="business_photo_limit" value="<?php echo e($limit->business_photo_limit); ?>" id="business_photo_limit" placeholder="Enter business photo limit" />
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group err_business_video_limit">
                        <label for="business_video_limit">Business Video Limit</label>
                        <input type="text" class="form-control" name="business_video_limit" value="<?php echo e($limit->business_video_limit); ?>" id="business_video_limit" placeholder="Enter business video limit" />
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group err_festival_photo_limit">
                        <label for="festival_photo_limit">Festival Photo Limit</label>
                        <input type="text" class="form-control" name="festival_photo_limit" value="<?php echo e($limit->festival_photo_limit); ?>" id="festival_photo_limit" placeholder="Enter festival photo limit" />
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group err_festival_video_limit">
                        <label for="festival_video_limit">Festival Video Limit</label>
                        <input type="text" class="form-control" name="festival_video_limit" value="<?php echo e($limit->festival_video_limit); ?>" id="festival_video_limit" placeholder="Enter festival video limit" />
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group err_incident_photo_limit">
                        <label for="incident_photo_limit">Incident Photo Limit</label>
                        <input type="text" class="form-control" name="incident_photo_limit" value="<?php echo e($limit->incident_photo_limit); ?>" id="incident_photo_limit" placeholder="Enter incident photo limit" />
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group err_incident_video_limit">
                        <label for="incident_video_limit">Incident Video Limit</label>
                        <input type="text" class="form-control" name="incident_video_limit" value="<?php echo e($limit->incident_video_limit); ?>" id="incident_video_limit" placeholder="Enter incident video limit" />
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group err_greeting_photo_limit">
                        <label for="greeting_photo_limit">Greeting Photo Limit</label>
                        <input type="text" class="form-control" name="greeting_photo_limit" value="<?php echo e($limit->greeting_photo_limit); ?>" id="greeting_photo_limit" placeholder="Enter greeting photo limit" />
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <button type="button" class="btn btn-success"  onclick="updateLimit()">Submit</button>
        </div>
    </form>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<script type="text/javascript" src="<?php echo e(url('/public/admin/js/user/downloadLimit.js?v='.rand())); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/digital-post/modules/User/Resources/views/donwload-limit.blade.php ENDPATH**/ ?>