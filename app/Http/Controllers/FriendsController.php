<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Request;

class FriendsController extends Controller
{
    public function add($id)
    {

        Friend::firstOrCreate(['user_1'=>auth()->user()->id,'user_2'=>$id]);
        return redirect('/chat');
    }

    public function cancelRequestToFriend($id)
    {
      Friend::query()->where('user_1',$id)->where('user_2',auth()->user()->id)->update(['user_2_reject'=>1]);
      return redirect('/chat');
    }
    public function cancelSendRequestToFriend($id)
    {
        Friend::query()->where('user_1',auth()->user()->id)->where('user_2',$id)->where('user_2_accept',null)->delete();
        return redirect('/chat');
    }

    public function deleteFriend($id)
    {
      Friend::query()->where('user_1', $id)->where('user_2',auth()->user()->id)->orWhere('user_2',$id)->where('user_1',auth()->user()->id)->delete();
    }

    public function friends()
    {
      $res =   Friend::query()->where('user_1', auth()->id())->where('user_2_accept',1)->orWhere('user_2', auth()->id())->where('user_2_accept',1)->select('user_1','user_2')->get();
      foreach($res as $result){
         if ($result->user_1 === auth()->id()){
             unset($result['user_1']);
         }elseif ($result->user_2 === auth()->id()){
             unset($result['user_2']);
         }
          $friends =  User::where('id',$result->user_1)->orWhere('id', $result->user_2)->select('name','id')->get();
      }
      return view('friends',compact('friends'));
    }
}


