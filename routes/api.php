<?php

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\ActivityController;
    

    // Ruta para obtener usuario autenticado
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:api');

    // Rutas públicas de autenticación
    Route::post('auth.login', [AuthController::class, 'login'])->name('api.login');
    Route::post('auth.register', [AuthController::class, 'register'])->name('api.register');

    // Rutas públicas para consultar actividades
    Route::get('activities', [ActivityController::class, 'index'])->name('api.activities.index');
    Route::get('activities/{activity}', [ActivityController::class, 'show'])->name('api.activity.show');
    Route::get('galleries', [GalleryController::class, 'index'])->name('api.galleries.index');

    // Rutas que requieren autenticación
    Route::middleware('auth:api')->group(function() {
        Route::get('auth.me', [AuthController::class, 'me'])->name('api.auth.me');
        Route::get('auth.logout', [AuthController::class, 'logout'])->name('api.auth.logout');
    });

    // Rutas que requieren autenticación Y permisos de administrador
    Route::middleware(['auth:api', 'admin'])->group(function() {
        Route::post('activity/store', [ActivityController::class, 'store'])->name('api.activity.store');
        Route::put('activity/update/{activity}', [ActivityController::class, 'update'])->name('api.activity.update');
        Route::delete('activity/delete/{activity}', [ActivityController::class, 'destroy'])->name('api.activity.delete');
    });

