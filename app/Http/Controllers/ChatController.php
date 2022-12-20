<?php

namespace App\Http\Controllers;

use App\Events\MessageEvent;
use App\Http\Resources\ChatsCollection;
use App\Jobs\SendFile;
use App\Models\Message;
use App\Notifications\TelegramNotification;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    public function chats()
    {
       $chats =  Message::where('recipient_id',auth()->user()->id)->orWhere('sender_id',auth()->user()->id)->select('id','recipient_id','sender_id','message')->with('recipient')->with('sender')->get();
       return new ChatsCollection($chats);
    }

    public function index($id)
    {
        return view('chat.chats');
    }

    public function get($id)
    {
        $messages =  Message::where('recipient_id',auth()->user()->id)->where('sender_id',$id)->orWhere('sender_id',auth()->user()->id)->where('recipient_id',$id)->select('id','recipient_id','sender_id','message','file')->with('recipient')->with('sender')->get();
        return new ChatsCollection($messages);
    }

    public function send(Request $request)
    {
        $message = $request->validate(['message'=>'required','file'=>'']);
       $message= Message::create(['sender_id'=>auth()->user()->id, 'recipient_id'=>request()->route('id'), 'message'=>$message['message'], 'file'=>$message['file']]);
        broadcast(new MessageEvent($message)) ;
    }

    public function sendFile(Request $request)
    {
        $file_path = $request->file('file')->store('public_files','public');
        $file_name = $request->file('file')->getFilename().$request->file('file')->getMimeType();
        $file_name = str_replace('/','.', $file_name);
        $res =   Message::create(['sender_id'=>auth()->user()->id, 'recipient_id'=>request()->route('id'), 'file'=>$file_name]);

         dispatch(new SendFile($file_path));
       return redirect()->back();
    }
public function downloadFile($file)
{
    return Storage::download('/public/public_files/',$file);
}
}
