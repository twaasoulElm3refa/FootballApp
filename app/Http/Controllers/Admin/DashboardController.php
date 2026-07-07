<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fixtures;
use App\Models\Leagues;
use App\Models\Teams;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    private const CACHE_TTL = 600;
    private const CACHE_KEY = 'dashboard:admin:stats';
    private const CACHE_TAGS = [
        'dashboard',
        'dashboard_users',
        'dashboard_leagues',
        'dashboard_teams',
        'dashboard_fixtures',
    ];

    /**
     * Get dashboard statistics or data.
     */
    public function index(Request $request): JsonResponse
    {
        if ($request->user()?->role !== 'admin') {
            return response()->json([
                'message' => 'Forbidden.',
            ], 403);
        }

        $stats = Cache::tags(self::CACHE_TAGS)->remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            return [
                'users' => [
                    'total' => User::count(),
                    'active' => User::where('status', 'active')->count(),
                ],
                'leagues' => [
                    'total' => Leagues::count(),
                    'active' => Leagues::where('is_active', true)->count(),
                ],
                'teams' => [
                    'total' => Teams::count(),
                    'active' => Teams::where('is_active', true)->count(),
                ],
                'fixtures' => [
                    'total' => Fixtures::count(),
                    'live' => Fixtures::where('is_live', true)->count(),
                    'finished' => Fixtures::where('is_finished', true)->count(),
                ],
            ];
        });

        return response()->json([
            'message' => 'Dashboard data retrieved successfully',
            'stats' => $stats,
        ]);
    }
}
