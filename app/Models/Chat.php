<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $guarded = false;

//    public function messages()
//    {
//        return $this->HasMany(Message::class,'chat_id','id');
//    }


    public function sender()
    {
        return $this->hasManyThrough(User::class,Message::class,'sender_id','id','id','id');
    }

    public function recipient()
    {
        return $this->hasManyThrough(User::class,Message::class,'recipient_id','id','id','id');
    }

    public function lastMessage()
    {
        return $this->hasOneThrough(Message::class,User::class,'id','sender_id','id','id')->select('message','sender_id','recipient_id','chat_id');
    }

    public function messages()
    {

        return $this->hasManyThrough(Message::class,User::class,'id','sender_id','id','id')->where('chat_id',1);
    }
}
