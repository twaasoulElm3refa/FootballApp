<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class NotificationPreference
 *
 * @property int $id
 * @property int $user_id
 * @property bool $goal_notifications
 * @property bool $match_notifications
 * @property bool $news_notifications
 * @property bool $marketing_notifications
 * @property bool $sound_enabled
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \App\Models\User $user
 */
class NotificationPreference extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'goal_notifications',
        'match_notifications',
        'news_notifications',
        'marketing_notifications',
        'sound_enabled',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'goal_notifications' => 'boolean',
            'match_notifications' => 'boolean',
            'news_notifications' => 'boolean',
            'marketing_notifications' => 'boolean',
            'sound_enabled' => 'boolean',
        ];
    }

    /**
     * Get the user that owns the notification preferences.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
