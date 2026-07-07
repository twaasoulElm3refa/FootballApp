<?php

namespace App\Http\Controllers\api\admin\teams;

use App\Http\Controllers\concerns\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Teams;
use App\Repository\Contracts\teams\TeamsRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class TeamDashboardController extends Controller
{
    use ApiResponse;
    private const CACHE_TAG = 'dashboard_teams';
    private const CACHE_TTL = 600;

    public function __construct(private readonly TeamsRepositoryInterface $teamsRepository)
    {
    }
    public function teamCount()
    {
        $count = Cache::tags([self::CACHE_TAG])->remember('dashboard:teams:count', self::CACHE_TTL, function () {
            return $this->teamsRepository->teamCount();
        });

        return $this->success($count, 'Teams count fetched successfully');
    }
}
