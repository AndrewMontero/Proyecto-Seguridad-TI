<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - AgroSensio</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">
        <!-- Card de Registro -->
        <div class="bg-gray-800 rounded-2xl shadow-2xl p-8 border border-gray-700">
            <!-- Logo/Título -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-white mb-2">AgroSensio</h1>
                <p class="text-gray-400">Crear nueva cuenta</p>
            </div>

            <!-- Formulario -->
            <form method="POST" action="{{ route('register.post') }}" class="space-y-5">
                @csrf

                <!-- Nombre -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Nombre completo</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        placeholder="Juan Pérez"
                    >
                    @error('name')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Correo electrónico</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        placeholder="correo@ejemplo.com"
                    >
                    @error('email')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contraseña -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Contraseña</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        placeholder="Mínimo 6 caracteres"
                    >
                    @error('password')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirmar Contraseña -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">Confirmar contraseña</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        required
                        class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        placeholder="Repite tu contraseña"
                    >
                </div>

                <!-- Botón de Registro -->
                <button
                    type="submit"
                    class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-lg transition duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-gray-800"
                >
                    Crear cuenta
                </button>
            </form>

            <!-- Link a Login -->
            <div class="mt-6 text-center">
                <p class="text-gray-400 text-sm">
                    ¿Ya tienes cuenta?
                    <a href="{{ route('login') }}" class="text-green-500 hover:text-green-400 font-medium transition">
                        Inicia sesión aquí
                    </a>
                </p>
            </div>

            <!-- Advertencia de Demo -->
            <div class="mt-6 p-4 bg-yellow-900/30 border border-yellow-700 rounded-lg">
                <p class="text-yellow-400 text-xs text-center">
                    ⚠️ <strong>Demo de Seguridad:</strong> Este formulario es parte de un entorno de prueba de vulnerabilidades.
                </p>
            </div>
        </div>

        <!-- Link a Home -->
        <div class="text-center mt-6">
            <a href="/" class="text-gray-500 hover:text-gray-400 text-sm transition">
                ← Volver al inicio
            </a>
        </div>
    </div>
</body>
</html>
