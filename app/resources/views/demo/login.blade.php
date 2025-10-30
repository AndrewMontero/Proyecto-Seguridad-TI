@extends('layouts.app')

@section('content')
<h2>Demo Login (weak password)</h2>
@if(session('error')) <div style="color:red">{{ session('error') }}</div> @endif
<form action="{{ url('/demo-login') }}" method="post">
    @csrf
    <label>Email:</label><input type="email" name="email"><br>
    <label>Password:</label><input type="password" name="password"><br>
    <button type="submit">Login (demo)</button>
</form>
<p>Use password <b>admin123</b> for demo.</p>
@endsection