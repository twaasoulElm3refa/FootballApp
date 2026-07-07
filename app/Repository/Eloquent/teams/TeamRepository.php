<?php

namespace App\Repository\Contracts\teams;

use App\Models\Teams;
use App\Repository\Contracts\teams\TeamsRepositoryInterface;

class TeamRepository implements TeamsRepositoryInterface
{
    public function teamCount()
    {
        return Teams::count();
    }
}
