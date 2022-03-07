<?php

namespace Modules\Festival\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
//use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;
use App\Language;
use DB;
use DataTables;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('festival::languageindex');
    }

    public function Languagelist(Request $request)
    {
      
        
            $languages = Language::where('is_delete','=',0)->get();
          
       

        $languagesCount = count($languages);
        
       
        $data = '';
        if($languagesCount!=0)
        {
            $count = 1;
            foreach ($languages as $key => $language)
            {
                $data .= '<tr>';
                $data .= '<td>'.$count++.'</td>';
                $data .= '<td>'.$language->name.'</td>';
                $data .= '<td><button onclick="editlanguage('.$language->id.')" class="btn btn-primary">Edit</button><button onclick="deletelanguage('.$language->id.')" class="btn btn-danger ml-1">Delete</button></td>';
                $data .= '</tr>';
            }    
        }

        return response()->json(['status'=>true,'data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('festival::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function Addlanguage(Request $request)
    {
        
        $temp = $request->all();
        $image = (isset($temp['thumnail'])) ? $temp['thumnail'] : 'undefined';
        if($image != 'undefined'){
            
            $path = $this->uploadFile($request, null, 'thumnail', 'language-image',true,300,300);
        } else {
            $path = '';
        }

        $language = new Language;
        $language->name = $temp['languagename'];
        $language->image = $path;
        $language->save();
        

        return redirect('language');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit(Request $request)
    {
        $id = $request->id;
        $data = Language::where('id', $id)->first();
        return response()->json(['status'=>true,'data'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request)
    {
        $temp = $request->all();
        
        $name = $temp['languagename'];
        $id = $temp['languageid'];

        $image = (isset($temp['thumnail'])) ? $temp['thumnail'] : 'undefined';
        if($image != 'undefined'){
            
            $path = $this->uploadFile($request, null, 'thumnail', 'language-image',true,300,300);
        } else {
            $path = '';
        }

        if($path == "")
        {

            Language::where('id', $id)->update(array(
                     'name' => $name,
                     
                 ));
        }
        else
        {
            Language::where('id', $id)->update(array(
                'name' => $name,
                'image' => $path
            ));
        }
        

        return redirect('language');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request)
    {
        $temp = $request->all();
        $id = $temp['id'];
        Language::where('id', $id)->update(array(
                'is_delete' => 1,
                
            ));
        

        return redirect('language');
    }
}
