<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use File;
use DB;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    private $storage_folder = 'storage';

     public function __construct()
     {
        ini_set('memory_limit', -1);
     }
    

    public function uploadFile($request, $record = [], $name, $path, $thumb = false, $thumbWidthSize = null, $thumbHeightSize = null) {
        if($this->storage_folder != null){
            $path = $this->storage_folder.'/'.$path.'/'.Carbon::now()->format('Y').'/'.Carbon::now()->format('m');
        }
        
        if ($request->hasFile($name)) {
            $file_name = $request->file($name)->store($path);
            if ($thumb) {
                
                $file = $request->file($name);
                $path = $file->hashName('thumb/' . $path);
                $image = \Intervention\Image\Facades\Image::make($file);
                $file_name = $path;
                
                // Resize uploaded file
                if ($thumb == true && !empty($thumbWidthSize) && !empty($thumbHeightSize)) {
                    $image->resize($thumbWidthSize, $thumbHeightSize, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                } elseif ($thumb == true && !empty($thumbWidthSize) && $thumbHeightSize == null) {
                    $image->resize($thumbWidthSize, null , function ($constraint) {
                        $constraint->aspectRatio();
                    });
                } elseif ($thumb == true && $thumbWidthSize == null && !empty($thumbHeightSize)) {
                    $image->resize(null, $thumbHeightSize, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                Storage::put($path, (string) $image->encode());
                //dd('hii');
                if (!empty($record) && Storage::exists($record[$name]) ) {
                    Storage::delete('thumb/' . $record[$name]);
                }
            }
            if (!empty($record) && Storage::has($record[$name])) {
                Storage::delete($record[$name]);
            }
            
            return $file_name;

        } else {

        }
    }

    public function uploadFile_thumnail($request, $record = [], $name, $path, $thumb = false, $thumbWidthSize = null, $thumbHeightSize = null) {
        if($this->storage_folder != null){
            $path = $this->storage_folder.'/'.$path.'/'.Carbon::now()->format('Y').'/'.Carbon::now()->format('m');
        }
        if ($request->hasFile($name)) {
            $file_name = $request->file($name)->store($path);
            if ($thumb) {
                
                $file = $request->file($name);
                $path = $file->hashName('thumb/' . $path);
                $image = \Intervention\Image\Facades\Image::make($file);

                // Resize uploaded file
                if ($thumb == true && !empty($thumbWidthSize) && !empty($thumbHeightSize)) {
                    $image->resize($thumbWidthSize, $thumbHeightSize, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                } elseif ($thumb == true && !empty($thumbWidthSize) && $thumbHeightSize == null) {
                    $image->resize($thumbWidthSize, null , function ($constraint) {
                        $constraint->aspectRatio();
                    });
                } elseif ($thumb == true && $thumbWidthSize == null && !empty($thumbHeightSize)) {
                    $image->resize(null, $thumbHeightSize, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                Storage::put($path, (string) $image->encode());
                //dd('hii');
                if (!empty($record) && Storage::exists($record[$name]) ) {
                    Storage::delete('thumb/' . $record[$name]);
                }
            }
            if (!empty($record) && Storage::has($record[$name])) {
                Storage::delete($record[$name]);
            }
            
            return $file_name;

        } else {

        }
    }

    public function multipleUploadFile($file, $path, $thumb = false, $thumbWidthSize = null, $thumbHeightSize = null) {
        if($this->storage_folder != null){
            $path = $this->storage_folder.'/'.$path.'/'.Carbon::now()->format('Y').'/'.Carbon::now()->format('m');
        }
            $file_name = $file->store($path);
            if ($thumb) {
                //$file = $request->file($name);
                $path = $file->hashName('thumb/' . $path);
                $image = \Intervention\Image\Facades\Image::make($file);

                // Resize uploaded file
                if ($thumb == true && !empty($thumbWidthSize) && !empty($thumbHeightSize)) {
                    $image->resize($thumbWidthSize, $thumbHeightSize, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                } elseif ($thumb == true && !empty($thumbWidthSize) && $thumbHeightSize == null) {
                    $image->resize($thumbWidthSize, null , function ($constraint) {
                        $constraint->aspectRatio();
                    });
                } elseif ($thumb == true && $thumbWidthSize == null && !empty($thumbHeightSize)) {
                    $image->resize(null, $thumbHeightSize, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }

                Storage::put($path, (string) $image->encode());
                $file_name = $path; 
            }
           return $file_name;

    }

    public function multipleUploadFileThumb($file, $path, $thumb = false, $thumbWidthSize = null, $thumbHeightSize = null) {
        if($this->storage_folder != null){
            $path = $this->storage_folder.'/'.$path.'/'.Carbon::now()->format('Y').'/'.Carbon::now()->format('m');
        }
            $file_name = $file->store($path);
            if ($thumb) {
                //$file = $request->file($name);
                $path = $file->hashName('thumb/' . $path);
                $file_name = $path; 
                $image = \Intervention\Image\Facades\Image::make($file);

                // Resize uploaded file
                if ($thumb == true && !empty($thumbWidthSize) && !empty($thumbHeightSize)) {
                    $image->resize($thumbWidthSize, $thumbHeightSize, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                } elseif ($thumb == true && !empty($thumbWidthSize) && $thumbHeightSize == null) {
                    $image->resize($thumbWidthSize, null , function ($constraint) {
                        $constraint->aspectRatio();
                    });
                } elseif ($thumb == true && $thumbWidthSize == null && !empty($thumbHeightSize)) {
                    $image->resize(null, $thumbHeightSize, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }

                Storage::put($path, (string) $image->encode());
            }
           return $file_name;

    }

    public function deleteFile($record,$name,$is_thumb=false){
        if(!empty($record)){
            Storage::delete($record[$name]);
            if($is_thumb){
                Storage::delete('thumb/' . $record[$name]);
            }
        }
    }

    public function exportFile($filetype, $filename = 'export', $headers = [], $records = []) {

        Excel::create($filename, function($excel) use ($headers,$records) {
            $excel->sheet('Sheet1', function($sheet) use ($headers,$records) {
                $sheet->row(1, $headers);
                $sheet->row(1, function($row) {
                    // call cell manipulation methods
                    $row->setBackground('#846648');
                    $row->setFontColor('#FFFFFF');
                    $row->setFontFamily('Calibri');
                    $row->setFontSize(14);
                    $row->setFontWeight('bold');
                    $row->setAlignment('center');
                    $row->setValignment('center');
                });
                // Sheet manipulation
                $sheet->rows($records);
                $sheet->freezeFirstRow();
            });
        })->export($filetype);
    }

    public function uploadFile_thumnail_database($request, $record = [], $name, $path, $thumb = false, $thumbWidthSize = null, $thumbHeightSize = null) {
        if($this->storage_folder != null){
            $path = $this->storage_folder.'/'.$path.'/'.Carbon::now()->format('Y').'/'.Carbon::now()->format('m');
        }
            try {
                if ($thumb) {
                
                    //$file = $request->file($name);
                    $file = Storage::get($name);
                    //$file = file_get_contents($name);
                   
                    //$path = $file->hashName('thumb/' . $path);
                    $path = 'thumb/' . $path.$name;
                    $file_name = $path;
                    $image = \Intervention\Image\Facades\Image::make($file);
    
                    // Resize uploaded file
                    if ($thumb == true && !empty($thumbWidthSize) && !empty($thumbHeightSize)) {
                        $image->resize($thumbWidthSize, $thumbHeightSize, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    } elseif ($thumb == true && !empty($thumbWidthSize) && $thumbHeightSize == null) {
                        $image->resize($thumbWidthSize, null , function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    } elseif ($thumb == true && $thumbWidthSize == null && !empty($thumbHeightSize)) {
                        $image->resize(null, $thumbHeightSize, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }
                    Storage::put($path, (string) $image->encode());
                    //dd('hii');
                    if (!empty($record) && Storage::exists($record[$name]) ) {
                        Storage::delete('thumb/' . $record[$name]);
                    }
                }
                if (!empty($record) && Storage::has($record[$name])) {
                    Storage::delete($record[$name]);
                }
                
                return $file_name;
            } catch (\Throwable $th) {
                $file_name = Null;
                return $file_name;
            }
            

        
    }

    public function addPurchasePlanHistory($business_id, $business_type, $start_date = "") {
        $purchaseData = DB::table('purchase_plan')->where('purc_business_id', $business_id)->where('purc_business_type', $business_type)->first();
        if($start_date == "") {
            $start_date = $purchaseData->purc_start_date;
        }
        DB::table('purchase_plan_history')->where('pph_is_latest', 1)->where('pph_purc_business_id', $business_id)->where('pph_purc_business_type', $business_type)->update(['pph_is_latest' => 0]);
        $historyData = array(
            'pph_purc_id' => $purchaseData->purc_id,
            'pph_purc_user_id' => $purchaseData->purc_user_id,
            'pph_purc_order_id' => $purchaseData->purc_order_id,
            'pph_purc_business_id' => $purchaseData->purc_business_id,
            'pph_purc_business_type' => $purchaseData->purc_business_type,
            'pph_purc_plan_id' => $purchaseData->purc_plan_id,
            'pph_purc_plan_id' => $purchaseData->purc_plan_id,
            'pph_purc_plan_id' => $purchaseData->purc_plan_id,
            'pph_purc_plan_id' => $purchaseData->purc_plan_id,
            'pph_purc_start_date' => $start_date,
            'pph_purc_end_date' => $purchaseData->purc_end_date,
            'pph_purchase_id' => $purchaseData->purchase_id,
            'pph_device' => $purchaseData->device,
        );

        DB::table('purchase_plan_history')->insert($historyData);
    }

    public function updateCencalDateInHistoryTable($business_id, $business_type) {
        DB::table('purchase_plan_history')->where('pph_is_latest', 1)->where('pph_purc_business_id', $business_id)->where('pph_purc_business_type', $business_type)->update(['pph_cencal_date' => Carbon::now(), 'pph_purc_is_cencal'=> 1]);
    }
}
