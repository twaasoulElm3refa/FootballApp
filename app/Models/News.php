<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'news';

    protected $fillable = [
        'league_id',
        'team_id',
        'fixture_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'image',
        'source_name',
        'source_url',
        'author_name',
        'status',
        'is_featured',
        'is_breaking',
        'views_count',
        'published_at',
        'tags',
        'meta',
    ];

    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'meta' => 'array',
            'is_featured' => 'boolean',
            'is_breaking' => 'boolean',
            'published_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    public function league(): BelongsTo
    {
        return $this->belongsTo(Leagues::class, 'league_id');
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Teams::class, 'team_id');
    }

    public function fixture(): BelongsTo
    {
        return $this->belongsTo(Fixtures::class, 'fixture_id');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(UserNotification::class, 'news_id');
    }
}
