<?php

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
    Route::group(['controller' => App\Http\Controllers\UserController::class ], function () {
        Route::resource('users',App\Http\Controllers\UserController::class);
        Route::get('check_email_dublicate', 'CheckEmailDublicate');
        Route::get('check_username_dublicate', 'CheckUsernameDublicate');
    });
    Route::group(['controller' => App\Http\Controllers\HomeController::class ], function () {

        Route::get('dashboard',  'index')->name('home');
        Route::get('profiles', 'Profile')->name('admin.profile');
        Route::post('update-profile','updateAdminProfile')->name('admin.update_profile');
        Route::post('update-password','updatePassword')->name('admin.update_password');
        Route::get('logout','logout')->name('admin.logout');

        //static page
        Route::get('static-page/{slug}','getStaticPage');
        Route::post('update-static-page','postUpdateStaticPage')->name('static_page_update');
    });
    
    

    // // projetc
    // Route::get('projects',[App\Http\Controllers\ProjectController::class ,'getProjects']);
    // Route::post('add-project',[App\Http\Controllers\ProjectController::class ,'postAddProject']);
    // Route::post('add-milestone',[App\Http\Controllers\ProjectController::class ,'postAddMilestone']);
});

// Email verification
// Route::get('verifyemail/{id}', [App\Http\Controllers\VerificationController::class, 'EmailVerification']);

// Forgot password
// Route::get('passwordreset/{id}/{date}', [App\Http\Controllers\PasswordController::class, 'ResetPassword']);
// Route::post('savepassword/{id}/{date}', [App\Http\Controllers\PasswordController::class, 'UpdatePassword']);
// Route::get('thankyou', [App\Http\Controllers\PasswordController::class, 'Thankyou']);

// Command
// Route::get('cache-clear', [App\Http\Controllers\CacheController::class, 'CacheClear'])->name('CacheClear');
// Route::get('migrate-tables', [App\Http\Controllers\CacheController::class, 'MigrateTable'])->name('MigrateTable');

// Logout
// Route::get('/logout', [App\Http\Controllers\CacheController::class, 'Logout'])->name('Logout');
