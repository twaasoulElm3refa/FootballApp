<?php

namespace App\Http\Controllers\api\admin\users;

use App\Http\Controllers\concerns\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Repository\Contracts\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserDashboardController extends Controller
{
    use ApiResponse;

    protected UserRepositoryInterface $userInterface;

    protected int $cacheTime = 60 * 10;

    private const CACHE_TAG = 'dashboard_users';

    public function __construct(UserRepositoryInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }

    public function userCount()
    {
        $cacheKey = $this->makeCacheKey('count');

        $count = $this->usersCache()->remember($cacheKey, $this->cacheTime, function () {
            return $this->userInterface->count();
        });

        return $this->success($count, 'User count fetched successfully');
    }

    public function userActive()
    {
        $cacheKey = $this->makeCacheKey('active_count');

        $count = $this->usersCache()->remember($cacheKey, $this->cacheTime, function () {
            return $this->userInterface->countActive();
        });

        return $this->success($count, 'Active user count fetched successfully');
    }

    public function users(Request $request)
    {
        $page = (int) $request->get('page', 1);
        $perPage = (int) $request->get('per_page', 10);
        $search = $request->get('search');
        $status = $request->get('status');

        $cacheKey = $this->makeUsersCacheKey($page, $perPage, $search, $status);

        $users = $this->usersCache()->remember($cacheKey, $this->cacheTime, function () use ($perPage, $search, $status) {
            return $this->userInterface->getAll($perPage, $search, $status);
        });

        return $this->success($users, 'Users fetched successfully');
    }

    public function getUser($id)
    {
        $cacheKey = $this->makeCacheKey('show', [
            'id' => $id,
        ]);

        $user = $this->usersCache()->remember($cacheKey, $this->cacheTime, function () use ($id) {
            return $this->userInterface->get($id);
        });

        return $this->success($user, 'User fetched successfully');
    }

    public function createUser(UserCreateRequest $request)
    {
        $data = $request->validated();

        $user = $this->userInterface->create($data);

        $this->clearUsersCache();

        return $this->success($user, 'User created successfully');
    }

    public function updateUser(UserUpdateRequest $request, $id)
    {
        $data = $request->validated();

        $user = $this->userInterface->update($id, $data);

        $this->clearUsersCache();

        return $this->success($user, 'User updated successfully');
    }

    public function deleteUser($id)
    {
        $this->userInterface->delete($id);

        $this->clearUsersCache();

        return $this->success(null, 'User deleted successfully');
    }

    private function makeUsersCacheKey($page, $perPage, $search = null, $status = null): string
    {
        return $this->makeCacheKey('index', [
            'page' => $page,
            'per_page' => $perPage,
            'search' => $search,
            'status' => $status,
        ]);
    }

    private function makeCacheKey(string $type, array $params = []): string
    {
        return 'dashboard:users:' . $type . ':' . md5(json_encode($params));
    }

    private function clearUsersCache(): void
    {
        Cache::tags([self::CACHE_TAG])->flush();
    }

    private function usersCache()
    {
        return Cache::tags([self::CACHE_TAG]);
    }

    public function latestUsers()
    {
        $users = $this->usersCache()->remember('dashboard:users:latest', $this->cacheTime, function () {
            return $this->userInterface->latest();
        });

        return $this->success($users, 'Latest users fetched successfully');
    }
}
