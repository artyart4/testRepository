@extends('layouts.app')
@section('content')
    <div class="flex justify-center">
        <ul class="bg-white rounded-lg w-96 text-gray-900">
            @foreach($friends as $friend)
            <li class="px-6 py-2 border-b border-gray-200 w-full rounded-t-lg"></li>
            <li class="px-6 py-2 border-b border-gray-200 w-full">{{$friend->name}} <a href="/chat/{{$friend->id}}" class="inline-block px-6 py-2.5 bg-blue-400 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-500 hover:shadow-lg focus:bg-blue-500 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-600 active:shadow-lg transition duration-150 ease-in-out">написать</a>  <a href="{{route('deleteFriend',$friend->id)}}" class="inline-block px-6 py-2.5 bg-red-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out">удалить из друзей</a></li>
            <li class="px-6 py-2 w-full rounded-b-lg">And a fifth one</li>
            @endforeach
        </ul>
    </div>

@endsection
