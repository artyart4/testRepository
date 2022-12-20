<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return ['id'=>$this->id, 'message'=>$this->message, 'recipient_id'=>$this->recipient_id,'sender_id'=>$this->sender_id,'recipient_name'=>$this->recipient->name, 'sender_name'=>$this->sender->name, 'file'=>$this->file];
    }
}
