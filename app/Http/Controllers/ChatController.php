<?php

namespace App\Http\Controllers;

use App\Events\MessageEvent;
use App\Http\Middleware\TwoFaCheck;
use App\Http\Resources\ChatsCollection;
use App\Jobs\SendFile;
use App\Models\Chat;
use App\Models\Message;
use App\Notifications\TelegramNotification;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class BlalblaController extends Controller
{


    public function index()
    {
        $myChats = Chat::where('user_1',auth()->user()->id)->orWhere('user_2',auth()->user()->id)->with('sender')->with('recipient')->with('lastMessage')->get();
        return view('chat.chats', compact('myChats'));
    }

    public function get($id)
    {
        if (Gate::check('avaliable_message',$id)){
            $chat_id =Chat::where('user_1',$id)->where('user_2',auth()->user()->id)->orWhere('user_1',auth()->user()->id)->where('user_2',$id)->value('id');
            $messages = Message::where('chat_id',$chat_id)->get();

            return $messages;
        }else{
            return \Illuminate\Auth\Access\Response::deny('вы не можете писать пользователю, который не добавил вас', 403);
        }

    }

    public function send(Request $request,  $chat_id)
    {
        $message = $request->validate(['message'=>'required']);
//        $message_crypt = Crypt::encryptString($request->input('message'));
       $message= Message::create(['sender_id'=>auth()->user()->id, 'recipient_id'=>request()->route('id'), 'message'=>$request->input('message'),'chat_id'=>1]);


        broadcast(new MessageEvent($message)) ;
    }

    public function sendFile(Request $request)
    {
        $file_path = $request->file('file')->store('public_files','public');
        $file_name = $request->file('file')->getFilename().$request->file('file')->getMimeType();
        $file_name = str_replace('/','.', $file_name);
        $res =   Message::create(['sender_id'=>auth()->user()->id, 'recipient_id'=>request()->route('id'), 'file'=>$file_name, 'message'=>$request->input('message'),'chat_id'=>1]);

         dispatch(new SendFile($file_path));
       return redirect()->back();
    }
public function downloadFile($file)
{
    return Storage::download('/public/public_files/',$file);
}

}
