<?php

namespace App\Repository\Eloquent\fixtures;

use App\Models\Fixtures;
use App\Repository\Contracts\fixtures\FixturesRepositoryInterface;

class FixtureRepository implements FixturesRepositoryInterface
{
    public function fixtureCount()
    {
        return Fixtures::count();
    }

    public function fixtureLive()
    {
        return Fixtures::where('is_live', 1)->count();
    }

    public function fixtureFinished()
    {
        return Fixtures::where('is_finished', 1)->count();
    }
}
