<?php

namespace Modules\Admin\Http\Controllers\Api\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Propaganistas\LaravelPhone\PhoneNumber;

use Modules\Admin\Entities\Admin;
use Modules\Admin\Transformers\AdminResource;

class AccountController extends Controller
{
    public function updateProfile(Request $request)
    {
        $user = auth('admin')->user();

        $validator = \Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:admins,email,' . $user->id . ',id',
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()], 400);
        }

        $user->update($request->all());

        return response()->json(['message' => 'Profile updated.']);
    }

    public function updatePassword(Request $request)
    {
        $user = auth('admin')->user();

        $validator = \Validator::make($request->all(), [
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()], 400);
        }

        if (!\Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Current password not correct.'], 400);
        }

        $user->password = bcrypt($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password updated.']);
    }
}
