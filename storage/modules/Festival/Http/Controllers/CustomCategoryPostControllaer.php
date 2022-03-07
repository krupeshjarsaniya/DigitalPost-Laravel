<?php

namespace Modules\Festival\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Festival;
use App\Post;
use App\Language;
use App\CustomSubCategory;
use Illuminate\Support\Str;
use DB;
use DataTables;
use Illuminate\Support\Facades\Storage;

class CustomCategoryPostControllaer extends Controller
{
    public function getCustomeCategoryPost(Request $request)
    {
    	$customcat = DB::table('custom_cateogry')->get();


        return DataTables::of($customcat)
        ->addIndexColumn()
        ->addColumn('action',function($row) {
            $btn = '<button class="btn btn-info btn-sm" id="editCatPost" onclick="editCat('.$row->custom_cateogry_id.')">Edit</button>';
            /*$btn .= '&nbsp;&nbsp;<button class="btn btn-danger btn-sm" id="removeCat" onclick="removeCatPost('.$row->custom_cateogry_id.')">Delete</button>';*/
            return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    } 

    public function getcatlist(){
     
        $posts =  DB::table('custom_cateogry')->get();
        $first =  DB::table('custom_cateogry')->first();
        $category = array();
        if($first) {
            $category =  CustomSubCategory::where('custom_category_id', $first->custom_cateogry_id)->get();
        }
        // return $data; 

        return response()->json(['status'=>true,'data'=>$posts, 'category'=> $category]);
    }

    public function addCustomCategoryPost(Request $request)
    {
    	//dd($request);

    	$temp = $request->all();
  
        $name = $temp['customcatid'];

        $position_x = $temp['position_x'];

        $position_y = $temp['position_y'];

        $img_position_x = $temp['img_position_x'];

        $img_position_y = $temp['img_position_y'];

        $img_height = $temp['img_height'];

        $img_width = $temp['img_width'];
        
        $language_id = $temp['flanguage'];

        $sub_category_id = $temp['fsubcategory'];

        $custom_cateogry_data_id = $temp['custom_cateogry_data_id'];

        $bannerimgs = (isset($temp['bannerimg'])) ? $temp['bannerimg'] : 'undefined';

        $imageones = (isset($temp['imageone'])) ? $temp['imageone'] : 'undefined';

        // $imagetwo = (isset($temp['imagetwo'])) ? $temp['imagetwo'] : 'undefined';

        $bannerimg_path = array();

        if($bannerimgs != 'undefined'){
           
            foreach ($bannerimgs as $bannerimg) 
            {
               $filename = "";
               $bannerimgpath = "";
                /*$filename = Str::random(7).time().'.'.$bannerimg->getClientOriginalExtension();
                $bannerimg->move(public_path('images/customcat'), $filename);
                $bannerimgpath = '/public/images/customcat/'.$filename;*/
                $bannerimgpath = $this->multipleUploadFileThumb($bannerimg,'customcat-post',true,300,300);
                array_push($bannerimg_path, $bannerimgpath);
            }
        } else {
            $bannerimgpath = '';
        }

        $imageone_path = array();
        if($imageones != 'undefined'){
            
            foreach ($imageones as $imageone) 
            {
               $filename = "";
               $bannerimgpath = "";
                /*$filename = Str::random(7).time().'.'.$imageone->getClientOriginalExtension();
	            $imageone->move(public_path('images/customcat'), $filename);
	            $imageonepath = '/public/images/customcat/'.$filename;*/
                $imageonepath = $this->multipleUploadFile($imageone,'customcat-post');
                array_push($imageone_path, $imageonepath);
            }
        } else {
            $imageonepath = '';
        }

       	$image_tp = array();
        for ($i=0; $i < count($position_x) ; $i++) 
        { 
            /*if ($i == 0) 
            {
               array_push($image_tp, $request->btype);
            }
            else
            {
                array_push($image_tp, $request->btype.$i);
            }*/
            if (isset($temp['btype']) && $i == 0 ) 
            {
                array_push($image_tp, $temp['btype']);
            }
            else
            {
                array_push($image_tp, $temp['btype'.$i]);
            }
        }



        for ($i=0; $i < count($position_x); $i++) 
        { 

	        if($custom_cateogry_data_id == '')
	        {
	            $affected = DB::table('custom_cateogry_data')
	                ->insert(['custom_cateogry_id' => $name, 'banner_image'=>$bannerimg_path[$i], 'image_one'=>$imageone_path[$i], 'image_two'=>'','position_x' => $position_x[$i], 'position_y' => $position_y[$i],'img_position_x' => $img_position_x[$i], 'img_position_y' => $img_position_y[$i],'img_height' => $img_height[$i], 'img_width' => $img_width[$i],'image_type'=>$image_tp[$i],'language_id'=>$language_id[$i],'custom_sub_category_id'=>$sub_category_id[$i]]);
	        } else {

	            if($imageone_path[$i] == '' && $bannerimg_path[$i] == '')
	            {
	                $affected = DB::table('custom_cateogry_data')
	            ->where('custom_cateogry_data_id', $custom_cateogry_data_id)
	            ->update(['custom_cateogry_id' => $name, 'image_two'=>'','position_x' => $position_x[$i], 'position_y' => $position_y[$i],'img_position_x' => $img_position_x[$i], 'img_position_y' => $img_position_y[$i],'img_height' => $img_height[$i], 'img_width' => $img_width[$i],'image_type'=>$image_tp[$i],'language_id'=>$language_id[$i],'custom_sub_category_id'=>$sub_category_id[$i]]);
	            }
	            else if($imageone_path[$i] == '' && $bannerimg_path[$i] != ''){
	                $affected = DB::table('custom_cateogry_data')
	                ->where('custom_cateogry_data_id', $custom_cateogry_data_id)
	                ->update(['custom_cateogry_id' => $name, 'banner_image'=>$bannerimg_path[$i], 'image_two'=>'','position_x' => $position_x[$i], 'position_y' => $position_y[$i],'img_position_x' => $img_position_x[$i], 'img_position_y' => $img_position_y[$i],'img_height' => $img_height[$i], 'img_width' => $img_width[$i],'image_type'=>$image_tp[$i],'language_id'=>$language_id[$i],'custom_sub_category_id'=>$sub_category_id[$i]]);
	            }

	            else if($imageone_path[$i] != '' && $bannerimg_path[$i] == ''){
	                $affected = DB::table('custom_cateogry_data')
	                ->where('custom_cateogry_data_id', $custom_cateogry_data_id)
	                ->update(['custom_cateogry_id' => $name, 'image_one'=>$imageone_path[$i], 'image_two'=>'','position_x' => $position_x[$i], 'position_y' => $position_y[$i],'img_position_x' => $img_position_x[$i], 'img_position_y' => $img_position_y[$i],'img_height' => $img_height[$i], 'img_width' => $img_width[$i],'image_type'=>$image_tp[$i],'language_id'=>$language_id[$i],'custom_sub_category_id'=>$sub_category_id[$i]]);
	            }
	            else {
	                $affected = DB::table('custom_cateogry_data')
	                ->where('custom_cateogry_data_id', $custom_cateogry_data_id)
	                ->update(['custom_cateogry_id' => $name, 'banner_image'=>$bannerimg_path[$i], 'image_one'=>$imageone_path[$i], 'image_two'=>'','position_x' => $position_x[$i], 'position_y' => $position_y[$i],'img_position_x' => $img_position_x[$i], 'img_position_y' => $img_position_y[$i],'img_height' => $img_height[$i], 'img_width' => $img_width[$i],'image_type'=>$image_tp[$i],'language_id'=>$language_id[$i],'custom_sub_category_id'=>$sub_category_id[$i]]);
	            }
	        }
        }



        return redirect('CustomCategorypost');
    }

    public function editCustomeCategoryPost(Request $request)
    {
    	$id = $request->id;

        $posts =  DB::table('custom_cateogry_data')->where('custom_cateogry_id','=',$id)->where('is_delete','=',0)->get();
        $category =  DB::table('custom_cateogry')->where('custom_cateogry_id','=',$id)->first();
        
        $subCategories =  CustomSubCategory::where('is_delete', 0)->where('custom_category_id','=',$id)->get();

        return response()->json(['status'=>true,'data'=>$category, 'images'=>$posts, 'subCategories'=>$subCategories]);

    }

    public function updateCustomCategoryvalue(Request $request)
    {
    	//dd($request);
    	$temp = $request->all();
  
        $name = $temp['customcatid'];

        $position_x = $temp['position_x'];

        $position_y = $temp['position_y'];

        $img_position_x = $temp['img_position_x'];

        $img_position_y = $temp['img_position_y'];

        $img_height = $temp['img_height'];

        $img_width = $temp['img_width'];

        $language_id = $temp['flanguage'];

        $sub_category_id = $temp['fsubcategory'];

        $image_tp = $temp['btype'];

        $custom_cateogry_data_id = $temp['id'];

        $bannerimg = (isset($temp['bannerimg'])) ? $temp['bannerimg'] : 'undefined';

        $imageone = (isset($temp['imageone'])) ? $temp['imageone'] : 'undefined';

        // $imagetwo = (isset($temp['imagetwo'])) ? $temp['imagetwo'] : 'undefined';


        if($bannerimg != 'undefined'){
            $filename = Str::random(7).time().'.'.$bannerimg->getClientOriginalExtension();
            $bannerimg->move(public_path('images/customcat'), $filename);
            $bannerimgpath = '/public/images/customcat/'.$filename;
        } else {
            $bannerimgpath = '';
        }
        if($imageone != 'undefined'){
            $filename = Str::random(7).time().'.'.$imageone->getClientOriginalExtension();
            $imageone->move(public_path('images/customcat'), $filename);
            $imageonepath = '/public/images/customcat/'.$filename;
        } else {
            $imageonepath = '';
        }

        if($imageonepath == '' && $bannerimgpath == ''){
                $affected = DB::table('custom_cateogry_data')
            ->where('custom_cateogry_data_id', $custom_cateogry_data_id)
            ->update(['custom_cateogry_id' => $name,'image_two'=>'','position_x' => $position_x, 'position_y' => $position_y,'img_position_x' => $img_position_x, 'img_position_y' => $img_position_y,'img_height' => $img_height, 'img_width' => $img_width,'image_type'=>$image_tp,'language_id'=>$language_id,'custom_sub_category_id'=>$sub_category_id]);
            }
            else if($imageonepath == '' && $bannerimgpath != ''){
                $affected = DB::table('custom_cateogry_data')
                ->where('custom_cateogry_data_id', $custom_cateogry_data_id)
                ->update(['custom_cateogry_id' => $name,'banner_image'=>$bannerimgpath, 'image_two'=>'','position_x' => $position_x, 'position_y' => $position_y,'img_position_x' => $img_position_x, 'img_position_y' => $img_position_y,'img_height' => $img_height, 'img_width' => $img_width,'image_type'=>$image_tp,'language_id'=>$language_id,'custom_sub_category_id'=>$sub_category_id]);
            }

            else if($imageonepath != '' && $bannerimgpath == ''){
                $affected = DB::table('custom_cateogry_data')
                ->where('custom_cateogry_data_id', $custom_cateogry_data_id)
                ->update(['custom_cateogry_id' => $name,'image_one'=>$imageonepath, 'image_two'=>'','position_x' => $position_x, 'position_y' => $position_y,'img_position_x' => $img_position_x, 'img_position_y' => $img_position_y,'img_height' => $img_height, 'img_width' => $img_width,'image_type'=>$image_tp,'language_id'=>$language_id,'custom_sub_category_id'=>$sub_category_id]);
            }
            else {
                $affected = DB::table('custom_cateogry_data')
                ->where('custom_cateogry_data_id', $custom_cateogry_data_id)
                ->update(['custom_cateogry_id' => $name,'banner_image'=>$bannerimgpath, 'image_one'=>$imageonepath, 'image_two'=>'','position_x' => $position_x, 'position_y' => $position_y,'img_position_x' => $img_position_x, 'img_position_y' => $img_position_y,'img_height' => $img_height, 'img_width' => $img_width,'image_type'=>$image_tp,'language_id'=>$language_id,'custom_sub_category_id'=>$sub_category_id]);
            }

        return response()->json(['status'=>true]);

    }

    public function RemoveCustomCategoryvalue(Request $request)
    {
    	//dd($request->id);
    	DB::table('custom_cateogry_data')
                ->where('custom_cateogry_data_id', $request->id)
                ->update(['is_delete'=>1]);
        return response()->json(['status'=>true]);
    }
}
