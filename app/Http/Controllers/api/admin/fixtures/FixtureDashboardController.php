<?php

namespace App\Http\Controllers\api\admin\fixtures;

use App\Http\Controllers\concerns\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Fixtures;
use App\Repository\Contracts\fixtures\FixturesRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class FixtureDashboardController extends Controller
{
    use ApiResponse;

    private const CACHE_TAG = 'dashboard_fixtures';

    private const CACHE_TTL = 600;

    public function __construct(private readonly FixturesRepositoryInterface $fixturesRepository)
    {
    }

    public function fixtureCount()
    {
        $count = Cache::tags([self::CACHE_TAG])->remember('dashboard:fixtures:count', self::CACHE_TTL, function () {
            return $this->fixturesRepository->fixtureCount();
        });

        return $this->success($count, 'Fixtures count fetched successfully');
    }

    public function fixtureLive()
    {
        $liveFixtures = Cache::tags([self::CACHE_TAG])->remember('dashboard:fixtures:live', self::CACHE_TTL, function () {
            return $this->fixturesRepository->fixtureLive();
        });

        return $this->success($liveFixtures, 'Live fixtures fetched successfully');
    }

    public function fixtureFinished()
    {
        $finishedFixtures = Cache::tags([self::CACHE_TAG])->remember('dashboard:fixtures:finished', self::CACHE_TTL, function () {
            return $this->fixturesRepository->fixtureFinished();
        });

        return $this->success($finishedFixtures, 'Finished fixtures fetched successfully');
    }
}
