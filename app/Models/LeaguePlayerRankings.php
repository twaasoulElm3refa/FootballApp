<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaguePlayerRankings extends Model
{
    protected $table = 'league_player_rankings';

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
