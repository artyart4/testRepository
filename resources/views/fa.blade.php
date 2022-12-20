
{{$secretKey}}
<form action="{{route('vetifyOTP')}}" method="post">
    @csrf
    <input type="text" placeholder="введите ключ" name="key">
    <input type="submit" value="enter">
</form>
