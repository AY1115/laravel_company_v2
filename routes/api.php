<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CompanyController; //追記
use App\Http\Controllers\Api\CompanyDetailController; //追記

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


//会社情報
Route::post('company.create', [CompanyController::class, 'store'])->name('api.company.create');
Route::get('company.{id}', [CompanyController::class, 'show'])->name('api.company.show');
Route::put('company.{id}.update', [CompanyController::class, 'update'])->name('api.company.update');
Route::delete('company.{id}.delete', [CompanyController::class, 'destroy'])->name('api.company.delete');
Route::get('companydetail.{id}', [CompanyController::class, 'showWith'])->name('api.company.showWith');
Route::post('extra1.create', [CompanyController::class, 'extra1'])->name('api.company.create.extra1');
Route::put('extra1.{id}.update', [CompanyController::class, 'extra2'])->name('api.company.update.extra1');


//請求先情報
Route::post('detail.{id}.create', [CompanyDetailController::class, 'store'])->name('api.detail.create');
Route::get('detail.{id}', [CompanyDetailController::class, 'show'])->name('api.detail.show');
Route::put('detail.{id}.update', [CompanyDetailController::class, 'update'])->name('api.detail.update');
Route::delete('detail.{id}.delete', [CompanyDetailController::class, 'destroy'])->name('api.detail.delete');
