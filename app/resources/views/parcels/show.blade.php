@extends('layouts.app')
@section('content')
<h1>{{ $parcel->name }}</h1>
<p><strong>Cultivo:</strong> {{ $parcel->crop ?? '—' }}</p>
<p><strong>Area:</strong> {{ $parcel->area ?? '—' }}</p>
<p><strong>Coordenadas:</strong> {{ $parcel->latitude ?? '—' }}, {{ $parcel->longitude ?? '—' }}</p>
<p><strong>Notas:</strong><br>{{ $parcel->notes ?? 'Sin notas' }}</p>

<a href="{{ route('parcels.edit', $parcel) }}">Editar</a>
<a href="{{ route('parcels.index') }}">Volver</a>
@endsection
