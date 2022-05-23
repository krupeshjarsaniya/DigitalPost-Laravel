
<?php $__env->startSection('title', 'Expired Plans'); ?>
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
    <h4 class="page-title">Admin User</h4>
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
            <a href="#">Expired Plans</a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12" id="viewfestival">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Expired Plans List
                <!-- <button type="button" onclick="showinsertform()" class="btn btn-info btn-sm pull-right" id="add-festival"><i class="fas fa-plus"></i></button> -->
                </h4>
            </div>
            <div class="card-body">
            
                <div class="table-responsive">
                    <table class="display table table-striped table-hover text-center" id="expiredplan-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Business Name</th>
                                <th>Plan Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
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

<div class="modal fade" id="myPlan">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">

      <!-- Modal Header -->
          <div class="modal-header">
              <h4 class="modal-title">Plan List</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
              <div class="form-group ">
                <label for="sel1">Select Plan:</label>
                <select class="form-control" id="planlist">
                  
                </select>
              </div>
          </div>
          <input type="hidden" name="" id="pur_id" value="">

          <!-- Modal footer -->
          <div class="modal-footer">
              <button type="button" class="btn btn-success" onclick="purchaseplan()">purchase</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>

      </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script type="text/javascript" src="<?php echo e(url('/public/admin/js/user/expiredplan.js?v='.rand())); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/digital-post/modules/User/Resources/views/expiredplanlist.blade.php ENDPATH**/ ?>