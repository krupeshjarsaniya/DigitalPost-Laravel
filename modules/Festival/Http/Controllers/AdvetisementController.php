<?php

namespace Modules\Festival\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use DB;
use DataTables;
use Validator;
use Illuminate\Support\Facades\Storage;

class AdvetisementController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('festival::adindex');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        
         
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $temp = $request->all();
        $number = $temp['phone'];
        $link = $temp['advlink'];

        if ($request->hasFile('thumnail')) {
            /*$image = $request->file('thumnail');
            $name = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/advetisement'), $name);
            $path = '/public/images/advetisement/'.$name;*/
            $path = $this->uploadFile($request, null, 'thumnail', 'advetisement-post');
        } else {
            $path = '';
        }

        if ($request->advid == "") 
        {
             DB::table('advetisement')->insert(
                    ['adv_number' => $number, 'adv_image' => $path, 'adv_link' => $link]
                );
        }
        else
        {
            if($path != "")
            {
                DB::table('advetisement')->where('id','=',$request->advid)->update(
                        ['adv_number' => $number, 'adv_image' => $path, 'adv_link' => $link]
                    );
            }
            else
            {
                DB::table('advetisement')->where('id','=',$request->advid)->update(
                        ['adv_number' => $number, 'adv_link' => $link]
                    );
            }
        }

            return redirect('advetisement');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function searchAdvetisement(Request $request)
    {
         $adv_datas = DB::table('advetisement')->where('is_delete','=',0)->get();
         $data = '';
         $adv_dataCount = count($adv_datas);
        if($adv_dataCount!=0)
        {
            $count = 1;
            foreach ($adv_datas as $key => $adv_data)
            {
                $data .= '<tr>';
                $data .= '<td>'.$count++.'</td>';
                $data .= '<td><img id="blah" src="'.Storage::url($adv_data->adv_image).'" id="aimage" alt="your image" height="50" width="50" /></td>';
                $data .= '<td>'.$adv_data->adv_number.'</td>';
                $data .= '<td>'.$adv_data->adv_link.'</td>';
                $data .= '<td><button onclick="editadvetisement('.$adv_data->id.')" class="btn btn-primary">Edit</button><button onclick="deleteadvetisement('.$adv_data->id.')" class="btn btn-danger ml-1">Delete</button></td>';
                $data .= '</tr>';
            }    
        }

            return response()->json(['status'=>true,'data'=>$data]); 

    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function EditAdvetisement(Request $request)
    {
        $id = $request->id;
         $adv_data = DB::table('advetisement')->where('id','=',$id)->where('is_delete','=',0)->first();
            return response()->json(['status'=>true,'data'=>$adv_data]); 
        
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function RemoveAdvetisement(Request $request)
    {
         DB::table('advetisement')->where('id','=',$request->id)->update(
                        ['is_delete' => 1, ]
                    );
            return response()->json(['status'=>true]); 

    }
}
