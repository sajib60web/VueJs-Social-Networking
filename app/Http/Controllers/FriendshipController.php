<?php

namespace App\Http\Controllers;

use App\Friendship;
use App\Notifications;
use App\User;
use Illuminate\Http\Request;
use Auth;
use DB;

class FriendshipController extends Controller
{
    public function friends()
    {
        $uid = Auth::user()->id;
        $friends1 = DB::table('friendships')
            ->leftJoin('users', 'users.id', 'friendships.user_requested')// who is not loggedin but send request to
            ->where('status', 1)
            ->where('requester', $uid)// who is loggedin
            ->get();

        //dd($friends1);
        $friends2 = DB::table('friendships')
            ->leftJoin('users', 'users.id', 'friendships.requester')
            ->where('status', 1)
            ->where('user_requested', $uid)
            ->get();
        $friends = array_merge($friends1->toArray(), $friends2->toArray());

        return view('profile.friends', compact('friends'));
    }

    public function findFriends()
    {
        $uid = Auth::user()->id;
        $friends = DB::table('profiles')
            ->leftJoin('users', 'users.id', '=', 'profiles.user_id')
            ->where('users.id', '!=', $uid)->get();
        return view('profile.findFriends', compact('friends'));
    }

    public function sendRequest($id)
    {
        Auth::user()->addFriend($id);
        return back();
    }

    public function unFriend($id)
    {
        $loggedUser = Auth::user()->id;
        DB::table('friendships')
            ->where('requester', $loggedUser)
            ->where('user_requested', $id)
            ->delete();

        DB::table('friendships')
            ->where('user_requested', $loggedUser)
            ->where('requester', $id)
            ->delete();
        return back()->with('msg', 'You are not friend with this person');
    }

    public function requestedCancel($id)
    {
        DB::table('friendships')
            ->where('user_requested', Auth::user()->id)
            ->where('requester', $id)
            ->delete();
        return back()->with('msg', 'Request has been Cancel');
    }

    public function requests()
    {
        $uid = Auth::user()->id;
        $FriendRequests = DB::table('friendships')
            ->rightJoin('users', 'users.id', '=', 'friendships.requester')
            ->where('status', '=', 0)
            ->where('user_requested', '=', $uid)->get();
        return view('profile.requests', compact('FriendRequests'));
    }

    public function accept($name, $id)
    {
        $uid = Auth::user()->id;
        $checkRequest = Friendship::where('requester', $id)
            ->where('user_requested', $uid)
            ->first();
        if ($checkRequest) {
            // echo "yes, update here";
            $updateFriendship = DB::table('friendships')
                ->where('user_requested', $uid)
                ->where('requester', $id)
                ->update(['status' => 1]);

            $notifcations = new Notifications();
            $notifcations->note = 'accepted your friend request';
            $notifcations->user_hero = $id; // who is accepting my request
            $notifcations->user_logged = Auth::user()->id; // me
            $notifcations->status = 1; // unread notifications
            $notifcations->save();

            if ($notifcations) {
                return back()->with('msg', 'You are now Friend with ' . $name);
            }
        } else {
            return back()->with('msg', 'You are now Friend with this user');
        }
    }


    public function notifications($id)
    {
        $uid = Auth::user()->id;
        $notes = DB::table('notifications')
            ->leftJoin('users', 'users.id', 'notifications.user_logged')
            ->where('notifications.id', $id)
            ->where('user_hero', $uid)
            ->orderBy('notifications.created_at', 'desc')
            ->get();
        DB::table('notifications')
            ->where('id', $id)
            ->update(['status' => 0]);
        return view('profile.notifications', compact('notes'));
    }

    public function requestRemove($id)
    {
        DB::table('friendships')
            ->where('user_requested', Auth::user()->id)
            ->where('requester', $id)
            ->delete();
        return back()->with('msg', 'Request has been deleted');
    }
}
