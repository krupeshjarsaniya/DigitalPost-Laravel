
<?php $__env->startSection('title', 'Festival'); ?>
<?php $__env->startSection('content'); ?>

<style>
    .imageThumb {
  max-height: 75px;
  border: 2px solid;
  padding: 1px;
  cursor: pointer;
}
.pip {
  display: inline-block;
  margin: 10px 10px 0 0;
}
.remove {
  display: block;
  background: #444;
  border: 1px solid black;
  color: white;
  text-align: center;
  cursor: pointer;
}
.remove:hover {
  background: white;
  color: black;
}

</style>
<div class="page-header">
    <h4 class="page-title">Custom</h4>
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
            <a href="#">Custom</a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12" id="addCategory" style="display: none;">
        <div class="card">
            <div class="card-header">
                <div class="card-title" id="country-title">Add Custom Category</div>
            </div>
            <form id="categotyform" name="categotyform" action=<?php echo e(route('addCustomCategorypost')); ?> method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <?php echo csrf_field(); ?>
                        <div class="row r_h">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="hidden" name="custom_cateogry_data_id" id="custom_cateogry_data_id" value="">
                                    <label for="customcatid">Category Name</label>
                                    <select name="customcatid" id="custom_cat_id" class="form-control">

                                    </select>
                                </div>
                            </div>
                        </div>
                            <div class="form-group" id="showphotos">
                            <label for="addphotos" class="r_h">Add Photos</label></div>
                        <div id="addphotos" class="r_h">
                            <div class="row ">
                                <div class="col-md-10">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="position_x">Text Position X</label>
                                                <input type="text" name="position_x[]" id="position_x" class="form-control" required>
                                            </div>
                                        </div> 
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="position_y">Text Position Y</label>
                                                <input type="text" name="position_y[]" id="position_y" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="img_position_x">Image Position X</label>
                                                <input type="text" name="img_position_x[]" id="img_position_x" class="form-control" required>
                                            </div>
                                        </div> 
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="img_position_y">Image Position Y</label>
                                                <input type="text" name="img_position_y[]" id="img_position_y" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="img_height">Image Height</label>
                                                <input type="text" name="img_height[]" id="img_height" class="form-control" required>
                                            </div>
                                        </div> 
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="img_width">Image Width</label>
                                                <input type="text" name="img_width[]" id="img_width" class="form-control" required>
                                            </div>
                                        </div>                  
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="fimage">Banner Image</label>
                                                <input type="file" class="form-control" onchange="readURL(this,'bannerimg');" id="fimage" name="bannerimg[]">
                                                <img id="bannerimg" src="#" alt="your image" height="100" width="100" style="display: none;"/>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="imgone">Image One</label>
                                                <input type="file" class="form-control" onchange="readURL(this,'imageone');" id="imgone" name="imageone[]">
                                                <img id="imageone" src="#" alt="your image" height="100" width="100" style="display: none;"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="information">Type</label>
                                                </div>
                                                <div class="form-check-inline">
                                                  <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="btype" id="btypefree" value="0" checked="checked">Free
                                                  </label>
                                                </div>
                                                <div class="form-check-inline">
                                                  <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="btype" id="btypepremium" value="1">Premium
                                                  </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                  <label for="flanguage">Select Language:</label>
                                                  <select class="form-control" name="flanguage[]" id="flanguage" required>
                                                    <option value="">Select Language</option>
                                                    <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($value->id); ?>"><?php echo e($value->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                  </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                  <label for="fsubcategory">Select Sub Category:</label>
                                                  <select class="form-control" name="fsubcategory[]" id="fsubcategory">
                                                  </select>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                                <div class="col-md-2 form-group">
                                    <button type="button" onclick="addbox()" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                                </div> 
                            </div>
                            <!-- <div class="col-md-6">
                                <div class="form-group">
                                    <label for="imgtwo">Image Two</label>
                                    <input type="file" class="form-control" onchange="readURL(this,'imagetwo');" id="imgtwo" name="imagetwo">
                                    <img id="imagetwo" src="#" alt="your image" height="100" width="100" style="display: none;"/>
                                </div>
                            </div> -->
                            

                        </div>
                    </div>
                </div>
            </div>
            <div class="card-action text-right">
                <button class="btn btn-success r_h" type="submit"  id="festival-btn">Submit</button>&nbsp;&nbsp;
                <button class="btn btn-danger"  type="button" onclick="showfestivallist()">Cancel</button>
            </div>
             </form>
        </div>
    </div>
    
    <div class="col-md-12" id="viewfestival">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Category List
                <button type="button" onclick="showinsertform()" class="btn btn-info btn-sm pull-right" id="add-festival"><i class="fas fa-plus"></i></button>
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="display table table-striped table-hover text-center" id="category-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
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
    <script type="text/javascript" src="<?php echo e(url('/public/admin/js/user/customeCategoryPost.js?v='.rand())); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/digital-post/modules/Festival/Resources/views/customcategorypost.blade.php ENDPATH**/ ?>