<?php

namespace Modules\User\Http\Controllers\Api\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\User\Entities\User;
use Modules\Reservation\Entities\Reservation;
use Modules\Partner\Entities\Franchisee;
use Modules\Partner\Entities\Installer;
use Modules\Partner\Entities\Institute;
use Modules\Partner\Entities\Insurance;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function report()
    {
        $user = auth()->user();

        $response = \Http::withToken($user->gb_token)->acceptJson()
            ->get(env('GB_API_BASE_URL').'/report', ['Merchant-Apikey' => env('GB_MERCHANT_API_KEY')]);

        $data = [
            'wallet' => $response->json(),
            'referrals_count' => $user->children()->count(),
            'reservations_count' => $user->reservations()->count(),
            'transactions_count' => $user->payments()->count(),
            'line_chart' => [],
            'pie_chart' => [Franchisee::count(), Installer::count(), Institute::count(), Insurance::count()]
        ];

        return response()->json(['data' => $data]);
    }

    public function walletBalance()
    {
        $user = auth()->user();

        $response = \Http::withToken($user->gb_token)->acceptJson()
            ->get(env('GB_API_BASE_URL').'/report', ['Merchant-Apikey' => env('GB_MERCHANT_API_KEY')]);

        return response()->json([
            'data' => $response->json(),
        ]);
    }
}
