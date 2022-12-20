@extends('layouts.app')
@section('content')
    <form method="POST" action="{{route('authenticate')}}">
        @csrf
        <input type="email" placeholder="email" name="email">
        <input type="password" placeholder="password" name="password">
        <input type="submit" value="enter">
    </form>
@endsection
