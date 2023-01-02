<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use Illuminate\Http\Request;

class ProfileeController extends Controller
{
    public function index()
    {
        if ($res = Friend::query()->where('user_2',auth()->user()->id)->where('user_2_accept')->with('requester')->get()){

            return view('profile',compact('res'));
        }
        return view('profile');
    }

    public function accept($id)
    {
        Friend::query()->update(['user_2_accept'=>1]);
        return redirect('/chat');
    }

}
