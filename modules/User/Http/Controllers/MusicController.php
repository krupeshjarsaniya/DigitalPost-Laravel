<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MusicCategory;
use App\Language;
use App\Music;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Validator;

class MusicController extends Controller
{
    public function index(Request $request, $id) {
        $category = MusicCategory::where('id', $id)->where('is_delete', 0)->first();
        if(empty($category)) {
            return redirect()->back();
        }
        $languages = Language::where('is_delete','=',0)->get();
        return view('user::music', compact('category', 'languages'));
    }

    public function getMusicByCategory(Request $request, $id) {
        $musics = Music::where('category_id', $id)->where('is_delete', 0);
        return DataTables::of($musics)
                ->editColumn('language_id', function($row) {
                    $language = Language::where('id', $row->language_id)->where('is_delete', 0)->first();
                    if(!empty($language)) {
                        return $language->name;
                    }
                    return "";
                })
                ->editColumn('image', function($row) {
                    $image = "";
                    if(!empty($row->image)) {
                        $image = "<img src='" . Storage::url($row->image) . "' height='100' width='100' />";
                    }
                    return $image;
                })
                ->editColumn('audio', function($row) {
                    $audio = "";
                    if(!empty($row->audio)) {
                        $audio = "<audio controls><source src='". Storage::url($row->audio) ."' /></audio>";
                    }
                    return $audio;
                })
                ->addColumn('action',function($row) {
                    $btn = "";
                    $btn .= '<button class="btn btn-primary btn-sm mr-2" data-id="'.$row->id.'" onclick="editMusic(this)"><i class="flaticon-pencil" area-hidden="true"></i></button>';
                    $btn .= '<button class="btn btn-danger btn-sm mr-2" data-id="'.$row->id.'" onclick="deleteMusic(this)"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action', 'image', 'audio'])
                ->make(true);
    }

    public function addMusic(Request $request) {

        $rules = [
            'category_id' => 'required',
            'name' => 'required',
            'language_id' => 'required',
            'image' => 'required|image',
            'audio' => 'required|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav',
        ];
        $message = [
            'category_id.required' => 'Category ID Is Required',
            'name.required' => 'Name Is Required',
            'language_id.required' => "Language Is Required",
            'image.required' => "Image Is Required",
            'image.image' => "Only Image Allowed",
            'audio.required' => "Audio Is Required",
            'audio.mimes' => "Only Audio Allowed",
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()){
            $error=json_decode($validator->errors());

            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        $image = $this->uploadFile($request, null, 'image', 'music/image');
        $audio = $this->uploadFile($request, null, 'audio', 'music');

        $newMusic = New Music();
        $newMusic->category_id = $request->category_id;
        $newMusic->name = $request->name;
        $newMusic->language_id = $request->language_id;
        $newMusic->image = $image;
        $newMusic->audio = $audio;
        if(isset($request->order_number) && $request->order_number != '' && $request->order_number > 0) {
            $newMusic->order_number = $request->order_number;
        }
        $newMusic->save();
        return response()->json(['status' => true,'message' => 'Music Added']);
        exit();

    }

    public function getMusicById(Request $request) {
        $id = $request->id;
        $music = Music::where('id', $id)->where('is_delete', 0)->first();
        if(empty($music)) {
            return response()->json(['status' => false, 'message' => 'Music Not Found']);
        }
        return response()->json(['status' => true, 'data' => $music, 'message' => 'Music Found']);
    }

    public function updateMusic(Request $request) {
        $rules = [
            'id' => 'required',
            'name' => 'required',
            'language_id' => 'required',
            'image' => 'image',
            'audio' => 'mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav',
        ];

        $messages = [
            'id.required' => 'ID Is Required',
            'name.required' => 'Name Is Required',
            'language.required' => 'Language Is Required',
            'image.image' => "Only Image Allowed",
            'audio.mimes' => 'Only Audio Allowed'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){
            $error=json_decode($validator->errors());

            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        $music = Music::where('id', $request->id)->where('is_delete', 0)->first();
        if(empty($music)) {
            return response()->json(['status' => false, 'message' => 'Music Not Found']);
        }

        $music->name = $request->name;
        $music->language_id = $request->language_id;
        if($request->hasFile('image')) {
            $image = $this->uploadFile($request, null, 'image', 'music/image');
            $music->image = $image;
        }
        if($request->hasFile('audio')) {
            $audio = $this->uploadFile($request, null, 'audio', 'music');
            $music->audio = $audio;
        }
        if(isset($request->order_number) && $request->order_number != '' && $request->order_number > 0) {
            $music->order_number = $request->order_number;
        }
        else {
            $music->order_number = null;
        }
        $music->save();

        return response()->json(['status' => true, 'message' => 'Music Updated']);

    }

    public function deleteMusic(Request $request) {
        $id = $request->id;
        $music = Music::where('id', $id)->where('is_delete', 0)->first();
        if(empty($music)) {
            return response()->json(['status' => false, 'message' => "Music Not Found"]);
        }
        $music->is_delete = 1;
        $music->save();
        return response()->json(['status' => true, 'message' => 'Music Deleted']);
    }
}
