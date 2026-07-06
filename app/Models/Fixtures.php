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

    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favourite_fixtures')
            ->withPivot([
                'notifications_enabled',
                'notify_before_match',
                'notify_match_start',
                'notify_goals',
                'notify_half_time',
                'notify_full_time',
                'notify_lineups',
                'notify_red_cards',
                'notify_penalties',
                'remind_before_minutes',
            ])
            ->withTimestamps();
    }

    public function notifications()
    {
        return $this->hasMany(UserNotification::class, 'fixture_id');
    }

    public function news()
    {
        return $this->hasMany(News::class, 'fixture_id');
    }

    public function syncLogs()
    {
        return $this->hasMany(FootballSyncLog::class, 'fixture_id');
    }

    public function followSuggestions()
    {
        return $this->hasMany(UserFollowSuggestion::class, 'fixture_id');
    }
}
