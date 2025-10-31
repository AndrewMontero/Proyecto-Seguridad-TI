@extends('layouts.app')

@section('title', 'Nueva Parcela - AgroSenso')

@section('content')
<div class="max-w-4xl mx-auto px-4">

    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('parcels.index') }}" class="text-green-600 hover:text-green-700 mb-4 inline-flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Volver a Parcelas
        </a>
        <h1 class="text-3xl font-bold text-gray-800 mt-4">
            <i class="fas fa-plus-circle text-green-600"></i>
            Crear Nueva Parcela
        </h1>
        <p class="text-gray-600 mt-2">Registra una nueva parcela para comenzar a monitorearla</p>
    </div>

    <!-- Formulario -->
    <div class="bg-white rounded-xl shadow-lg p-8">
        <form action="{{ route('parcels.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

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
                    value="{{ old('name') }}"
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
                <label for="location" class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-map-marker-alt text-red-600"></i>
                    Ubicación
                </label>
                <input
                    type="text"
                    id="location"
                    name="location"
                    value="{{ old('location') }}"
                    placeholder="Ej: Sector A, Coordenadas GPS, etc."
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                >
            </div>

            <!-- Área y Cultivo en dos columnas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                <!-- Área -->
                <div>
                    <label for="area" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-expand-arrows-alt text-blue-600"></i>
                        Área (hectáreas)
                    </label>
                    <input
                        type="number"
                        id="area"
                        name="area"
                        value="{{ old('area') }}"
                        step="0.01"
                        min="0"
                        placeholder="Ej: 2.5"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                    >
                </div>

                <!-- Tipo de Cultivo -->
                <div>
                    <label for="crop" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-seedling text-yellow-600"></i>
                        Tipo de Cultivo
                    </label>
                    <select
                        id="crop"
                        name="crop"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                    >
                        <option value="">Seleccionar cultivo...</option>
                        <option value="Café" {{ old('crop') == 'Café' ? 'selected' : '' }}>☕ Café</option>
                        <option value="Maíz" {{ old('crop') == 'Maíz' ? 'selected' : '' }}>🌽 Maíz</option>
                        <option value="Frijol" {{ old('crop') == 'Frijol' ? 'selected' : '' }}>🫘 Frijol</option>
                        <option value="Arroz" {{ old('crop') == 'Arroz' ? 'selected' : '' }}>🌾 Arroz</option>
                        <option value="Tomate" {{ old('crop') == 'Tomate' ? 'selected' : '' }}>🍅 Tomate</option>
                        <option value="Plátano" {{ old('crop') == 'Plátano' ? 'selected' : '' }}>🍌 Plátano</option>
                        <option value="Caña de azúcar" {{ old('crop') == 'Caña de azúcar' ? 'selected' : '' }}>🎋 Caña de azúcar</option>
                        <option value="Piña" {{ old('crop') == 'Piña' ? 'selected' : '' }}>🍍 Piña</option>
                        <option value="Otro" {{ old('crop') == 'Otro' ? 'selected' : '' }}>🌱 Otro</option>
                    </select>
                </div>
            </div>

            <!-- Notas -->
            <div class="mb-6">
                <label for="notes" class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-sticky-note text-yellow-600"></i>
                    Notas Adicionales
                </label>
                <textarea
                    id="notes"
                    name="notes"
                    rows="4"
                    placeholder="Agrega cualquier información relevante sobre esta parcela..."
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                >{{ old('notes') }}</textarea>
            </div>

            <!-- Foto de la parcela (opcional) -->
            <div class="mb-6">
                <label for="photo" class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-camera text-purple-600"></i>
                    Foto de la Parcela (opcional)
                </label>
                <div class="flex items-center justify-center w-full">
                    <label for="photo" class="flex flex-col items-center justify-center w-full h-40 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <i class="fas fa-cloud-upload-alt text-gray-400 text-4xl mb-3"></i>
                            <p class="mb-2 text-sm text-gray-500">
                                <span class="font-semibold">Click para subir</span> o arrastra y suelta
                            </p>
                            <p class="text-xs text-gray-500">PNG, JPG o JPEG (MAX. 5MB)</p>
                        </div>
                        <input id="photo" name="photo" type="file" accept="image/*" class="hidden" />
                    </label>
                </div>
                <p class="text-xs text-gray-500 mt-2">
                    <i class="fas fa-info-circle"></i>
                    Sube una foto para identificar mejor tu parcela
                </p>
            </div>

            <!-- Botones -->
            <div class="flex gap-4">
                <button
                    type="submit"
                    class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition flex items-center justify-center shadow-lg hover-scale"
                >
                    <i class="fas fa-save mr-2"></i>
                    Crear Parcela
                </button>
                <a
                    href="{{ route('parcels.index') }}"
                    class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 px-6 rounded-lg transition text-center"
                >
                    <i class="fas fa-times mr-2"></i>
                    Cancelar
                </a>
            </div>
        </form>
    </div>

    <!-- Info card -->
    <div class="mt-8 bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg">
        <div class="flex items-start">
            <i class="fas fa-info-circle text-blue-600 text-2xl mr-4 mt-1"></i>
            <div>
                <h3 class="text-lg font-bold text-blue-900 mb-2">Consejos para registrar tu parcela</h3>
                <ul class="text-sm text-blue-800 space-y-1">
                    <li>• Usa nombres descriptivos para identificar fácilmente tus parcelas</li>
                    <li>• Registra la ubicación exacta para referencias futuras</li>
                    <li>• El área te ayudará a calcular rendimientos por hectárea</li>
                    <li>• Las notas son útiles para registrar características especiales del terreno</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Preview de imagen
    document.getElementById('photo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Mostrar preview (opcional)
                console.log('Imagen seleccionada:', file.name);
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
@endsection
