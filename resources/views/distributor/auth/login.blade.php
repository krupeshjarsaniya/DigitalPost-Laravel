<!DOCTYPE html>

<html lang="en">

@extends('layouts.app')

@section('content')

<style type="text/css">
    #myVideo {
        position: fixed;
        right: 0;
        bottom: 0;
        min-width: 100%;
        min-height: 100%;
    }
</style>
<body class="login" >
    <link rel="icon" type="image/png" href="{{ asset('public/images/favicon1.png')}}"/>
    <div class="wrapper wrapper-login wrapper-login-full p-0" >



        <div class="login-aside w-100 d-flex align-items-center justify-content-center" style="">

            <div class="container container-login container-transparent animated fadeIn " style="background-color: #fff;box-shadow: -1px 3px 3px 3px #ccc;"   >

                <h3 class="text-center theme-font-color">Sign In To Distributor </h3>

                 <form method="POST" name="loginForm" onsubmit="return false" aria-label="{{ __('Login') }}">

                    @csrf

                    <div class="login-form">

                       <div class="form-group err_email">

                            <label for="email">Email Address</label>

                            <input type="email" class="form-control" name="email" required autofocus id="email" placeholder="Enter Email">

                        </div>

                        <div class="form-group err_password">

                            <label for="password" class="placeholder"><b>Password</b></label>

                            <div class="position-relative">

                                <input type="password" class="form-control" name="password" required id="password" placeholder="Password">

                            </div>

                        </div>

                        <div class="form-group form-action-d-flex mb-3 justify-content-center">

                            <input type="button" onclick="login()" class="btn btn-secondary" value="Login" name="submit">

                        </div>

                        <div class="form-group form-action-d-flex mb-3 justify-content-center">

                            <span>dont have an account? <a href="{{ route('distributors.registerForm') }}">Register</a></span>

                        </div>

                    </div>

                 </form>

            </div>

        </div>

    </div>

@endsection

@section('js')
    <script src="{{ asset('public/admin/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            document.title = "Login";
        })

        function login() {
            $('span.alerts').remove();

            var form = document.loginForm;

            var formData = new FormData(form);

            $.ajax({
                type: 'POST',
                url: "{{ route('distributors.login') }}",
                processData: false,
                contentType: false,
                dataType: 'json',
                data: formData,
                dataSrc: "",
                beforeSend: function ()
                {
                    $('.loader-custom').css('display','block');
                },
                complete: function (data, status)
                {
                    $('.loader-custom').css('display','none');
                },
                success: function (data)
                {
                    if (data.status == 401)
                    {
                        $.each(data.error1, function (index, value) {
                            if (value.length != 0) {
                                $('.err_' + index).append('<span class="small alerts text-danger">' + value + '</span>');
                            }

                        });
                        return false;
                    }
                    if(data.status) {
                        swal({
                            title: "Login",
                            text: data.message,
                            icon: 'success',
                        }).then(() => {
                            window.location.href = "{{ route('distributors.dashboard') }}"
                        });
                    }
                    else {
                        swal({
                            title: "Login",
                            text: data.message,
                            icon: 'error',
                        });
                    }
                }
            });
        }
    </script>
@endsection
