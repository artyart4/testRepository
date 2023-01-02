<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $guarded = false;
    protected $casts = [
        'message' => 'encrypted',
];
    public function recipient()
    {
        return $this->belongsTo(User::class,'recipient_id','id')->select('name','id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class,'sender_id','id')->select('name','id');;
    }


}
