<?php

use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\ContractsController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\AdminsController;
use App\Http\Controllers\Dashboard\MessagesController;
use App\Http\Controllers\Dashboard\PaymentsController;
use App\Http\Controllers\Dashboard\ProjectsController;
use App\Http\Controllers\Dashboard\ProposalsController;
use App\Http\Controllers\Dashboard\RolesController;
use App\Http\Controllers\Dashboard\SiteSettingsController;
use App\Http\Controllers\Dashboard\UsersController;
use Illuminate\Support\Facades\Route;



Route::group([
    'prefix' => 'admin/dashboard',
    'middleware' => ['auth:admin', 'admin.active'],
    'as' => 'dashboard.',
], function () {

    Route::resource('users', UsersController::class)->except(['create', 'store', 'show']);
    Route::resource('projects', ProjectsController::class)->except(['create', 'store', 'edit']);
    Route::resource('proposals', ProposalsController::class)->except(['create', 'store', 'edit']);
    Route::resource('contracts', ContractsController::class)->only(['index', 'show', 'update']);
    Route::resource('payments', PaymentsController::class)->only(['index', 'show', 'update']);
    Route::resource('messages', MessagesController::class)->only(['index', 'show']);
    Route::get('settings', [SiteSettingsController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [SiteSettingsController::class, 'update'])->name('settings.update');
    Route::post('users/bulk', [UsersController::class, 'bulk'])->name('users.bulk');
    Route::post('projects/bulk', [ProjectsController::class, 'bulk'])->name('projects.bulk');
    Route::post('proposals/bulk', [ProposalsController::class, 'bulk'])->name('proposals.bulk');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware('admin.super')->group(function () {
        Route::resource('roles', RolesController::class);
        Route::resource('admins', AdminsController::class)->except(['show']);
    });

    // Route::get('config', [ConfigController::class, 'index'])->name('config');
    // Route::post('config', [ConfigController::class, 'store']);

    Route::prefix('/categories')
        ->as('categories.')
        ->group(function () {
            Route::get('/', [CategoriesController::class, 'index'])
                ->name('index');
            Route::get('/create', [CategoriesController::class, 'create'])
                ->name('create');
            Route::get('/{category}', [CategoriesController::class, 'show'])
                ->name('show');
            Route::post('/', [CategoriesController::class, 'store'])
                ->name('store');
            Route::get('/{category}/edit', [CategoriesController::class, 'edit'])
                ->name('edit');
            Route::put('/{category}', [CategoriesController::class, 'update'])
                ->name('update');
            Route::delete('/{category}', [CategoriesController::class, 'destroy'])
                ->name('destroy');

            Route::get('/trash', [CategoriesController::class, 'trash'])
                ->name('trash');
            Route::put('/trash/{category}/restore', [CategoriesController::class, 'restore'])
                ->name('restore');
            Route::delete('/trash/{category}', [CategoriesController::class, 'forceDelete'])
                ->name('forceDelete');
        });
});
