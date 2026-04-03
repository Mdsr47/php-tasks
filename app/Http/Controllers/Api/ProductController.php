<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * GET /api/products
     * List all products with optional pagination.
     */
    public function index(): JsonResponse
    {
        // Bonus: pagination — defaults to 10 per page, customisable via ?per_page=N
        $perPage = (int) request('per_page', 10);

        // Clamp per_page between 1 and 100 to prevent abuse
        $perPage = max(1, min(100, $perPage));

        $products = Product::latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Products retrieved successfully.',
            'data'    => $products->items(),
            'meta'    => [
                'current_page' => $products->currentPage(),
                'last_page'    => $products->lastPage(),
                'per_page'     => $products->perPage(),
                'total'        => $products->total(),
            ],
        ], 200);
    }

    /**
     * POST /api/products
     * Create a new product.
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        // return just request data for debugging
        // return response()->json([
        //     'success' => true,
        //     'message' => 'Request data retrieved successfully.',
        //     'data'    => $request->all(),
        // ], 200);

        // $request->validate([
        //     'name'        => 'required|string|max:255',
        //     'price'       => 'required|numeric|min:0',
        //     'description' => 'nullable|string|max:1000',
        // ]);
        $product = Product::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully.',
            'data'    => $product,
        ], 201);
    }

    /**
     * DELETE /api/products/{id}
     * Delete an existing product.
     */
    public function destroy(int $id): JsonResponse
    {
        $product = Product::find($id);

        if (! $product) {
            return response()->json([
                'success' => false,
                'message' => "Product with ID {$id} not found.",
            ], 404);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => "Product '{$product->name}' deleted successfully.",
        ], 200);
    }
}