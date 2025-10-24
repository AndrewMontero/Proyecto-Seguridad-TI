@extends('layouts.app')
@section('content')
<h1>Crear Parcela</h1>

@if($errors->any())
  <ul>
    @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
  </ul>
@endif

<form method="POST" action="{{ route('parcels.store') }}">
  @csrf
  <label>Nombre</label><br>
  <input name="name" value="{{ old('name') }}" required><br>

  <label>Area</label><br>
  <input name="area" value="{{ old('area') }}"><br>

  <label>Cultivo</label><br>
  <input name="crop" value="{{ old('crop') }}"><br>

  <label>Latitude</label><br>
  <input name="latitude" value="{{ old('latitude') }}"><br>

  <label>Longitude</label><br>
  <input name="longitude" value="{{ old('longitude') }}"><br>

  <label>Notas</label><br>
  <textarea name="notes">{{ old('notes') }}</textarea><br>

  <button>Guardar</button>
</form>
@endsection
