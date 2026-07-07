<?php

namespace App\Repository\Eloquent\User;

use App\Models\User;
use App\Repository\Contracts\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function getAll($perPage = 10, $search = null, $status = null)
    {
        return User::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('username', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate($perPage);
    }

    public function count()
    {
        return User::count();
    }

    public function countActive()
    {
        return User::where('status', 'active')->count();
    }

    public function get($id)
    {
        return User::where('uuid', $id)->first();
    }

    public function create(array $data)
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return User::create($data);
    }

    public function update($id, array $data)
    {
        $user = User::where('uuid', $id)->firstOrFail();

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return $user->fresh();
    }

    public function delete($id)
    {
        $user = User::where('uuid', $id)->firstOrFail();

        return $user->delete();
    }
}
