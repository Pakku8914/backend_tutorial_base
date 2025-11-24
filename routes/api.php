<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\AuthController;

// 認証関連のルート
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::delete('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum');

// リソースルート
Route::apiResource('articles', ArticleController::class)
    ->only(['index', 'show']);
Route::apiResource('articles', ArticleController::class)
    ->except(['index', 'show'])
    ->middleware('auth:sanctum'); // 作成・更新・削除は認証必須
Route::apiResource('articles.comments', CommentController::class)
    ->only(['index']);
Route::apiResource('articles.comments', CommentController::class)
    ->except(['index', 'show'])
    ->middleware('auth:sanctum'); // 作成・更新・削除は認証必須
