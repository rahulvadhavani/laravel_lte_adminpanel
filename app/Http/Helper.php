<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

if(!function_exists('success')){
    function success($message = "Success",$data= [])
    {
        $res = ['status' => true,  'message' => $message, 'code' => 200];
        if(!empty($data)){
            $res = ['status' => true,  'message' => $message,'data' => $data, 'code' => 200];
        }
        return $res;
    }
}
if(!function_exists('error')){
    function error($message = "Something went wrong!!",$data=[])
    {
        $res = ['status' => false,  'message' => $message,"data"=>$data, 'code' => 400];
        return $res;
    }
}
if(!function_exists('authError')){
    function authError($message = "Unauthenticated")
    {
        $res = ['status' => false,  'message' => $message, 'code' => 401];
        return $res;
    }
}


if(!function_exists('imageUploader')){
    function imageUploader($image,$filePath,$isUrl = false,$storeAs='')
    {
        $path = public_path($filePath);
        File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
        if($storeAs == ''){
            $imageName = basename($path).'_'.time().'.'.$image->extension();
        }else{
            $imageName = $storeAs;
        }
        $image->move($path, $imageName);
        return $isUrl ? url($filePath,$imageName) : $filePath.$imageName;
    }
}

if (!function_exists('unlinkFile')) {
    function unlinkFile($path)
    {
        if (File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}

if (!function_exists('getSettings')) {
    function getSettings($key = "")
    {
        if (Cache::has('app_setting')) {
            $setting = Cache::get('app_setting');
        } else {
            $setting = Cache::rememberForever('app_setting', function () {
                return collect(Setting::get());
            });
        }
        if ($key != "") {
            $setting = $setting->where('key', $key)->first()->value ?? "";
            if ($key == 'logo_image') {
                $setting = ($setting != "" && File::exists(public_path($setting))) ? asset($setting) : asset('assets/images/logo.png');
            }
        }
        return $setting;
    }
}

?>