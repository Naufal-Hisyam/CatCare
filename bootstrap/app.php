<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckRole;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => CheckRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Kegagalan database (mis. saat menyimpan) ditampilkan sebagai pesan
        // yang jelas, bukan halaman error mentah Laravel.
        $exceptions->render(function (\Illuminate\Database\QueryException $e, \Illuminate\Http\Request $request) {
            report($e);

            if ($request->expectsJson()) {
                return response()->json(['message' => 'Terjadi kesalahan saat memproses data.'], 500);
            }

            if ($request->isMethod('GET')) {
                return response()->view('errors.500', [], 500);
            }

            return redirect()->back()->withInput()
                ->with('error', 'Data gagal disimpan karena terjadi kesalahan pada sistem. Silakan coba lagi.');
        });
    })->create();
