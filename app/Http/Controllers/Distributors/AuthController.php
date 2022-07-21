<?php

namespace App\Http\Controllers\Distributors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use Auth;
use Validator;
use App\User;
use App\DistributorChannel;

class AuthController extends Controller
{

    public function __construct(User $user)
    {

        $this->middleware(function ($request, $next) {
            if(Auth::check()) {
                $user = Auth::user();
                $distributor = DistributorChannel::where('user_id', $user->id)->first();
                if(!empty($distributor)) {
                    return redirect()->route('distributors.dashboard');
                }
                Auth::logout();
            }
            return $next($request);
        })->except('logout');
    }

    public function registerForm()
    {
        return view('distributor.auth.register');
    }

    public function register(Request $request) {

        $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|min:8',
                'full_name' => 'required',
                'contact_number' => 'required',
                'digital_post_app_login_number' => 'required',
                'area' => 'required',
                'city' => 'required',
                'state' => 'required',
                'work_experience' => 'required',
                'current_work' => 'required',
                'skills' => 'required'
            ],
            [
                'email.required' => 'Email Required',
                'email.email' => 'Email Not Formated',
                'password.required' => 'Password Required',
                'password.min' => 'Password Length Minimum 8',
                'full_name.required' => 'Name Required',
                'contact_number.required' => 'Contact Number Required',
                'digital_post_app_login_number.required' => 'Digital Post App Login Number Required',
                'area.required' => 'Area Required',
                'city.required' => 'City Required',
                'current_work.required' => 'Current Work Required',
                'work_experience.required' => 'Work Experience Required',
                'skills.required' => 'Skills Required',
            ]
        );

        if ($validator->fails())
        {
            $error=json_decode($validator->errors());

            return response()->json(['status' => 401,'error1' => $error]);
            exit();

        }

        $user = User::where('mobile', $request->digital_post_app_login_number)->first();
        if(empty($user)) {
            return response()->json([
                'status'=> false,
                'message' => "You must need account in digital post app first"
            ]);
        }

        $distributor = DistributorChannel::where('user_id', $user->id)->first();
        if(!empty($distributor)) {
            return response()->json([
                'status'=> false,
                'message' => "You are already registered as distributors. Your status : " . $distributor->status
            ]);
        }

        $distributor = new DistributorChannel;
        $distributor->user_id = $user->id;

        $distributor->full_name = $request->full_name;
        $distributor->email = $request->email;
        $distributor->password = Hash::make($request->password);
        $distributor->contact_number = $request->contact_number;
        $distributor->area = $request->area;
        $distributor->city = $request->city;
        $distributor->state = $request->state;
        $distributor->current_work = $request->current_work;
        $distributor->work_experience = $request->work_experience;
        $distributor->skills = $request->skills;

        $distributor->save();


        return response()->json([
            'status'=> true,
            'message' => "Registered successfully, Wait for admin to approve your request"
        ]);
    }

    public function loginForm() {
        return view('distributor.auth.login');
    }

    public function login(Request $request) {

        $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ],
            [
                'email.required' => 'Email Required',
                'email.email' => 'Email Not Fotmated',
                'password.required' => 'Password Required',
            ]
        );

        if ($validator->fails())
        {
            $error=json_decode($validator->errors());

            return response()->json(['status' => 401,'error1' => $error]);
            exit();

        }

        $distributor = DistributorChannel::where('email', $request->email)->first();
        if(empty($distributor)) {
            return response()->json([
                'status'=> 401,
                'error1' => ["email" => "Email ID not found"]
            ]);
        }

        if($distributor->status == 'pending') {
            return response()->json([
                'status'=> 401,
                'error1' => ["email" => "Your request is in pending status, wait for admin approval"]
            ]);
        }

        if($distributor->status == 'rejected') {
            return response()->json([
                'status'=> 401,
                'error1' => ["email" => "Your request is rejected, contact admin for more detail"]
            ]);
        }

        $user = User::where('id', $distributor->user_id)->first();
        if(empty($user)) {
            return response()->json([
                'status'=> 401,
                'error1' => ["email" => "User not found"]
            ]);
        }

        if(!Hash::check($request->password, $distributor->password)) {
            return response()->json([
                'status'=> 401,
                'error1' => ["password" => "Wrong password"]
            ]);
        }
        // Auth::loginUsingId($user->id);
        Auth::login($user);

        return response()->json([
            'status'=> true,
            'message' => "Login successfully"
        ]);
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('distributors.loginForm');
    }
}
