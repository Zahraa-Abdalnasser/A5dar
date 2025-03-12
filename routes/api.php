<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OrderController;

Route::get('/message' , function()
{
return response()->json([
    'message'=>'hello', 
    'name'=>'zhra'
]) ; 
}
)->middleware('auth:sanctum'); 
// user 
Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']); 
Route::get('/user/{id}', [UserController::class, 'show']); // show profile 

Route::middleware('auth:sanctum')->group(function () {
Route::post('/update/{id}',[UserController::class,'update']); 
Route::post('/logout', [UserController::class, 'logout']);
});
//Route::apiResource('/offers',OfferController::class)->middleware('auth:sanctum')->except(['index', 'show']);
//offers
Route::get('/offers', [OfferController::class, 'index']); // show all offers 
Route::get('/offers/{offer}', [OfferController::class, 'show']); // show a specific offer 

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/offers', [OfferController::class, 'store']);
    Route::post('/offers/{id}', [OfferController::class, 'update']);
    Route::delete('/offers/{offer}', [OfferController::class, 'destroy']);
/// order 
    Route::post('/offers/{offer}/orders', [OrderController::class, 'store']);
    Route::post('/orders/{order}', [OrderController::class, 'update']);
    Route::delete('/orders/{order}', [OrderController::class, 'destroy']);
    
    Route::post('/orders/{order}/decision', [OrderController::class, 'handleOrderDecision']);


});

