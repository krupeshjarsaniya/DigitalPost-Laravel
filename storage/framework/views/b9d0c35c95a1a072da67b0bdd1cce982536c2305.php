<?php $__env->startSection('title', 'Background Remove Request'); ?>
<?php $__env->startSection('content'); ?>
<style type="text/css">
    .select2-container {
        width: 100% !important;
    }
</style>
<div class="page-header">
    <h4 class="page-title">Background Remove Request</h4>
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
            <a href="#">Background Remove Request</a>
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
                <h4 class="card-title">Background Remove Request
                </h4>
            </div>
            <div class="table-responsive">
                <table class="display table table-striped table-hover text-center w-100" id="bg-request-table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Business Type</th>
                            <th>Business</th>
                            <th>Mobile</th>
                            <th>Remove Logo</th>
                            <th>Remove Watermark</th>
                            <th>Remove Left Image</th>
                            <th>Remove Right Image</th>
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
        table = $('#bg-request-table').DataTable({
            processing: true,
            serverSide: true,
            "ajax": "<?php echo e(route('bg-request-list')); ?>",
            "columns": [
                {data: 'user_id', name: 'user_id'},
                {data: 'business_type', name: 'business_type'},
                {data: 'business_id', name: 'business_id'},
                {data: 'mobile', name: 'business_id'},
                {data: 'remove_logo', name: 'remove_logo'},
                {data: 'remove_watermark', name: 'remove_watermark'},
                {data: 'remove_left_image', name: 'remove_left_image'},
                {data: 'remove_right_image', name: 'remove_right_image'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });
    })

    function removeRequest(ele) {
        var id = $(ele).attr('data-id');

        swal({
            title: 'Are you sure?',
            text: "Remove this request!",
            type: 'warning',
            buttons:{
                confirm: {
                    text : 'Yes, Remove it!',
                    className : 'btn btn-success'
                },
                cancel: {
                    visible: true,
                    className: 'btn btn-danger'
                }
            }
        }).then((result) => {
            if(result) {
                var url = "<?php echo e(route('bg-request-remove')); ?>";
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

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/digital-post/modules/User/Resources/views/bgRemoveRequest.blade.php ENDPATH**/ ?>