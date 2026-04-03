<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PostController extends Controller
{
    /**
     * Base URL for the external API.
     */
    private const API_URL = 'https://jsonplaceholder.typicode.com/posts';

    /**
     * GET /api/posts
     * Fetch the first 10 posts from JSONPlaceholder.
     * Bonus: filter by title using ?search=keyword
     */
    public function index(Request $request): JsonResponse
    {
        // Fetch all posts from external API using Laravel HTTP Client
        $response = Http::timeout(10)->get(self::API_URL);

        // Handle external API failure gracefully
        if ($response->failed()) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch posts from external API.',
                'error'   => $response->status(),
            ], 502);
        }

        $posts = collect($response->json());

        // Bonus: search/filter by title (case-insensitive)
        $search = $request->query('search');
        if ($search) {
            $posts = $posts->filter(function ($post) use ($search) {
                return str_contains(
                    strtolower($post['title']),
                    strtolower($search)
                );
            })->values(); // re-index after filter
        }

        // Return only title and body, limit to first 10
        $formatted = $posts->take(10)->map(function ($post) {
            return [
                'title' => $post['title'],
                'body'  => $post['body'],
            ];
        })->values();

        return response()->json([
            'success' => true,
            'message' => 'Posts retrieved successfully.',
            'search'  => $search ?? null,
            'count'   => $formatted->count(),
            'data'    => $formatted,
        ], 200);
    }
}