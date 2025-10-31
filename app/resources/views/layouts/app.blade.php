<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'AgroSenso Lite')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Animaciones suaves */
        * {
            transition: all 0.3s ease;
        }

        /* Gradient personalizado */
        .bg-agro-gradient {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
        }

        /* Hover effects */
        .hover-scale:hover {
            transform: scale(1.05);
        }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50">

    <!-- Navbar -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo y nombre -->
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-3">
                        <div class="bg-agro-gradient p-2 rounded-lg">
                            <i class="fas fa-seedling text-white text-2xl"></i>
                        </div>
                        <span class="text-2xl font-bold text-gray-800">
                            Agro<span class="text-green-600">Senso</span> Lite
                        </span>
                    </a>
                </div>

                <!-- Menu principal -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="/dashboard" class="text-gray-700 hover:text-green-600 px-3 py-2 rounded-md text-sm font-medium flex items-center">
                        <i class="fas fa-home mr-2"></i> Dashboard
                    </a>
                    <a href="/parcels" class="text-gray-700 hover:text-green-600 px-3 py-2 rounded-md text-sm font-medium flex items-center">
                        <i class="fas fa-map-marked-alt mr-2"></i> Parcelas
                    </a>
                    <a href="/productos" class="text-gray-700 hover:text-green-600 px-3 py-2 rounded-md text-sm font-medium flex items-center">
                        <i class="fas fa-box mr-2"></i> Productos
                    </a>
                    <a href="/lecturas" class="text-gray-700 hover:text-green-600 px-3 py-2 rounded-md text-sm font-medium flex items-center">
                        <i class="fas fa-temperature-high mr-2"></i> Lecturas
                    </a>
                </div>

                <!-- Usuario -->
                <div class="flex items-center space-x-4">
                    @auth
                        <div class="flex items-center space-x-3">
                            <span class="text-sm text-gray-700">
                                <i class="fas fa-user-circle text-green-600"></i>
                                {{ Auth::user()->name }}
                            </span>
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm">
                                    <i class="fas fa-sign-out-alt mr-1"></i> Salir
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="/login" class="text-gray-700 hover:text-green-600 px-3 py-2 rounded-md text-sm font-medium">
                            Iniciar Sesión
                        </a>
                        <a href="/register" class="bg-agro-gradient text-white px-4 py-2 rounded-lg text-sm hover-scale">
                            Registrarse
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" class="text-gray-700 hover:text-green-600">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="/dashboard" class="block text-gray-700 hover:bg-green-50 px-3 py-2 rounded-md">
                    <i class="fas fa-home mr-2"></i> Dashboard
                </a>
                <a href="/parcels" class="block text-gray-700 hover:bg-green-50 px-3 py-2 rounded-md">
                    <i class="fas fa-map-marked-alt mr-2"></i> Parcelas
                </a>
                <a href="/productos" class="block text-gray-700 hover:bg-green-50 px-3 py-2 rounded-md">
                    <i class="fas fa-box mr-2"></i> Productos
                </a>
                <a href="/lecturas" class="block text-gray-700 hover:bg-green-50 px-3 py-2 rounded-md">
                    <i class="fas fa-temperature-high mr-2"></i> Lecturas
                </a>
            </div>
        </div>
    </nav>

    <!-- Mensajes Flash -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 mt-4">
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-3 text-xl"></i>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 mt-4">
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-3 text-xl"></i>
                    <p>{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Contenido principal -->
    <main class="py-6">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12">
        <div class="max-w-7xl mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">AgroSenso Lite</h3>
                    <p class="text-gray-400 text-sm">
                        Sistema de gestión agrícola inteligente para el monitoreo y control de parcelas.
                    </p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Enlaces</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="/dashboard" class="hover:text-white">Dashboard</a></li>
                        <li><a href="/parcels" class="hover:text-white">Mis Parcelas</a></li>
                        <li><a href="/productos" class="hover:text-white">Productos</a></li>
                        <li><a href="/lecturas" class="hover:text-white">Lecturas</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contacto</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><i class="fas fa-envelope mr-2"></i> info@agrosenso.com</li>
                        <li><i class="fas fa-phone mr-2"></i> +506 1234-5678</li>
                        <li><i class="fas fa-map-marker-alt mr-2"></i> Costa Rica</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-6 text-center text-sm text-gray-400">
                <p>&copy; 2024 AgroSenso Lite. Proyecto Seguridad TI.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Auto-hide flash messages
        setTimeout(function() {
            const alerts = document.querySelectorAll('[role="alert"]');
            alerts.forEach(alert => {
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            });
        }, 5000);
    </script>

    @stack('scripts')
</body>
</html>
