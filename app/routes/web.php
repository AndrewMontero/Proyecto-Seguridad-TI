<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ParcelController;
use App\Http\Controllers\LecturaController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| RUTAS ORIGINALES
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/productos', [ProductoController::class, 'index']);
Route::get('/productos/crear', [ProductoController::class, 'create']);
Route::post('/productos/guardar', [ProductoController::class, 'store']);

// Resource completo para parcels (incluye destroy)
Route::resource('parcels', ParcelController::class);
// Esto genera automáticamente: index, create, store, show, edit, update, destroy



/*
|--------------------------------------------------------------------------
| RUTAS DE LECTURAS
|--------------------------------------------------------------------------
*/

Route::get('/lecturas', [LecturaController::class, 'index'])->name('lecturas.index');
Route::get('/lecturas/crear', [LecturaController::class, 'create'])->name('lecturas.create');
Route::post('/lecturas', [LecturaController::class, 'store'])->name('lecturas.store');
Route::get('/lecturas/{id}', [LecturaController::class, 'show'])->name('lecturas.show');
Route::delete('/lecturas/{id}', [LecturaController::class, 'destroy'])->name('lecturas.destroy');



/*
|--------------------------------------------------------------------------
| RUTAS DE AUTENTICACIÓN
|--------------------------------------------------------------------------
*/

// Mostrar formulario de login
Route::get('/login', function () {
    return view('demo.login');
})->name('login');

// Procesar login
Route::post('/login', function (Request $r) {
    $credentials = $r->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $r->session()->regenerate();
        return redirect()->intended('/dashboard');
    }

    return back()->withErrors([
        'email' => 'Las credenciales no coinciden con nuestros registros.',
    ])->withInput();
})->name('login.post');

// Mostrar formulario de registro
Route::get('/register', function () {
    return view('demo.register');
})->name('register');

// Procesar registro
Route::post('/register', function (Request $r) {
    $validated = $r->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6|confirmed',
    ]);

    $user = \App\Models\User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
    ]);

    Auth::login($user);
    return redirect('/dashboard')->with('success', 'Registro exitoso');
})->name('register.post');

// Logout
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/')->with('success', 'Sesión cerrada correctamente');
})->name('logout');



/*
|--------------------------------------------------------------------------
| VULNERABILIDAD A05 — SECURITY MISCONFIGURATION
| Exposición del archivo .env si APP_DEBUG=true
|--------------------------------------------------------------------------
*/
Route::get('/demo/leak-env', function (Request $request) {
    // Solo visible si APP_DEBUG=true
    if (config('app.debug') !== true) {
        abort(404);
    }

    $envPath = base_path('.env');
    if (!file_exists($envPath)) {
        return response('No .env file found', 200)->header('Content-Type', 'text/plain');
    }

    $content = file_get_contents($envPath);
    return response($content, 200)->header('Content-Type', 'text/plain');
});



/*
|--------------------------------------------------------------------------
| VULNERABILIDAD A10 — SSRF (Server-Side Request Forgery)
| Endpoint vulnerable: /fetch?url=<target>
|--------------------------------------------------------------------------
*/
Route::get('/fetch', function (Request $r) {
    $url = $r->query('url', '');

    if (empty($url)) {
        return response('Provide ?url=...', 400)->header('Content-Type', 'text/plain');
    }

    // ⚠️ VULNERABLE: sin validación ni lista blanca
    try {
        $context = stream_context_create(['http' => ['timeout' => 5]]);
        $content = @file_get_contents($url, false, $context);
        if ($content === false) {
            return response("Error fetching: $url", 500)->header('Content-Type', 'text/plain');
        }
        return response($content, 200)->header('Content-Type', 'text/plain');
    } catch (\Throwable $e) {
        return response('Fetch error: ' . $e->getMessage(), 500)->header('Content-Type', 'text/plain');
    }
});



/*
|--------------------------------------------------------------------------
| VULNERABILIDAD A07 — BROKEN AUTHENTICATION
| Contraseña débil + token de reset predecible
|--------------------------------------------------------------------------
*/

// DEMO LOGIN: acepta la contraseña débil "admin123" para cualquier usuario
Route::post('/demo-login', function (Request $r) {
    $email = $r->post('email');
    $password = $r->post('password');

    $user = \App\Models\User::where('email', $email)->first();
    if ($user && $password === 'admin123') {
        Auth::login($user);
        $r->session()->regenerate();
        return redirect('/dashboard')->with('success', 'Logged in (demo vulnerable).');
    }

    return back()->with('error', 'Invalid demo credentials');
})->name('demo-login');

// DEMO RESET REQUEST: genera tokens de reset predecibles
Route::post('/demo-reset-request', function (Request $r) {
    $email = $r->post('email');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return response('Invalid email', 400)->header('Content-Type', 'text/plain');
    }

    // ⚠️ Token predecible basado en email + tiempo
    $token = md5($email . floor(time() / 600));

    $path = storage_path('app/reset_tokens.json');
    $tokens = [];
    if (file_exists($path)) {
        $tokens = json_decode(file_get_contents($path), true) ?: [];
    }
    $tokens[$email] = ['token' => $token, 'created_at' => time()];
    file_put_contents($path, json_encode($tokens));

    // En demo mostramos el token directamente (mala práctica)
    return response("Demo reset token for $email: $token", 200)->header('Content-Type', 'text/plain');
});

// DEMO RESET VALIDATOR: valida tokens predecibles
Route::match(['get', 'post'], '/demo-reset', function (Request $r) {
    $email = $r->input('email');
    $token = $r->input('token');

    $path = storage_path('app/reset_tokens.json');
    $tokens = [];
    if (file_exists($path)) {
        $tokens = json_decode(file_get_contents($path), true) ?: [];
    }

    if (!isset($tokens[$email]) || $tokens[$email]['token'] !== $token) {
        return response('Invalid or expired token', 400)->header('Content-Type', 'text/plain');
    }

    return response("Token valid for $email — demo reset allowed", 200)->header('Content-Type', 'text/plain');
});



/*
|--------------------------------------------------------------------------
| DASHBOARD Y AUTENTICACIÓN
|--------------------------------------------------------------------------
*/

// Dashboard (requiere autenticación)
Route::get('/dashboard', function () {
    $totalParcelas = \App\Models\Parcel::count();
    $totalProductos = \App\Models\Producto::count();
    $lecturasHoy = 5; // Simulado
    $alertas = 2; // Simulado

    $ultimasParcelas = \App\Models\Parcel::latest()->take(3)->get();
    $ultimasLecturas = []; // Por ahora vacío

    return view('dashboard', compact(
        'totalParcelas',
        'totalProductos',
        'lecturasHoy',
        'alertas',
        'ultimasParcelas',
        'ultimasLecturas'
    ));
})->middleware('auth')->name('dashboard');
