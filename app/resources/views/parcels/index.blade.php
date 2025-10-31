@extends('layouts.app')

@section('title', 'Mis Parcelas - AgroSenso')

@section('content')
<div class="max-w-7xl mx-auto px-4">

    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-map-marked-alt text-green-600"></i>
                Mis Parcelas
            </h1>
            <p class="text-gray-600 mt-2">Gestiona todas tus parcelas agrícolas</p>
        </div>
        <a href="{{ route('parcels.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold flex items-center shadow-lg hover-scale">
            <i class="fas fa-plus mr-2"></i>
            Nueva Parcela
        </a>
    </div>

    <!-- Estadísticas rápidas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Parcelas</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $parcels->count() }}</h3>
                </div>
                <i class="fas fa-map-marked-alt text-green-600 text-3xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Área Total</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $parcels->sum('area') }} ha</h3>
                </div>
                <i class="fas fa-expand-arrows-alt text-blue-600 text-3xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Cultivos</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $parcels->pluck('crop')->unique()->count() }}</h3>
                </div>
                <i class="fas fa-seedling text-yellow-600 text-3xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Activas</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $parcels->count() }}</h3>
                </div>
                <i class="fas fa-check-circle text-purple-600 text-3xl"></i>
            </div>
        </div>
    </div>

    <!-- Filtros y búsqueda -->
    <div class="bg-white rounded-lg shadow-lg p-4 mb-6">
        <form method="GET" action="{{ route('parcels.index') }}" class="flex gap-4">
            <div class="flex-1">
                <input
                    type="text"
                    name="search"
                    placeholder="Buscar por nombre o ubicación..."
                    value="{{ request('search') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                >
            </div>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg">
                <i class="fas fa-search mr-2"></i>
                Buscar
            </button>
        </form>
    </div>

    <!-- Lista de parcelas -->
    @if($parcels->isEmpty())
        <div class="bg-white rounded-lg shadow-lg p-12 text-center">
            <i class="fas fa-seedling text-gray-300 text-6xl mb-4"></i>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">No tienes parcelas registradas</h3>
            <p class="text-gray-600 mb-6">Comienza creando tu primera parcela agrícola</p>
            <a href="{{ route('parcels.create') }}" class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold">
                <i class="fas fa-plus mr-2"></i>
                Crear Primera Parcela
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($parcels as $parcel)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition group">

                    <!-- Header de la tarjeta con imagen de fondo -->
                    <div class="h-40 bg-gradient-to-br from-green-400 to-green-600 relative">
                        <div class="absolute inset-0 bg-black bg-opacity-20 flex items-center justify-center">
                            <i class="fas fa-map-marked-alt text-white text-6xl opacity-30"></i>
                        </div>
                        <div class="absolute top-4 right-4">
                            <span class="bg-white bg-opacity-90 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">
                                <i class="fas fa-seedling mr-1"></i>
                                {{ $parcel->crop ?? 'Sin cultivo' }}
                            </span>
                        </div>
                    </div>

                    <!-- Contenido de la tarjeta -->
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-green-600 transition">
                            {{ $parcel->name }}
                        </h3>

                        <div class="space-y-2 text-sm text-gray-600 mb-4">
                            <div class="flex items-center">
                                <i class="fas fa-map-marker-alt text-red-500 w-5"></i>
                                <span>{{ $parcel->location ?? 'Sin ubicación' }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-expand-arrows-alt text-blue-500 w-5"></i>
                                <span>{{ $parcel->area ?? 0 }} hectáreas</span>
                            </div>
                            @if($parcel->notes)
                                <div class="flex items-start">
                                    <i class="fas fa-sticky-note text-yellow-500 w-5 mt-1"></i>
                                    <span class="line-clamp-2">{{ Str::limit($parcel->notes, 50) }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Estado simulado -->
                        <div class="flex items-center mb-4 text-sm">
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center">
                                    <i class="fas fa-thermometer-half text-orange-500 mr-1"></i>
                                    <span class="text-gray-700">{{ rand(20, 30) }}°C</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-tint text-blue-500 mr-1"></i>
                                    <span class="text-gray-700">{{ rand(60, 80) }}%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="flex gap-2">
                            <a href="{{ route('parcels.show', $parcel->id) }}"
                               class="flex-1 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-center text-sm transition">
                                <i class="fas fa-eye mr-1"></i>
                                Ver
                            </a>
                            <a href="{{ route('parcels.edit', $parcel->id) }}"
                               class="flex-1 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-center text-sm transition">
                                <i class="fas fa-edit mr-1"></i>
                                Editar
                            </a>
                            <form action="{{ route('parcels.destroy', $parcel->id) }}"
                                  method="POST"
                                  class="inline"
                                  onsubmit="return confirm('¿Estás seguro de eliminar esta parcela?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm transition">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Footer con fecha -->
                    <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
                        <p class="text-xs text-gray-500">
                            <i class="fas fa-clock mr-1"></i>
                            Actualizada: {{ $parcel->updated_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Paginación -->
        <div class="mt-8">
            {{ $parcels->links() }}
        </div>
    @endif
</div>

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush
@endsection
