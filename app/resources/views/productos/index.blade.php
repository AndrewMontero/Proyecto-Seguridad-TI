@extends('layouts.app')

@section('title', 'Productos - AgroSensio')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">

    <!-- Navbar -->
    <nav class="bg-slate-800/50 backdrop-blur-sm border-b border-slate-700 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-8">
                    <a href="/" class="text-2xl font-bold text-green-400">AgroSensio</a>
                    <div class="hidden md:flex space-x-4">
                        <a href="/dashboard" class="text-gray-300 hover:text-white px-3 py-2 rounded-md transition">Dashboard</a>
                        <a href="/parcels" class="text-gray-300 hover:text-white px-3 py-2 rounded-md transition">Parcelas</a>
                        <a href="/productos" class="text-white bg-green-600 px-3 py-2 rounded-md">Productos</a>
                    </div>
                </div>
                <a href="/productos/crear" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                    + Nuevo Producto
                </a>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-white mb-2">Productos</h1>
            <p class="text-gray-400">Gestión de productos agrícolas</p>
        </div>

        <!-- Buscador -->
        <div class="mb-8">
            <form action="/productos" method="GET" class="flex gap-4">
                <input
                    type="text"
                    name="buscar"
                    value="{{ $busqueda ?? '' }}"
                    placeholder="Buscar productos..."
                    class="flex-1 px-4 py-3 bg-slate-800/50 border border-slate-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500"
                >
                <button
                    type="submit"
                    class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition font-semibold"
                >
                    Buscar
                </button>
                @if(isset($busqueda) && $busqueda !== '')
                    <a
                        href="/productos"
                        class="px-6 py-3 bg-slate-700 hover:bg-slate-600 text-white rounded-lg transition font-semibold"
                    >
                        Limpiar
                    </a>
                @endif
            </form>
        </div>

        <!-- Grid de Productos -->
        @if(isset($productos) && $productos->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($productos as $producto)
                <div class="bg-slate-800/50 backdrop-blur-sm border border-slate-700 rounded-xl p-6 hover:border-green-500 transition">
                    <div class="flex justify-between items-start mb-4">
                        <!-- ⚠️ VULNERABLE: XSS - nombre sin escapar -->
                        <h3 class="text-xl font-bold text-white">
                            {!! is_object($producto) ? $producto->nombre : $producto['nombre'] !!}
                        </h3>
                        <span class="text-green-400 font-bold text-lg">
                            €{{ number_format(is_object($producto) ? ($producto->precio ?? 0) : ($producto['precio'] ?? 0), 2) }}
                        </span>
                    </div>
                    <!-- ⚠️ VULNERABLE: XSS - descripción sin escapar -->
                    <p class="text-gray-400 mb-6">
                        {!! is_object($producto) ? ($producto->descripcion ?? '') : ($producto['descripcion'] ?? '') !!}
                    </p>
                    <div class="flex gap-3">
                        <a
                            href="/productos/{{ is_object($producto) ? $producto->id : $producto['id'] }}/editar"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg text-center transition font-semibold"
                        >
                            Editar
                        </a>
                        <form
                            action="/productos/{{ is_object($producto) ? $producto->id : $producto['id'] }}"
                            method="POST"
                            class="flex-1"
                            onsubmit="return confirm('¿Estás seguro de eliminar este producto?')"
                        >
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded-lg transition font-semibold"
                            >
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="bg-slate-800/50 backdrop-blur-sm border border-slate-700 rounded-xl p-12 text-center">
                <svg class="w-20 h-20 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <h3 class="text-2xl font-bold text-white mb-2">
                    @if(isset($busqueda) && $busqueda !== '')
                        No se encontraron resultados
                    @else
                        No hay productos registrados
                    @endif
                </h3>
                <p class="text-gray-400 mb-6">
                    @if(isset($busqueda) && $busqueda !== '')
                        Intenta con otros términos de búsqueda: "{{ $busqueda }}"
                    @else
                        Comienza agregando tu primer producto
                    @endif
                </p>
                @if(isset($busqueda) && $busqueda !== '')
                    <a
                        href="/productos"
                        class="inline-block px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition font-semibold"
                    >
                        Ver todos los productos
                    </a>
                @else
                    <a
                        href="/productos/crear"
                        class="inline-block px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition font-semibold"
                    >
                        + Crear primer producto
                    </a>
                @endif
            </div>
        @endif

    </div>
</div>
@endsection
