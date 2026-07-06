<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teams extends Model
{
    protected $table = 'teams';

    protected $guarded = [];

    public function leagues()
    {
        return $this->belongsToMany(Leagues::class, 'league_teams')
            ->withPivot([
                'season',
                'group_name',
                'round',
                'is_active',
                'sort_order',
                'meta',
            ])
            ->withTimestamps();
    }

    public function homeFixtures()
    {
        return $this->hasMany(Fixtures::class, 'home_team_id');
    }

    public function awayFixtures()
    {
        return $this->hasMany(Fixtures::class, 'away_team_id');
    }

    public function fixtureEvents()
    {
        return $this->hasMany(FixtureEvents::class, 'team_id');
    }

    public function fixtureLineups()
    {
        return $this->hasMany(FixtureLineups::class, 'team_id');
    }

    public function fixtureLineupPlayers()
    {
        return $this->hasMany(FixtureLineupPlayers::class, 'team_id');
    }
}
