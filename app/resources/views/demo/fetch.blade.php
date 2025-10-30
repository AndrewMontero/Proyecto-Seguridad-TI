@extends('layouts.app')

@section('content')
<h2>Demo SSRF - fetch</h2>
<form action="{{ url('/fetch') }}" method="get">
    <label>URL to fetch:</label>
    <input type="text" name="url" placeholder="http://example.com" style="width:80%">
    <button type="submit">Fetch</button>
</form>
@endsection
