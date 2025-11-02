<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Lectura - AgroSensio</title>
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
                        <a href="/productos" class="text-gray-300 hover:text-white transition">Productos</a>
                        <a href="/lecturas" class="text-white font-semibold">Lecturas</a>
                    </div>
                </div>
                <a href="/lecturas" class="text-gray-400 hover:text-white transition">
                    ← Volver
                </a>
            </div>
        </div>
    </nav>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold mb-2">📊 Nueva Lectura de Sensores</h1>
            <p class="text-gray-400">Registra una nueva lectura de condiciones ambientales</p>
        </div>

        <!-- Formulario -->
        <div class="bg-gray-800 border border-gray-700 rounded-xl p-8">
            <form method="POST" action="/lecturas" class="space-y-6">
                @csrf

                <!-- Parcela -->
                <div>
                    <label for="parcel_id" class="block text-sm font-medium text-gray-300 mb-2">
                        Parcela <span class="text-red-500">*</span>
                    </label>
                    <select
                        id="parcel_id"
                        name="parcel_id"
                        required
                        class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-green-500"
                    >
                        <option value="">Selecciona una parcela</option>
                        @foreach($parcelas as $parcela)
                        <option value="{{ $parcela->id }}">{{ $parcela->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Grid 2 columnas -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Temperatura -->
                    <div>
                        <label for="temperatura" class="block text-sm font-medium text-gray-300 mb-2">
                            🌡️ Temperatura (°C)
                        </label>
                        <input
                            type="number"
                            id="temperatura"
                            name="temperatura"
                            step="0.01"
                            placeholder="25.5"
                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500"
                        >
                    </div>

                    <!-- Humedad -->
                    <div>
                        <label for="humedad" class="block text-sm font-medium text-gray-300 mb-2">
                            💧 Humedad Ambiental (%)
                        </label>
                        <input
                            type="number"
                            id="humedad"
                            name="humedad"
                            step="0.01"
                            max="100"
                            placeholder="75.5"
                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500"
                        >
                    </div>

                    <!-- pH -->
                    <div>
                        <label for="ph" class="block text-sm font-medium text-gray-300 mb-2">
                            ⚗️ pH del Suelo
                        </label>
                        <input
                            type="number"
                            id="ph"
                            name="ph"
                            step="0.01"
                            min="0"
                            max="14"
                            placeholder="6.5"
                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500"
                        >
                    </div>

                    <!-- Humedad Suelo -->
                    <div>
                        <label for="humedad_suelo" class="block text-sm font-medium text-gray-300 mb-2">
                            🌱 Humedad del Suelo (%)
                        </label>
                        <input
                            type="number"
                            id="humedad_suelo"
                            name="humedad_suelo"
                            step="0.01"
                            max="100"
                            placeholder="65.0"
                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500"
                        >
                    </div>
                </div>

                <!-- Tipo de Sensor -->
                <div>
                    <label for="tipo_sensor" class="block text-sm font-medium text-gray-300 mb-2">
                        📱 Tipo de Sensor
                    </label>
                    <input
                        type="text"
                        id="tipo_sensor"
                        name="tipo_sensor"
                        placeholder="DHT22, DS18B20, etc."
                        class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500"
                    >
                </div>

                <!-- Fecha de Lectura -->
                <div>
                    <label for="fecha_lectura" class="block text-sm font-medium text-gray-300 mb-2">
                        📅 Fecha y Hora de Lectura
                    </label>
                    <input
                        type="datetime-local"
                        id="fecha_lectura"
                        name="fecha_lectura"
                        value="{{ now()->format('Y-m-d\TH:i') }}"
                        class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-green-500"
                    >
                </div>

                <!-- Notas (Vulnerable a XSS) -->
                <div>
                    <label for="notas" class="block text-sm font-medium text-gray-300 mb-2">
                        📝 Notas / Observaciones
                    </label>
                    <textarea
                        id="notas"
                        name="notas"
                        rows="4"
                        placeholder="Observaciones sobre las condiciones de la parcela..."
                        class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500"
                    ></textarea>
                    <p class="text-xs text-gray-500 mt-1">⚠️ Campo vulnerable a XSS (demo)</p>
                </div>

                <!-- Botones -->
                <div class="flex gap-4 pt-4">
                    <button
                        type="submit"
                        class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-lg transition"
                    >
                        💾 Guardar Lectura
                    </button>
                    <a
                        href="/lecturas"
                        class="flex-1 bg-gray-700 hover:bg-gray-600 text-white text-center font-semibold py-3 rounded-lg transition"
                    >
                        Cancelar
                    </a>
                </div>
            </form>
        </div>

        <!-- Info de vulnerabilidad -->
        <div class="mt-6 bg-yellow-900/30 border border-yellow-700 rounded-lg p-4">
            <p class="text-yellow-400 text-sm">
                ⚠️ <strong>Demo:</strong> Este formulario no valida entradas y es vulnerable a XSS. Las notas se guardan sin sanitizar.
            </p>
        </div>
    </div>
</body>
</html>
