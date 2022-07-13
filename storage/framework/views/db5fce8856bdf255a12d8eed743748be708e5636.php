<?php $__env->startSection('title', 'Distributor'); ?>
<?php $__env->startSection('content'); ?>
<style type="text/css">
    .select2-container {
        width: 100% !important;
    }
</style>
<div class="page-header">
    <h4 class="page-title">Distributor</h4>
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
            <a href="#">Distributor</a>
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
                <h4 class="card-title">Distributor
                </h4>
            </div>
            <div class="table-responsive">
                <table class="display table table-striped table-hover text-center w-100" id="distributor-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>City</th>
                            <th>Current Work</th>
                            <th>Contact No</th>
                            <th>Email</th>
                            <th>Status</th>
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

<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<script>
    var table = "";
    $(document).ready(function() {
        table = $('#distributor-table').DataTable({
            processing: true,
            serverSide: true,
            "ajax": "<?php echo e(route('distributor.list')); ?>",
            "columns": [
                {data: 'name', name: 'name'},
                {data: 'city', name: 'city'},
                {data: 'current_work', name: 'current_work'},
                {data: 'contact_no', name: 'contact_no'},
                {data: 'email', name: 'email'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });
    })

    function approveRequest(ele) {
        var id = $(ele).attr('data-id');

        swal({
            title: 'Are you sure?',
            text: "Approve this request!",
            type: 'warning',
            buttons:{
                confirm: {
                    text : 'Yes, Approve it!',
                    className : 'btn btn-success'
                },
                cancel: {
                    visible: true,
                    className: 'btn btn-danger'
                }
            }
        }).then((result) => {
            if(result) {
                var url = "<?php echo e(route('distributor.approve')); ?>";
                var data = {
                    id: id,
                    _token: "<?php echo e(csrf_token()); ?>"
                }
                $('.loader-custom').css('display','block');
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        $('.loader-custom').css('display','none');
                        if(response.status == true) {
                            table.ajax.reload();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(error) {
                        $('.loader-custom').css('display','none');
                        console.log(error);
                    }
                });
            }
        });

    }

    function rejectRequest(ele) {
        var id = $(ele).attr('data-id');

        swal({
            title: 'Are you sure?',
            text: "Reject this request!",
            type: 'warning',
            buttons:{
                confirm: {
                    text : 'Yes, Reject it!',
                    className : 'btn btn-success'
                },
                cancel: {
                    visible: true,
                    className: 'btn btn-danger'
                }
            }
        }).then((result) => {
            if(result) {
                var url = "<?php echo e(route('distributor.reject')); ?>";
                var data = {
                    id: id,
                    _token: "<?php echo e(csrf_token()); ?>"
                }
                $('.loader-custom').css('display','block');
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        $('.loader-custom').css('display','none');
                        if(response.status == true) {
                            table.ajax.reload();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(error) {
                        $('.loader-custom').css('display','none');
                        console.log(error);
                    }
                });
            }
        });

    }


</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/digital-post/modules/User/Resources/views/distributor.blade.php ENDPATH**/ ?>