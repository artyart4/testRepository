@extends('layouts.app')
@section('content')
    {{$res}}
    @foreach($res as $result)

    <div class="flex justify-center">
        <div class="rounded-lg shadow-lg bg-white w-1/3">
            <a href="#!">
                <img class="rounded-t-lg" src="https://mdbootstrap.com/img/new/standard/nature/184.jpg" alt=""/>
            </a>
            <div class="p-6">
                <h5 class="text-gray-900 text-xl font-medium mb-2">{{$result->name}}</h5>
                <p class="text-gray-700 text-base mb-4">
                  email: {{$result->email}}
                </p>
                @php
                $action ='';
                $action2 = '';
                $url = '';
                $url2 = '';
                if (!\App\Models\Friend::where('user_1',$result->id)->orWhere('user_2',$result->id)->count()){
                    $action = 'добавить';
                    $url = "/add/$result->id";
                }elseif(\App\Models\Friend::where('user_1',$result->id)->where('user_2',auth()->user()->id)->where('user_2_accept', null)->where('user_2_reject',null)->count()){
                    $action = 'не принимать';
                     $url = "/cancelfriend/$result->id";
                    $action2 = 'принять';
                     $url2 = "/profile/accept/$result->id";
                }elseif(\App\Models\Friend::where('user_1',auth()->user()->id)->where('user_2',$result->id)->where('user_2_accept', null)->where('user_2_reject',null)->count()){
                    $action = 'отменить отправку заявки в друзья';
                    $url = "/cancelsendrequest/$result->id";
                }elseif(\App\Models\Friend::where('user_1',$result->id)->where('user_2_accept', true)->orWhere('user_2',$result->id)->where('user_2_accept', true)->count()){
                    $action = 'удалить из друзей';
                    $url = "/deleteFriend/$result->id";
                }elseif ($result->id === auth()->id()){
                    $action = '';
                }
                @endphp
                <a href="{{$url}}" class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out mb-2">{{$action}}</a><br>
                @if($action2 != '')
                    <a href="{{$url2}}" class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out mb-2">{{$action2}}</a><br>
                @endif
                @if(\App\Models\Friend::where('user_1',$result->id)->where('user_2_accept',1)->orWhere('user_2', $result->id)->where('user_2_accept',1)->first())
                <a href="/chat/{{$result->id}}" class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">написать</a>
                @endif
            </div>
        </div>
    </div>
    @endforeach
@endsection
