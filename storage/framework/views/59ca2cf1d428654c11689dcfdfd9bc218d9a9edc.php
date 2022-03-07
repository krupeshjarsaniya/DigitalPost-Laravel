<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <!-- <title><?php echo e(config('app.name', 'Laravel')); ?></title> -->
    <!-- <title><?php echo e(config('constants.SITE_NAME')); ?> | <?php echo $__env->yieldContent('title'); ?></title> -->
    <title>Digital Post | <?php echo $__env->yieldContent('title'); ?></title>
    <!-- Scripts -->
    <!-- <script src="<?php echo e(asset('public/js/app.js')); ?>" defer></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?php echo e(asset('public/admin/logo/logo.png')); ?>"/>
    <!-- Styles -->
    <link href="<?php echo e(asset('public/css/app.css')); ?>" rel="stylesheet">
    <script src="<?php echo e(asset('public/admin/js/plugin/webfont/webfont.min.js')); ?> "></script>
    <script>
        WebFont.load({
            google: {"families":["Lato:300,400,700,900"]},
            custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['<?php echo e(asset('public/admin/css/fonts.min.css')); ?> ']},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="<?php echo e(asset('public/admin/css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/admin/css/datatables.button.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/admin/css/atlantis.min.css')); ?>">

    <!-- CSS Just for demo purpose, don't include it in your project -->
    

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.21.0/ui/trumbowyg.min.css" />
    <style type="text/css">
      input[type=number]::-webkit-inner-spin-button,
      input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
     }

     #divLoading
     {
        display : none;
     }
     .loader-custom
     {
        display : none;
        position : fixed;
        z-index: 100000000;
        background-image : url('<?php echo e(asset("public/loading.gif")); ?>');
        background-color:#666;
        opacity : 0.4;
        background-repeat : no-repeat;
        background-position : center;
        left : 0;
        bottom : 0;
        right : 0;
        top : 0;
    }
    .navbar-header[data-background-color="blue2"], .logo-header[data-background-color="blue"], .bg-primary-gradient,.btn-primary,.btn-primary:focus,.dt-button,.card-primary
    {
      border-color: #6200EA !important;
      background: #6200EA !important; 
    }
    .navbar-header[data-background-color=blue2] {
        background: #6200fa !important;
    }
    .sidebar.sidebar-style-2 .nav.nav-primary>.nav-item.active>a
    {
      background: #6200EE !important; 
      box-shadow: 4px 4px 10px 0 rgba(0,0,0,.1),4px 4px 15px -5px rgba(35,31,32,.4)!important;
    }
    .page-item.active .page-link {
        z-index: 1;
        color: #fff;
        background-color: #6200EE;
        border-color: #6200EE;
    }
    .alerts{
      color:red;
    }
    </style>
    <?php echo $__env->yieldContent('css'); ?>
</head>
<body>
    <?php
        use Illuminate\Support\Facades\Storage;
        $s_url = Storage::url('/');
    ?>
    <script type="text/javascript">
        var APP_URL = <?php echo json_encode(url('/')); ?>;
        var s_urls = '<?php echo e($s_url); ?>';
        var SPACE_STORE_URL = s_urls.replace(".com//",".com/");
    </script> 
    <div class="wrapper">
        <div class="main-header">
            <div class="logo-header" data-background-color="blue">
                <a href="<?php echo e(route('dashboard')); ?>" class="logo">
                    <!-- <img src="<?php echo e(asset('public/admin/logo/user-logo.png')); ?>" alt="navbar brand" class="navbar-brand" style="height:60%"> -->
                    <h2 class="mt-3 text-white">Digital Post</h2>
                </a>
                <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <i class="icon-menu"></i>
                    </span>
                </button>
                <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
               <div class="nav-toggle">
                   <button class="btn btn-toggle toggle-sidebar">
                       <i class="icon-menu"></i>
                   </button>
               </div>
            </div>
         
            <?php echo $__env->make('admin.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         
        </div>
         
            <?php echo $__env->make('admin.layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            
        <div class="main-panel">
            <div class="content">
                <div class="page-inner">
                    <?php echo e(csrf_field()); ?> 
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </div>
                <?php echo $__env->make('admin.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
    <div class="loader-custom"></div>
    <div class="img-model">
        <div class="overlay"></div>
        <div class="img-show">
            <span title="close">X</span>
            <img src="">
        </div>
    </div>
    <!--Core Jquery JS -->
    <script src="<?php echo e(asset('public/admin/js/core/jquery.3.2.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/admin/js/core/popper.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/admin/js/core/bootstrap.min.js')); ?>"></script>

    <!-- Datatables -->
    <script src="<?php echo e(asset('public/admin/js/plugin/datatables/datatables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/admin/js/plugin/datatables/datatables.button.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/admin/js/plugin/datatables/datatables.button.flash.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/admin/js/plugin/datatables/datatables.zip.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/admin/js/plugin/datatables/datatables.pdf.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/admin/js/plugin/datatables/datatables.fonts.js')); ?>"></script>
    <script src="<?php echo e(asset('public/admin/js/plugin/datatables/datatables.button.html5.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/admin/js/plugin/datatables/datatables.button.print.min.js')); ?>"></script>

    <!-- jQuery UI -->
    <script src="<?php echo e(asset('public/admin/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/admin/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')); ?>"></script>

    <!-- jQuery Scrollbar -->
    <script src="<?php echo e(asset('public/admin/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')); ?>"></script>

    <!-- Moment JS -->
    <script src="<?php echo e(asset('public/admin/js/plugin/moment/moment.min.js')); ?>"></script>

    <!-- Chart JS -->
    

    <!-- jQuery Sparkline -->
   

    <!-- Chart Circle -->
    <script src="<?php echo e(asset('public/admin/js/plugin/chart-circle/circles.min.js')); ?>"></script>

    
    <!-- Bootstrap Notify -->
    <script src="<?php echo e(asset('public/admin/js/plugin/bootstrap-notify/bootstrap-notify.min.js')); ?>"></script>

    <!-- Bootstrap Toggle -->
    <script src="<?php echo e(asset('public/admin/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js')); ?>"></script>

    <!-- jQuery Vector Maps -->
    

    <!-- Google Maps Plugin -->
    

    <!-- Dropzone -->
    

    <!-- Fullcalendar -->
    

    <!-- DateTimePicker -->
   <script src="<?php echo e(asset('public/admin/js/plugin/datepicker/bootstrap-datetimepicker.min.js')); ?>"></script>

    <!-- Bootstrap Tagsinput -->
    <script src="<?php echo e(asset('public/admin/js/plugin/bootstrap-tagsinput/bootstrap-tagsinput.min.js')); ?>"></script>

    <!-- Bootstrap Wizard -->
    

    <!-- jQuery Validation -->
    <script src="<?php echo e(asset('public/admin/js/plugin/jquery.validate/jquery.validate.min.js')); ?>"></script>

    <!-- Summernote -->
    

    <!-- Select2 -->
    <script src="<?php echo e(asset('public/admin/js/plugin/select2/select2.full.min.js')); ?>"></script>

    <!-- Sweet Alert -->
    <script src="<?php echo e(asset('public/admin/js/plugin/sweetalert/sweetalert.min.js')); ?>"></script>

    <!-- Magnific Popup -->
    

    <!-- Atlantis JS -->
    <script src="<?php echo e(asset('public/admin/js/atlantis.min.js')); ?>"></script>
    
    <!-- Atlantis DEMO methods, don't include it in your project! -->
    <!--<script src="<?php echo e(asset('public/admin/js/setting-demo.js')); ?>"></script>-->
    <!--<script src="<?php echo e(asset('public/admin/js/demo.js')); ?>"></script>-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.21.0/trumbowyg.min.js"></script>

    <?php echo $__env->yieldContent('js'); ?>
</body>
<div id="divLoading">
   </div>
</html>
<?php /**PATH /opt/lampp/htdocs/digital-post/resources/views/admin/layouts/app.blade.php ENDPATH**/ ?>