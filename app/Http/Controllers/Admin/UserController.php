<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\UpdateUserRequest;
use App\Mail\UserRegistrationMail;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use JetBrains\PhpStorm\NoReturn;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param User $user
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function index(User $user): JsonResponse
    {
        $this->authorize('viewAny', $user);
        return response()->json(['users' => $user->with('posts')->get()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $this->authorize('update', $user);

        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        $user->update($data);

        return response()->json(['user' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(User $user): JsonResponse
    {
        $this->authorize('delete', $user);
        $user->delete();
        return response()->json([
            'message' => 'Deleted'
        ]);
    }

    public function show(User $user): JsonResponse
    {
        $user->load('posts.postUserLiked');
        return response()->json(['user' => $user]);
    }
}
