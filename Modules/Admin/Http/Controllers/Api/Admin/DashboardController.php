<?php

namespace Modules\Admin\Http\Controllers\Api\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\User\Entities\User;
use Modules\Order\Entities\Reservation;
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
        return response()->json([
            'users_count' => User::count(),
            'reservations_count' => Reservation::count(),
            'transactions_count' => User::count() *  13,
            'facilities_count' => User::count(),
            'line_chart' => [],
            'pie_chart' => [Franchisee::count(), Installer::count(), Institute::count(), Insurance::count()]
        ]);
    }
}
