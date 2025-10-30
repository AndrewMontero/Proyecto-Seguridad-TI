@extends('layouts.app')

@section('content')
<h2>Demo Reset Validate</h2>
<form action="{{ url('/demo-reset') }}" method="post">
    @csrf
    <label>Email:</label><input type="email" name="email"><br>
    <label>Token:</label><input type="text" name="token"><br>
    <button type="submit">Validate token</button>
</form>
@endsection
