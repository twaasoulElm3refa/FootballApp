<?php

namespace App\Repository\Contracts\fixtures;

interface FixturesRepositoryInterface
{
    public function fixtureCount();
    public function fixtureLive();
    public function fixtureFinished();
}
