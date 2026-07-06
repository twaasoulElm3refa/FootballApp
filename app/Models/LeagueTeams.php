<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeagueTeams extends Model
{
    protected $table = 'league_teams';

    protected $guarded = [];

    public function league()
    {
        return $this->belongsTo(Leagues::class, 'league_id');
    }

    public function team()
    {
        return $this->belongsTo(Teams::class, 'team_id');
    }

}
