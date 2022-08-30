<?php

namespace Modules\Admin\Http\Controllers\Api\Admin\Auth;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Password;
use Propaganistas\LaravelPhone\PhoneNumber;

use Modules\Admin\Entities\Admin;
use Modules\Admin\Transformers\AdminResource;

class LoginController extends Controller
{
    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker('admins');
    }

    /**
     * Login
     */
    public function login()
    {
        if (! $token = auth('admin')->attempt(request()->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid email or password.'], 401);
        }

        if(request()->remember) {
            auth('admin')->factory()->setTTL(null);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Logout
     */
    public function logout()
    {
        auth('admin')->logout();
        return response()->json(null, 204);
    }

    /**
     * Refresh authentication token
     */
    public function refresh()
    {
        $token = auth('admin')->refresh();
        return $this->response()->json(['access_token' => $token]);
    }

    /**
     * Authentication response
     */
    public function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('admin')->factory()->getTTL(),
            'guard' => 'admin',
            'user' => new AdminResource(auth('admin')->user()),
        ]);
    }
}
