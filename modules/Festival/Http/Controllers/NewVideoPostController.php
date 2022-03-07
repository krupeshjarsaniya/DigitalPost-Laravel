<?php

namespace Modules\Festival\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use DB;
use DataTables;
use App\VideoSubCategory;
use Validator;
use Illuminate\Support\Facades\Storage;

class NewVideoPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getVideoData(Request $request)
    {

            $festivals = DB::table('video_data')->where('video_type','=','festival')->where('video_is_delete','=',0)->orderBy('video_date','DESC')->get();
            $incidents = DB::table('video_data')->where('video_type','=','incident')->where('video_is_delete','=',0)->get();

        $festivalsCount = count($festivals);
        $incidentsCount = count($incidents);

        $data = '';
        if($festivalsCount!=0)
        {
            $count = 1;
            foreach ($festivals as $key => $festival)
            {
                $data .= '<tr>';
                $data .= '<td>'.$count++.'</td>';
                $data .= '<td>'.$festival->video_name.'</td>';
                $data .= '<td>'.$festival->video_date.'</td>';
                $data .= '<td>Festival</td>';
                $data .= '<td>'.$festival->video_info.'</td>';
                $data .= '<td><button onclick="addFestivalCategory('.$festival->video_id.')" class="btn btn-success">Sub Category</button><button onclick="editVideoPost('.$festival->video_id.')" class="btn btn-primary ml-1">Edit</button><button onclick="removeVideo('.$festival->video_id.')" class="btn btn-danger ml-1">Delete</button></td>';
                $data .= '</tr>';
            }    
        }


        $incidentdata = '';
        if($incidentsCount!=0)
        {
            $count = 1;
            foreach ($incidents as $key => $incident)
            {
                $incidentdata .= '<tr>';
                $incidentdata .= '<td>'.$count++.'</td>';
                $incidentdata .= '<td>'.$incident->video_name.'</td>';
                $incidentdata .= '<td>'.$incident->video_date.'</td>';
                $incidentdata .= '<td>Incident</td>';
                $incidentdata .= '<td>'.$incident->video_info.'</td>';
                $incidentdata .= '<td><button onclick="addFestivalCategory('.$incident->video_id.')" class="btn btn-success">Sub Category</button><button onclick="editVideoPost('.$incident->video_id.')" class="btn btn-primary ml-1">Edit</button><button onclick="removeVideo('.$incident->video_id.')" class="btn btn-danger ml-1">Delete</button></td>';
                $incidentdata .= '</tr>';
            }
        }

            return response()->json(['status'=>true,'data'=>$data,'incidents'=>$incidentdata]); 

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $temp = $request->all();
        $name = $temp['videoname'];
        $date = (isset($temp['videodate'])) ? $temp['videodate'] : null;
        $info = $temp['information'];
        $type = $temp['ftype'];
        $flanguage = $temp['flanguage'];
        $fsubcategory = $temp['fsubcategory'];
        $color = $temp['videocolor'];

        $image = (isset($temp['thumnail'])) ? $temp['thumnail'] : 'undefined';

         if($image != 'undefined'){
            /*$filename = Str::random(7).time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images'), $filename);
            $path = '/public/images/'.$filename;*/
            $path = $this->uploadFile($request, null, 'thumnail', 'festival-video',true,300,300);

        } else {
            $path = '';
        }
        if ($request->videoid == "") 
        {
            $video = DB::table('video_data')->insert(
                    ['video_name' => $name, 'video_date' => $date, 'video_info' => $info, 'video_image'=>$path,'video_type'=>$type]
                );
          
            $videoid = DB::getPdo()->lastInsertId();
        }
        else
        {
            if ($path == "") 
            {
                 $video = DB::table('video_data')->where('video_id','=',$request->videoid)->update(
                        ['video_name' => $name, 'video_date' => $date, 'video_info' => $info,'video_type'=>$type]
                    );
                 $videoid = $request->videoid;
            }
            else
            {
                $video = DB::table('video_data')->where('video_id','=',$request->videoid)->update(
                        ['video_name' => $name, 'video_date' => $date, 'video_info' => $info, 'video_image'=>$path,'video_type'=>$type]
                    );
                 $videoid = $request->videoid;
            }
        }
        
        $image_ty = array();
        for ($i=0; $i < count($flanguage) ; $i++) 
        { 
            /*if ($i == 0) 
            {
               array_push($image_ty, $request->btype);
            }
            else
            {
                array_push($image_ty, $request->btype.$i);
            }*/

            if (isset($temp['btype']) && $i == 0 ) 
            {
                array_push($image_ty, $temp['btype']);
            }
            else
            {
                array_push($image_ty, $temp['btype'.$i]);
            }
        }

        $videos_path = array();

        if (isset($temp['files'])) {
            foreach ($request->file('video_file') as $v_image) 
            {
               $name = "";
               $video_file = "";
                $name = Str::random(7).time().'.'.$v_image->getClientOriginalExtension();
                $v_image->move(public_path('images/videopost/videos'), $name);
                $video_file = 'public/images/videopost/videos/'.$name;
                //$video_file = $this->multipleUploadFile($v_image,'video-post');
                array_push($videos_path, $video_file);
            }

            foreach ($request->file('files') as $key => $image) {
                /*$filename = Str::random(7).time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('images'), $filename);
                $path = '/public/images/'.$filename;*/
                $path = $this->multipleUploadFileThumb($image,'video-post-thumb',true,300,300);

                DB::table('video_post_data')->insert(
                ['video_post_id' => $videoid, 'thumbnail' => $path, 'video_url' => $videos_path[$key], 'image_type'=>$image_ty[$key],'language_id'=>$flanguage[$key],'color'=>$color[$key], 'sub_category_id' => $fsubcategory[$key]]
            );
            }
        }

        return redirect('festival/newvideopost');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getNewVideoEdit(Request $request)
    {
        $id = $request->id;
        $video = DB::table('video_data')->where('video_id', $id)->first();
        $posts = DB::table('video_post_data')->where('video_post_id','=',$id)->where('is_deleted','=',0)->get();
        // return $data; 
         $s_url = Storage::url('/');
        $categories = VideoSubCategory::where('festival_id','=',$id)->where('is_delete','=',0)->get();
        return response()->json(['status'=>true,'data'=>$video,'images'=>$posts,'s_url'=>$s_url, 'categories'=> $categories]);
    }

    public function removefestivalimage(Request $request)
    {

        $id = $request->id;
        $posts = DB::table('video_post_data')->where('id','=',$id)->update(array(
                'is_deleted' => 1,
        ));

        return response()->json(['status'=>true]);
    }

    public function ChangeImageType(Request $request)
    {
        $id = $request->id;
        $posts = DB::table('video_post_data')->where('id','=',$id)->update(array(
                'image_type' => $request->image_ty,
        ));

        return response()->json(['status'=>true]);
    }

    public function ChangeLanguage(Request $request)
    {
        $id = $request->id;
        $posts = DB::table('video_post_data')->where('id','=',$id)->update(array(
                'language_id' => $request->language_id,
        ));

        return response()->json(['status'=>true]);
    }

    public function ChangeSubCategory(Request $request)
    {
        $id = $request->id;
        $posts = DB::table('video_post_data')->where('id','=',$id)->update(array(
                'sub_category_id' => $request->sub_category_id,
        ));

        return response()->json(['status'=>true]);
    }

    public function changeColor(Request $request)
    {
        $id = $request->id;
        $posts = DB::table('video_post_data')->where('id','=',$id)->update(array(
                'color' => $request->color,
        ));

        return response()->json(['status'=>true]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;

        $posts = DB::table('video_post_data')->where('video_post_id','=',$id)->where('is_deleted','=',0)->get();
        if(count($posts) == 0)
        {
            DB::table('video_data')->where('video_id', $id)->update(['video_is_delete' => 1]);
            return response()->json(['status'=>200]);
        }
        else
        {
            return response()->json(['status'=>401]);
        }
    }

    public function getSubCategory(Request $request) {
        $stickers = VideoSubCategory::where('is_delete', 0)->where('festival_id', $request->id);
        
        if ($request->ajax())
        {
            # code...
            return DataTables::of($stickers)
            ->editColumn('name',function($row) {
                $name = "<div class='row' >";
                $name .= "<div class='col-9' >";
                $name .= "<input class='form-control' type='text' id='name_".$row->id."' value='".$row->name."' />";
                $name .= "</div>";
                $name .= "<div class='col-3' >";
                $name .= "<button class='btn btn-primary' data-festival-id='".$row->festival_id."' data-sub-category-id='".$row->id."' onclick='editSubCategory(this)'>Update</button>";
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
                'festival_id' => 'required',      
                'sub_category_name' => 'required',      
            ],
            [
                'festival_id.required' => 'Select Festival',
                'sub_category_name.required' => 'Name is Required',
            ]
        );

        if ($validator->fails()) 
        {  
            $error=json_decode($validator->errors());          

            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        $checkCategory = VideoSubCategory::where('name', $request->sub_category_name)->where('festival_id', $request->festival_id)->where('is_delete',0)->first();
        if($checkCategory) {
            $error=['sub_category_name' => 'Category already exists'];
            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        $category = new VideoSubCategory;
        $category->name = $request->sub_category_name;
        $category->festival_id = $request->festival_id;
        $category->save();

        return response()->json(['status' => 1,'data' => "", 'message' => 'Category added' ]);
    }

    public function editSubCategory(Request $request) {
        $validator = Validator::make($request->all(), [
                'festival_id' => 'required',      
                'sub_category_id' => 'required',      
                'sub_category_name' => 'required',      
            ],
            [
                'sub_category_id.required' => 'Select Festival',
                'festival_id.required' => 'Select Festival',
                'sub_category_name.required' => 'Name is Required',
            ]
        );

        if ($validator->fails()) 
        {  
            $error=json_decode($validator->errors());          

            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        $checkCategory = VideoSubCategory::where('name', $request->sub_category_name)->where('id', $request->sub_category_id)->where('festival_id', $request->festival_id)->where('is_delete',0)->first();
        if($checkCategory) {
            return response()->json(['status' => false,'message' => "Sub Category already exists"]);
            exit();
        }

        $category = VideoSubCategory::find($request->sub_category_id);
        $category->name = $request->sub_category_name;
        $category->save();

        return response()->json(['status' => true, 'message' => 'Category updated' ]);
    }

    public function deleteSubCategory(Request $request) {
        $id = $request->id;
        $posts = DB::table('video_post_data')->where('sub_category_id','=',$id)->where('is_deleted',0)->count();
        if($posts > 0) {
            return response()->json(['status' => 1,'data' => "", 'message' => 'Delete related images before delete sub category']);
        }
        $category = VideoSubCategory::find($id);
        if($category) {
            $category->is_delete = 1;
        }
        $category->save();
        return response()->json(['status' => 1,'data' => "", 'message' => 'Sub Category deleted' ]);
    }

}
