<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class ConditionController extends Controller
{
    
    public function privacyplicy()
    {
        $privacy = DB::table('setting')->where('setting_id','=',1)->select('privacy_policy')->first();
        return view('privacypolicy',[ 'privacy' => $privacy]);
    }

    public function termcondition()
    {
        $termcondition = DB::table('setting')->where('setting_id','=',1)->select('terms_condition')->first();
         return view('termsconditions',[ 'termcondition' => $termcondition]);
    }

    public function referralpolicy()
    {
        $referral = DB::table('setting')->where('setting_id','=',1)->select('referral_policy')->first();
        return view('referralpolicy',[ 'referral' => $referral]);
    }
    
    public function logout () {
        //logout user
        auth()->logout();
        // redirect to homepage
        return redirect('/');
    }
}
