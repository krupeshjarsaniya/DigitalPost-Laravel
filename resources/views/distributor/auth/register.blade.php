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
    .login .wrapper.wrapper-login .container-login, .login .wrapper.wrapper-login .container-signup {
        width: 700px;
        padding: 60px 25px;
        border-radius: 5px;
    }
</style>
<body class="login" >
    <link rel="icon" type="image/png" href="{{ asset('public/images/favicon1.png')}}"/>
    <div class="wrapper wrapper-login wrapper-login-full p-0" >



        <div class="login-aside w-100 d-flex align-items-center justify-content-center" style="">

            <div class="container container-login container-transparent animated fadeIn " style="background-color: #fff;box-shadow: -1px 3px 3px 3px #ccc;"   >

                <h3 class="text-center theme-font-color">Sign Up To Distributor </h3>

                 <form method="POST" name="registerForm" onsubmit="return false" aria-label="{{ __('Register') }}">

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

                        <div class="form-group err_full_name">

                            <label for="full_name">Full Name</label>

                            <input type="text" class="form-control" name="full_name" required autofocus id="full_name" placeholder="Enter Full Name">

                        </div>

                        <div class="form-group err_contact_number">

                            <label for="contact_number">Contact Number</label>

                            <input type="text" class="form-control" name="contact_number" required autofocus id="contact_number" placeholder="Enter Contact Number">

                        </div>

                        <div class="form-group err_digital_post_app_login_number">

                            <label for="digital_post_app_login_number">Digital Post App Login Number</label>

                            <input type="text" class="form-control" name="digital_post_app_login_number" required autofocus id="digital_post_app_login_number" placeholder="Enter Digital Post App Login Number">

                        </div>

                        <div class="form-group err_area">

                            <label for="area">Area you are looking</label>

                            <input type="text" class="form-control" name="area" required autofocus id="area" placeholder="Enter Contact Number">

                        </div>

                        <div class="form-group err_city">

                            <label for="city">City</label>

                            <input type="text" class="form-control" name="city" required autofocus id="city" placeholder="Enter City">

                        </div>

                        <div class="form-group err_state">

                            <label for="state">State</label>

                            <input type="text" class="form-control" name="state" required autofocus id="state" placeholder="Enter State">

                        </div>

                        <div class="form-group err_work_experience">

                            <label for="work_experience">Your Work Experience</label>

                            <input type="text" class="form-control" name="work_experience" required autofocus id="work_experience" placeholder="Enter Your Work Experience">

                        </div>

                        <div class="form-group err_current_work">

                            <label for="current_work">Describe Your Current Work</label>

                            <input type="text" class="form-control" name="current_work" required autofocus id="current_work" placeholder="Enter Your Current Work">

                        </div>

                        <div class="form-group err_skills">

                            <label for="skills">Describe your Skills</label>

                            <input type="text" class="form-control" name="skills" required autofocus id="skills" placeholder="Enter Your Skills">

                        </div>

                        <div class="form-group form-action-d-flex mb-3 justify-content-center">

                            <input type="button" onclick="register()" class="btn btn-secondary" value="Register" name="submit">

                        </div>

                        <div class="form-group form-action-d-flex mb-3 justify-content-center">

                            <span>Already have an account? <a href="{{ route('distributors.loginForm') }}">Login</a></span>

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
            document.title = "Register";
        })

        function register() {
            $('span.alerts').remove();

            var form = document.registerForm;

            var formData = new FormData(form);

            $.ajax({
                type: 'POST',
                url: "{{ route('distributors.register') }}",
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
                            title: "Register",
                            text: data.message,
                            icon: 'success',
                        }).then(() => {
                            window.location.href = "{{ route('distributors.loginForm') }}"
                        });
                    }
                    else {
                        swal({
                            title: "Register",
                            text: data.message,
                            icon: 'succes',
                        });
                    }
                }
            });
        }
    </script>
@endsection
