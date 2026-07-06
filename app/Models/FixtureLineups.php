<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FixtureLineups extends Model
{
    protected $table = 'fixture_lineups';

    protected $guarded = [];

    public function fixture()
    {
        return $this->belongsTo(Fixtures::class, 'fixture_id');
    }

    public function team()
    {
        return $this->belongsTo(Teams::class, 'team_id');
    }

    public function players()
    {
        return $this->hasMany(FixtureLineupPlayers::class, 'fixture_lineup_id');
    }

}
