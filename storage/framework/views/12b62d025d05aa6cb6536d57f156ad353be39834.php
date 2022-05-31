
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
    <h4 class="page-title">Political Category</h4>
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
            <a href="#">Political Category</a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12" id="addCategory" style="display: none;">
        <div class="card">
            <div class="card-header">
                <div class="card-title" id="country-title">Add Political Category</div>
            </div>
            <form id="categotyform" name="categotyform" action=<?php echo e(route('addPoliticalcategory')); ?> method="post" enctype='multipart/form-data'>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="categoryid" id="categoryid" value="">
                                    <label for="categoryname">Category Name</label>
                                    <input type="text" class="form-control" id="categoryname" placeholder="Enter Category Name" name="categoryname" required>
                                </div>
                            </div>

                            
                           <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cat_slider_img">Image</label>
                                    <input type="file" class="form-control" onchange="readURL(this);" id="cat_slider_img" name="cat_slider_img">
                                    <img id="blah" src="#" alt="your image" height="100" width="100" style="display: none;"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-action text-right">
                <button class="btn btn-success" type="submit"  id="festival-btn">Submit</button>&nbsp;&nbsp;
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
                                <th>Free Business</th>
                                <th>Premium Business</th>
                                <th>image</th>
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
    <script type="text/javascript" src="<?php echo e(url('/public/admin/js/user/politicalcategory.js?v='.rand())); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/digital-post/modules/Festival/Resources/views/politicalcategory.blade.php ENDPATH**/ ?>