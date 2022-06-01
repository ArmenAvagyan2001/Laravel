<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPostLikedController extends Controller
{
    /**
     * @param Post $post
     * @param Request $request
     * @return JsonResponse
     */
    public function like (Post $post, Request $request)
    {
        Auth::user()->userPostLiked()->toggle($request->post_id);
        $postUserLiked = $post->where('id', $request->post_id)->with('postUserLiked')->get()->toArray();

        return response()->json(['post' => $postUserLiked]);
    }
}
