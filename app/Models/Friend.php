<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use HasFactory;
    protected $guarded = false;

    public function requester()
    {
        return $this->HasMany(User::class,'id','user_1')->select('name','id');
    }

    public function friend_2(){
        return $this->belongsTo(User::class, 'id','');
    }
}
