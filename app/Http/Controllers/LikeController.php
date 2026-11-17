<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request, Post $post): JsonResponse
    {
        $post->likes()->firstOrCreate([
            'user_id' => $request->user()->id,
        ]);

        return $this->response($post, true);
    }

    public function destroy(Request $request, Post $post): JsonResponse
    {
        $post->likes()->where('user_id', $request->user()->id)->delete();

        return $this->response($post, false);
    }

    private function response(Post $post, bool $liked): JsonResponse
    {
        return response()->json([
            'liked' => $liked,
            'count' => $post->likes()->count(),
        ]);
    }
}
