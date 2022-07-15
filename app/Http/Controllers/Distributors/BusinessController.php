<?php

namespace App\Http\Controllers\Distributors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use DataTables;
use Carbon\Carbon;
use App\DistributorChannel;
use App\DistributorTransaction;
use App\Business;
use App\Purchase;
use Illuminate\Support\Facades\Storage;

class BusinessController extends Controller
{

    public function index()
    {
        return view('distributor.business');
    }

    public function businessList(Request $request) {
        $businesses = Business::where('user_id', Auth::user()->id)->where('is_distributor_business', 1);
        return DataTables::of($businesses)
        ->addIndexColumn()
        ->editColumn('busi_logo', function($row) {
            $image = "";
            if(!empty($row->busi_logo)) {
                $image = "<img height='100' width='100' src='". Storage::url($row->busi_logo) ."' />";
            }
            return $image;
        })
        ->editColumn('watermark_image', function($row) {
            $image = "";
            if(!empty($row->watermark_image)) {
                $image = "<img height='100' width='100' src='". Storage::url($row->watermark_image) ."' />";
            }
            return $image;
        })
        ->editColumn('busi_logo_dark', function($row) {
            $image = "";
            if(!empty($row->busi_logo_dark)) {
                $image = "<img height='100' width='100' src='". Storage::url($row->busi_logo_dark) ."' />";
            }
            return $image;
        })
        ->editColumn('watermark_image_dark', function($row) {
            $image = "";
            if(!empty($row->watermark_image_dark)) {
                $image = "<img height='100' width='100' src='". Storage::url($row->watermark_image_dark) ."' />";
            }
            return $image;
        })
        ->editColumn('is_premium', function($row) {
            $is_premium = "<span class='badge badge-danger'>false</span>";

            $checkPurchase = Purchase::where('purc_business_type', 1)->where('purc_business_id', $row->busi_id)->where('purc_plan_id', '!=', 3)->first();
            if(!empty($checkPurchase)) {
                $is_premium = "<span class='badge badge-success'>true</span>";
                // $is_premium = true;
            }
            return $is_premium;
        })
        ->rawColumns(['busi_logo', 'watermark_image', 'busi_logo_dark', 'watermark_image_dark', 'is_premium'])
        ->make(true);
    }

    public function businessAdd()
    {
        return view('distributor.businessAdd');
    }
}
