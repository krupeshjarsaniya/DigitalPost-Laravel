<?php

namespace Modules\Festival\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Festival;
use App\Post;
use App\CustomSubCategory;
use Illuminate\Support\Str;
use DB;
use DataTables;
use Validator;
use Illuminate\Support\Facades\Storage;

class FestivalController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('festival::index');
    }


    public function addFestival(Request $request)
    {
        $temp = $request->all();
  
        $name = $temp['festivalname'];
        $date = (isset($temp['festivaldate'])) ? $temp['festivaldate'] : '';
        $info = $temp['information'];
        $type = $temp['ftype'];
        $image = (isset($temp['thumnail'])) ? $temp['thumnail'] : 'undefined';

         if($image != 'undefined'){
            $filename = Str::random(7).time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images'), $filename);
            $path = url('/').'/public/images/'.$filename;

        } else {
            $path = '';
        }

        $festival = new Festival();
        $festival->fest_name = $name;
        (isset($temp['festivaldate'])) ? $festival->fest_date = $date : '';
        $festival->fest_info = $info;
        $festival->fest_image = $path;
        $festival->fest_type = $type;

        $festival->save();
        $festid = $festival->id;
        
        // print_r($temp);die;
        if (isset($temp['files'])) {
            foreach ($request->file('files') as $image) {
                $filename = Str::random(7).time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('images'), $filename);
                $path = url('/').'/public/images/'.$filename;

                
                $post = new Post();
                $post->post_category_id = $festid;
                $post->post_content = $path;
                $post->save();
            }
        }
      // return view('festival::index'); //response()->json(['status'=>true,'message'=>'Festival successfully added']); 
            return redirect('festival');
    }

    public function getSubCategory(Request $request) {
        $stickers = CustomSubCategory::where('is_delete', 0)->where('custom_category_id', $request->id);
        
        if ($request->ajax())
        {
            # code...
            return DataTables::of($stickers)
            ->editColumn('name',function($row) {
                $name = "<div class='row' >";
                $name .= "<div class='col-9' >";
                $name .= "<input class='form-control' type='text' id='name_".$row->id."' value=".$row->name." />";
                $name .= "</div>";
                $name .= "<div class='col-3' >";
                $name .= "<button class='btn btn-primary' data-custom-category-id='".$row->custom_category_id."' data-sub-category-id='".$row->id."' onclick='editSubCategory(this)'>Update</button>";
                $name .= "</div>";
                return $name;
            })
            ->addColumn('action',function($row) {
                $btn = '<button class="btn btn-danger btn-sm mb-2" data-id="'.$row->id.'" onclick="deleteSubCategory(this)"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                return $btn;
            })
            ->rawColumns(['action', 'name'])
            ->make(true);
        }
    }

    public function getSubCategoryTest(Request $request) {
        $stickers = CustomSubCategory::where('is_delete', 0)->where('custom_category_id', $request->id);
        
        if ($request->ajax())
        {
            # code...
            return DataTables::of($stickers)
            ->editColumn('name',function($row) {
                $name = "<div class='row' >";
                $name .= "<div class='col-9' >";
                $name .= "<input class='form-control' type='text' id='name_".$row->id."' value=".$row->name." />";
                $name .= "</div>";
                $name .= "<div class='col-3' >";
                $name .= "<button class='btn btn-primary' data-custom-category-id='".$row->custom_category_id."' data-sub-category-id='".$row->id."' onclick='editSubCategory(this)'>Update</button>";
                $name .= "</div>";
                return $name;
            })
            ->addColumn('action',function($row) {
                $btn = '<button class="btn btn-danger btn-sm mb-2" data-id="'.$row->id.'" onclick="deleteSubCategory(this)"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                return $btn;
            })
            ->rawColumns(['action', 'name'])
            ->make(true);
        }
    }


    public function addSubCategory(Request $request) {
        $validator = Validator::make($request->all(), [
                'custom_category_id' => 'required',      
                'sub_category_name' => 'required',      
            ],
            [
                'custom_category_id.required' => 'Select Category',
                'sub_category_name.required' => 'Name is Required',
            ]
        );

        if ($validator->fails()) 
        {  
            $error=json_decode($validator->errors());          

            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        $checkCategory = CustomSubCategory::where('name', $request->sub_category_name)->where('custom_category_id', $custom_category_id)->where('is_delete',0)->first();
        if($checkCategory) {
            $error=['sub_category_name' => 'Category already exists'];
            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        $category = new CustomSubCategory;
        $category->name = $request->sub_category_name;
        $category->custom_category_id = $request->custom_category_id;
        $category->save();

        return response()->json(['status' => 1,'data' => "", 'message' => 'Category added' ]);
    }

    public function addSubCategoryTest(Request $request) {
        $validator = Validator::make($request->all(), [
                'custom_category_id' => 'required',      
                'sub_category_name' => 'required',      
            ],
            [
                'custom_category_id.required' => 'Select Category',
                'sub_category_name.required' => 'Name is Required',
            ]
        );

        if ($validator->fails()) 
        {  
            $error=json_decode($validator->errors());          

            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        $checkCategory = CustomSubCategory::where('name', $request->sub_category_name)->where('custom_category_id', $request->custom_category_id)->where('is_delete',0)->first();
        if($checkCategory) {
            $error=['sub_category_name' => 'Category already exists'];
            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        $category = new CustomSubCategory;
        $category->name = $request->sub_category_name;
        $category->custom_category_id = $request->custom_category_id;
        $category->save();

        return response()->json(['status' => 1,'data' => "", 'message' => 'Category added' ]);
    }

    public function editSubCategory(Request $request) {
        $validator = Validator::make($request->all(), [
                'custom_category_id' => 'required',      
                'sub_category_id' => 'required',      
                'sub_category_name' => 'required',      
            ],
            [
                'sub_category_id.required' => 'Select Festival',
                'custom_category_id.required' => 'Select Festival',
                'sub_category_name.required' => 'Name is Required',
            ]
        );

        if ($validator->fails()) 
        {  
            $error=json_decode($validator->errors());          

            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        $checkCategory = CustomSubCategory::where('name', $request->sub_category_name)->where('id', $request->sub_category_id)->where('custom_category_id', $request->custom_category_id)->where('is_delete',0)->first();
        if($checkCategory) {
            return response()->json(['status' => false,'message' => "Sub Category already exists"]);
            exit();
        }

        $category = CustomSubCategory::find($request->sub_category_id);
        $category->name = $request->sub_category_name;
        $category->save();

        return response()->json(['status' => true, 'message' => 'Category updated' ]);
    }

    public function editSubCategoryTest(Request $request) {
        $validator = Validator::make($request->all(), [
                'custom_category_id' => 'required',      
                'sub_category_id' => 'required',      
                'sub_category_name' => 'required',      
            ],
            [
                'sub_category_id.required' => 'Select Festival',
                'custom_category_id.required' => 'Select Festival',
                'sub_category_name.required' => 'Name is Required',
            ]
        );

        if ($validator->fails()) 
        {  
            $error=json_decode($validator->errors());          

            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        $checkCategory = CustomSubCategory::where('name', $request->sub_category_name)->where('id', $request->sub_category_id)->where('custom_category_id', $request->custom_category_id)->where('is_delete',0)->first();
        if($checkCategory) {
            return response()->json(['status' => false,'message' => "Sub Category already exists"]);
            exit();
        }

        $category = CustomSubCategory::find($request->sub_category_id);
        $category->name = $request->sub_category_name;
        $category->save();

        return response()->json(['status' => true, 'message' => 'Category updated' ]);
    }

    public function deleteSubCategory(Request $request) {
        $id = $request->id;
        $posts = DB::table('custom_cateogry_data')->where('custom_sub_category_id','=',$id)->where('is_delete',0)->count();
        if($posts > 0) {
            return response()->json(['status' => 1,'data' => "", 'message' => 'Delete related images before delete sub category']);
        }
        $category = CustomSubCategory::find($id);
        if($category) {
            $category->is_delete = 1;
        }
        $category->save();
        return response()->json(['status' => 1,'data' => "", 'message' => 'Sub Category deleted' ]);
    }

    public function deleteSubCategoryTest(Request $request) {
        $id = $request->id;
        $posts = DB::table('custom_cateogry_data')->where('custom_sub_category_id','=',$id)->where('is_delete',0)->count();
        if($posts > 0) {
            return response()->json(['status' => 1,'data' => "", 'message' => 'Delete related images before delete sub category']);
        }
        $category = CustomSubCategory::find($id);
        if($category) {
            $category->is_delete = 1;
        }
        $category->save();
        return response()->json(['status' => 1,'data' => "", 'message' => 'Sub Category deleted' ]);
    }

    public function searchMonthsFestival(Request $request)
    {

        $date = $request->date;
        if($date)
        {
            $festivals = Festival::where('fest_date', 'LIKE', $date . '%')->where('fest_type','=','festival')->where('fest_is_delete','=',0)->get();
            $incidents = Festival::where('fest_date', 'LIKE', $date . '%')->where('fest_type','=','incident')->where('fest_is_delete','=',0)->get();
        }
        else
        {
            $festivals = Festival::where('fest_type','=','festival')->where('fest_is_delete','=',0)->get();
            $incidents = Festival::where('fest_type','=','incident')->where('fest_is_delete','=',0)->get();
        }

        $festivalsCount = count($festivals);
        $incidentsCount = count($incidents);
        
        // dd($festivalsCount,$incidentsCount);
        
        $data = '';
        if($festivalsCount!=0)
        {
            $count = 1;
            foreach ($festivals as $key => $festival)
            {
                $data .= '<tr>';
                $data .= '<td>'.$count++.'</td>';
                $data .= '<td>'.$festival->fest_name.'</td>';
                $data .= '<td>'.$festival->fest_date.'</td>';
                $data .= '<td>Festival</td>';
                $data .= '<td>'.$festival->fest_info.'</td>';
                $data .= '<td><button onclick="editFestival('.$festival->fest_id.')" class="btn btn-primary">Edit</button><button onclick="deleteFestival('.$festival->fest_id.')" class="btn btn-danger ml-1">Delete</button></td>';
                $data .= '</tr>';
            }    
        }
        // else
        // {
        //     $data .= '<tr>';
        //     $data .= '<td colspan="6" align="center">No data found</td>';
        //     $data .= '</tr>';
        // }
        
        $incidentdata = '';
        if($incidentsCount!=0)
        {
            $count = 1;
            foreach ($incidents as $key => $incident)
            {
                $incidentdata .= '<tr>';
                $incidentdata .= '<td>'.$count++.'</td>';
                $incidentdata .= '<td>'.$incident->fest_name.'</td>';
                // $incidentdata .= '<td>'.$incident->fest_date.'</td>';
                $incidentdata .= '<td>Incident</td>';
                $incidentdata .= '<td>'.$incident->fest_info.'</td>';
                $incidentdata .= '<td><button onclick="editFestival('.$incident->fest_id.')" class="btn btn-primary">Edit</button><button onclick="deleteFestival('.$incident->fest_id.')" class="btn btn-danger ml-1">Delete</button></td>';
                $incidentdata .= '</tr>';
            }
        }
        // else
        // {
        //     $incidentdata .= '<tr>';
        //     $incidentdata .= '<td colspan="6" align="center">No data found</td>';
        //     $incidentdata .= '</tr>';
        // }

        // if(!empty($festivals))
        // {
            return response()->json(['status'=>true,'data'=>$data,'incidents'=>$incidentdata]); 

        // } else {
        //     return response()->json(['status'=>false,'data'=>'No festival found']); 
        // }

    }
    
    public function getFestivalforedit(Request $request){
        $id = $request->id;
        $data = Festival::where('fest_id', $id)->first();
        $posts = Post::where('post_category_id','=',$id)->where('post_is_deleted','=',0)->get();
        // return $data; 

        return response()->json(['status'=>true,'data'=>$data,'images'=>$posts]);

    }

    public function removefestivalimage(Request $request)
    {
        $id = $request->id;
        $posts = Post::where('post_id','=',$id)->update(array(
                'post_is_deleted' => 1,
        ));

        return response()->json(['status'=>true]);
    }

    public function deleteFestival(Request $request){

        $id = $request->id;
        Festival::where('fest_id', $id)->update(array(
                'fest_is_delete' => 1,
        ));
    }
    public function updateFestival(Request $request){

        $temp = $request->all();
    // print_r($temp);die();
        $name = $temp['festivalname'];
        $date = $temp['festivaldate'];
        $info = $temp['information'];
        $type = $temp['ftype'];
        $image = (isset($temp['thumnail'])) ? $temp['thumnail'] : 'undefined';
        $id = $temp['festivalid'];
     
         if($image != 'undefined'){
            $filename = Str::random(7).time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images'), $filename);
            $path = url('/').'/public/images/'.$filename;
            Festival::where('fest_id', $id)->update(array(
                'fest_name' => $name,
                'fest_date' => $date,
                'fest_info' => $info,
                'fest_type' => $type,
                'fest_image' => $path,
            ));

        } else {

            Festival::where('fest_id', $id)->update(array(
                'fest_name' => $name,
                'fest_date' => $date,
                'fest_info' => $info,
                'fest_type' => $type,
            ));
        }

        if (isset($temp['files'])) {
            foreach ($request->file('files') as $image) {
                $filename = Str::random(7).time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('images'), $filename);
                $path = url('/').'/public/images/'.$filename;

                $post = new Post();
                $post->post_category_id = $id;
                $post->post_content = $path;
                $post->save();
            }
        }
        
         return redirect('festival');

    }

    public function addCategory(Request $request){

        $temp = $request->all();

        $categoryname = $temp['categoryname'];
        $categoryid = $temp['categoryid'];
        $imgposition = $temp['imgposition'];
        $highlight = $temp['highlight'] ? $temp['highlight'] : 0;

        if ($request->hasFile('cat_slider_img')) {
            /*$image = $request->file('cat_slider_img');
            $name = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/customcat'), $name);
            $cat_slider_imgpath = '/public/images/customcat/'.$name;*/
            $cat_slider_imgpath = $this->uploadFile($request, null, 'cat_slider_img', 'custom-category-slider-img',true,300,300);
            //dd($cat_slider_imgpath);
           /* $extension = $request->file('cat_slider_img')->extension();
            $cat_slider_imgpath = Storage::disk('do')->put('uploads', $request->file('cat_slider_img'), time().'.'.$extension, 'public');*/
        } else {
            $cat_slider_imgpath = '';
        }

        if($categoryid == ''){
            DB::table('custom_cateogry')->insert(
                ['name' => $categoryname, 'slider_img' => $cat_slider_imgpath, 'slider_img_position' => $imgposition]
            );
        } else {
            if($cat_slider_imgpath != ''){
                DB::table('custom_cateogry')
                ->where('custom_cateogry_id', $categoryid)
                ->update(['name' => $categoryname, 'slider_img' => $cat_slider_imgpath, 'slider_img_position' => $imgposition, 'highlight' => $highlight]);
            } else {
                DB::table('custom_cateogry')
                ->where('custom_cateogry_id', $categoryid)
                ->update(['name' => $categoryname, 'slider_img_position' => $imgposition, 'highlight' => $highlight]);
            }
            
        }
       

        return redirect('festival/custom');
    }

    public function getAllCategory(){
        $customcat = DB::table('custom_cateogry')->orderBy('slider_img_position','ASC')->get();

        return DataTables::of($customcat)
        ->addIndexColumn()
        ->addColumn('action',function($row) {
            $btn = '<button class="btn btn-info btn-sm" onclick="addCustomSubCategory('.$row->custom_cateogry_id.')">Sub Category</button>';
            $btn .= '&nbsp;&nbsp;<button class="btn btn-info btn-sm" id="editCat" onclick="editCat('.$row->custom_cateogry_id.')">Edit</button>';
            $btn .= '&nbsp;&nbsp;<button class="btn btn-danger btn-sm" id="removeCat" onclick="removeCat('.$row->custom_cateogry_id.')">Delete</button>';
            return $btn;
        })
        ->addColumn('slider_img',function($row) {
            if($row->slider_img !=''){
                $btn = '<img src="'.Storage::url($row->slider_img).'" height="50px" width="50">';
            } else {
                $btn = '';
            }
            return $btn;
        })
        ->rawColumns(['action','slider_img'])
        ->make(true);
    }

    public function removeCat(Request $request){

        $temp = $request->all();
        $id = $temp['id'];
        $posts = DB::table('custom_cateogry_data')->where('custom_cateogry_id','=',$id)->where('is_delete','=',0)->get();
        if(count($posts) == 0)
        {
        
            DB::table('custom_cateogry')->where('custom_cateogry_id', '=', $id)->delete();
            return response()->json(['status'=>200]);
        }
        else
        {
            return response()->json(['status'=>401]);
        }
        

    }

    public function getcatdetailforedit(Request $request){

        $id = $request->id;

        $posts =  DB::table('custom_cateogry')->where('custom_cateogry_id','=',$id)->first();
        // return $data; 

        return response()->json(['status'=>true,'data'=>$posts]);

    }

    public function getcatlist(){
     
        $posts =  DB::table('custom_cateogry')->get();
        // return $data; 

        return response()->json(['status'=>true,'data'=>$posts]);
    }

    public function addCatPost(Request $request){
        $temp = $request->all();
  
        $name = $temp['customcatid'];

        $position_x = $temp['position_x'];

        $position_y = $temp['position_y'];

        $img_position_x = $temp['img_position_x'];

        $img_position_y = $temp['img_position_y'];

        $img_height = $temp['img_height'];

        $img_width = $temp['img_width'];

        $custom_cateogry_data_id = $temp['custom_cateogry_data_id'];

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
        // if($imagetwo != 'undefined'){
        //     $filename = Str::random(7).time().'.'.$imagetwo->getClientOriginalExtension();
        //     $imagetwo->move(public_path('images/customcat'), $filename);
        //     $imagetwopath = '/public/images/customcat/'.$filename;
        // } else {
        //     $imagetwopath = '';
        // }

        if($custom_cateogry_data_id == ''){
            $affected = DB::table('custom_cateogry_data')
                ->insert(['custom_cateogry_id' => $name, 'banner_image'=>$bannerimgpath, 'image_one'=>$imageonepath, 'image_two'=>'','position_x' => $position_x, 'position_y' => $position_y,'img_position_x' => $img_position_x, 'img_position_y' => $img_position_y,'img_height' => $img_height, 'img_width' => $img_width]);
        } else {

            if($imageonepath == '' && $bannerimgpath == ''){
                $affected = DB::table('custom_cateogry_data')
            ->where('custom_cateogry_data_id', $custom_cateogry_data_id)
            ->update(['custom_cateogry_id' => $name, 'image_two'=>'','position_x' => $position_x, 'position_y' => $position_y,'img_position_x' => $img_position_x, 'img_position_y' => $img_position_y,'img_height' => $img_height, 'img_width' => $img_width]);
            }
            else if($imageonepath == '' && $bannerimgpath != ''){
                $affected = DB::table('custom_cateogry_data')
                ->where('custom_cateogry_data_id', $custom_cateogry_data_id)
                ->update(['custom_cateogry_id' => $name, 'banner_image'=>$bannerimgpath, 'image_two'=>'','position_x' => $position_x, 'position_y' => $position_y,'img_position_x' => $img_position_x, 'img_position_y' => $img_position_y,'img_height' => $img_height, 'img_width' => $img_width]);
            }

            else if($imageonepath != '' && $bannerimgpath == ''){
                $affected = DB::table('custom_cateogry_data')
                ->where('custom_cateogry_data_id', $custom_cateogry_data_id)
                ->update(['custom_cateogry_id' => $name, 'image_one'=>$imageonepath, 'image_two'=>'','position_x' => $position_x, 'position_y' => $position_y,'img_position_x' => $img_position_x, 'img_position_y' => $img_position_y,'img_height' => $img_height, 'img_width' => $img_width]);
            }
            else {
                $affected = DB::table('custom_cateogry_data')
                ->where('custom_cateogry_data_id', $custom_cateogry_data_id)
                ->update(['custom_cateogry_id' => $name, 'banner_image'=>$bannerimgpath, 'image_one'=>$imageonepath, 'image_two'=>'','position_x' => $position_x, 'position_y' => $position_y,'img_position_x' => $img_position_x, 'img_position_y' => $img_position_y,'img_height' => $img_height, 'img_width' => $img_width]);
            }
        }


        return redirect('festival/customcatpost');
    }

    public function getAllCategoryPost(){
  
        $customcat = DB::table('custom_cateogry_data')->join('custom_cateogry', 'custom_cateogry_data.custom_cateogry_id', '=', 'custom_cateogry.custom_cateogry_id')->get();


        return DataTables::of($customcat)
        ->addIndexColumn()
        ->addColumn('action',function($row) {
            $btn = '<button class="btn btn-info btn-sm" id="editCatPost" onclick="editCat('.$row->custom_cateogry_data_id.')">Edit</button>';
            $btn .= '&nbsp;&nbsp;<button class="btn btn-danger btn-sm" id="removeCat" onclick="removeCatPost('.$row->custom_cateogry_data_id.')">Delete</button>';
            return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function removeCatPost(Request $request){

        $temp = $request->all();
        $id = $temp['id'];
       
        DB::table('custom_cateogry_data')->where('custom_cateogry_data_id', '=', $id)->delete();

        return response()->json(['status'=>true]);

    }

    public function getcatpostdetailforedit(Request $request){

        $id = $request->id;

        $posts =  DB::table('custom_cateogry_data')->where('custom_cateogry_data_id','=',$id)->first();
        // return $data; 


        $posts->banner_image = url('/').$posts->banner_image;
        $posts->image_one = url('/').$posts->image_one;
 

        return response()->json(['status'=>true,'data'=>$posts]);
    }


    // ------------------------ Video Post

    public function allvideopostlist(){
        $user = DB::table('video_post')->where('is_deleted','=',0)->get();

        return DataTables::of($user)
        ->addIndexColumn()
        ->addColumn('action',function($row) {
            $btn = '<button class="btn btn-info btn-sm" id="editVideoPost" onclick="editVideoPost('.$row->video_post_id.')"><i class="flaticon-pencil"></i></button>';
            $btn .= '&nbsp;&nbsp;<button class="btn btn-danger btn-sm" id="removeVideo" onclick="removeVideo('.$row->video_post_id.')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
            return $btn;
        })
        ->addColumn('thumbnail',function($row) {
            if($row->thumbnail !=''){
                $btn = '<img src="'.url('/').$row->thumbnail.'" height="50px" width="50">';
            } else {
                $btn = '';
            }
            return $btn;
        })
        ->rawColumns(['action','thumbnail'])
        ->make(true);
    }
    public function addVideoPost(Request $request){
        $temp = $request->all();

        $festivaldate = $temp['festivaldate'];
        $video_post_id = $temp['video_post_id'];
        $color = $temp['color'];
        
        if ($request->hasFile('video_thumbnail')) {
            $image = $request->file('video_thumbnail');
            $name = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/videopost/thumbnail'), $name);
            $video_thumbnail = '/public/images/videopost/thumbnail/'.$name;
        } else {
            $video_thumbnail = '';
        }
        
        if ($request->hasFile('video_file')) {
            $image = $request->file('video_file');
            $name = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/videopost/videos'), $name);
            $video_file = '/public/images/videopost/videos/'.$name;
        } else {
            $video_file = '';
        }
        
 
        if($video_post_id == ''){
            DB::table('video_post')->insert(
                ['thumbnail' => $video_thumbnail, 'video_url' => $video_file, 'date' => $festivaldate, 'color' => $color]
            );
        } else {
            if($video_thumbnail != '' && $video_file == ''){
                DB::table('video_post')
                ->where('video_post_id', $video_post_id)
                ->update(['thumbnail' => $video_thumbnail, 'date' => $festivaldate, 'color' => $color]);
            } 
            
            if($video_thumbnail == '' && $video_file != ''){ 
                DB::table('video_post')
                ->where('video_post_id', $video_post_id)
                ->update(['video_url' => $video_file, 'date' => $festivaldate, 'color' => $color]);
            }

            if($video_thumbnail != '' && $video_file != ''){
                DB::table('video_post')
                ->where('video_post_id', $video_post_id)
                ->update(['thumbnail' => $video_thumbnail, 'video_url' => $video_file, 'date' => $festivaldate, 'color' => $color]);
            }

            if($video_thumbnail == '' && $video_file == ''){
                DB::table('video_post')
                ->where('video_post_id', $video_post_id)
                ->update(['date' => $festivaldate, 'color' => $color]);
            }
            
        }
       

        return redirect('festival/videopost');
    }

    public function removeVideoPost(Request $request){
        $id = $request->id;

        DB::table('video_post')->where('video_post_id', $id)->update(['is_deleted' => 1]);

        return response()->json(['status'=>true]);
    }

    public function getVideoEdit(Request $request){
        $id = $request->id;

        $data = DB::table('video_post')->where('video_post_id', $id)->first();


        $data->thumbnail = url('/').$data->thumbnail;


        return response()->json(['status'=>true,'data' => $data]);
    }

    public function test()
    {
                $file = Storage::url('storage/custom-category-slider-img/2021/07/MBE2s3OfIQPcjxLYI1iR1ZQkFo5hEXghVsCf316v.png');
                $file1 = '<img src="'.$file.'">';
                return $file1;

    }
}
