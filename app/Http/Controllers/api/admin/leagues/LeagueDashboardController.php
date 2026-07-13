<?php

namespace App\Http\Controllers\api\admin\leagues;

use App\Http\Controllers\concerns\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\LeagueCreateRequest;
use App\Repository\Contracts\leagues\LeagueRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LeagueDashboardController extends Controller
{
    use ApiResponse;

    protected int $cacheTime = 60 * 10;

    private const CACHE_TAG = 'dashboard_leagues';

    public function __construct(private readonly LeagueRepositoryInterface $leagueRepository)
    {
    }

    public function leagues(Request $request)
    {
        $page = (int) $request->get('page', 1);
        $perPage = (int) $request->get('per_page', 10);
        $search = $request->get('search');
        $status = $request->get('status');

        $cacheKey = $this->makeCacheKey('index', [
            'page' => $page,
            'per_page' => $perPage,
            'search' => $search,
            'status' => $status,
        ]);

        $leagues = $this->leaguesCache()->remember($cacheKey, $this->cacheTime, function () use ($perPage, $search, $status) {
            return $this->leagueRepository->getAll($perPage, $search, $status);
        });

        return $this->success($leagues, 'Leagues fetched successfully');
    }

    public function topLeagues()
    {
        $cacheKey = $this->makeCacheKey('top');

        $leagues = $this->leaguesCache()->remember($cacheKey, $this->cacheTime, function () {
            return $this->leagueRepository->getTopLeagues();
        });

        return $this->success($leagues, 'Top leagues fetched successfully');
    }

    public function leagueCount()
    {
        $cacheKey = $this->makeCacheKey('count');

        $count = $this->leaguesCache()->remember($cacheKey, $this->cacheTime, function () {
            return $this->leagueRepository->count();
        });

        return $this->success($count, 'Leagues count fetched successfully');
    }

    public function leagueActive()
    {
        $cacheKey = $this->makeCacheKey('active_count');

        $count = $this->leaguesCache()->remember($cacheKey, $this->cacheTime, function () {
            return $this->leagueRepository->countActive();
        });

        return $this->success($count, 'Active leagues count fetched successfully');
    }

    public function getLeague($id)
    {
        $cacheKey = $this->makeCacheKey('show', [
            'id' => $id,
        ]);

        $league = $this->leaguesCache()->remember($cacheKey, $this->cacheTime, function () use ($id) {
            return $this->leagueRepository->get($id);
        });

        return $this->success($league, 'League fetched successfully');
    }

    public function createLeague(LeagueCreateRequest $request)
    {
        $league = $this->leagueRepository->create($request->validated());

        $this->clearLeaguesCache();

        return $this->success($league, 'League created successfully');
    }

    public function updateLeague(LeagueCreateRequest $request, $id)
    {
        $league = $this->leagueRepository->update($id, $request->validated());

        $this->clearLeaguesCache();

        return $this->success($league, 'League updated successfully');
    }

    public function deleteLeague($id)
    {
        $this->leagueRepository->delete($id);

        $this->clearLeaguesCache();

        return $this->success(null, 'League deleted successfully');
    }

    private function makeCacheKey(string $type, array $params = []): string
    {
        return 'dashboard:leagues:' . $type . ':' . md5(json_encode($params));
    }

    private function clearLeaguesCache(): void
    {
        Cache::tags([self::CACHE_TAG])->flush();
    }

    private function leaguesCache()
    {
        return Cache::tags([self::CACHE_TAG]);
    }

}
