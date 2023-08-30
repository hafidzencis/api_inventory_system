<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvetoryController;
use App\Http\Controllers\StorageUnitController;
use App\Http\Controllers\VendorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

Route::post('admin',[AdminController::class,'createAdmin']);
Route::get('admin/{id}',[AdminController::class,'getAdminById']);
Route::get('admin',[AdminController::class,'getAllAdmin']);
Route::put('admin/{id}',[AdminController::class,'updateAdmin']);
Route::delete('admin/{id}',[AdminController::class,'deleteAdmin']);

Route::post('vendor',[VendorController::class,'createVendor']);
Route::get('vendor/{id}',[VendorController::class,'getVendorById']);
Route::get('vendor',[VendorController::class,'getAllVendor']);
Route::put('vendor/{id}',[VendorController::class,'updateVendor']);
Route::delete('vendor/{id}',[VendorController::class,'deleteVendor']);

Route::post('storageunit',[StorageUnitController::class,'createStorageUnit']);
Route::get('storageunit/{id}',[StorageUnitController::class,'getStorageUnitById']);
Route::get('storageunit',[StorageUnitController::class,'getAllStorageUnit']);
Route::put('storageunit/{id}',[StorageUnitController::class,'updateStorageUnit']);
Route::delete('storageunit/{id}',[StorageUnitController::class,'deleteStorageUnit']);

Route::post('inventory',[InvetoryController::class,'createInventory']);
Route::get('inventory/{id}',[InvetoryController::class,'getInventoryById']);
Route::get('inventory',[InvetoryController::class,'getAllInventory']);
Route::put('inventory/{id}',[InvetoryController::class,'updateInventory']);
Route::delete('inventory/{id}',[InvetoryController::class,'deleteInventory']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
