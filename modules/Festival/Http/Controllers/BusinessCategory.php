<?php

namespace Modules\Festival\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use DB;
use DataTables;
use App\BusinessSubCategory;
use App\Language;
use Validator;
use Illuminate\Support\Facades\Storage;
class BusinessCategory extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ShowCategory()
    {
        $category_data = DB::table('business_category')->where('is_delete','=',0);

        return DataTables::of($category_data)
            ->addIndexColumn()
            ->addColumn('free_business',function($row) {
                $free_business = DB::table('business')->where('business.business_category', $row->name)->leftJoin('purchase_plan', 'purchase_plan.purc_business_id', '=', 'business.busi_id')->where('purchase_plan.purc_plan_id', 3)->where('purchase_plan.purc_business_type', 1)->where('business.busi_delete',0)->count();

               return $free_business;
            })
            ->addColumn('premium_business',function($row) {

                $premium_business = DB::table('business')->where('business.business_category', $row->name)->leftJoin('purchase_plan', 'purchase_plan.purc_business_id', '=', 'business.busi_id')->where('purchase_plan.purc_plan_id', '!=', 3)->where('purchase_plan.purc_is_cencal', 0)->where('purchase_plan.purc_is_expire', 0)->where('purchase_plan.purc_business_type', 1)->where('business.busi_delete',0)->count();

               return $premium_business;
            })
            ->addColumn('image',function($row) {
               $btn = '<img src="'.Storage::url($row->image).'" height="100" width="100">';

               return $btn;
            })
            ->addColumn('action',function($row) {
                $btn = '<button onclick="addSubCategory('.$row->id.')" class="btn btn-success">Sub Category</button><a href="'.route('businesscategory.video', ['id' => $row->id]).'" class="btn btn-danger ml-1">Video</a><button onclick="editcategory('.$row->id.')" class="btn btn-primary ml-1">Edit</button><button onclick="deletecategory('.$row->id.')" class="btn btn-danger ml-1">Delete</button></td>';

                return $btn;
            })
            ->rawColumns(['action','image'])
            ->make(true);


        $categoryCount = count($category_data);


        /* $data = '';
        if($categoryCount!=0)
        {
            $count = 1;
            foreach ($category_data as $key => $category)
            {

                $premium_business = DB::table('business')->where('business.business_category', $category->name)->leftJoin('purchase_plan', 'purchase_plan.purc_business_id', '=', 'business.busi_id')->where('purchase_plan.purc_plan_id', '!=', 3)->where('purchase_plan.purc_is_cencal', 0)->where('purchase_plan.purc_is_expire', 0)->where('purchase_plan.purc_business_type', 1)->where('business.busi_is_approved', 0)->where('business.busi_delete',0)->count();
                $data .= '<tr>';
                $data .= '<td>'.$count++.'</td>';
                $data .= '<td>'.$category->name.'</td>';
                $data .= '<td>'.$free_business.'</td>';
                $data .= '<td>'.$premium_business.'</td>';
                $data .= '<td><img src="'.Storage::url($category->image).'" height="100" width="100"></td>';
                $data .= '<td><button onclick="addSubCategory('.$category->id.')" class="btn btn-success">Sub Category</button><a href="'.route('businesscategory.video', ['id' => $category->id]).'" class="btn btn-danger ml-1">Video</a><button onclick="editcategory('.$category->id.')" class="btn btn-primary ml-1">Edit</button><button onclick="deletecategory('.$category->id.')" class="btn btn-danger ml-1">Delete</button></td>';
                $data .= '</tr>';
            }
        }

        return response()->json(['status'=>true,'data'=>$data]); */
    }

    public function ShowCategoryVideo(Request $request, $id) {
        $category = DB::table('business_category')->where('id', $id)->where('is_delete','=',0)->first();
        if(empty($category)) {
            return redirect()->back();
        }
        // dd($category);
        $language = Language::where('is_delete','=',0)->get();
        $subcategory = BusinessSubCategory::where('business_category_id',$id)->where('is_delete', 0)->get();
        $posts = DB::table('business_category_post_data')->where('post_type', 'video')->where('buss_cat_post_id','=',$request->id)->where('is_deleted','=',0)->get();
        return view('festival::businesscategoryvideo', ['category' => $category, 'language' => $language, 'subcategory' => $subcategory, 'posts' => $posts]);
    }

    public function ShowCategoryVideoStore(Request $request) {
        $temp = $request->all();
        // dd($temp);
        $image_ty = array();
        $flanguage = $temp['flanguage'];
        $fsubcategory = $temp['fsubcategory'];
        for ($i=0; $i < count($flanguage) ; $i++)
        {
            if (isset($temp['btype']) && $i == 0 )
            {
                array_push($image_ty, $temp['btype']);
            }
            else
            {
                array_push($image_ty, $temp['btype'.$i]);
            }
        }
        if (isset($temp['video_file'])) {
            $thumb_path = array();
            foreach ($request->file('files') as $v_image)
            {
                $video_thumb = $this->multipleUploadFile($v_image,'bussness-post-video-thumb',true,300,300);
                array_push($thumb_path, $video_thumb);
            }
            foreach ($request->file('video_file') as $key => $image) {
                $name = Str::random(7).time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('images/videopost/bussness-post-video'), $name);
                $path = 'public/images/videopost/bussness-post-video/'.$name;
                //$path = $this->multipleUploadFile($image,'bussness-post-video');
                DB::table('business_category_post_data')->insert(
                    ['buss_cat_post_id' => $temp['business_category_id'], 'video_thumbnail' => $thumb_path[$key], 'video_url'=>$path, 'post_type' => 'video', 'image_type'=>$image_ty[$key],'language_id'=>$flanguage[$key],'business_sub_category_id'=>$fsubcategory[$key]]
                );
            }
        }
        return redirect()->route('businesscategory.video', ['id' => $temp['business_category_id']]);
    }

    public function ChangeVideoType(Request $request)
    {
        $id = $request->id;
        $posts = DB::table('business_category_post_data')->where('id','=',$id)->update(array(
                'image_type' => $request->image_ty,
        ));

        return response()->json(['status'=>true]);
    }

    public function ChangeVideoLanguage(Request $request)
    {
        $id = $request->id;
        $posts = DB::table('business_category_post_data')->where('id','=',$id)->update(array(
                'language_id' => $request->language_id,
        ));

        return response()->json(['status'=>true]);
    }

    public function ChangeVideoSubCategory(Request $request)
    {
        $id = $request->id;
        $posts = DB::table('business_category_post_data')->where('id','=',$id)->update(array(
                'business_sub_category_id' => $request->sub_category_id,
        ));

        return response()->json(['status'=>true]);
    }

    public function ShowCategoryVideoDelete(Request $request) {
        DB::table('business_category_post_data')->where('id', $request->id)
            ->update(
                    ['is_deleted' => 1]
                );
    }

    public function getSubCategory(Request $request) {
        $stickers = BusinessSubCategory::where('is_delete', 0)->where('business_category_id', $request->id);

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
                $name .= "<button class='btn btn-primary' data-business-category-id='".$row->business_category_id."' data-sub-category-id='".$row->id."' onclick='editSubCategory(this)'>Update</button>";
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
                'business_category_id' => 'required',
                'sub_category_name' => 'required',
            ],
            [
                'business_category_id.required' => 'Select Festival',
                'sub_category_name.required' => 'Name is Required',
            ]
        );

        if ($validator->fails())
        {
            $error=json_decode($validator->errors());

            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        $checkCategory = BusinessSubCategory::where('name', $request->sub_category_name)->where('business_category_id', $request->business_category_id)->where('is_delete',0)->first();
        if($checkCategory) {
            $error=['sub_category_name' => 'Category already exists'];
            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        $category = new BusinessSubCategory;
        $category->name = $request->sub_category_name;
        $category->business_category_id = $request->business_category_id;
        $category->save();

        return response()->json(['status' => 1,'data' => "", 'message' => 'Category added' ]);
    }

    public function editSubCategory(Request $request) {
        $validator = Validator::make($request->all(), [
                'business_category_id' => 'required',
                'sub_category_id' => 'required',
                'sub_category_name' => 'required',
            ],
            [
                'sub_category_id.required' => 'Select Festival',
                'business_category_id.required' => 'Select Festival',
                'sub_category_name.required' => 'Name is Required',
            ]
        );

        if ($validator->fails())
        {
            $error=json_decode($validator->errors());

            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        $checkCategory = BusinessSubCategory::where('name', $request->sub_category_name)->where('id', $request->sub_category_id)->where('business_category_id', $request->business_category_id)->where('is_delete',0)->first();
        if($checkCategory) {
            return response()->json(['status' => false,'message' => "Sub Category already exists"]);
            exit();
        }

        $category = BusinessSubCategory::find($request->sub_category_id);
        $category->name = $request->sub_category_name;
        $category->save();

        return response()->json(['status' => true, 'message' => 'Category updated' ]);
    }

    public function deleteSubCategory(Request $request) {
        $id = $request->id;
        $posts = DB::table('business_category_post_data')->where('business_sub_category_id','=',$id)->where('is_deleted',0)->count();
        if($posts > 0) {
            return response()->json(['status' => 1,'data' => "", 'message' => 'Delete related images before delete sub category']);
        }
        $category = BusinessSubCategory::find($request->id);
        if($category) {
            $category->is_delete = 1;
        }
        $category->save();
        return response()->json(['status' => 1,'data' => "", 'message' => 'Sub Category deleted' ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* $validator = Validator::make($request->all(), [

            'flanguage' => 'required',
        ]);
        if ($validator->fails())
        {
            $error=json_decode($validator->errors());

            return response()->json(['status' => 401,'error1' => $error]);
            exit();

        }*/

        $temp = $request->all();
        $type = $temp['btype'];
        $flanguage = $temp['flanguage'];
        $fsubcategory = $temp['fsubcategory'];
        $ffestivalId = $temp['ffestivalId'];
        if(isset($temp['files']))
        {
            foreach ($flanguage as $key => $value)
            {
                $value = trim($value);
                if (empty($value))
                {
                    if ($key == 0)
                    {
                        $error = ['flanguage' => 'Select Language'];
                    }
                    else
                    {
                        $error = ['flanguage'.$key => 'Select Language'];
                    }

                    return response()->json(['status' => 401,'error1' => $error]);
                    exit();
                }

            }
        }

        $image = (isset($temp['thumnail'])) ? $temp['thumnail'] : 'undefined';

         if($image != 'undefined'){
            /*$filename = Str::random(7).time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/businesscategory'), $filename);
            $path = '/public/images/businesscategory/'.$filename;*/

            $path = $this->uploadFile($request, null, 'thumnail', 'bussness-post',true,300,300);

        } else {
            $path = '';
        }


        if ($request->categoryid == "")
        {
             $cat = DB::table('business_category')->insert(
                    ['name' => $request->categoryname, 'image' => $path]
                );
             $bussness_cat_id = DB::getPdo()->lastInsertId();
        }
        else
        {
            $data_get = DB::table('business_category')->where('id', $request->categoryid)->first();
            DB::table('business')->where('business_category', $data_get->name)->update(['business_category'=>$request->categoryname]);
            DB::table('business_new')->where('business_category', $data_get->name)->update(['business_category'=>$request->categoryname]);

            if($path == "")
            {
                 DB::table('business_category')->where('id', $request->categoryid)
                ->update(
                        ['name' => $request->categoryname]
                    );
            }
            else
            {
                DB::table('business_category')->where('id', $request->categoryid)
                ->update(
                        ['name' => $request->categoryname, 'image' => $path]
                    );
            }

            $bussness_cat_id = $request->categoryid;
        }

        $image_ty = array();
        for ($i=0; $i < count($flanguage) ; $i++)
        {
            if (isset($temp['btype']) && $i == 0 )
            {
                array_push($image_ty, $temp['btype']);
            }
            else
            {
                array_push($image_ty, $temp['btype'.$i]);
            }
        }


        if (isset($temp['files'])) {
            for($j=0; $j< count($image_ty); $j++) {
                if($j == 0) {
                    foreach ($request->file('files') as $key => $image) {
                        /*$filename = Str::random(7).time().'.'.$image->getClientOriginalExtension();
                        $image->move(public_path('images/businesscategory'), $filename);
                        $path = '/public/images/businesscategory/'.$filename;*/

                        $path = $this->multipleUploadFile($image,'bussness-post');
                        $path_thumb = $this->multipleUploadFile($image,'bussness-post-thumb',true,300,300);
                        DB::table('business_category_post_data')->insert(
                        ['buss_cat_post_id' => $bussness_cat_id, 'thumbnail' => $path, 'post_thumb'=>$path_thumb, 'image_type'=>$image_ty[$j],'language_id'=>$flanguage[$j],'business_sub_category_id'=>$fsubcategory[$j], 'festival_id'=> $ffestivalId[$j]]
                    );
                    }
                }
                else {
                    foreach ($request->file('files' . $j) as $key => $image) {
                        /*$filename = Str::random(7).time().'.'.$image->getClientOriginalExtension();
                        $image->move(public_path('images/businesscategory'), $filename);
                        $path = '/public/images/businesscategory/'.$filename;*/

                        $path = $this->multipleUploadFile($image,'bussness-post');
                        $path_thumb = $this->multipleUploadFile($image,'bussness-post-thumb',true,300,300);
                        DB::table('business_category_post_data')->insert(
                        ['buss_cat_post_id' => $bussness_cat_id, 'thumbnail' => $path, 'post_thumb'=>$path_thumb, 'image_type'=>$image_ty[$j],'language_id'=>$flanguage[$j],'business_sub_category_id'=>$fsubcategory[$j], 'festival_id'=> $ffestivalId[$j]]
                    );
                    }
                }
            }

        }

            return response()->json(['status' => 1,'data' => ""]);

        //return redirect('businesscategory');

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
    public function edit(Request $request)
    {
        $category_data = DB::table('business_category')->where('id','=',$request->id)->where('is_delete','=',0)->first();
        $posts = DB::table('business_category_post_data')->where('post_type', 'image')->where('buss_cat_post_id','=',$request->id)->where('is_deleted','=',0)->get();
        $categories = BusinessSubCategory::where('business_category_id', $request->id)->get();
        return response()->json(['status'=>true,'data'=>$category_data, 'images'=>$posts, 'categories'=>$categories]);

    }

    public function removeBuseinesCATimage(Request $request)
    {

        $id = $request->id;
        $posts = DB::table('business_category_post_data')->where('id','=',$id)->update(array(
                'is_deleted' => 1,
        ));

        return response()->json(['status'=>true]);
    }

    public function ChangeImageType(Request $request)
    {
        $id = $request->id;
        $posts = DB::table('business_category_post_data')->where('id','=',$id)->update(array(
                'image_type' => $request->image_ty,
        ));

        return response()->json(['status'=>true]);
    }

    public function ChangeLanguage(Request $request)
    {
        $id = $request->id;
        $posts = DB::table('business_category_post_data')->where('id','=',$id)->update(array(
                'language_id' => $request->language_id,
        ));

        return response()->json(['status'=>true]);
    }

    public function ChangeSubCategory(Request $request)
    {
        $id = $request->id;
        $posts = DB::table('business_category_post_data')->where('id','=',$id)->update(array(
                'business_sub_category_id' => $request->sub_category_id,
        ));

        return response()->json(['status'=>true]);
    }

    public function changefestival(Request $request)
    {
        $id = $request->id;
        $posts = DB::table('business_category_post_data')->where('id','=',$id)->update(array(
                'festival_id' => $request->festival_id,
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
        $posts = DB::table('business_category_post_data')->where('buss_cat_post_id','=',$request->id)->where('is_deleted','=',0)->get();
        $category_data = DB::table('business_category')->where('id','=',$request->id)->where('is_delete','=',0)->first();

        $category = DB::table('business')->where('business_category','=',$category_data->name)->where('is_deleted','=',0)->get();

        if(count($posts) == 0 && count($category) == 0)
        {
            DB::table('business_category')->where('id', $request->id)
            ->update(
                    ['is_delete' => 1]
                );
            return response()->json(['status'=>200]);
        }
        else
        {
            return response()->json(['status'=>401]);
        }
    }
}
