<?php $__env->startSection('title', 'Users'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h4 class="page-title">Business</h4>
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
            <a href="#">Business</a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12" id="editBusiness" style="display: none;">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card-title">Edit Business</div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group">
                        <lable for="business_name">Name</lable>
                        <input type="hidden" name="business_id" id="business_id" class="form-control">
                        <input type="text" name="business_name" id="business_name" class="form-control">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group">
                        <lable for="business_email">Email</lable>
                        <input type="text" name="business_email" id="business_email" class="form-control">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group">
                        <lable for="business_mobile">Mobile</lable>
                        <input type="text" name="business_mobile" id="business_mobile" class="form-control">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group">
                        <lable for="business_mobile">Mobile 2</lable>
                        <input type="text" name="business_mobile_second" id="business_mobile_second" class="form-control">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group">
                        <lable for="business_website">Website</lable>
                        <input type="text" name="business_website" id="business_website" class="form-control">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group">
                        <lable for="business_address">Address</lable>
                        <input type="text" name="business_address" id="business_address" class="form-control">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group">
                        <label for="logo" class="form-label">Upload Logo</label>
                        <input type="file" name="logo" id="logo" class="form-control"><br>
                        <img id="logoimg" src="#" alt="your image" style="display: none;width: 100px;height:100px;"/>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 form-group">
                        <label for="watermark" class="form-label">Upload Watermark</label>
                        <input type="file" name="watermark" id="watermark" class="form-control"><br>
                        <img id="watermarkimg" src="#" alt="your image" style="display: none;width: 100px;height:100px;"/>
                    </div>
		    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                         <div class="form-group ">
                          <label for="sel1">Select Category:</label>
                          <select class="form-control" id="bcategory_list" name="business_category">
                            <option value="" selected="selected" disabled>Select Category</option>
                            <?php $__currentLoopData = $business_category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            
                                <option value="<?php echo e($value->name); ?>"><?php echo e($value->name); ?></option>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </select>
                        </div>   
                    </div>
                </div>
            </div>
            <div class="card-action">
                <button class="btn btn-success" onclick="UpdateBusiness()">Submit</button>
                <button class="btn btn-danger" onclick="back()">Cancel</button>
            </div>
        </div>
    </div>
    <div class="col-md-12" id="viewDetail">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card-title" id="country-title">Business Information</div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label for="carrier-drpdwn" class="form-label col-lg-1">Filter By Purchase</label>
                    <select name="carrier_id" id="carrier-drpdwn" class="form-control col-lg-3 ml-1">
                        <option value="">Get All</option>
                        <option value="By Admin">By Admin</option>
                        <option value="By User">By User</option>
                        <option value="Not Purchase">Not Purchase</option>
                    </select>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="display table table-striped table-hover text-center" id="business-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                
                                <th>Logo</th>
                                <th>Watermark</th>
                                
                                <th>Purchase Date</th>
                                <th>Purchase Plan</th>
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

<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script type="text/javascript" src="<?php echo e(url('/public/admin/js/user/businesslist.js?v='.rand())); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/digital-post/modules/User/Resources/views/businesslist.blade.php ENDPATH**/ ?>