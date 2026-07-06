<?php

namespace App\Http\Controllers\api\admin\users;

use App\Http\Controllers\concerns\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\User\UserResources;
use App\Repository\Contracts\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserDashboardController extends Controller
{
    use ApiResponse;
    protected UserRepositoryInterface $userInterface;

    protected int $cacheTime = 60 * 10;

    public function __construct(UserRepositoryInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }

    public function userCount()
    {
        return $this->success($this->userInterface->count(), 'User count fetched successfully');
    }

    public function users(Request $request)
    {
        $page = $request->get('page', 1);
        $perPage = $request->get('per_page', 10);
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
        $cacheKey = "dashboard:users:show:{$id}";

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

        $this->clearUsersCache($id);

        return $this->success($user, 'User updated successfully');
    }

    public function deleteUser($id)
    {
        $this->userInterface->delete($id);

        $this->clearUsersCache($id);

        return $this->success(null, 'User deleted successfully');
    }

    private function makeUsersCacheKey($page, $perPage, $search = null, $status = null): string
    {
        return 'dashboard:users:index:'.md5(json_encode([
            'page' => $page,
            'per_page' => $perPage,
            'search' => $search,
            'status' => $status,
        ]));
    }

    private function clearUsersCache($userId = null): void
    {
        if (method_exists(Cache::getStore(), 'tags')) {
            Cache::tags(['dashboard_users'])->flush();

            return;
        }
        Cache::flush();
    }

    private function usersCache()
    {
        if (method_exists(Cache::getStore(), 'tags')) {
            return Cache::tags(['dashboard_users']);
        }

        return Cache::store();
    }
}
