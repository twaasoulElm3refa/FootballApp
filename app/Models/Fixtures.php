<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fixtures extends Model
{
    protected $table = 'fixtures';

    protected $guarded = [];

    public function league()
    {
        return $this->belongsTo(Leagues::class, 'league_id');
    }

    public function homeTeam()
    {
        return $this->belongsTo(Teams::class, 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Teams::class, 'away_team_id');
    }

    public function events()
    {
        return $this->hasMany(FixtureEvents::class, 'fixture_id');
    }

    public function lineups()
    {
        return $this->hasMany(FixtureLineups::class, 'fixture_id');
    }

    public function players()
    {
        return $this->hasMany(FixtureLineupPlayers::class, 'fixture_id');
    }

    public function stats()
    {
        return $this->hasMany(FixtureStatistics::class, 'fixture_id');
    }

    public function playerStats()
    {
        return $this->hasMany(FixturePlayerStatistics::class, 'fixture_id');
    }
}
