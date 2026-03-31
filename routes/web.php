<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\PaymentsCallbackController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ProjectsController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('home2');
// });
// Route::get('/shope', function () {
//     return view('shope');
// });
Route::group([
    'prefix' => LaravelLocalization::setLocale()
], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('projects', [ProjectsController::class, 'index'])
        ->name('projects.browse');

    Route::get('projects/{project}', [ProjectsController::class, 'show'])
        ->name('projects.show');
});

Route::middleware('auth:web')->group(function () {
    Route::get('messages', [MessagesController::class, 'create'])
        ->name('messages');
    Route::post('messages', [MessagesController::class, 'store']);
});

Route::get('otp/request', [OtpController::class, 'create'])->name('otp.create');
Route::post('otp/request', [OtpController::class, 'store']);
Route::get('otp/verify', [OtpController::class, 'verifyForm'])->name('otp.verify');
Route::post('otp/verify', [OtpController::class, 'verify']);

require __DIR__ . '/dashboard.php';
require __DIR__ . '/freelancer.php';
require __DIR__ . '/client.php';
require __DIR__ . '/auth.php';

Route::get('payments/create', [PaymentsController::class, 'create'])->name('payments.create');
Route::get('/payments/callback/success', [PaymentsCallbackController::class, 'success'])->name('payments.success');
Route::get('/payments/callback/cancel', [PaymentsCallbackController::class, 'cancel'])->name('payments.cancel');
