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

    public function playerRankings()
    {
        return $this->hasMany(LeaguePlayerRankings::class);
    }

    public function topScorers()
    {
        return $this->hasMany(LeaguePlayerRankings::class)
            ->where('type', 'top_scorers')
            ->orderBy('rank');
    }

    public function topAssists()
    {
        return $this->hasMany(LeaguePlayerRankings::class)
            ->where('type', 'top_assists')
            ->orderBy('rank');
    }

    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favourite_leagues')
            ->withPivot([
                'notifications_enabled',
                'notify_match_start',
                'notify_goals',
                'notify_half_time',
                'notify_full_time',
                'notify_lineups',
                'notify_red_cards',
                'sort_order',
            ])
            ->withTimestamps();
    }

    public function notifications()
    {
        return $this->hasMany(UserNotification::class, 'league_id');
    }

    public function news()
    {
        return $this->hasMany(News::class, 'league_id');
    }

    public function syncLogs()
    {
        return $this->hasMany(FootballSyncLog::class, 'league_id');
    }

    public function followSuggestions()
    {
        return $this->hasMany(UserFollowSuggestion::class, 'league_id');
    }
}
