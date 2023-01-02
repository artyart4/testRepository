<?php

namespace App\Http\Controllers\Auth2;

use App\Http\Controllers\Controller;
use App\Models\User;
use  Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;
use PragmaRX\Google2FAQRCode\Google2FA as Google2FAQrCode;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate(['email'=>'email:dns|required', 'password'=>'min:6']);
        if(Auth::attempt($data)){
            $request->session()->regenerate();
            if (\auth()->user()->fa){

                $google2fa = new Google2FA();

                $secretKey = $google2fa->generateSecretKey();
              if (\auth()->user()->secret_key === null && \auth()->user()->fa){
                  User::where('id',\auth()->user()->id)->update(['secret_key'=>$secretKey]);
                  return view('fa',compact('secretKey'));
              }else{
                  $secretKey = auth()->user()->secret_key;
                  return view('fa',compact('secretKey'));
              }
            }
           return redirect('/chat/2');
        }
        return false;
    }

    public function vetifyOTP()
    {
        $google2fa = new Google2FA();
        $user_key = \request()->input('key');
        $user = \auth()->user();
      if ($google2fa->verifyKey($user->secret_key, $user_key)){
          User::where('id',auth()->user()->id)->update(['google2fa_secret_enable'=>1]);
          return redirect('/chat/2');
      }else{
          User::where('id',auth()->user()->id)->update(['google2fa_secret_enable'=>0]);
          Auth::logout();
          return redirect('/login2');
      }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login2');
    }
}
