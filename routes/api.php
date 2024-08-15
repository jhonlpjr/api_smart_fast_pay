<?php

use App\Http\Middleware\VerifyToken;
use app\modules\paymentmethod\infraestructure\controllers\PaymentMethodController;
use App\Modules\User\Infraestructure\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });

// Definir la nueva ruta para crear un usuario



Route::middleware([VerifyToken::class])->group(function () {
    Route::post('/users/create', [UserController::class, 'create']);

    Route::post('/payment-method/create', [PaymentMethodController::class, 'create']);
    Route::delete('/payment-method/delete/{id}', [PaymentMethodController::class, 'delete']);
    Route::get('/payment-method/{id}', [PaymentMethodController::class, 'findOne']);
});
Route::post('/users/login', [UserController::class, 'login']);