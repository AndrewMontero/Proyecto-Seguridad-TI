<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - AgroSensio</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white">
    <!-- Navbar -->
    <nav class="bg-gray-800 border-b border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-green-500">AgroSensio</h1>
                    <span class="ml-4 text-gray-400">Dashboard</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-300">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg transition">
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Mensaje de éxito -->
        @if(session('success'))
        <div class="mb-6 bg-green-900/50 border border-green-700 text-green-300 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
        @endif

        <!-- Tarjetas de Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Parcelas -->
            <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 hover:border-green-500 transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Total Parcelas</p>
                        <p class="text-3xl font-bold text-white mt-2">{{ $totalParcelas }}</p>
                    </div>
                    <div class="bg-green-500/20 p-3 rounded-lg">
                        <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Productos -->
            <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 hover:border-blue-500 transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Total Productos</p>
                        <p class="text-3xl font-bold text-white mt-2">{{ $totalProductos }}</p>
                    </div>
                    <div class="bg-blue-500/20 p-3 rounded-lg">
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Lecturas Hoy -->
            <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 hover:border-yellow-500 transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Lecturas Hoy</p>
                        <p class="text-3xl font-bold text-white mt-2">{{ $lecturasHoy }}</p>
                    </div>
                    <div class="bg-yellow-500/20 p-3 rounded-lg">
                        <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Alertas -->
            <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 hover:border-red-500 transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Alertas Activas</p>
                        <p class="text-3xl font-bold text-white mt-2">{{ $alertas }}</p>
                    </div>
                    <div class="bg-red-500/20 p-3 rounded-lg">
                        <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grid de dos columnas -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- Últimas Parcelas -->
            <div class="bg-gray-800 border border-gray-700 rounded-xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold">Últimas Parcelas</h2>
                    <a href="/parcels" class="text-green-500 hover:text-green-400 text-sm">Ver todas →</a>
                </div>

                @if($ultimasParcelas->count() > 0)
                    <div class="space-y-3">
                        @foreach($ultimasParcelas as $parcela)
                        <div class="bg-gray-700/50 rounded-lg p-4 hover:bg-gray-700 transition">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-semibold">{{ $parcela->name }}</p>
                                    <p class="text-sm text-gray-400">{{ $parcela->area }} m²</p>
                                </div>
                                <a href="/parcels/{{ $parcela->id }}" class="text-green-500 hover:text-green-400">
                                    Ver →
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-400 text-center py-8">No hay parcelas registradas</p>
                @endif
            </div>

            <!-- Accesos Rápidos -->
            <div class="bg-gray-800 border border-gray-700 rounded-xl p-6">
                <h2 class="text-xl font-bold mb-4">Accesos Rápidos</h2>
                <div class="space-y-3">
                    <a href="/parcels/create" class="block bg-green-600 hover:bg-green-700 text-center py-3 rounded-lg transition">
                        ➕ Nueva Parcela
                    </a>
                    <a href="/productos/crear" class="block bg-blue-600 hover:bg-blue-700 text-center py-3 rounded-lg transition">
                        ➕ Nuevo Producto
                    </a>
                    <a href="/parcels" class="block bg-gray-700 hover:bg-gray-600 text-center py-3 rounded-lg transition">
                        📋 Ver Parcelas
                    </a>
                    <a href="/productos" class="block bg-gray-700 hover:bg-gray-600 text-center py-3 rounded-lg transition">
                        📦 Ver Productos
                    </a>
                </div>
            </div>
        </div>

        <!-- Advertencia de Demo -->
        <div class="mt-8 bg-yellow-900/30 border border-yellow-700 rounded-xl p-6">
            <div class="flex items-start space-x-3">
                <svg class="w-6 h-6 text-yellow-500 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <div>
                    <h3 class="text-yellow-500 font-semibold mb-1">⚠️ Entorno de Demostración de Vulnerabilidades</h3>
                    <p class="text-yellow-300 text-sm">Este sistema contiene vulnerabilidades intencionales para propósitos educativos. No usar en producción.</p>
                </div>
            </div>
        </div>

    </div>
</body>
</html>
