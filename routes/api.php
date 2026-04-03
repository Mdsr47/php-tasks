<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ProductController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');




/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Task 1 — Product REST API
| Task 2 — External API Consumer (JSONPlaceholder Posts)
|
*/

// ─── Task 1: Products ────────────────────────────────────────────────────────

Route::prefix('products')->group(function () {
    // GET  /api/products          → List all products (paginated)
    Route::get('/',      [ProductController::class, 'index']);

    // POST /api/products          → Create a product
    Route::post('/',     [ProductController::class, 'store']);

    // DELETE /api/products/{id}   → Delete a product
    Route::delete('/{id}', [ProductController::class, 'destroy']);
});


// ─── Task 2: External Posts API ──────────────────────────────────────────────

// GET /api/posts               → Fetch first 10 posts (supports ?search=keyword)
Route::get('/posts', [PostController::class, 'index']);
