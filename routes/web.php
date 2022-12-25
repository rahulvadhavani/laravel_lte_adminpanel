<?php

use App\Http\Controllers\{HomeController,UserController};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin'],function(){
    Auth::routes(['register' => false]);
});

Route::group(['middleware' => ['auth'],'prefix' => 'admin'], function () {
    Route::group(['controller' => UserController::class ], function () {
        Route::resource('users',UserController::class);
        Route::get('check_email_dublicate', 'CheckEmailDublicate');
        Route::get('check_username_dublicate', 'CheckUsernameDublicate');
    });
    Route::group(['controller' => HomeController::class ], function () {
        Route::get('dashboard',  'index')->name('home');
        Route::get('profile', 'Profile')->name('admin.profile');
        Route::post('update-profile','updateAdminProfile')->name('admin.update_profile');
        Route::post('update-password','updatePassword')->name('admin.update_password');
        Route::post('save-setting','saveSetting')->name('admin.save_setting');
        Route::get('logout','logout')->name('admin.logout');

        //static page
        Route::get('static-page/{slug}','getStaticPage');
        Route::post('update-static-page','postUpdateStaticPage')->name('static_page_update');
    });
    
});