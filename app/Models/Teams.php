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

    public function fixtureStatistics()
    {
        return $this->hasMany(FixtureStatistics::class, 'team_id');
    }

    public function fixturePlayerStatistics()
    {
        return $this->hasMany(FixturePlayerStatistics::class, 'team_id');
    }

    public function standings()
    {
        return $this->hasMany(Standings::class, 'team_id');
    }

    public function rankings()
    {
        return $this->hasMany(LeaguePlayerRankings::class, 'team_id');
    }

    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favourite_teams')
            ->withPivot([
                'notifications_enabled',
                'notify_match_start',
                'notify_goals',
                'notify_half_time',
                'notify_full_time',
                'notify_lineups',
                'notify_red_cards',
                'notify_penalties',
                'notify_news',
                'sort_order',
            ])
            ->withTimestamps();
    }

    public function notifications()
    {
        return $this->hasMany(UserNotification::class, 'team_id');
    }

    public function news()
    {
        return $this->hasMany(News::class, 'team_id');
    }

    public function syncLogs()
    {
        return $this->hasMany(FootballSyncLog::class, 'team_id');
    }

    public function followSuggestions()
    {
        return $this->hasMany(UserFollowSuggestion::class, 'team_id');
    }
}
