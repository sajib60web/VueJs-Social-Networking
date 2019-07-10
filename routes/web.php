<?php

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

use App\Notifications;
use App\Post;

Route::get('/', function () {
    $posts = DB::table('posts')
        ->leftJoin('profiles', 'profiles.user_id','posts.user_id')
        ->leftJoin('users', 'users.id','posts.user_id')
        ->get();
//    return $posts;
    return view('welcome', compact('posts'));
});

Route::get('/count', function () {
    $notifications = App\Notifications::where('status', 1)
        ->where('user_logged', Auth::user()->id)
        ->count();
    return $notifications;
});

Route::get('/test', function () {
    return Auth::user()->test();
});

Auth::routes();
Route::group(['middleware' => 'auth'], function () {
    //Start Home Controller
    Route::get('/home', 'HomeController@index')->name('home');
    //End Home Controller

    //Start Profile Controller
    Route::get('/profile/{slug}', 'ProfileController@index');
    Route::get('/changePhoto', 'ProfileController@changePhoto');
    Route::post('/uploadPhoto', 'ProfileController@uploadPhoto');
    Route::get('/edit-profile', 'ProfileController@editProfile');
    Route::post('/updateProfile', 'ProfileController@updateProfile');
    //End Profile Controller

    //Start Friendship Controller
    Route::get('/findFriends', 'FriendshipController@findFriends');
    Route::get('/addFriend/{id}', 'FriendshipController@sendRequest');
    Route::get('/un-friend/{id}', 'FriendshipController@unFriend');
    Route::get('/requested-cancel/{id}', 'FriendshipController@requestedCancel');
    Route::get('/requests', 'FriendshipController@requests');
    Route::get('/accept/{name}/{id}', 'FriendshipController@accept');
    Route::get('friends', 'FriendshipController@friends');
    Route::get('requestRemove/{id}', 'FriendshipController@requestRemove');

    Route::get('/notifications/{id}', 'FriendshipController@notifications');
    //End Friendship Controller

});
Route::get('/logout', 'Auth\LoginController@logout');
