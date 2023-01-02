<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class SearchController extends Controller
{
    public function index(){
        $query = request()->input('query');
      $res =   User::where('name','LIKE', "%$query%")->select('id','email','name')->get();
      if (!$res){
          $res = User::where('email','LIKE',"$query")->select('id','email','name')->get();
      }
      return view('result', compact('res'));
    }
}
