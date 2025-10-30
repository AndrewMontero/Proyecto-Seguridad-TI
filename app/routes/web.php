<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ParcelController;
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
Route::resource('parcels', ParcelController::class);
// Esto generará index, create, store, show, edit, update, destroy



/*
|--------------------------------------------------------------------------
| VULNERABILIDAD A — SECURITY MISCONFIGURATION
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
| VULNERABILIDAD B — SSRF (Server-Side Request Forgery)
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
| VULNERABILIDAD C — BROKEN AUTHENTICATION
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
        return redirect('/')->with('success', 'Logged in (demo vulnerable).');
    }

    return back()->with('error', 'Invalid demo credentials');
});

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
