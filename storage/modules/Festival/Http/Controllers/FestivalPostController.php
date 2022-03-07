<?php

namespace Modules\Festival\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Festival;
use App\VideoData;
use App\Post;
use DB;

class FestivalPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getFestivalPostData(Request $request)
    {
		$limit = 30;
        if (!empty($request->limit)) 
		{
            $limit = $request->limit;
        }
        $where[] = ['fest_is_delete', '=', 0];
        if (!empty($request->date)) {
            $where[] = ['fest_date', '>=', $request->date];
        }
		if (!$request->has('get')){
			$request->get = 'all';
		}
		$festivals = null;
        if ($request->get=='all' || $request->get=='festivals') {
			$festivals = Festival::where($where)->where('fest_type', '=', 'festival')->orderBy('fest_date', 'ASC')->select('fest_id as id','fest_name as name','fest_date as date','fest_image as image')->limit($limit)->get();
        }
		$incidents = null;
		if ($request->get=='all' || $request->get=='incidents') {
			$incidents1 = Festival::where('fest_is_delete', '=', 0)->where('fest_type', '=', 'incident')->where('new_cat','!=',0)->orderBy('new_cat', 'ASC')->orderBy('position_no', 'ASC')->select('fest_id as id','fest_name as name','fest_date as date','fest_image as image')->limit($limit)->get();
			$incidents2 = Festival::where('fest_is_delete', '=', 0)->where('fest_type', '=', 'incident')->where('new_cat',0)->orderBy('new_cat', 'ASC')->orderBy('position_no', 'ASC')->select('fest_id as id','fest_name as name','fest_date as date','fest_image as image')->limit($limit)->get();
			//return $incidents1=$incidents1->merge($incidents2);
			$incidents = array_merge($incidents1->toArray(),$incidents2->toArray());
		}
        
		if($festivals || $incidents){
			return response()->json(['status' => true, 'festivals' => $festivals, 'incidents' => $incidents]);
		}else{
			return response()->json(['status' => false]);
		}
    }	
	public function getFestivalPostPhotosData(Request $request) 
	{
        $where[] = ['post_is_deleted', '=', 0];
        if (empty($request->id)) 
		{
			if (empty($request->name)) 
			{
				if (!empty($request->post_id)) {
					$where[] = ['post_id', '=', $request->post_id];
				}else{
					return response()->json(['status' => false, 'message' => 'Id isn\'t set']);
				}
			} else {
				$festivals = Festival::where('fest_name', $request->name)->first(['fest_id']);
				if(!empty($festivals->fest_id)){
					$request->id = $festivals->fest_id;
					$where[] = ['post_category_id','=',$request->id];
				}else{
					return response()->json(['status' => false, 'message' => 'Id isn\'t set']);
				}
			}
        }else{
			$where[] = ['post_category_id','=',$request->id];
		}
		$limit = 20;
        if (!empty($request->limit)) 
		{
            $limit = $request->limit;
        }
		$posts = Post::where($where)->select('post_id as id','post_thumb as image','post_thumb as vfile')->orderBy('post_id','DESC')->limit($limit)->get();
		if($posts){
			return response()->json(['status' => true, 'postPhotos' => $posts]);
		}else{
			return response()->json(['status' => false]);
		}
	}
	
	public function singleFestivalPostPhotosData(Request $request) 
	{
        $where[] = ['post_is_deleted', '=', 0];
		$where[] = ['post_id', '=', $request->post_id];
		$posts = Post::where($where)->select('post_content as vfile')->orderBy('post_id','DESC')->get();
		if($posts){
			return response()->json(['status' => true, 'postPhotos' => $posts]);
		}else{
			return response()->json(['status' => false]);
		}
	}
	
	
	// Category Code
    public function getBusinessCategoryData(Request $request) 
	{		
		$limit = 5;
        if (!empty($request->limit)) 
		{
            $limit = $request->limit;
        }
		$categoryData = DB::table('business_category')->where('is_delete','=',0)->select('id','name')->limit($limit)->get();
		if($categoryData){
			return response()->json(['status' => true, 'categoryData' => $categoryData]);
		}else{
			return response()->json(['status' => false]);
		}
    }
    public function getBusinessCategoryPostData(Request $request) 
	{
        $where[] = ['is_deleted', '=', 0];
        if (empty($request->id)) 
		{
			if (empty($request->name)) 
			{
				if (!empty($request->post_id)) {
					$where[] = ['id', '=', $request->post_id];
				}else{
					return response()->json(['status' => false, 'message' => 'Id isn\'t set']);
				}
			} else {
				$festivals = DB::table('business_category')->where('name', $request->name)->first(['id']);
				if(!empty($festivals->id)){
					$request->id = $festivals->id;
					$where[] = ['buss_cat_post_id','=',$request->id];
				}else{
					return response()->json(['status' => false, 'message' => 'Id isn\'t set']);
				}
			}
        }else{
			$where[] = ['buss_cat_post_id','=',$request->id];
		}
		$limit = 20;
        if (!empty($request->limit)) 
		{
            $limit = $request->limit;
        }
		
        $categoryPost = DB::table('business_category_post_data')->where($where)->select('id','post_thumb as image','post_thumb as vfile')->limit($limit)->orderby('id','DESC')->get();
		if($categoryPost){
			return response()->json(['status' => true, 'categoryPost' => $categoryPost]);
		}else{
			return response()->json(['status' => false]);
		}
		
    }
    public function singleBusinessCategoryPostData(Request $request) 
	{
        $where[] = ['is_deleted', '=', 0];
		$where[] = ['id', '=', $request->post_id];
		
        $categoryPost = DB::table('business_category_post_data')->where($where)->select('thumbnail as vfile')->get();
		if($categoryPost){
			return response()->json(['status' => true, 'categoryPost' => $categoryPost]);
		}else{
			return response()->json(['status' => false]);
		}
		
    }
	
	
	
	
	// get Videos Code
    public function getFestivalVideoData(Request $request)
    {
        $where[] = ['video_is_delete', '=', 0];
        if (!empty($request->date)) {
            $where[] = ['video_date', '>=', $request->date];
        }
		$limit = 30;
        if (!empty($request->limit)) 
		{
            $limit = $request->limit;
        }
        $festivals = VideoData::where('video_type', '=', 'festival')->where($where)->orderBy('video_date', 'ASC')->select('video_id as id','video_name as name','video_date as date','video_image as image')->limit($limit)->get();
        $incidents = VideoData::where('video_type', '=', 'incident')->where('video_is_delete', '=', 0)->orderBy('video_id', 'ASC')->select('video_id as id','video_name as name','video_date as date','video_image as image')->limit($limit)->get();

		if($festivals || $incidents){
			return response()->json(['status' => true, 'festivals' => $festivals, 'incidents' => $incidents]);
		}else{
			return response()->json(['status' => false]);
		}
    }
	public function getFestivalVideoPhotosData(Request $request) 
	{
        $where[] = ['is_deleted', '=', 0];
        if (empty($request->id)) 
		{
			if (empty($request->name)) 
			{
				if (!empty($request->post_id)) {
					$where[] = ['id', '=', $request->post_id];
				}else{
					return response()->json(['status' => false, 'message' => 'Id isn\'t set']);
				}
			} else {
				$festivals = VideoData::where('video_name', $request->name)->first(['video_id']);
				if(!empty($festivals->video_id)){
				$request->id = $festivals->video_id;
				$where[] = ['video_post_id', '=', $request->id];
				}else{
					return response()->json(['status' => false, 'message' => 'Id isn\'t set']);
				}
			}
		}else{
			$where[] = ['video_post_id', '=', $request->id];
		}
		$limit = 20;
        if (!empty($request->limit)) 
		{
            $limit = $request->limit;
        }
		$posts = DB::table('video_post_data')->where($where)->select('id','thumbnail as image','video_url as vfile')->orderBy('id','DESC')->limit($limit)->get();
		if($posts){
			return response()->json(['status' => true, 'postPhotos' => $posts]);
		}else{
			return response()->json(['status' => false]);
		}
	}
	public function singleFestivalVideoPhotosData(Request $request) 
	{
        $where[] = ['is_deleted', '=', 0];
		$where[] = ['id', '=', $request->post_id];
		$posts = DB::table('video_post_data')->where($where)->select('video_url as vfile')->get();
		if($posts){
			return response()->json(['status' => true, 'postPhotos' => $posts]);
		}else{
			return response()->json(['status' => false]);
		}
	}
}
