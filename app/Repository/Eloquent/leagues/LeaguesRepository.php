<?php

namespace App\Repository\Eloquent\leagues;

use App\Models\Leagues;
use App\Repository\Contracts\leagues\LeagueRepositoryInterface;

class LeaguesRepository implements LeagueRepositoryInterface
{
    public function getAll($perPage = 10, $search = null, $status = null)
    {
        return Leagues::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('country', 'like', "%{$search}%")
                        ->orWhere('type', 'like', "%{$search}%");
                });
            })
            ->when($status !== null, function ($query) use ($status) {
                if (in_array($status, ['active', '1', 1, true], true)) {
                    $query->where('is_active', true);
                } elseif (in_array($status, ['inactive', '0', 0, false], true)) {
                    $query->where('is_active', false);
                }
            })
            ->latest()
            ->paginate($perPage);
    }

    public function count()
    {
        return Leagues::count();
    }

    public function countActive()
    {
        return Leagues::where('is_active', true)->count();
    }

    public function get($id)
    {
        return Leagues::find($id);
    }

    public function create(array $data)
    {
        return Leagues::create($data);
    }

    public function update($id, array $data)
    {
        $league = Leagues::findOrFail($id);

        $league->update($data);

        return $league->fresh();
    }

    public function delete($id)
    {
        $league = Leagues::findOrFail($id);

        return $league->delete();
    }
}
