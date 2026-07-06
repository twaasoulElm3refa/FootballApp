<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserFollowSuggestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'suggestion_type',
        'team_id',
        'league_id',
        'fixture_id',
        'reason',
        'score',
        'is_seen',
        'is_dismissed',
        'is_followed',
        'seen_at',
        'dismissed_at',
        'followed_at',
        'meta',
    ];

    protected function casts(): array
    {
        return [
            'score' => 'decimal:2',
            'is_seen' => 'boolean',
            'is_dismissed' => 'boolean',
            'is_followed' => 'boolean',
            'seen_at' => 'datetime',
            'dismissed_at' => 'datetime',
            'followed_at' => 'datetime',
            'meta' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Teams::class, 'team_id');
    }

    public function league(): BelongsTo
    {
        return $this->belongsTo(Leagues::class, 'league_id');
    }

    public function fixture(): BelongsTo
    {
        return $this->belongsTo(Fixtures::class, 'fixture_id');
    }
}
