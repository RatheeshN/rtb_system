<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdSlotController;
use App\Http\Controllers\BidController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/ad-slots', [AdSlotController::class, 'index']);
    Route::post('/ad-slots', [AdSlotController::class, 'store']);
    Route::post('/ad-slots/{adSlotId}/bids', [BidController::class, 'placeBid']);
    Route::get('/ad-slots/{adSlotId}/bids', [BidController::class, 'getBids']);
    Route::get('/ad-slots/{adSlotId}/winner', [BidController::class, 'getWinningBid']);
    Route::get('/bids', [BidController::class, 'getUserBids']);
});