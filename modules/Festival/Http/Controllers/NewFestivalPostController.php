<?php

namespace Modules\Festival\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Festival;
use App\Post;
use App\FestivalSubCategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class NewFestivalPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = DB::table('business_category_post_data')
            ->where('is_deleted', 0)
            ->where('post_thumb', null)
            ->get();

        foreach ($post as $key => $value) {
            $data = $this->uploadFile_thumnail_database('', '', $value->thumbnail, 'festival-post-thumb', true, 300, 300);
            $post = DB::table('business_category_post_data')->where('id', $value->id)->update(['post_thumb' => $data]);
        }
        dd($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getFestivalPostData(Request $request)
    {
        $date = $request->date;
        if ($date) {
            $festivals = Festival::where('fest_date', 'LIKE', $date . '%')->where('fest_type', '=', 'festival')->where('fest_is_delete', '=', 0)->orderBy('fest_date', 'DESC')->get();
            $trandings = Festival::where('fest_date', 'LIKE', $date . '%')->where('fest_type', '=', 'tranding')->where('fest_is_delete', '=', 0)->orderBy('fest_date', 'DESC')->get();
            $incidents = Festival::where('fest_date', 'LIKE', $date . '%')->where('fest_type', '=', 'incident')->where('fest_is_delete', '=', 0)->orderBy('position_no', 'ASC')->get();
        } else {
            $festivals = Festival::where('fest_type', '=', 'festival')->where('fest_is_delete', '=', 0)->orderBy('fest_date', 'DESC')->get();
            $trandings = Festival::where('fest_type', '=', 'tranding')->where('fest_is_delete', '=', 0)->orderBy('fest_date', 'DESC')->get();
            $incidents = Festival::where('fest_type', '=', 'incident')->where('fest_is_delete', '=', 0)->orderBy('position_no', 'ASC')->get();
        }

        $festivalsCount = count($festivals);
        $trandingsCount = count($trandings);
        $incidentsCount = count($incidents);

        $data = '';
        if ($festivalsCount != 0) {
            $count = 1;
            foreach ($festivals as $key => $festival) {
                $data .= '<tr>';
                $data .= '<td>' . $count++ . '</td>';
                $data .= '<td>' . $festival->fest_name . '</td>';
                $data .= '<td>' . $festival->fest_date . '</td>';
                $data .= '<td>Festival</td>';
                $data .= '<td>' . $festival->fest_info . '</td>';
                $data .= '<td><button onclick="addFestivalCategory(' . $festival->fest_id . ')" class="btn btn-success">Sub Category</button><button onclick="editFestival(' . $festival->fest_id . ')" class="btn btn-primary ml-1">Edit</button><button onclick="deleteFestival(' . $festival->fest_id . ')" class="btn btn-danger ml-1">Delete</button></td>';
                $data .= '</tr>';
            }
        }

        $trandingdata = '';
        if ($trandingsCount != 0) {
            $count = 1;
            foreach ($trandings as $key => $tranding) {
                $trandingdata .= '<tr>';
                $trandingdata .= '<td>' . $count++ . '</td>';
                $trandingdata .= '<td>' . $tranding->fest_name . '</td>';
                $trandingdata .= '<td>' . $tranding->fest_date . '</td>';
                $trandingdata .= '<td>Tranding</td>';
                $trandingdata .= '<td>' . $tranding->fest_info . '</td>';
                $trandingdata .= '<td><button onclick="addFestivalCategory(' . $tranding->fest_id . ')" class="btn btn-success">Sub Category</button><button onclick="editFestival(' . $tranding->fest_id . ')" class="btn btn-primary ml-1">Edit</button><button onclick="deleteFestival(' . $tranding->fest_id . ')" class="btn btn-danger ml-1">Delete</button></td>';
                $trandingdata .= '</tr>';
            }
        }

        $incidentdata = '';
        if ($incidentsCount != 0) {
            $count = 1;
            foreach ($incidents as $key => $incident) {
                $incidentdata .= '<tr>';
                $incidentdata .= '<td>' . $count++ . '</td>';
                $incidentdata .= '<td>' . $incident->fest_name . '</td>';
                $incidentdata .= '<td>Incident</td>';
                $incidentdata .= '<td>' . $incident->fest_info . '</td>';
                $incidentdata .= '<td><button onclick="addFestivalCategory(' . $incident->fest_id . ')" class="btn btn-success">Sub Category</button><button onclick="editFestival(' . $incident->fest_id . ')" class="btn btn-primary ml-1">Edit</button><button onclick="deleteFestival(' . $incident->fest_id . ')" class="btn btn-danger ml-1">Delete</button></td>';
                $incidentdata .= '</tr>';
            }
        }

        return response()->json(['status' => true, 'data' => $data, 'incidents' => $incidentdata, 'trandings' => $trandingdata]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fest_id = 0;
        if ($request->festivalid == "") {
            $temp = $request->all();
            $name = $temp['festivalname'];
            $date = (isset($temp['festivaldate'])) ? $temp['festivaldate'] : '';
            $info = $temp['information'];
            $type = $temp['ftype'];
            $flanguage = $temp['flanguage'];
            $post_mode = $temp['fimagemode'];
            $position_no = $temp['festivalposition'];
            $image = (isset($temp['thumnail'])) ? $temp['thumnail'] : 'undefined';
            $new_cat = (isset($temp['new_cat'])) ? $temp['new_cat'] : '0';

            if ($image != 'undefined') {
                $path = $this->uploadFile($request, null, 'thumnail', 'festival-image', true, 300, 300);
            } else {
                $path = '';
            }

            $festival = new Festival();
            $festival->fest_name = $name;
            (isset($temp['festivaldate'])) ? $festival->fest_date = $date : '';
            $festival->fest_info = $info;
            $festival->fest_info = $info;
            $festival->fest_image = $path;
            $festival->fest_type = $type;
            $festival->position_no = $position_no;
            $festival->new_cat = $new_cat;


            $festival->save();
            $festid = $festival->id;
            $catid = $request->fsubcategory ? $request->fsubcategory : 0;

            if (isset($temp['files'])) {
                foreach ($request->file('files') as $key => $image) {
                    $post = new Post();
                    $post->post_category_id = $festid;
                    $post->sub_category_id = $catid;
                    $post->language_id = $flanguage;
                    $post->image_type = $request->btype;
                    $post->post_mode = $post_mode;
                    $post->post_content = $this->multipleUploadFile($image, 'festival-post');
                    $post->post_thumb = $this->multipleUploadFileThumb($image, 'festival-post-thumb', true, 300, 300);
                    $post->save();
                }
            }
        } else {
            $temp = $request->all();
            $id = $temp['festivalid'];
            $fest_id = $id;
            $name = $temp['festivalname'];
            $date = $temp['festivaldate'];
            $info = $temp['information'];
            $type = $temp['ftype'];
            $flanguage = $temp['flanguage'];
            $post_mode = $temp['fimagemode'];
            $position_no = $temp['festivalposition'];
            $image = (isset($temp['thumnail'])) ? $temp['thumnail'] : 'undefined';
            $new_cat = (isset($temp['new_cat'])) ? $temp['new_cat'] : '0';

            if ($image != 'undefined') {
                $path = $this->uploadFile($request, null, 'thumnail', 'festival-image', true, 300, 300);
                Festival::where('fest_id', $id)->update(array(
                    'fest_name' => $name,
                    'fest_date' => $date,
                    'fest_info' => $info,
                    'fest_type' => $type,
                    'fest_image' => $path,
                    'position_no' => $position_no,
                    'new_cat' => $new_cat,
                ));
            } else {
                Festival::where('fest_id', $id)->update(array(
                    'fest_name' => $name,
                    'fest_date' => $date,
                    'fest_info' => $info,
                    'fest_type' => $type,
                    'position_no' => $position_no,
                    'new_cat' => $new_cat,
                ));
            }

            if (isset($temp['files'])) {
                $catid = $request->fsubcategory ? $request->fsubcategory : 0;
                foreach ($request->file('files') as $key => $image) {
                    $post = new Post();
                    $post->post_category_id = $id;
                    $post->sub_category_id = $catid;
                    $post->language_id = $flanguage;
                    $post->image_type = $request->btype;
                    $post->post_mode = $post_mode;
                    $post->post_content = $this->multipleUploadFile($image, 'festival-post');
                    $post->post_thumb = $this->multipleUploadFileThumb($image, 'festival-post-thumb', true, 300, 300);
                    $post->save();
                }
            }
        }
        if ($fest_id == 0) {
            return redirect('FestivalPost');
        } else {
            return redirect('FestivalPost?fest_id=' . $fest_id);
        }
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
    public function getNewFestivalPostEdit(Request $request)
    {
        $id = $request->id;
        $data = Festival::where('fest_id', $id)->first();
        $posts = Post::where('post_category_id', '=', $id)->where('post_is_deleted', '=', 0)->get();
        $categories = FestivalSubCategory::where('festival_id', '=', $id)->where('is_delete', '=', 0)->get();
        $s_url = Storage::url('/');

        return response()->json(['status' => true, 'data' => $data, 'images' => $posts, 'categories' => $categories, 's_url' => $s_url]);
    }


    public function removefestivalimage(Request $request)
    {

        $id = $request->id;
        Post::where('post_id', '=', $id)->update(array(
            'post_is_deleted' => 1,
        ));

        return response()->json(['status' => true]);
    }

    public function ChangeImageType(Request $request)
    {

        $id = $request->id;
        Post::where('post_id', '=', $id)->update(array(
            'image_type' => $request->image_ty,
        ));

        return response()->json(['status' => true]);
    }

    public function ChangeLanguage(Request $request)
    {
        $id = $request->id;
        Post::where('post_id', '=', $id)->update(array(
            'language_id' => $request->language_id,
        ));

        return response()->json(['status' => true]);
    }

    public function ChangeSubCategory(Request $request)
    {
        $id = $request->id;
        Post::where('post_id', '=', $id)->update(array(
            'sub_category_id' => $request->sub_category_id,
        ));

        return response()->json(['status' => true]);
    }

    public function ChangeImageMode(Request $request)
    {
        $id = $request->id;
        Post::where('post_id', '=', $id)->update(array(
            'post_mode' => $request->post_mode,
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function FestivalPostUpdate(Request $request)
    {
        $temp = $request->all();
        $name = $temp['festivalname'];
        $date = $temp['festivaldate'];
        $info = $temp['information'];
        $type = $temp['ftype'];
        $flanguage = $temp['flanguage'];
        $image = (isset($temp['thumnail'])) ? $temp['thumnail'] : 'undefined';
        $id = $temp['festivalid'];

        if ($image != 'undefined') {

            $path = $this->uploadFile($request, null, 'thumnail', 'festival-image');
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
            foreach ($request->file('files') as $key => $image) {

                $post = new Post();
                $post->post_category_id = $id;
                $post->language_id = $flanguage;
                $post->image_type = $request->btype;
                $post->post_content = $this->multipleUploadFile($image, 'festival-post');
                $post->save();
            }
        }

        return redirect('FestivalPost');
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
        $posts = Post::where('post_category_id', '=', $id)->where('post_is_deleted', '=', 0)->get();

        if (count($posts) == 0) {
            Festival::where('fest_id', $id)->update(array(
                'fest_is_delete' => 1,
            ));

            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 401]);
        }
    }

    public function getSubCategory(Request $request)
    {
        $stickers = FestivalSubCategory::where('is_delete', 0)->where('festival_id', $request->id);

        if ($request->ajax()) {
            # code...
            return DataTables::of($stickers)
                ->editColumn('name', function ($row) {
                    $name = "<div class='row' >";
                    $name .= "<div class='col-9' >";
                    $name .= "<input class='form-control' type='text' id='name_" . $row->id . "' value='" . $row->name . "' />";
                    $name .= "</div>";
                    $name .= "<div class='col-3' >";
                    $name .= "<button class='btn btn-primary' data-festival-id='" . $row->festival_id . "' data-sub-category-id='" . $row->id . "' onclick='editSubCategory(this)'>Update</button>";
                    $name .= "</div>";
                    return $name;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<button class="btn btn-danger btn-sm mb-2" data-id="' . $row->id . '" onclick="deleteSubCategory(this)"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action', 'name'])
                ->make(true);
        }
    }

    public function addSubCategory(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'festival_id' => 'required',
                'sub_category_name' => 'required',
            ],
            [
                'festival_id.required' => 'Select Festival',
                'sub_category_name.required' => 'Name is Required',
            ]
        );

        if ($validator->fails()) {
            $error = json_decode($validator->errors());

            return response()->json(['status' => 401, 'error1' => $error]);
            exit();
        }

        $checkCategory = FestivalSubCategory::where('name', $request->sub_category_name)->where('festival_id', $request->festival_id)->where('is_delete', 0)->first();
        if ($checkCategory) {
            $error = ['sub_category_name' => 'Category already exists'];
            return response()->json(['status' => 401, 'error1' => $error]);
            exit();
        }

        $category = new FestivalSubCategory;
        $category->name = $request->sub_category_name;
        $category->festival_id = $request->festival_id;
        $category->save();

        return response()->json(['status' => 1, 'data' => "", 'message' => 'Category added']);
    }

    public function editSubCategory(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
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

        if ($validator->fails()) {
            $error = json_decode($validator->errors());

            return response()->json(['status' => 401, 'error1' => $error]);
            exit();
        }

        $checkCategory = FestivalSubCategory::where('name', $request->sub_category_name)->where('id', $request->sub_category_id)->where('festival_id', $request->festival_id)->where('is_delete', 0)->first();
        if ($checkCategory) {
            return response()->json(['status' => false, 'message' => "Sub Category already exists"]);
            exit();
        }

        $category = FestivalSubCategory::find($request->sub_category_id);
        $category->name = $request->sub_category_name;
        $category->save();

        return response()->json(['status' => true, 'message' => 'Category updated']);
    }

    public function deleteSubCategory(Request $request)
    {
        $id = $request->id;
        $posts = Post::where('sub_category_id', '=', $id)->where('post_is_deleted', 0)->count();
        if ($posts > 0) {
            return response()->json(['status' => 1, 'data' => "", 'message' => 'Delete related images before delete sub category']);
        }
        $category = FestivalSubCategory::find($id);
        if ($category) {
            $category->is_delete = 1;
        }
        $category->save();
        return response()->json(['status' => 1, 'data' => "", 'message' => 'Sub Category deleted']);
    }
}
