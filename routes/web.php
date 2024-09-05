<?php

use App\Models\User;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\DiscountController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::middleware(['verify.shopify'])->group(function () {

    Route::get('/', [WelcomeController::class, 'welcome'])->name('home');
    Route::post('/save-settings', [WelcomeController::class, 'saveSettings'])->name('saveSettings');

    Route::post('/update-order/{id}', [OrderController::class, 'updateOrder'])->name('updateOrder');
    Route::post('/bulk-update-order', [OrderController::class, 'bulkUpdateOrder'])->name('bulkUpdateOrder');
  
    // Route::get('/plans', [WelcomeController::class, 'plans'])->name('plans');

});

Route::get('/print/{user}', [OrderController::class, 'printOrder'])->name('printOrder');

Route::get('/privacy-policy', [WelcomeController::class, 'privacyPolicy']);

// Route::get('/get_webhooks', function(){
//    return User::find(21)->api()->rest("get", "/admin/api/2023-10/webhooks.json");
// });


