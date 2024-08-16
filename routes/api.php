<?php

use App\Http\Middleware\VerifyToken;
use app\modules\payment\infraestructure\controllers\PaymentController;
use app\modules\paymentmethod\infraestructure\controllers\PaymentMethodController;
use App\Modules\User\Infraestructure\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });

// Definir la nueva ruta para crear un usuario



Route::middleware([VerifyToken::class])->group(function () {
    //USERS
    Route::post('/users/create', [UserController::class, 'create']);
    Route::delete('/users/delete/{id}', [UserController::class, 'delete']);
    Route::get('/users/balance/{id}', [UserController::class, 'getBalance']);
    Route::get('/users/find/{id}', [UserController::class, 'findOne']);
    //PAYMENT
    Route::post('/payment/create', [PaymentController::class, 'create']);
    Route::delete('/payment/delete/{id}', [PaymentController::class, 'delete']);
    Route::get('/payment/find', [PaymentController::class, 'find']);
    Route::get('/payment/find/{id}', [PaymentController::class, 'findOne']);
    Route::post('/payment/process', [PaymentController::class, 'process']);

    //PAYMENT METHOD
    Route::post('/payment-method/create', [PaymentMethodController::class, 'create']);
    Route::delete('/payment-method/delete/{id}', [PaymentMethodController::class, 'delete']);
    Route::get('/payment-method/find/{id}', [PaymentMethodController::class, 'findOne']);
});
Route::post('/users/login', [UserController::class, 'login']);