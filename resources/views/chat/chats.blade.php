@extends('layouts.app')

@section('content')
{{--    {{$myChats}}--}}
    <chats-component :my_id="{{auth()->user()->id}}"   :recipient="{{request()->route('id')}}" :my_chats="{{$myChats}}"></chats-component>
@dd(response())
    <div class="w-full px-5 flex flex-col justify-between">
    <form action="{{route('fileSend',request()->route()->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
            <input
                class="w-full bg-gray-300 py-5 px-3 rounded-xl"
                type="file"
                name="file"
                accept=".doc,.docx,.epub, .png, .jpg" />
        <input type="submit" value="enter" class="bg-red-400">
    </form>
    </div>
@endsection

