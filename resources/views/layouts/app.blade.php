<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <title>Login</title>

    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />

    <!-- <link rel="icon" href="http://themekita.com/demo-atlantis-bootstrap/livepreview/examples/assets/img/icon.ico" type="image/x-icon"/> -->
    <link rel="icon" type="image/png" href="{{ asset('public/images/favicon1.png')}}"/>


    <!-- Fonts and icons -->

    <script src="{{ asset('public/admin/js/plugin/webfont/webfont.min.js') }}"></script>

    <script>
        var APP_URL = {!! json_encode(url('/')) !!};
        WebFont.load({
            google: {"families":["Lato:300,400,700,900"]},
            custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{ asset("public/admin/main/css/fonts.min.css") }}']},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <link rel="stylesheet" href="{{ asset('public/admin/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/admin/css/atlantis.min.css') }}">
    <style type="text/css">
        .navbar-header[data-background-color="blue2"], .logo-header[data-background-color="blue"], .bg-primary-gradient,.btn-primary,.btn-primary:focus,.dt-button,.card-primary,.btn-secondary
        {
          border-color: #6200EE !important;
          background: #6200EE !important; 
        }
        .btn-link,.theme-font-color
        {
           color: #6200EE !important;
        }
        .dt-button{
          background: #6200EE !important;
          color:white !important; 
        }


        .btn-default:disabled, .btn-default:hover,.btn-info:disabled, .btn-info:hover,.btn-success:disabled, .btn-success:hover,.btn-secondary:disabled, .btn-secondary:hover,.btn-danger:disabled, .btn-danger:hover,.btn-dark:disabled, .btn-dark:hover,.btn-light:disabled, .btn-light:hover,.btn-secondary:disabled,.btn-secondary:hover{
          background: #6200EE !important; 
          border-color: #6200EE !important; 
        }
        .btn-primary:disabled, .btn-primary:hover,.btn-dark:hover,.dt-button:hover{
          background: #F3F3F3!important; 
          border-color: #F3F3F3 !important; 
          color:#6200EE !important;
        }
    </style>
</head>
<body>

    <div id="app">
        <main>
            @yield('content')
        </main>
    </div>
    <script src="{{ asset('public/admin/js/core/jquery.3.2.1.min.js') }}"></script>
    <script src="{{ asset('public/admin/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/admin/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('public/admin/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/admin/js/atlantis.min.js') }}"></script>
    @yield('js')
  </body>
</html>

