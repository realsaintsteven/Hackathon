<?php

namespace Modules\User\Http\Controllers\Api\User;

use Illuminate\Support\Facades\Notification;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Auth\Events\Registered;
use Propaganistas\LaravelPhone\PhoneNumber;

use Modules\User\Entities\User;
use Modules\User\Transformers\UserResource;

use Modules\User\Http\Requests\AccountUpdateRequest;
use Modules\User\Notifications\PasswordResetNotification;

//use Modules\Core\Traits\FileTrait;

class AccountController extends Controller
{
  //  use FileTrait;

    public function uploadImage(Request $request)
    {
        $user = auth()->user();

        if($image = $user->uploadImage($request->file('upload'), 300, 300, true)) {
            $user->deleteImage();
            $user->image = $image;
            $user->save();
        }

        return response()->json(['data' => [
            'image' => $image,
            'image_url' => $user->image_url
        ]]);
    }

    public function updateProfile(AccountUpdateRequest $request)
    {
        $user = auth()->user();

       
        if(!empty($request->upload) && $request->has('upload')) {
            $params['image'] = $this->uploadImage($request->file('upload'), 'files');
            if(isset($user->image)) {
                $user->deleteImage($user->image, 'images');
            }
        }

        $user->update($request->all());

        return response()->json(['message' => 'Profile updated.']);
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $validator = \Validator::make($request->all(), [
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()], 400);
        }

        $response = \Http::withToken($user->gb_token)->acceptJson()
            ->patch(env('GB_API_BASE_URL').'/account/password', $request->all());
        
        if(!$response->successful()) {
            return response()->json($response->json(), $response->status());
        }

        return response()->json(['message' => 'Password updated.']);
    }

    public function updateKyc(Request $request)
    {
        $user = auth()->user();
        $params = $request->only('identity_number');

        if(!empty($request->upload_file) && $request->has('upload_file')) {
            $params['identity_file'] = $this->uploadFile($request->file('upload_file'), 'files');
            if(isset($user->kyc->identity_file)) {
                $user->kyc->deleteFile($user->kyc->identity_file, 'files');
            }
        }

        $kyc = $user->kyc()->updateOrCreate(['user_id' => $user->id], $params);

        return response()->json(['data' => $kyc, 'message' => 'KYC updated.']);
    }

    public function forgotPassword(Request $request)
    {
        $response = \Http::acceptJson()
            ->withHeaders(['Merchant-Apikey' => env('GB_MERCHANT_API_KEY')])
            ->post(env('GB_API_BASE_URL').'/auth/forgot-password-token', $request->all());

        if(!$response->successful()) {
            return response()->json($response->json(), $response->status());
        }

        $token = $response['data']['token'];
        // $gbUser = $token = $response['data']['user'];
        // $user = User::whereGbUid($gbUser['customer_no'])->first();
        $user = User::whereEmail($request->email)->first();
        
        $user->notify(new PasswordResetNotification($token));
        // Notification::send($request->email, new PasswordResetNotification($token));
        // \Mail::to($request->email)->send(new PasswordResetNotification($token));

        return response()->json(['message' => 'We have emailed your password reset link!']);
    }

    public function resetPassword(Request $request)
    {
        $response = \Http::acceptJson()
            ->withHeaders(['Merchant-Apikey' => env('GB_MERCHANT_API_KEY')])
            ->post(env('GB_API_BASE_URL').'/auth/reset-password', $request->all());

        if(!$response->successful()) {
            return response()->json($response->json(), $response->status());
        }

        return response()->json(['message' => 'Password reset successfully']);
    }
}
