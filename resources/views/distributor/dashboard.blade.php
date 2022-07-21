<!DOCTYPE html>

<html lang="en">

@extends('distributor.layouts.app')

@section('content')

<div class="row">
    <div class="col-sm-6 col-md-4">
        <div class="card card-stats card-primary card-round">
            <div class="card-body">
                <div class="row">
                    <div class="col-5">
                        <div class="icon-big text-center">
                            <i class="fas fa-briefcase"></i>
                        </div>
                    </div>
                    <div class="col-7 col-stats">
                        <div class="numbers">
                            <p class="card-category">Total Business</p>
                            <h4 class="card-title">{{$totalBusiness}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="card card-stats card-primary card-round">
            <div class="card-body">
                <div class="row">
                    <div class="col-5">
                        <div class="icon-big text-center">
                            <i class="fas fa-briefcase"></i>
                        </div>
                    </div>
                    <div class="col-7 col-stats">
                        <div class="numbers">
                            <p class="card-category">Total Political Business</p>
                            <h4 class="card-title">{{$politicalBusiness}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="card card-stats card-primary card-round">
            <div class="card-body">
                <div class="row">
                    <div class="col-5">
                        <div class="icon-big text-center">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                    </div>
                    <div class="col-7 col-stats">
                        <div class="numbers">
                            <p class="card-category">Total Expired Plan</p>
                            <h4 class="card-title">{{$totalExpirePlan}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="card card-stats card-primary card-round">
            <div class="card-body">
                <div class="row">
                    <div class="col-5">
                        <div class="icon-big text-center">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                    </div>
                    <div class="col-7 col-stats">
                        <div class="numbers">
                            <p class="card-category">Total Upcoming Expire Plan </p>
                            <h4 class="card-title">{{$totalUpcomingExpiredPlan}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="card card-stats card-primary card-round">
            <div class="card-body">
                <div class="row">
                    <div class="col-5">
                        <div class="icon-big text-center">
                            <i class="fas fa-wallet"></i>
                        </div>
                    </div>
                    <div class="col-7 col-stats">
                        <div class="numbers">
                            <p class="card-category">Distributor Wallet</p>
                            <h4 class="card-title">{{Auth::user()->distributor->balance}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="card card-stats card-primary card-round">
            <div class="card-body">
                <div class="row">
                    <div class="col-5">
                        <div class="icon-big text-center">
                            <i class="fas fa-coins"></i>
                        </div>
                    </div>
                    <div class="col-7 col-stats">
                        <div class="numbers">
                            <p class="card-category">Referral Earning</p>
                            <h4 class="card-title">{{Auth::user()->distributor->referral_earnings}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
</script>
@endsection
