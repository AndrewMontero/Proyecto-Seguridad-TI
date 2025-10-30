<?php
// app/Http/Controllers/DemoController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DemoController extends Controller
{
    // Misconfiguration: show .env when debug=true
    public function leakEnv(Request $request)
    {
        if (config('app.debug') !== true) {
            abort(404);
        }

        $envPath = base_path('.env');
        if (!file_exists($envPath)) {
            return response('No .env file found', 200)->header('Content-Type', 'text/plain');
        }

        return response(file_get_contents($envPath), 200)->header('Content-Type', 'text/plain');
    }

    // SSRF: fetch content (GET)
    public function fetch(Request $r)
    {
        $url = $r->query('url', '');
        if (empty($url)) {
            // show simple form view if no url param
            return view('demo.fetch');
        }

        try {
            $context = stream_context_create(['http' => ['timeout' => 5]]);
            $content = @file_get_contents($url, false, $context);
            if ($content === false) {
                return response("Error fetching: $url", 500)->header('Content-Type','text/plain');
            }
            return response($content, 200)->header('Content-Type','text/plain');
        } catch (\Throwable $e) {
            return response('Fetch error: '.$e->getMessage(), 500)->header('Content-Type','text/plain');
        }
    }

    // Demo login (weak password)
    public function showLogin()
    {
        return view('demo.login');
    }

    public function demoLogin(Request $r)
    {
        $email = $r->post('email');
        $password = $r->post('password');

        $user = \App\Models\User::where('email', $email)->first();
        if ($user && $password === 'admin123') {
            Auth::login($user);
            return redirect('/')->with('success','Logged in (demo vulnerable).');
        }

        return back()->with('error','Invalid demo credentials');
    }

    // Demo reset request (predictable token)
    public function showResetRequest()
    {
        return view('demo.reset-request');
    }

    public function demoResetRequest(Request $r)
    {
        $email = $r->post('email');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return back()->with('error','Invalid email');
        }

        $token = md5($email . floor(time() / 600));
        $path = storage_path('app/reset_tokens.json');
        $tokens = [];
        if (file_exists($path)) {
            $tokens = json_decode(file_get_contents($path), true) ?: [];
        }
        $tokens[$email] = ['token' => $token, 'created_at' => time()];
        file_put_contents($path, json_encode($tokens));

        return response("Demo reset token for $email: $token", 200)->header('Content-Type','text/plain');
    }

    // Demo reset validation
    public function showReset()
    {
        return view('demo.reset');
    }

    public function demoReset(Request $r)
    {
        $email = $r->input('email');
        $token = $r->input('token');

        $path = storage_path('app/reset_tokens.json');
        $tokens = [];
        if (file_exists($path)) {
            $tokens = json_decode(file_get_contents($path), true) ?: [];
        }

        if (!isset($tokens[$email]) || $tokens[$email]['token'] !== $token) {
            return response('Invalid or expired token', 400)->header('Content-Type','text/plain');
        }

        return response("Token valid for $email — demo reset allowed", 200)->header('Content-Type','text/plain');
    }
}
