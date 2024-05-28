<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeServiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\organization\OrganizationBranchController;
use App\Http\Controllers\organization\OrganizationController;
use App\Http\Controllers\OrganizationServiceController;
use App\Http\Controllers\TelegramBotController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('google', [AuthController::class, 'google'])->name('google');
    Route::post('set-phone', [AuthController::class, 'setPhone'])->name('setPhone');
    Route::get('get-otp/{phone}', [AuthController::class, 'getOtp']);
});

Route::group(['prefix' => 'auth', 'middleware' => 'auth:employee, auth:client'], function () {
    Route::get('profile', [AuthController::class, 'getProfile']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
});

Route::group(['middleware' => ['auth:employee']], function () {
    Route::apiResource('organization', OrganizationController::class);
    Route::apiResource('organization.branch', OrganizationBranchController::class);
    Route::apiResource('organization.service', OrganizationServiceController::class);
    Route::apiResource('organization.employee', EmployeeController::class);
    Route::apiResource('organization.employee.service', EmployeeServiceController::class);
    Route::apiResource('organization.order', OrderController::class);

    Route::put('organization/{organization}/order/{order}/status', [OrderController::class, 'changeStatus']);

    Route::get('organization/{organization}/check-phone/{phone}', [OrganizationController::class, 'checkClientPhone']);
});

Route::post('organization/{organization}/employee/{employee}/time-slots', [EmployeeController::class, 'getTimeSlots']);
Route::any('telegram', [TelegramBotController::class, 'webhook']);
Route::get('init-organization', [OrganizationController::class, 'initOrganization']);



//curl -F "url=https://1691-84-54-78-10.ngrok-free.app/public/telegram" https://api.telegram.org/bot554709576:AAEVnR3zA6r7Wr5YiRv5zGuewUopafrqRd0/setWebhook
