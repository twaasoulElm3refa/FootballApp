<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leagues extends Model
{
    protected $table = 'leagues';

    protected $guarded = [];

    public function teams()
    {
        return $this->belongsToMany(Teams::class, 'league_teams')
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

    public function fixtures()
    {
        return $this->hasMany(Fixtures::class, 'league_id');
    }

    public function standings()
    {
        return $this->hasMany(Standings::class, 'league_id');
    }

    public function rankings()
    {
        return $this->hasMany(LeaguePlayerRankings::class, 'league_id');
    }
}
