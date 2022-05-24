<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\StorePostsRequest;
use App\Http\Requests\Posts\UpdatePostsRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AdminPostsController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Post::class, 'post');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
//        return response()->json(['posts' => auth()->user()->posts->toArray()]);
        return response()->json(['posts' => Post::all()]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StorePostsRequest $request
     * @return JsonResponse
     */
    public function store(StorePostsRequest $request): JsonResponse
    {
        $image = $request->file('image');
        $path = $image->store('public/images');

        $data = $request->validated();

        $post = Post::create([
            'name' => $data['name'],
            'subject' => $data['subject'],
            'image' => substr($path, 6),
            'user_id' => auth()->user()->getAuthIdentifier()
        ]);

        return response()->json(['post' => $post]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePostsRequest $request
     * @param Post $post
     * @return JsonResponse
     */
    public function update(UpdatePostsRequest $request, Post $post): JsonResponse
    {
//        $image = $request->file('image');
//        $path = $image->store('public/images');

        $data = $request->validated();

        $post->update([
            'name' => $data['name'],
            'subject' => $data['subject'],
//            'image' => substr($path, 6)
        ]);

        return response()->json(['post' => $post]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Post $post
     * @return JsonResponse
     */
    public function destroy(Request $request, Post $post): JsonResponse
    {
        $path = public_path('/storage' . $post->image);
        if (file_exists($path)) {
            unlink($path);
        }
        $post->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
