<?php

namespace Modules\User\Http\Controllers\Api\User\Auth;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Auth\Events\Registered;
use Propaganistas\LaravelPhone\PhoneNumber;

use Modules\User\Entities\User;
use Modules\Competition\Entities\Team;
use Modules\User\Transformers\UserResource;

class LoginController extends Controller
{
    /**
     * Login
     */
    public function login(Request $request)
    {
      //  return $request->all();

        if (! $token = auth()->attempt(request()->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid email or password.'], 401);
        }

        if(request()->remember) {
            auth()->factory()->setTTL(null);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Logout
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh authentication token
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /** 
     * Authentication response
     */
    public function respondWithToken($token)
    {

        $payload = auth()->user()->load(
           'teamUsers'
        )->toArray();

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL(),
            'guard' => 'user',
            // 'user' => new UserResource(auth()->user()),
            'user' => new UserResource($payload),
        ]);
    }
}
