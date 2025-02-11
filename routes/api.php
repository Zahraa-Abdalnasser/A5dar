<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OfferController;

Route::get('/message' , function()
{
return response()->json([
    'message'=>'hello', 
    'name'=>'zhra'
]) ; 
}
)->middleware('auth:sanctum'); 

Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']); 
Route::put('/update/{id}',[UserController::class,'update']); 
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
//Route::apiResource('/offers',OfferController::class)->middleware('auth:sanctum')->except(['index', 'show']);
Route::get('/offers', [OfferController::class, 'index']); // show all offers 
Route::get('/offers/{offer}', [OfferController::class, 'show']); // show a specific offer 

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/offers', [OfferController::class, 'store']);
    Route::post('/offers/{id}', [OfferController::class, 'update']);
    Route::delete('/offers/{offer}', [OfferController::class, 'destroy']);
});

