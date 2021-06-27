<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\VerifyPhoneNumberController;
use App\Http\Controllers\PusherController;
use App\Http\Controllers\AdminController;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified', 'verifiedphonenumber'])->name('dashboard');

Route::get('/verify-phone-number', [VerifyPhoneNumberController::class, 'createPhoneVerification'])
->middleware('auth', 'verified')
->name('phoneverification.notice');

Route::post('/verify-phone-number', [VerifyPhoneNumberController::class, 'verifyPhoneNumber'])
->middleware('auth', 'verified')
->name('phoneverification.verify');

Route::post('/pusher/auth', [PusherController::class, 'pusherAuth'])
->middleware('auth');

Route::get('all-users', [AdminController::class, 'allUser'])
->middleware(['auth', 'verified', 'verifiedphonenumber'])
->name('all-users');

Route::get('impersonate/{user_id}', [AdminController::class, 'impersonate'])
->middleware(['auth', 'verified', 'verifiedphonenumber',])
->name('impersonate');

Route::get('impersonate_leave', [AdminController::class, 'impersonate_leave'])
->middleware(['auth', 'verified', 'verifiedphonenumber'])
->name('impersonate_leave');

require __DIR__.'/auth.php';
