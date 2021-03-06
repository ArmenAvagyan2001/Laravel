<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Posts\StorePostsRequest;
use App\Http\Requests\Admin\Posts\UpdatePostsRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Post $post): JsonResponse
    {
        $post->with('postUserLiked')->get();
        return response()->json(['posts' => $post->with('postUserLiked')->get()]);
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
        $this->authorize('update', $post);
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
     * @param Post $post
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(Post $post): JsonResponse
    {
        $this->authorize('delete', $post);
        $path = public_path('/storage' . $post->image);
        if (file_exists($path)) {
            unlink($path);
        }
        $post->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
