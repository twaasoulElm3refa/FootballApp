<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FixtureLineupPlayers extends Model
{
    protected $table = 'fixture_lineup_players';

    protected $guarded = [];

    public function fixtureLineup()
    {
        return $this->belongsTo(FixtureLineups::class, 'fixture_lineup_id');
    }

    public function team()
    {
        return $this->belongsTo(Teams::class, 'team_id');
    }
}
