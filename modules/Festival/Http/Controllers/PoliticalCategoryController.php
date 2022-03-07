<?php

namespace Modules\Festival\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use DB;
use DataTables;
use Illuminate\Support\Facades\Storage;
use App\PoliticalCategory;

class PoliticalCategoryController extends Controller
{

    public function addCategory(Request $request){

        $temp = $request->all();

        $categoryname = $temp['categoryname'];
        $categoryid = $temp['categoryid'];


        if ($request->hasFile('cat_slider_img')) {
            $cat_slider_imgpath = $this->uploadFile($request, null, 'cat_slider_img', 'political-category-slider-img',true,300,300);
        } else {
            $cat_slider_imgpath = '';
        }

        if($categoryid == ''){
            DB::table('political_category')->insert(
                ['pc_name' => $categoryname, 'pc_image' => $cat_slider_imgpath]
            );
        } else {
            if($cat_slider_imgpath != ''){
                DB::table('political_category')
                ->where('pc_id', $categoryid)
                ->update(['pc_name' => $categoryname, 'pc_image' => $cat_slider_imgpath]);
            } else {
                DB::table('political_category')
                ->where('pc_id', $categoryid)
                ->update(['pc_name' => $categoryname]);
            }
            
        }
        return redirect('festival/politicalcategory');
    }

    public function getAllCategory(){
        $customcat = DB::table('political_category')->where('pc_is_deleted','=',0)->get();

        return DataTables::of($customcat)
        ->addIndexColumn()
        ->addColumn('free_business',function($row) {
            $free_business = DB::table('political_business')->where('political_business.pb_pc_id', $row->pc_id)->leftJoin('purchase_plan', 'purchase_plan.purc_business_id', '=', 'political_business.pb_id')->where('purchase_plan.purc_plan_id', 3)->where('purchase_plan.purc_business_type', 2)->where('political_business.pb_is_deleted',0)->count();
            return $free_business;
        })
        ->addColumn('premium_business',function($row) {
            $premium_business = DB::table('political_business')->where('political_business.pb_pc_id', $row->pc_id)->leftJoin('purchase_plan', 'purchase_plan.purc_business_id', '=', 'political_business.pb_id')->where('purchase_plan.purc_plan_id', '!=', 3)->where('purchase_plan.purc_business_type', 2)->where('purchase_plan.purc_is_cencal', 0)->where('purchase_plan.purc_is_expire', 0)->where('political_business.pb_is_deleted',0)->count();
            return $premium_business;
        })
        ->addColumn('action',function($row) {
            $btn = '<button class="btn btn-info btn-sm" id="editCat" onclick="editCat('.$row->pc_id.')">Edit</button>';
            $btn .= '&nbsp;&nbsp;<button class="btn btn-danger btn-sm" id="removeCat" onclick="removeCat('.$row->pc_id.')">Delete</button>';
            return $btn;
        })
        ->addColumn('pc_image',function($row) {
            if($row->pc_image !=''){
                $btn = '<img src="'.Storage::url($row->pc_image).'" height="50px" width="50">';
            } else {
                $btn = '';
            }
            return $btn;
        })
        ->rawColumns(['action','pc_image'])
        ->make(true);
    }

    public function removePoliticalCategory(Request $request){

        $temp = $request->all();
        $id = $temp['id'];
       $post = DB::table('political_business')->where('pb_pc_id',$id)->get();
        
        // DB::table('political_category')->where('pc_id', '=', $id)->delete();
        if(count($post) == 0)
        {
            DB::table('political_category')
                    ->where('pc_id', $id)
                    ->update(['pc_is_deleted' => 1]);
    
            return response()->json(['status'=>200]);
        }
        else
        {
            return response()->json(['status'=>401]);
        }

    }

    public function getcatdetailforedit(Request $request){

        $id = $request->id;

        $posts =  DB::table('political_category')->where('pc_id','=',$id)->first();
        // return $data; 

        return response()->json(['status'=>true,'data'=>$posts]);

    }

    public function getcatlist(){
     
        $posts =  DB::table('custom_cateogry')->get();
        // return $data; 

        return response()->json(['status'=>true,'data'=>$posts]);
    }


}
