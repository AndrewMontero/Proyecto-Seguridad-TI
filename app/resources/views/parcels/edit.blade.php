@extends('layouts.app')

@section('title', 'Editar Parcela - AgroSenso')

@section('content')
<div class="max-w-4xl mx-auto px-4">

    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('parcels.index') }}" class="text-green-600 hover:text-green-700 mb-4 inline-flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Volver a Parcelas
        </a>
        <h1 class="text-3xl font-bold text-gray-800 mt-4">
            <i class="fas fa-edit text-green-600"></i>
            Editar Parcela: {{ $parcel->name }}
        </h1>
        <p class="text-gray-600 mt-2">Actualiza la información de tu parcela</p>
    </div>

    <!-- Formulario -->
    <div class="bg-white rounded-xl shadow-lg p-8">
        <form action="{{ route('parcels.update', $parcel->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Nombre de la parcela -->
            <div class="mb-6">
                <label for="name" class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-signature text-green-600"></i>
                    Nombre de la Parcela *
                </label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $parcel->name) }}"
                    required
                    placeholder="Ej: Parcela Norte, Lote 5, etc."
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('name') border-red-500 @enderror"
                >
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Ubicación -->
            <div class="mb-6">
                <label for="location" class="block text-gray-700 font-semibold mb-
