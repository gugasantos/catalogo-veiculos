<?php
use App\Http\Controllers\Admin\VehicleAdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VehicleController;

/*
|--------------------------------------------------------------------------
| Rotas públicas
|--------------------------------------------------------------------------
*/

Route::get('/', [VehicleController::class, 'home'])->name('home');

Route::get('/veiculos', [VehicleController::class, 'index'])->name('vehicles.index');
Route::get('/veiculos/{slug}', [VehicleController::class, 'show'])->name('vehicles.show');

/*
|--------------------------------------------------------------------------
| Login Admin (oculto do público)
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('login');
})->name('logout');


/*
|--------------------------------------------------------------------------
| Rotas ADMIN (protegidas)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard simples (opcional)
        Route::get('/', function () {
            return redirect()->route('admin.vehicles.index');
        })->name('dashboard');

        // CRUD de veículos
        Route::get('/vehicles', [VehicleAdminController::class, 'index'])
            ->name('vehicles.index');

        Route::get('/vehicles/create', [VehicleAdminController::class, 'create'])
            ->name('vehicles.create');

        Route::post('/vehicles', [VehicleAdminController::class, 'store'])
            ->name('vehicles.store');

        Route::get('/vehicles/{vehicle}/edit', [VehicleAdminController::class, 'edit'])
            ->name('vehicles.edit');

        Route::put('/vehicles/{vehicle}', [VehicleAdminController::class, 'update'])
            ->name('vehicles.update');

        // Ativar / Ocultar veículo
        Route::post('/vehicles/{vehicle}/toggle', [VehicleAdminController::class, 'toggleStatus'])
            ->name('vehicles.toggle');
        
        Route::delete('/vehicles/{vehicle}', [\App\Http\Controllers\Admin\VehicleAdminController::class, 'destroy'])
            ->name('vehicles.destroy');

        Route::get('/vehicles/{vehicle}/share/image', [VehicleAdminController::class, 'generateShareImage'])
            ->name('vehicles.share.image');

        Route::get('/vehicles/{vehicle}/share',[VehicleAdminController::class, 'shareSmart']
            )->name('vehicles.share.smart');
            
        Route::get('vehicles/{vehicle}/share/file', [VehicleAdminController::class, 'shareFile'])
        ->name('vehicles.share.file');

    });
