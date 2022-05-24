<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthLoginRequest;
use App\Http\Requests\Auth\AuthRegisterRequest;
use App\Mail\UserRegistrationMail;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /**
     * @param $user
     * @return JsonResponse
     */
    public function response ($user): JsonResponse
    {
        $token = $user->createToken('token_name')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    /**
     * @param AuthRegisterRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function register (AuthRegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'verify_token' => bin2hex(random_bytes(10)),
            'role_id' => User::CLIENT,
        ]);

        Mail::to($user)->send(new UserRegistrationMail($user));
        return $this->response($user);
    }

    /**
     * @param AuthLoginRequest $request
     * @return JsonResponse
     */
    public function login(AuthLoginRequest $request): JsonResponse
    {
        $validated = $request->validated();
        if ( !Auth::attempt( $validated ) ) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }elseif (Auth::user()->email_verified_at == null) {
            return response()->json([
                'message' => 'you need to verify your email address',
            ], 401);
        }

        return $this->response( Auth::user() );
    }


    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        Auth::user()->tokens()->delete();
        return response()->json(['message' => 'You have left this site']);
    }

    public function verify(Request $request)
    {
        $verify_token = $request->get('token');

        User::where('verify_token', $verify_token)->update([
            'email_verified_at' => now()
        ]);
    }
}
