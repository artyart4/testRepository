@extends('layouts.app')
@section('content')
<h2>Пополнить баланс</h2>
    <form method="post" action="{{route('payment.create')}}">
        @csrf
         <input type="number" name="amount" placeholder="сумма"> <br>
        <input type="text" name="description" placeholder="добавьте описание платежа">
        <input type="submit" value="оплатить">
    </form>

<p>тест</p>
    <h2> Баланс</h2>
    <div> @if(cache()->has('balance')) {{cache()->get('balance')}}$ @else 0$ @endif </div>
@endsection
