<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaymentController;
use \Illuminate\Support\Facades\Artisan;

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

Route::get("/checkout", [CheckoutController::class, "index"]);
Route::put("/checkout/add", [CheckoutController::class, "add"]);
Route::get("/checkout/total", [CheckoutController::class, "total"]);


Route::post("/order", [OrderController::class, "order"]);
//Route::get("/purchase", [PurchaseController::class, "purchase"]);
Route::post("/payment", [PaymentController::class, "payment"]);
Route::get("/payment", [PaymentController::class, "handleRedirect"]);


Route::get('/reset/and/seed', function () {
//
//    $migrateReset = Artisan::call('migrate:refresh');
//    $brandSeeder = Artisan::call('db:seed', ['--class' => "BrandSeeder"]);
//    $productSeeder = Artisan::call('db:seed', ['--class' => "ProductSeeder"]);

    return response()->json([
        "migration" => Artisan::call('migrate') === 0 ? "ok": "failed",
        "brandSeeder" => Artisan::call('db:seed', ['--class' => "BrandSeeder"]) === 0 ? "ok": "failed",
        "productSeeder" =>  Artisan::call('db:seed', ['--class' => "ProductSeeder"]) === 0 ? "ok": "failed"
    ]);


});

Route::resource("/", ProductController::class);
