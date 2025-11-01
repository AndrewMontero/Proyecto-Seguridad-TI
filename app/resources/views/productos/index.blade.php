<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - AgroSensio</title>
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
                <a href="/productos/crear" class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg transition">
                    + Nuevo Producto
                </a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold mb-2">Productos</h1>
            <p class="text-gray-400">Gestión de productos agrícolas</p>
        </div>

        <!-- Buscador -->
        <div class="mb-6 bg-gray-800 border border-gray-700 rounded-xl p-4">
            <form method="GET" action="/productos" class="flex gap-3">
                <input
                    type="text"
                    name="search"
                    placeholder="Buscar productos..."
                    value="{{ request('search') }}"
                    class="flex-1 px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500"
                >
                <button type="submit" class="bg-green-600 hover:bg-green-700 px-6 py-2 rounded-lg transition">
                    Buscar
                </button>
            </form>
        </div>

        <!-- Grid de Productos -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @forelse($productos ?? [] as $producto)
            <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 hover:border-green-500 transition">
                <div class="flex justify-between items-start mb-4">
                    <!-- ⚠️ VULNERABLE: XSS - nombre sin escapar -->
                    <h3 class="text-xl font-bold text-white">{!! $producto->nombre ?? $producto->name !!}</h3>
                    <span class="bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-sm">
                        €{{ number_format($producto->precio ?? $producto->price ?? 0, 2) }}
                    </span>
                </div>

                <!-- ⚠️ VULNERABLE: XSS - descripción sin escapar -->
                <p class="text-gray-400 text-sm mb-4 line-clamp-2">
                    {!! $producto->descripcion ?? $producto->description ?? 'Sin descripción' !!}
                </p>

                <div class="flex gap-2">
                    <a href="/productos/{{ $producto->id }}/edit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-center py-2 rounded-lg transition text-sm">
                        Editar
                    </a>
                    <form method="POST" action="/productos/{{ $producto->id }}" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('¿Eliminar producto?')" class="w-full bg-red-600 hover:bg-red-700 py-2 rounded-lg transition text-sm">
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="col-span-full bg-gray-800 border border-gray-700 rounded-xl p-12 text-center">
                <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <h3 class="text-xl font-semibold text-gray-400 mb-2">No hay productos</h3>
                <p class="text-gray-500 mb-4">Comienza agregando tu primer producto</p>
                <a href="/productos/crear" class="inline-block bg-green-600 hover:bg-green-700 px-6 py-2 rounded-lg transition">
                    + Crear Producto
                </a>
            </div>
            @endforelse
        </div>

        <!-- Paginación -->
        @if(isset($productos) && method_exists($productos, 'links'))
        <div class="mt-6">
            {{ $productos->links() }}
        </div>
        @endif
    </div>

    <style>
        /* Estilos para paginación de Laravel con Tailwind */
        nav[role="navigation"] {
            @apply flex justify-center;
        }
        nav[role="navigation"] .flex {
            @apply gap-2;
        }
        nav[role="navigation"] a,
        nav[role="navigation"] span {
            @apply px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white transition;
        }
        nav[role="navigation"] a:hover {
            @apply bg-gray-700 border-green-500;
        }
        nav[role="navigation"] span[aria-current="page"] {
            @apply bg-green-600 border-green-600;
        }
        nav[role="navigation"] span[aria-disabled="true"] {
            @apply opacity-50 cursor-not-allowed;
        }
    </style>
</body>
</html>
