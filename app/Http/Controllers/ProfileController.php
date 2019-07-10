<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Auth;
use DB;
use Image;

class ProfileController extends Controller
{
    public function index($slug) {
        $userData = DB::table('users')
            ->leftJoin('profiles', 'profiles.user_id','users.id')
            ->where('slug', $slug)
            ->get();
        return view('profile.index', compact('userData'))->with('data', Auth::user()->profile);
    }

    public function changePhoto(){
        return view('profile.pic');
    }

    public function uploadPhoto(Request $request) {
        $file = $request->file('pic');
        $filename = $file->getClientOriginalName();
        $path = 'user-img';
        $file->move($path, $filename);
        $user_id = Auth::user()->id;
        DB::table('users')->where('id', $user_id)->update(['pic' => $filename]);
        return back();
    }

    public function editProfile()
    {
        return view('profile.edit-profile')->with('data', Auth::user()->profile);
    }

    public function updateProfile(Request $request)
    {
        $user_id = Auth::user()->id;
        DB::table('profiles')->where('user_id', $user_id)->update($request->except('_token'));
        return back();
    }
}
