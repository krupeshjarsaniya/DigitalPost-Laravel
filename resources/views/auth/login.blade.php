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

        

        <div class="login-aside w-100 d-flex align-items-center justify-content-center   " style="">

            <div class="container container-login container-transparent animated fadeIn " style="background-color: #fff;box-shadow: -1px 3px 3px 3px #ccc;"   >

                <h3 class="text-center theme-font-color">Sign In To Admin</h3>

                 <form method="POST" name="loginForm" onsubmit="return false" aria-label="{{ __('Register') }}">

                    @csrf

                    <div class="login-form">

                       <div class="form-group err_email">

                            <label for="email2">Email Address</label>

                            <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus id="email2" placeholder="Enter Email">

                        </div>

                        <div class="form-group err_password">

                            <label for="password" class="placeholder"><b>Password</b></label>

                            <div class="position-relative">

                                <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required id="password" placeholder="Password">

                            </div>

                        </div>

                        <div class="form-group form-action-d-flex mb-3">

                            <div class="custom-control custom-checkbox">

                                <input type="checkbox" class="custom-control-input" id="rememberme">

                                <label class="custom-control-label m-0" for="rememberme">Remember Me</label>

                            </div>

                            <input type="button" onclick="login()" class="btn btn-secondary" value="Login" name="submit">

                        </div>

                    </div>

                 </form>

            </div>

        </div>

    </div>

@endsection

@section('js')
    <script type="text/javascript" src="{{ url('/public/admin/js/login.js') }}"></script>
@endsection
    