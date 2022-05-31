<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;

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

/**************** Login Admin***************/

Route::get('/',
    [LoginController::class,"index"])
    ->name('admin.login');

Route::post('/auth/authenticate',
    [LoginController::class,"authenticate"])
    ->name('admin.authenticate');

Route::get('/admin/recovery-password',
    [LoginController::class,"recoveryPassword"])
    ->name('admin.recovery.password')
    ->withoutMiddleware('auth.admin:admin');

Route::post('/admin/recovery-password/send',
    [LoginController::class,"passwordRecoveryPost"])
    ->name('admin.send.recovery.password')
    ->withoutMiddleware('auth.admin:admin');

Route::get('/admin/reset-password/redirect',
    [LoginController::class,"redirectResetPassword"])
    ->name('post.password.reset')
    ->withoutMiddleware('auth.admin:admin');

Route::post('/admin/reset-password/',
    [LoginController::class,"changePassword"])
    ->name('reset.password')
    ->withoutMiddleware('auth.admin:admin');
