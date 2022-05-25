<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AdminProfileRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\StaticPageRequest;
use App\Models\StaticPage;
use Exception;
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
        $total_user_count = User::count();
        return view('admin.dashboard',compact('title'))->with('user_count',$total_user_count);
    }

    public function profile()
    {
        $title = 'Profile';
        $user = Auth::user();
        return view('admin.profile',compact('title'))->with('user',$user);
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
    public function updatePassword(ChangePasswordRequest $request)
    {
        try{
            $userId = Auth::user()->id;
            $user =User::where('id',$userId)->first();
            $validatedData['password'] = Hash::make($request->password);
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

