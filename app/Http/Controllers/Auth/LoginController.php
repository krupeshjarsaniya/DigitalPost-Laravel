<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Validator;
use App\User;
use App\Permission;
use App\Menu;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
        // $this->middleware('auth', ['except' => ['privacypolicy', 'termsandcondition']]);guest
        
    }
    
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function showLoginForm(Request $request) {
        if(Auth::check()) {
            $user = Auth::user();
            $redirect = route('dashboard');
            if($user->user_role != 1) {
                $checkPermission = Permission::where('user_role', $user->user_role)->first();
                if(empty($checkPermission)) {
                    Auth::logout();
                    return redirect('/login');
                }
                $checkMenu = Menu::find($checkPermission->menu_id);
                if(empty($checkMenu)) {
                    Auth::logout();
                    return redirect('/login');
                }
                $redirect = route($checkMenu->route);
            }
            return redirect($redirect);
        }
        else {
            return view('auth.login');
        }
    }

    public function AdminLogin(Request $request)
    {
        Auth::logout();
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',      
            'password' => 'required',      
        ],
        [
            'email.required'=> "Email is required",
            'email.email'=> "Enter valid email",
            'password.required'=> "Password is required",
        ]);

        if ($validator->fails()) 
        {
            $error=json_decode($validator->errors());          
            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        $user = User::where('email',$request->email)->where('user_role', '!=',0)->where('status', '!=', 2)->first();
        
        if(empty($user))
        {
            $error=['email'=> "Email not found"];          
            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }
        if($user->user_role != 1) {
            if($user->status == 1)
            {
                $error=['email'=> "Your account is blocked!"];          
                return response()->json(['status' => 401,'error1' => $error]);
                exit();
            }
        }
        $credentials = ['email'=>$user->email,'password'=>$request->password];
        if (Auth::attempt($credentials)) 
        {
            $redirect = route('dashboard');
            if($user->user_role != 1) {
                $checkPermission = Permission::where('user_role', $user->user_role)->first();
                if(empty($checkPermission)) {
                    Auth::logout();
                    $error=['email'=> "You don't have a permission to access"];          
                    return response()->json(['status' => 401,'error1' => $error]);
                    exit();
                }
                $checkMenu = Menu::find($checkPermission->menu_id);
                if(empty($checkMenu)) {
                    Auth::logout();
                    $error=['email'=> "You don't have a permission to access"];          
                    return response()->json(['status' => 401,'error1' => $error]);
                    exit();
                }
                $redirect = route($checkMenu->route);
            }
            return response()->json(['status' => 1,'data' => "", 'redirect' => $redirect]);
        }
        else
        {
            $error=['password'=> "Incorrect password"];          
            return response()->json(['status' => 401,'error1' => $error]);
            exit();   
        }
    }
}