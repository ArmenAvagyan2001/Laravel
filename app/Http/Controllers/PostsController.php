<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\StorePostsRequest;
use App\Http\Requests\Posts\UpdatePostsRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        //
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
     * @param Post $posts
     * @return JsonResponse
     */
    public function update(UpdatePostsRequest $request, Post $post): JsonResponse
    {
        $data = $request->validated();
        $image = $request->file('image');
        if ($image != null) {

            $path = $image->store('public/images');

            $post->update([
                'name' => $data['name'],
                'subject' => $data['subject'],
                'image' => substr($path, 6)
            ]);
        }else {
            $post->update($data);
        }

        return response()->json(['post' => $post]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @return JsonResponse
     */
    public function destroy(Post $post): JsonResponse
    {
        $path = public_path('/storage' . $post->image);
        if (file_exists($path)) {
            unlink($path);
        }
        $post->delete();
        return response()->json(['message' => 'Deleted']);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        return response()->json(['posts' => auth()->user()->with('posts')->first()->posts]);
    }
}
