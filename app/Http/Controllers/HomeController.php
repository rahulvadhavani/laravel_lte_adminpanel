<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\{AdminProfileRequest,AppSettingRequest,ChangePasswordRequest,StaticPageRequest};
use App\Models\Setting;
use App\Models\StaticPage;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
   
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index()
    {
        $title = 'Dashboard';
        $data = [];
        $statistics = Cache::remember('statistics', 60 * 15, function () {
            return [
                'UsersCount' => User::userRole()->count()
            ];
        });
        $data['Users'] = ['count' => $statistics['UsersCount'], 'route' => route('users.index'), 'class' => 'bg-primary', 'icon' => 'fas fa-solid fa-users'];
        $cards = $data;
        return view('admin.dashboard',compact('title','cards'));
    }

    public function profile()
    {
        $title = 'Profile';
        $user = Auth::user();
        $settings = Setting::where('status', 1)->get()->pluck('value', 'key')->toArray();
        $settings['logo_image_url'] = (isset($settings['logo_image']) && $settings['logo_image'] != "" && File::exists(public_path($settings['logo_image']))) ? asset($settings['logo_image']) : asset('dist/img/default-150x150.png');
        return view('admin.profile',compact('title','settings','user'));
    }

    public function updateAdminProfile(AdminProfileRequest $request)
    {
        try{
            $userId = Auth::user()->id;
            $post_data = $request->only('first_name','last_name','name','image');
            $post_data['user_id'] = $userId;
            $validUser = User::find($userId);
            if($validUser == null){
                return error('Invalid user detail');
            }
            if($request->image !=''){
                $img = $this->FileUploadHelper($post_data['image'],'uploads/user');
                $post_data['image'] = $img;    
                if($validUser->image !=''){
                    $path = public_path('uploads/user/'.basename($validUser->image));
                    $this->destroyFileHelper($path);
                }
                $post_data['image'] = $post_data['image'];
            } else {
                unset($post_data['image']);
            }
            $validUser->update($post_data);
            return success('Profile updated successfully');
            
        } catch(Exception $e) {
            return error('Something went wrong!',$e->getMessage());
        }
    }

    public function saveSetting(AppSettingRequest $request)
    {
        try{
            $userId = Auth::user()->id;
            $validatedData = $request->validated(); 
            foreach ($validatedData as $key => $value) {
                if ($value != '') {
                    if ($key == 'logo_image' && !empty($validatedData['logo_image'])) {
                        $value =  imageUploader($validatedData['logo_image'],'uploads/home/',$isUrl = false,$storeAs='logo.'.$validatedData['logo_image']->extension());
                    }
                    Setting::updateOrCreate(['key' => $key], ['key' => $key, 'value' => $value]);
                }
            }
            Cache::forget('app_setting');
            Cache::rememberForever('app_setting', function () {
                return collect(Setting::get());
            });
            return success('Settings Updated successfully.');
            
        } catch(Exception $e) {
            return error('Something went wrong!',$e->getMessage());
        }
    }

    public function updatePassword(ChangePasswordRequest $request)
    {
        try{
            $userId = Auth::user()->id;
            $user =User::where('id',$userId)->first();
            $validatedData['password'] = $request->password;
            $user->update($validatedData);
            return success('Password updated successfully');
            
        } catch(Exception $e) {
            return error('Something went wrong!',$e->getMessage());
        }
    }

    public function getStaticPage($slug){   
        $slug =  $slug;
        $arr = array_keys(StaticPage::PAGES);
        if (!in_array($slug,$arr)) {
            abort('404');
        }
        $title =  $slug;
        $content =  '';
        $parent_id =  'static-page';
        $page = StaticPage::where('slug',$slug)->first();
        if ($page) {
            $title= $page->title;
            $content= $page->content;
        }
        return view('staticpage.index',compact('title','slug','content','parent_id'));
    }
    public function postUpdateStaticPage(StaticPageRequest $request){
        $post_data = $request->only('slug','content');
        try {
            $post_data['title'] = StaticPage::PAGES[$request->slug];
            $page = StaticPage::updateOrCreate(['slug'=>$post_data['slug']],$post_data);
            return success($post_data['title'].' updated successfully.');
        } catch (\Throwable $th) {
            return error('Something went wrong',$th->getMessage());
        }
    
    }
    public function Logout(){
    	Auth::logout();
    	return \Redirect::to("admin/login")
        ->with('message', array('type' => 'success', 'text' => 'You have successfully logged out'));
    }
}

