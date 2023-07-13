<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StaffController;

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

/**
 *  API: Authentication
 */
Route::controller(AuthController::class)->group(function () {
    Route::get('auth/user', 'getAllUser');
    //Route::get('auth/user/{id}', 'getUserById');
    Route::post('auth/register/staff/new', 'registerNewStaffAsUser');
    Route::post('auth/register/staff', 'registerStaffAsUser');
    //Route::post('auth/register/customer/new', 'registerCustomerNew');
    //Route::post('auth/register/customer', 'registerCustomer');
    //Route::post('auth/login', 'login');
    //Route::post('auth/logout', 'logout');
    //Route::post('auth/refresh', 'refresh');
    //Route::put('auth/user', 'updateUser');
    Route::put('auth/user/suspend/{id}', 'toggleSuspendUser');
    Route::delete('auth/user/{id}', 'deleteUser');
});

/**
 *  API: Staff
 */
Route::controller(StaffController::class)->group(function () {
    Route::get('staff', 'getAllStaff');
    Route::get('staff/{id}', 'getStaffById');
    Route::post('staff', 'createStaff');
    Route::put('staff', 'updateStaff');
    Route::put('staff/suspend/{id}', 'toggleSuspendStaff');
    Route::delete('staff/{id}', 'deleteStaff');
});