<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DistributorChannel;
use App\Business;
use App\DistributorBusinessFrame;
use App\DistributorTransaction;
use App\Purchase;
use App\PoliticalBusiness;
use App\PoliticalCategory;
use App\Plan;
use DataTables;
use Validator;
use Carbon\Carbon;
use Storage;
use DB;

class DistributorChannelController extends Controller
{
    public function index()
    {
        return view('user::distributor_channel');
    }

    public function list(Request $request)
    {
        $distributors = DistributorChannel::select('*');
        return DataTables::of($distributors)
            ->editColumn('created_at', function ($transaction) {
                return Carbon::parse($transaction->created_at)->format("d-m-Y h:i A");
            })
            ->addColumn('action', function ($distributor) {
                $button = "";
                if ($distributor->status != 'approved') {
                    $button .= '<button onclick="approveRequest(this)" class="btn btn-xs btn-success btn-edit mb-2 ml-2" data-id="' . $distributor->id . '">Approve</button>';
                }
                if ($distributor->status != 'rejected') {
                    $button .= '<button onclick="rejectRequest(this)" class="btn btn-xs btn-danger btn-delet mb-2 ml-2" data-id="' . $distributor->id . '">Reject</button>';
                }
                $view_url = route('distributor_channel.view', ['id' => $distributor->id]);
                $button .= '<a href="' . $view_url . '" class="btn btn-xs btn-primary btn-edit mb-2 ml-2" data-id="' . $distributor->id . '">View</button>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function businessList(Request $request, $id)
    {

        $businesses = Business::where('user_id', $id)->where('is_distributor_business', 1);
        return DataTables::of($businesses)
            ->addIndexColumn()
            ->editColumn('busi_mobile', function ($row) {

                $mobile = "$row->busi_mobile<br>$row->busi_mobile_second";

                return $mobile;
            })
            ->editColumn('busi_logo', function ($row) {
                $image = "";
                if (!empty($row->busi_logo)) {
                    $image = "<img height='100' width='100' src='" . Storage::url($row->busi_logo) . "' />";
                }
                return $image;
            })
            ->editColumn('watermark_image', function ($row) {
                $image = "";
                if (!empty($row->watermark_image)) {
                    $image = "<img height='100' width='100' src='" . Storage::url($row->watermark_image) . "' />";
                }
                return $image;
            })
            ->editColumn('busi_logo_dark', function ($row) {
                $image = "";
                if (!empty($row->busi_logo_dark)) {
                    $image = "<img height='100' width='100' src='" . Storage::url($row->busi_logo_dark) . "' />";
                }
                return $image;
            })
            ->editColumn('watermark_image_dark', function ($row) {
                $image = "";
                if (!empty($row->watermark_image_dark)) {
                    $image = "<img height='100' width='100' src='" . Storage::url($row->watermark_image_dark) . "' />";
                }
                return $image;
            })
            ->editColumn('is_premium', function ($row) {
                $is_premium = "<span class='badge badge-danger'>false</span>";

                $checkPurchase = Purchase::where('purc_business_type', 1)->where('purc_business_id', $row->busi_id)->where('purc_plan_id', '!=', 3)->first();
                if (!empty($checkPurchase)) {
                    $plan = Plan::where('plan_id', $checkPurchase->purc_plan_id)->first();
                    $is_premium = "<span class='badge badge-success'>true</span><br />";
                    $is_premium .= "<span >Plan: ".$plan->plan_or_name."</span><br />";
                    $is_premium .= "<span >Active Date: ".$checkPurchase->purc_start_date."</span><br />";
                    $is_premium .= "<span >Expiry Date: ".$checkPurchase->purc_end_date."</span><br />";
                }
                return $is_premium;
            })

            ->addColumn('action', function ($row) {

                $button = "";
                $button .= '<button onclick="editBusinessData(this)" class="btn btn-xs btn-success btn-edit mb-2" data-id="' . $row->busi_id . '">Edit</button>
                            <button onclick="purchaseHistory(this)" class="btn btn-xs btn-primary btn-edit mb-2" data-type="1" data-id="' . $row->busi_id . '">Purchase History</button>';
                return $button;
            })
            ->rawColumns(['busi_logo', 'busi_mobile', 'watermark_image', 'busi_logo_dark', 'watermark_image_dark', 'is_premium', 'action'])
            ->make(true);
    }

    public function politicalBusinessList(Request $request, $id)
    {

        $politicalBusinesses = PoliticalBusiness::where('user_id', $id)->where('is_distributor_business', 1)->with('category');;
        return DataTables::of($politicalBusinesses)
            ->addIndexColumn()
            ->editColumn('pb_mobile', function ($row) {

                $mobile = "$row->pb_mobile<br>$row->pb_mobile_second";

                return $mobile;
            })
            ->editColumn('pb_party_logo', function ($row) {
                $image = "";
                if (!empty($row->pb_party_logo)) {
                    $image = "<img height='100' width='100' src='" . Storage::url($row->pb_party_logo) . "' />";
                }
                return $image;
            })
            ->editColumn('pb_watermark', function ($row) {
                $image = "";
                if (!empty($row->pb_watermark)) {
                    $image = "<img height='100' width='100' src='" . Storage::url($row->pb_watermark) . "' />";
                }
                return $image;
            })
            ->editColumn('pb_party_logo_dark', function ($row) {
                $image = "";
                if (!empty($row->pb_party_logo_dark)) {
                    $image = "<img height='100' width='100' src='" . Storage::url($row->pb_party_logo_dark) . "' />";
                }
                return $image;
            })
            ->editColumn('pb_watermark_dark', function ($row) {
                $image = "";
                if (!empty($row->pb_watermark_dark)) {
                    $image = "<img height='100' width='100' src='" . Storage::url($row->pb_watermark_dark) . "' />";
                }
                return $image;
            })
            ->editColumn('pb_left_image', function ($row) {
                $image = "";
                if (!empty($row->pb_left_image)) {
                    $image = "<img height='100' width='100' src='" . Storage::url($row->pb_left_image) . "' />";
                }
                return $image;
            })
            ->editColumn('pb_right_image', function ($row) {
                $image = "";
                if (!empty($row->pb_right_image)) {
                    $image = "<img height='100' width='100' src='" . Storage::url($row->pb_right_image) . "' />";
                }
                return $image;
            })
            ->editColumn('is_premium', function ($row) {
                $is_premium = "<span class='badge badge-danger'>false</span>";

                $checkPurchase = Purchase::where('purc_business_type', 2)->where('purc_business_id', $row->pb_id)->where('purc_plan_id', '!=', 3)->first();
                if (!empty($checkPurchase)) {
                    $plan = Plan::where('plan_id', $checkPurchase->purc_plan_id)->first();
                    $is_premium = "<span class='badge badge-success'>true</span><br />";
                    $is_premium .= "<span >Plan: ".$plan->plan_or_name."</span><br />";
                    $is_premium .= "<span >Active Date: ".$checkPurchase->purc_start_date."</span><br />";
                    $is_premium .= "<span >Expiry Date: ".$checkPurchase->purc_end_date."</span><br />";
                }
                return $is_premium;
            })
            ->addColumn('action', function ($row) {
                $button = "";
                $button .= '<button onclick="editPoliticalBusinessData(this)" class="btn btn-xs btn-success btn-edit mb-2" data-id="' . $row->pb_id . '">Edit</button>
                            <button onclick="purchaseHistory(this)" class="btn btn-xs btn-primary btn-edit mb-2" data-type="2" data-id="' . $row->pb_id . '">Purchase History</button>';
                return $button;
            })
            ->rawColumns(['pb_party_logo', 'pb_mobile', 'pb_watermark', 'pb_party_logo_dark', 'pb_watermark_dark', 'pb_left_image', 'pb_right_image', 'is_premium', 'action'])
            ->make(true);
    }

    public function getBusiness(Request $request)
    {
        $getData = Business::where('busi_id', $request->id)->first();
        return response()->json(['status' => true, 'data' => $getData]);
    }
    public function getFrameList(Request $request,$id)
    {
        $frame = DB::table('user_frames')->where('distributor_id', $id)->where('is_deleted',0);

        return DataTables::of($frame)
            ->addIndexColumn()
            ->addColumn('business_name', function ($row) {
                $businessName = "";
                if($row->business_type == 1)
                {
                    $getBusiness = Business::where('busi_id',$row->business_id)->first();
                    if(!empty($getBusiness)){
                        $businessName = $getBusiness->busi_name;
                    }
                }
                else{

                    $getBusiness = PoliticalBusiness::where('pb_id',$row->business_id)->first();
                    if(!empty($getBusiness)){
                        $businessName = $getBusiness->pb_name;
                    }
                }

                return $businessName;
            })

            ->addColumn('business_type', function ($row) {
                $businessType = "";
                if($row->business_type == 1)
                {
                    $businessType = "Normal Business";
                }
                else{
                    $businessType = "Political Business";
                }

                return $businessType;
            })

            ->editColumn('frame_url', function ($row) {
                $image = "";
                if (!empty($row->frame_url)) {
                    $image = "<img height='100' width='100' src='" . Storage::url($row->frame_url) . "' />";
                }
                return $image;
            })

            ->addColumn('action', function ($row) {
                $button = "";
                $button .= '<button onclick="deleteFrame(this)" class="btn btn-xs btn-danger btn-edit mb-2" data-id="' . $row->user_frames_id . '">Delete</button>';
                return $button;
            })
            ->rawColumns(['action','frame_url'])
            ->make(true);
    }

    public function deleteFrame(Request $request){

        DB::table('user_frames')->where('user_frames_id', $request->id)->update(['is_deleted'=>1]);
        return response()->json(['status' => true, 'message' => "Delete Frame successfully"]);
    }

    public function getPoliticalBusiness(Request $request)
    {
        $getData = PoliticalBusiness::where('pb_id', $request->id)->first();
        return response()->json(['status' => true, 'data' => $getData]);
    }


    public function updateBusiness(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'busi_name' => 'required',
            ],
            [
                'busi_name' => 'Please Enter Name',
            ]
        );

        if ($validator->fails()) {
            $error = json_decode($validator->errors());

            return response()->json(['status' => 401, 'error1' => $error]);
            exit();
        }

        $updateCategory = Business::where('busi_id', $request->busi_id)->first();
        $updateCategory->busi_name = $request->busi_name;
        $updateCategory->busi_email = $request->busi_email;
        $updateCategory->busi_mobile = $request->busi_mobile;
        $updateCategory->busi_mobile_second = $request->busi_mobile_second;
        $updateCategory->busi_website = $request->busi_website;
        $updateCategory->busi_address = $request->busi_address;
        $updateCategory->hashtag = $request->hashtag;
        $updateCategoryRoute::prefix('distributor-channel')->middleware('adminauth')->group(function() {
            Route::get('/', 'DistributorChannelController@index')->name('distributor_channel');
            Route::post('/get', 'DistributorChannelController@get')->name('distributor_channel.get');
            Route::get('/list', 'DistributorChannelController@list')->name('distributor_channel.list');
            Route::post('/approve', 'DistributorChannelController@approve')->name('distributor_channel.approve');
            Route::post('/reject', 'DistributorChannelController@reject')->name('distributor_channel.reject');
            Route::get('/transaction/{id}', 'DistributorChannelController@transactionList')->name('distributor_channel.transactionList');
            Route::post('/addTransaction/{id}', 'DistributorChannelController@addTransaction')->name('distributor_channel.addTransaction');
            Route::post('/updateDistributor/{id}', 'DistributorChannelController@updateDistributor')->name('distributor_channel.updateDistributor');
            Route::get('/businessList/{id}', 'DistributorChannelController@businessList')->name('distributor_channel.businessList');
            Route::post('/getBusiness', 'DistributorChannelController@getBusiness')->name('distributor_channel.getBusiness');
            Route::post('/updateBusiness', 'DistributorChannelController@updateBusiness')->name('distributor_channel.updateBusiness');
            Route::get('/politicalBusinessList/{id}', 'DistributorChannelController@politicalBusinessList')->name('distributor_channel.politicalBusinessList');
            Route::post('/getPoliticalBusiness', 'DistributorChannelController@getPoliticalBusiness')->name('distributor_channel.getPoliticalBusiness');
            Route::post('/updatePoliticalBusiness', 'DistributorChannelController@updatePoliticalBusiness')->name('distributor_channel.updatePoliticalBusiness');
            Route::get('/{id}', 'DistributorChannelController@view')->name('distributor_channel.view');
        });
        $updateCategory->busi_linkedin = $request->busi_linkedin;
        $updateCategory->busi_youtube = $request->busi_youtube;

        if ($request->hasFile('busi_logo')) {
            $busi_logo = $this->uploadFile($request, null, 'busi_logo', 'business-img');
            $updateCategory->busi_logo = $busi_logo;
        }
        if ($request->hasFile('busi_logo_dark')) {
            $busi_logo_dark = $this->uploadFile($request, null, 'busi_logo_dark', 'business-img');
            $updateCategory->busi_logo_dark = $busi_logo_dark;
        }
        if ($request->hasFile('watermark_image')) {
            $watermark_image = $this->uploadFile($request, null, 'watermark_image', 'business-img');
            $updateCategory->watermark_image = $watermark_image;
        }
        if ($request->hasFile('watermark_image_dark')) {
            $watermark_image_dark = $this->uploadFile($request, null, 'watermark_image_dark', 'business-img');
            $updateCaRoute::prefix('distributor-channel')->middleware('adminauth')->group(function() {
                Route::get('/', 'DistributorChannelController@index')->name('distributor_channel');
                Route::post('/get', 'DistributorChannelController@get')->name('distributor_channel.get');
                Route::get('/list', 'DistributorChannelController@list')->name('distributor_channel.list');
                Route::post('/approve', 'DistributorChannelController@approve')->name('distributor_channel.approve');
                Route::post('/reject', 'DistributorChannelController@reject')->name('distributor_channel.reject');
                Route::get('/transaction/{id}', 'DistributorChannelController@transactionList')->name('distributor_channel.transactionList');
                Route::post('/addTransaction/{id}', 'DistributorChannelController@addTransaction')->name('distributor_channel.addTransaction');
                Route::post('/updateDistributor/{id}', 'DistributorChannelController@updateDistributor')->name('distributor_channel.updateDistributor');
                Route::get('/businessList/{id}', 'DistributorChannelController@businessList')->name('distributor_channel.businessList');
                Route::post('/getBusiness', 'DistributorChannelController@getBusiness')->name('distributor_channel.getBusiness');
                Route::post('/updateBusiness', 'DistributorChannelController@updateBusiness')->name('distributor_channel.updateBusiness');
                Route::get('/politicalBusinessList/{id}', 'DistributorChannelController@politicalBusinessList')->name('distributor_channel.politicalBusinessList');
                Route::post('/getPoliticalBusiness', 'DistributorChannelController@getPoliticalBusiness')->name('distributor_channel.getPoliticalBusiness');
                Route::post('/updatePoliticalBusiness', 'DistributorChannelController@updatePoliticalBusiness')->name('distributor_channel.updatePoliticalBusiness');
                Route::get('/{id}', 'DistributorChannelController@view')->name('distributor_channel.view');
            });
            $updateCategory->watermark_image_dark = $watermark_image_dark;
        }

        $updateCategory->business_category = $request->business_category;
        $updateCategory->save();

        return response()->json(['status' => true, 'message' => "Business Insert successfully"]);
    }
    public function updatePoliticalBusiness(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'pb_name' => 'required',
            ],
            [
                'pb_name' => 'Please Enter Name',
            ]
        );

        if ($validator->fails()) {
            $error = json_decode($validator->errors());

            return response()->json(['status' => 401, 'error1' => $error]);
            exit();
        }

        $updatePoliticalBusiness = PoliticalBusiness::where('pb_id', $request->pb_id)->first();
        $updatePoliticalBusiness->pb_name = $request->pb_name;
        $updatePoliticalBusiness->pb_designation = $request->pb_designation;
        $updatePoliticalBusiness->pb_mobile = $request->pb_mobile;
        $updatePoliticalBusiness->pb_mobile_second = $request->pb_mobile_second;
        $updatePoliticalBusiness->pb_pc_id = $request->pb_pc_id;
        $updatePoliticalBusiness->hashtag = $request->hashtag;
        $updatePoliticalBusiness->pb_facebook = $request->pb_facebook;
        $updatePoliticalBusiness->pb_twitter = $request->pb_twitter;
        $updatePoliticalBusiness->pb_instagram = $request->pb_instagram;
        $updatePoliticalBusiness->pb_linkedin = $request->pb_linkedin;
        $updatePoliticalBusiness->pb_youtube = $request->pb_youtube;

        if ($request->hasFile('pb_party_logo')) {
            $pb_party_logo = $this->uploadFile($request, null, 'pb_party_logo', 'political-business-img');
            $updatePoliticalBusiness->pb_party_logo = $pb_party_logo;
        }
        if ($request->hasFile('pb_party_logo_dark')) {
            $pb_party_logo_dark = $this->uploadFile($request, null, 'pb_party_logo_dark', 'political-business-img');
            $updatePoliticalBusiness->pb_party_logo_dark = $pb_party_logo_dark;
        }
        if ($request->hasFile('watermark_image')) {
            $watermark_image = $this->uploadFile($request, null, 'watermark_image', 'political-business-img');
            $updatePoliticalBusiness->watermark_image = $watermark_image;
        }
        if ($request->hasFile('pb_watermark_dark')) {
            $pb_watermark_dark = $this->uploadFile($request, null, 'pb_watermark_dark', 'political-business-img');
            $updatePoliticalBusiness->pb_watermark_dark = $pb_watermark_dark;
        }
        if ($request->hasFile('pb_left_image')) {
            $pb_left_image = $this->uploadFile($request, null, 'pb_left_image', 'political-business-img');
            $updatePoliticalBusiness->pb_left_image = $pb_left_image;
        }
        if ($request->hasFile('pb_right_image')) {
            $pb_right_image = $this->uploadFile($request, null, 'pb_right_image', 'political-business-img');
            $updatePoliticalBusiness->pb_right_image = $pb_right_image;
        }
        $updatePoliticalBusiness->save();
        return response()->json(['status' => true, 'message' => "Political Business Update successfully"]);
    }


    public function get(Request $request)
    {
        $id = $request->id;
        $data = DistributorChannel::find($id);
        if (empty($data)) {
            return response()->json([
                'status' => false,
                'message' => "Request not found"
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => "Data fetched successfully",
            'data' => $data
        ]);
    }

    public function approve(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required',
                'referral_benefits' => 'required',
                'start_up_plan_rate' => 'required',
                'custom_plan_rate' => 'required',
                'combo_plan_rate' => 'required',
            ],
            [
                'id.required' => 'ID Is required',
                'referral_benefits.required' => 'Referral Benefits Is Required',
                'start_up_plan_rate.required' => 'Start Up Plan Rate Is Required',
                'custom_plan_rate.required' => 'Custom Plan Rate Is Required',
                'combo_plan_rate.required' => 'Combo Plan Rate Is Required',
            ]
        );

        if ($validator->fails()) {
            $error = json_decode($validator->errors());

            return response()->json(['status' => 401, 'error1' => $error]);
            exit();
        }

        $id = $request->id;
        $checkRequest = DistributorChannel::find($id);
        if (!empty($checkRequest)) {
            $checkRequest->referral_benefits = $request->referral_benefits;
            $checkRequest->start_up_plan_rate = $request->start_up_plan_rate;
            $checkRequest->custom_plan_rate = $request->custom_plan_rate;
            $checkRequest->combo_plan_rate = $request->combo_plan_rate;
            $checkRequest->status = 'approved';
        }
        $checkRequest->save();

        return response()->json([
            'status' => true,
            'message' => "Request approved successfully"
        ]);
    }

    public function reject(Request $request)
    {
        $id = $request->id;
        $checkRequest = DistributorChannel::find($id);
        if (!empty($checkRequest)) {
            $checkRequest->status = 'rejected';
        }
        $checkRequest->save();

        return response()->json([
            'status' => true,
            'message' => "Request rejected successfully"
        ]);
    }

    public function view($id)
    {

        $busi_cats = DB::table('business_category')->where('is_delete', 0)->get();
        $pb_cats = PoliticalCategory::where('pc_is_deleted', 0)->get();
        $distributor = DistributorChannel::find($id);
        if (empty($distributor)) {
            return redirect()->back();
        }
        return view('user::distributor_channel_detail', compact('distributor', 'busi_cats', 'pb_cats'));
    }

    public function transactionList(Request $request, $id)
    {
        $transactions = DistributorTransaction::where('distributor_id', $id);
        return DataTables::of($transactions)
            ->editColumn('type', function ($transaction) {
                if ($transaction->type == 'deposit') {
                    return "<span style='font-size: 12px; text-transform: uppercase;' class='badge badge-success'>$transaction->type</span>";
                } else {
                    return "<span style='font-size: 12px; text-transform: uppercase;' class='badge badge-danger'>$transaction->type</span>";
                }
            })
            ->editColumn('created_at', function ($transaction) {
                return Carbon::parse($transaction->created_at)->format("d-m-Y h:i A");
            })
            ->rawColumns(['created_at', 'type'])
            ->make(true);
    }

    public function addTransaction(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'amount' => 'required',
                'type' => 'required|in:deposit,withdrawal',
            ],
            [
                'amount.required' => 'Amount Is Required',
                'type.required' => 'Type Is Required',
                'type.in' => 'Type Is Invalid',
            ]
        );

        if ($validator->fails()) {
            $error = json_decode($validator->errors());

            return response()->json(['status' => 401, 'error1' => $error]);
            exit();
        }

        $distributor = DistributorChannel::find($id);
        if (empty($distributor)) {
            return response()->json([
                'status' => false,
                'message' => "Distributor not found"
            ]);
        }

        if ($distributor->status != 'approved') {
            return response()->json([
                'status' => false,
                'message' => "Distributor not approved"
            ]);
        }

        $newAmount = $distributor->balance;
        if ($request->type == 'deposit') {
            $newAmount = $newAmount + $request->amount;
        } else {
            if ($request->amount > $newAmount) {
                return response()->json([
                    'status' => false,
                    'message' => "insufficient balance"
                ]);
            }
            $newAmount = $newAmount - $request->amount;
        }

        $distributor->balance = $newAmount;
        $distributor->save();

        $transaction = new DistributorTransaction;
        $transaction->distributor_id = $id;
        $transaction->amount = $request->amount;
        $transaction->type = $request->type;
        $transaction->description = $request->description;
        $transaction->save();

        $data = [
            'balance' => $newAmount
        ];

        return response()->json([
            'status' => true,
            'message' => "Transaction added successfully",
            'data' => $data
        ]);
    }

    public function updateDistributor(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'full_name' => 'required',
                'email' => 'required',
                'contact_number' => 'required',
                'area' => 'required',
                'city' => 'required',
                'state' => 'required',
                'current_work' => 'required',
                'work_experience' => 'required',
                'skills' => 'required',
                'referral_benefits' => 'required',
                'custom_plan_rate' => 'required',
                'start_up_plan_rate' => 'required',
                'combo_plan_rate' => 'required',
                'status' => 'required',
            ],
            [
                'full_name.required' => 'Full Name Is Required',
                'email.required' => 'Email Is Required',
                'contact_number.required' => 'Contact Number Is Required',
                'area.required' => 'Area Is Required',
                'city.required' => 'City Is Required',
                'state.required' => 'State Is Required',
                'current_work.required' => 'Current work Is Required',
                'work_experience.required' => 'Work experience Is Required',
                'skills.required' => 'Skills Is Required',
                'referral_benefits.required' => 'Referral Benefits Is Required',
                'custom_plan_rate.required' => 'Custom plan rate Is Required',
                'start_up_plan_rate.required' => 'Start up plan rate Is Required',
                'combo_plan_rate.required' => 'Combo plan rate Is Required',
                'status.required' => 'Status Is Required',
                'status.required' => 'Status Is Required',
            ]
        );

        if ($validator->fails()) {
            $error = json_decode($validator->errors());

            return response()->json(['status' => 401, 'error1' => $error]);
            exit();
        }

        $checkEmail = DistributorChannel::where('email', $request->email)->where('id', '!=', $id)->first();
        if (!empty($checkEmail)) {
            return response()->json([
                'status' => false,
                'message' => "Email already exists"
            ]);
        }

        $checkNumber = DistributorChannel::where('contact_number', $request->contact_number)->where('id', '!=', $id)->first();
        if (!empty($checkNumber)) {
            return response()->json([
                'status' => false,
                'message' => "Contact number already exists"
            ]);
        }

        $distributor = DistributorChannel::find($id);
        if (empty($distributor)) {
            return response()->json([
                'status' => false,
                'message' => "Distributor not found"
            ]);
        }

        $distributor->full_name = $request->full_name;
        $distributor->email = $request->email;
        $distributor->contact_number = $request->contact_number;
        $distributor->area = $request->area;
        $distributor->city = $request->city;
        $distributor->state = $request->state;
        $distributor->current_work = $request->current_work;
        $distributor->work_experience = $request->work_experience;
        $distributor->skills = $request->skills;
        $distributor->referral_benefits = $request->referral_benefits;
        $distributor->custom_plan_rate = $request->custom_plan_rate;
        $distributor->start_up_plan_rate = $request->start_up_plan_rate;
        $distributor->combo_plan_rate = $request->combo_plan_rate;
        $distributor->status = $request->status;
        $distributor->allow_add_frames = $request->allow_add_frames;

        if ($request->hasFile('aadhar_card_photo')) {
            $aadhar_card_photo = $this->uploadFile($request, null, 'aadhar_card_photo', 'distributor-image');
            $distributor->aadhar_card_photo = $aadhar_card_photo;
        }

        if ($request->hasFile('user_photo')) {
            $user_photo = $this->uploadFile($request, null, 'user_photo', 'distributor-image');
            $distributor->user_photo = $user_photo;
        }

        $distributor->save();

        return response()->json([
            'status' => true,
            'message' => "Distributor updated successfully",
            'data' => $distributor
        ]);
    }

    public function frame()
    {
        return view('user::distributor_frame_request');
    }

    public function changeFrameStatus(Request $request){

        $data = DistributorBusinessFrame::where('id', $request->id)->first();

        if(empty($data))
        {
            return response()->json([
                'status' => false,
                'message' => "Frame Not Found",
            ]);
        }

        DistributorBusinessFrame::where('id', $request->id)->update(['status'=>'REJECTED']);
        return response()->json([
            'status' => true,
            'message' => "Frame Request Rejected successfully"

        ]);
    }

    public function acceptFrame(Request $request){

        $data = DistributorBusinessFrame::where('id', $request->id)->first();

        if(empty($data))
        {
            return response()->json([
                'status' => false,
                'message' => "Frame Not Found",
            ]);
        }

        $dataArr = array(
            'user_id' => $data->user_id,
            'business_id' => $data->business_id,
            'business_type' => $data->business_type,
            'frame_url' => $data->frame_url,
            'distributor_id' => $data ->distributor_id
        );

       DB::table('user_frames')->insert($dataArr);
       $data->delete();

       return response()->json([
        'status' => true,
        'message' => "Frame Request Accepted successfully",
        ]);

    }

    public function frameList(Request $request)
    {
        $frame_requests = DistributorBusinessFrame::where('distributor_business_frames.status', 'PENDING')->with('distributor');

        return DataTables::of($frame_requests)
            ->editColumn('frame_url', function ($frame_request) {
                $image = "";
                if(!empty($frame_request->frame_url)) {
                    $image = '<img src="'.Storage::url($frame_request->frame_url).'" width="150px" height="150px" />';
                }
                return $image;
            })
            ->editColumn('business_name', function ($frame_request) {

                $business_name = "";
                if($frame_request->business_type == 1)
                {

                    $getBusiness = Business::where('busi_id',$frame_request->business_id)->first();
                    if(!empty($getBusiness)){
                        $business_name = $getBusiness->busi_name;
                    }
                }
                else{

                    $getBusiness = PoliticalBusiness::where('pb_id',$frame_request->business_id)->first();
                    if(!empty($getBusiness)){
                        $business_name = $getBusiness->pb_name;
                    }
                }

                return $business_name;
            })
            ->editColumn('created_at', function ($frame_request) {
                return Carbon::parse($frame_request->created_at)->format("d-m-Y h:i A");
            })
            ->addColumn('action', function ($frame_request) {
                    $btn = "";
                    $btn .= '<button class="btn btn-primary btn-sm mr-2" onClick="acceptFrames(this)" data-id="' . $frame_request->id . '"  ">Accept</button>';
                    $btn .= '<button class="btn btn-danger btn-sm mr-2" onClick="changeStatus(this)"  data-id="' . $frame_request->id . '"">Reject</button>';
                    return $btn;

            })
            ->rawColumns(['created_at', 'frame_url','action'])
            ->make(true);
    }

    public function purchasePlanHistory(Request $request)
    {
        $purchasePlans = DB::table('purchase_plan_history')->where('pph_purc_business_id',$request->id)->where('pph_purc_business_type',$request->type);

            return DataTables::of($purchasePlans)
            ->addIndexColumn()
            ->addColumn('plan_or_name', function ($purchasePlan) {
                $plan = DB::table('plan')->where('plan_id',$purchasePlan->pph_purc_plan_id)->first();
                return $plan->plan_or_name;

            })
            ->make(true);

    }
}
