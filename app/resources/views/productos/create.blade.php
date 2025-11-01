<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Producto - AgroSensio</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white min-h-screen">
    <!-- Navbar -->
    <nav class="bg-gray-800 border-b border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-8">
                    <a href="/" class="text-2xl font-bold text-green-500">AgroSensio</a>
                    <div class="hidden md:flex space-x-4">
                        <a href="/dashboard" class="text-gray-300 hover:text-white transition">Dashboard</a>
                        <a href="/parcels" class="text-gray-300 hover:text-white transition">Parcelas</a>
                        <a href="/productos" class="text-white font-semibold">Productos</a>
                    </div>
                </div>
                <a href="/productos" class="text-gray-400 hover:text-white transition">
                    ← Volver
                </a>
            </div>
        </div>
    </nav>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold mb-2">Agregar Nuevo Producto</h1>
            <p class="text-gray-400">Completa el formulario para crear un producto</p>
        </div>

        <!-- Formulario -->
        <div class="bg-gray-800 border border-gray-700 rounded-xl p-8">
            <form method="POST" action="/productos/guardar" class="space-y-6">
                @csrf

                <!-- Nombre -->
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-300 mb-2">
                        Nombre del Producto <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        required
                        class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500"
                        placeholder="Ej: Fertilizante NPK"
                    >
                    @error('nombre')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Descripción -->
                <div>
                    <label for="descripcion" class="block text-sm font-medium text-gray-300 mb-2">
                        Descripción
                    </label>
                    <textarea
                        id="descripcion"
                        name="descripcion"
                        rows="4"
                        class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500"
                        placeholder="Describe las características del producto..."
                    ></textarea>
                    @error('descripcion')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Precio -->
                <div>
                    <label for="precio" class="block text-sm font-medium text-gray-300 mb-2">
                        Precio (€) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-3 text-gray-400">€</span>
                        <input
                            type="number"
                            id="precio"
                            name="precio"
                            step="0.01"
                            min="0"
                            required
                            class="w-full pl-10 pr-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500"
                            placeholder="0.00"
                        >
                    </div>
                    @error('precio')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Botones -->
                <div class="flex gap-4 pt-4">
                    <button
                        type="submit"
                        class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-lg transition"
                    >
                        Guardar Producto
                    </button>
                    <a
                        href="/productos"
                        class="flex-1 bg-gray-700 hover:bg-gray-600 text-white text-center font-semibold py-3 rounded-lg transition"
                    >
                        Cancelar
                    </a>
                </div>
            </form>
        </div>

        <!-- Ayuda -->
        <div class="mt-6 bg-blue-900/30 border border-blue-700 rounded-lg p-4">
            <p class="text-blue-400 text-sm">
                💡 <strong>Tip:</strong> Asegúrate de completar todos los campos obligatorios marcados con <span class="text-red-500">*</span>
            </p>
        </div>
    </div>
</body>
</html>
