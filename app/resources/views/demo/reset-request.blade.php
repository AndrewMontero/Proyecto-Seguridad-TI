@extends('layouts.app')

@section('content')
<h2>Demo Reset Request (predictable token)</h2>
<form action="{{ url('/demo-reset-request') }}" method="post">
    @csrf
    <label>Email:</label><input type="email" name="email"><br>
    <button type="submit">Request reset token</button>
</form>
@endsection
