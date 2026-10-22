<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(api: __DIR__.'/../routes/api.php', commands: __DIR__.'/../routes/console.php', health: '/up')
    ->withMiddleware(function (Middleware $middleware): void {})
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (ValidationException $e, Request $request) {
            if ($request->is('api/*')) return response()->json(['message'=>'البيانات المدخلة غير صحيحة.','errors'=>$e->errors()],422);
        });
        $exceptions->render(function (AuthorizationException $e, Request $request) {
            if ($request->is('api/*')) return response()->json(['message'=>'ليس لديك صلاحية لتنفيذ هذا الإجراء.'],403);
        });
        $exceptions->render(function (ModelNotFoundException|NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) return response()->json(['message'=>'العنصر المطلوب غير موجود.'],404);
        });
        $exceptions->render(function (\Throwable $e, Request $request) {
            if ($request->is('api/*') && app()->hasDebugModeEnabled()) return null;
            if ($request->is('api/*')) return response()->json(['message'=>'حدث خطأ داخلي.'],500);
        });
    })->create();
