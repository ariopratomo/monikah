<?php

use App\Http\Controllers\Admin\UndanganController;
use App\Http\Controllers\Member\AuthController as MemberAuthController;
use App\Http\Controllers\Member\UndanganController as MemberUndanganController;
use App\Http\Controllers\UndanganMasterController as PublicUndanganController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// routes for admin routes

Route::prefix('member')->group(function () {
    Route::controller(MemberAuthController::class)->group(function () {
        Route::post('login', 'login');
        Route::post('register', 'register');

        Route::middleware(['auth.role:member','throttle:60,1'])->group(function () {
            Route::get('me', 'me');
            Route::post('logout', 'logout');
        });
    });

    // Routes undaangan
    Route::controller(MemberUndanganController::class)->group(function () {
        Route::middleware(['auth.role:member'])->group(function () {
            // route group prefix: undangan
            Route::prefix('undangan')->group(function () {
                Route::get('/', 'index');
                Route::post('/', 'store');
                Route::post('/agenda', 'agendaCreate');
                Route::post('/location', 'locationCreate');
                Route::post('/love-story', 'loveStoryCreate');
                Route::post('/galery', 'galeryCreate');
                Route::post('/invite-guest', 'inviteGuest');
            });
        });
    });
});

Route::get('/{slug}',PublicUndanganController::class.'@index');
Route::get('check/slug/{slug}',PublicUndanganController::class.'@checkSlug');
