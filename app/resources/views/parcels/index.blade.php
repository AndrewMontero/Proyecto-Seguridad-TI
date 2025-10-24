@extends('layouts.app') {{-- si usas layout, si no usa HTML básico --}}
@section('content')
<h1>Parcelas</h1>

<form method="GET" action="{{ route('parcels.index') }}">
    <input type="text" name="q" value="{{ old('q', $q ?? '') }}" placeholder="Buscar por nombre o cultivo">
    <button>Buscar</button>
    <a href="{{ route('parcels.create') }}">Nueva parcela</a>
</form>

@if(session('success')) <div>{{ session('success') }}</div> @endif

<ul>
@foreach($parcels as $p)
  <li>
    <a href="{{ route('parcels.show', $p) }}">{{ $p->name }}</a>
    — {{ $p->crop ?? '—' }} — {{ $p->area ? $p->area.' ha' : '' }}
    <a href="{{ route('parcels.edit', $p) }}">Editar</a>
    <form method="POST" action="{{ route('parcels.destroy',$p) }}" style="display:inline">
      @csrf
      @method('DELETE')
      <button onclick="return confirm('Eliminar parcela?')">Eliminar</button>
    </form>
  </li>
@endforeach
</ul>

{{ $parcels->withQueryString()->links() }}
@endsection
