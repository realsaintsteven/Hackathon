<?php

namespace Modules\User\Http\Controllers\Api\User\Auth;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Auth\Events\Registered;
use Propaganistas\LaravelPhone\PhoneNumber;

use Modules\User\Entities\User;
use Modules\User\Transformers\UserResource;

use Modules\User\Http\Requests\RegisterUserRequest;

class RegisterController extends Controller
{
    /**
     * Register
     */
    public function register(RegisterUserRequest $request)
    {
        if (!$request->accept) {
            return response()->json(['message' => 'Accept terms and condition to continue.'], 400);
        }

        $request->validate([
            'firstname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);


        $params = $request->all();
        
        event(new Registered($user = User::create($params)));

        $user = User::find($user->id); // This will fetch all table columns

        $token = auth('api')->login($user);

        return $this->respondWithToken($token);
    }

    /**
     * Authentication response
     */
    public function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL(),
            'guard' => 'user',
            'user' => new UserResource(auth()->user()),
            // 'user' => new UserResource(auth()->user()->load('kyc', 'profile')),
        ]);
    }
}
