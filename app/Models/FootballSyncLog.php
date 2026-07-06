<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FootballSyncLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'sync_type',
        'league_id',
        'fixture_id',
        'team_id',
        'season',
        'sync_date',
        'status',
        'records_fetched',
        'records_created',
        'records_updated',
        'records_failed',
        'started_at',
        'finished_at',
        'duration_ms',
        'error_message',
        'params',
        'meta',
    ];

    protected function casts(): array
    {
        return [
            'sync_date' => 'date',
            'started_at' => 'datetime',
            'finished_at' => 'datetime',
            'params' => 'array',
            'meta' => 'array',
        ];
    }

    public function league(): BelongsTo
    {
        return $this->belongsTo(Leagues::class, 'league_id');
    }

    public function fixture(): BelongsTo
    {
        return $this->belongsTo(Fixtures::class, 'fixture_id');
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Teams::class, 'team_id');
    }
}
