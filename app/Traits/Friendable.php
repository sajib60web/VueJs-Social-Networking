<?php

namespace App\Traits;
use App\Friendship;

trait Friendable
{
    public function test() {
        return 'hi';
    }

    public function addFriend($id){
        $Friendship = Friendship::create([
            'requester' => $this->id,
            'user_requested' => $id,
        ]);
        if($Friendship){
            return $Friendship;
        }
        return 'Failed';

//        echo 'Adding Friend';

    }
}
