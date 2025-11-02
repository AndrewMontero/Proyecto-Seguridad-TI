@extends('layouts.app')

@section('title', 'Lecturas - AgroSenso')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            <i class="fas fa-chart-line text-green-600 mr-3"></i>
            Lecturas de Sensores
        </h1>
        <a href="/lecturas/crear" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition">
            <i class="fas fa-plus mr-2"></i>
            Nueva Lectura
        </a>
    </div>

    <!-- Tabla de lecturas -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        ID
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Parcela
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Fecha
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Datos
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($lecturas as $lectura)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ is_array($lectura) ? $lectura['id'] : $lectura->id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @if(is_array($lectura))
                            {{ $lectura['parcela_nombre'] ?? 'N/A' }}
                        @else
                            {{ $lectura->parcela->nombre ?? 'N/A' }}
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ is_array($lectura) ? $lectura['fecha_lectura'] : $lectura->fecha_lectura }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        @php
                            $datos = is_array($lectura) ? ($lectura['datos'] ?? '') : ($lectura->datos ?? '');
                        @endphp
                        {{ substr($datos, 0, 50) }}@if(strlen($datos) > 50)...@endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        @php
                            $lecturaId = is_array($lectura) ? $lectura['id'] : $lectura->id;
                        @endphp
                        <a href="/lecturas/{{ $lecturaId }}" class="text-blue-600 hover:text-blue-900 mr-3">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="/lecturas/{{ $lecturaId }}/editar" class="text-green-600 hover:text-green-900 mr-3">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="/lecturas/{{ $lecturaId }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Estás seguro?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                        <i class="fas fa-info-circle mr-2"></i>
                        No hay lecturas registradas
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
