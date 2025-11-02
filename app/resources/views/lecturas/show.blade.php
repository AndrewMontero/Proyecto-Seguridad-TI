<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle Lectura - AgroSensio</title>
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

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold mb-2">📊 Detalle de Lectura #{{ $lectura->id }}</h1>
            <p class="text-gray-400">Información completa de la lectura de sensores</p>
        </div>

        <!-- Tarjeta principal -->
        <div class="bg-gray-800 border border-gray-700 rounded-xl overflow-hidden mb-6">
            <!-- Header de la tarjeta -->
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                <h2 class="text-xl font-bold">
                    {!! $lectura->parcela_nombre ?? 'Sin parcela' !!}
                </h2>
                <p class="text-green-100 text-sm">
                    📅 {{ date('d/m/Y H:i:s', strtotime($lectura->fecha_lectura)) }}
                </p>
            </div>

            <!-- Contenido -->
            <div class="p-6">
                <!-- Grid de mediciones -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Temperatura -->
                    <div class="bg-gray-700/50 rounded-lg p-6 border border-gray-600">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-gray-400 text-sm">Temperatura</span>
                            <div class="text-3xl">🌡️</div>
                        </div>
                        <p class="text-4xl font-bold text-orange-400">
                            {{ $lectura->temperatura }}°C
                        </p>
                        <div class="mt-2 h-2 bg-gray-600 rounded-full overflow-hidden">
                            <div class="h-full bg-orange-400" style="width: {{ min(($lectura->temperatura / 50) * 100, 100) }}%"></div>
                        </div>
                    </div>

                    <!-- Humedad Ambiental -->
                    <div class="bg-gray-700/50 rounded-lg p-6 border border-gray-600">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-gray-400 text-sm">Humedad Ambiental</span>
                            <div class="text-3xl">💧</div>
                        </div>
                        <p class="text-4xl font-bold text-blue-400">
                            {{ $lectura->humedad }}%
                        </p>
                        <div class="mt-2 h-2 bg-gray-600 rounded-full overflow-hidden">
                            <div class="h-full bg-blue-400" style="width: {{ $lectura->humedad }}%"></div>
                        </div>
                    </div>

                    <!-- pH -->
                    <div class="bg-gray-700/50 rounded-lg p-6 border border-gray-600">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-gray-400 text-sm">pH del Suelo</span>
                            <div class="text-3xl">⚗️</div>
                        </div>
                        <p class="text-4xl font-bold text-green-400">
                            {{ $lectura->ph }}
                        </p>
                        <div class="mt-2 flex justify-between text-xs text-gray-500">
                            <span>Ácido</span>
                            <span>Neutro</span>
                            <span>Alcalino</span>
                        </div>
                        <div class="mt-1 h-2 bg-gray-600 rounded-full overflow-hidden">
                            <div class="h-full bg-green-400" style="width: {{ ($lectura->ph / 14) * 100 }}%"></div>
                        </div>
                    </div>

                    <!-- Humedad Suelo -->
                    <div class="bg-gray-700/50 rounded-lg p-6 border border-gray-600">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-gray-400 text-sm">Humedad del Suelo</span>
                            <div class="text-3xl">🌱</div>
                        </div>
                        <p class="text-4xl font-bold text-yellow-400">
                            {{ $lectura->humedad_suelo }}%
                        </p>
                        <div class="mt-2 h-2 bg-gray-600 rounded-full overflow-hidden">
                            <div class="h-full bg-yellow-400" style="width: {{ $lectura->humedad_suelo }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Información adicional -->
                <div class="border-t border-gray-700 pt-6 space-y-4">
                    @if($lectura->tipo_sensor)
                    <div class="flex items-start">
                        <div class="text-gray-400 w-32">📱 Sensor:</div>
                        <div class="text-white font-medium">{{ $lectura->tipo_sensor }}</div>
                    </div>
                    @endif

                    @if($lectura->notas)
                    <div class="flex items-start">
                        <div class="text-gray-400 w-32">📝 Notas:</div>
                        <div class="text-white flex-1">
                            <!-- ⚠️ VULNERABLE: XSS - muestra notas sin escapar -->
                            <div class="bg-gray-700/50 rounded-lg p-4 border border-gray-600">
                                {!! $lectura->notas !!}
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="flex items-start">
                        <div class="text-gray-400 w-32">🕒 Registrada:</div>
                        <div class="text-white">{{ date('d/m/Y H:i:s', strtotime($lectura->created_at)) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Acciones -->
        <div class="flex gap-4">
            <a href="/lecturas" class="flex-1 bg-gray-700 hover:bg-gray-600 text-center py-3 rounded-lg transition font-semibold">
                ← Volver a Lecturas
            </a>
            <form method="POST" action="/lecturas/{{ $lectura->id }}" class="flex-1" onsubmit="return confirm('¿Eliminar esta lectura?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 py-3 rounded-lg transition font-semibold">
                    🗑️ Eliminar Lectura
                </button>
            </form>
        </div>

        <!-- Alerta de vulnerabilidad IDOR -->
        <div class="mt-6 bg-red-900/30 border border-red-700 rounded-lg p-4">
            <p class="text-red-400 text-sm">
                ⚠️ <strong>Vulnerabilidad IDOR:</strong> Esta página no verifica permisos. Cualquiera puede ver lecturas cambiando el ID en la URL.
            </p>
        </div>
    </div>
</body>
</html>
