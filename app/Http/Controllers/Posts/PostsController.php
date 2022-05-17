<?php

namespace App\Http\Controllers\Posts;

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
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(['posts' => Post::all()]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StorePostsRequest $request
     * @return JsonResponse
     */
    public function store(StorePostsRequest $request)
    {
//        dd(auth()->user()->getAuthIdentifier());
        $validated = $request->validated();
        $image = $request->file('image');
        $path = $image->store('public/images');
        $post = Post::create([
            'name' => $request->name,
            'subject' => $request->subject,
            'image' => substr($path,6),
            'user_id' => auth()->user()->getAuthIdentifier()
        ]);

        return response()->json(['post' => $post]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePostsRequest $request
     * @param Post $posts
     * @return void
     */
    public function update(UpdatePostsRequest $request, Post $posts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @return JsonResponse
     */
    public function destroy (Post $post)
    {
        $post->delete();
        return response()->json(['message' => 'Deleted']);
    }

    public function show() {

    }

    public function getUser($id) {
        $user = auth()->user()->with('posts')->first();
        dd($user->posts);
    }
}
