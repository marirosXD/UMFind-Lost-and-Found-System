<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClaimController;
use Illuminate\Support\Facades\Route;

// --------------------------------------------------
// PUBLIC ROUTES
// --------------------------------------------------

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Dashboard (auth only)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


// --------------------------------------------------
// ITEMS (PUBLIC + AUTH)
// --------------------------------------------------

// Browse items (PUBLIC)
Route::get('/items', [ItemController::class, 'index'])
    ->name('items.index');

// View single item (PUBLIC)
Route::get('/items/{item}', [ItemController::class, 'show'])
    ->whereNumber('item')
    ->name('items.show');


// AUTH ONLY ITEM ACTIONS
Route::middleware('auth')->group(function () {

    // Create item
    Route::get('/items/create', [ItemController::class, 'create'])
        ->name('items.create');

    Route::post('/items', [ItemController::class, 'store'])
        ->name('items.store');

    Route::get('/items/{item}/edit', [ItemController::class, 'edit'])
        ->name('items.edit');

    Route::put('/items/{item}', [ItemController::class, 'update'])
        ->name('items.update');

    Route::delete('/items/{item}', [ItemController::class, 'destroy'])
        ->name('items.destroy');

    Route::get('/my-items', [ItemController::class, 'myItems'])
        ->name('my-items');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});


// --------------------------------------------------
// ADMIN ROUTES (FULLY PROTECTED)
// --------------------------------------------------

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('dashboard');

        // Users management
        Route::get('/users', [AdminController::class, 'users'])
            ->name('users');

        Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])
            ->name('users.edit');

        Route::put('/users/{id}', [AdminController::class, 'updateUser'])
            ->name('users.update');

        Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])
            ->name('users.delete');

        Route::patch('/items/{item}/receive', [ItemController::class, 'receiveItem'])
           ->name('receiveItem');

        // Return system
        Route::get('/items/{item}/return', [AdminController::class, 'showReturnForm'])
            ->name('items.return.form');

        Route::post('/items/{item}/return', [AdminController::class, 'storeReturn'])
            ->name('items.return.store');

        // Claim system
        Route::get('/claims', [ClaimController::class, 'index'])
            ->name('claims.index');

        Route::get('/claims/{claim}', [ClaimController::class, 'show'])
            ->name('claims.show');

        Route::get('/items/{item}/claim', [ItemController::class, 'claimForm'])
            ->name('items.claim.form');

        Route::post('/items/{item}/claim', [ItemController::class, 'claimStore'])
            ->name('items.claim.store');

        Route::post('/claims/{item}', [ClaimController::class, 'store'])->name('claims.store');
    });

    Route::get('/debug-csrf', function() {
    return response()->json([
        'session_id'      => session()->getId(),
        'session_driver'  => config('session.driver'),
        'session_domain'  => config('session.domain'),
        'session_secure'  => config('session.secure'),
        'session_same_site' => config('session.same_site'),
        'csrf_token'      => csrf_token(),
        'app_key_set'     => !empty(config('app.key')),
        'app_env'         => config('app.env'),
        'cookies_received'=> request()->cookies->all(),
        'forwarded_proto' => request()->header('X-Forwarded-Proto'),
        'is_secure'       => request()->isSecure(),
    ]);
});


// Laravel auth routes
require __DIR__.'/auth.php';
