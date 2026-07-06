<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 *
 * @property int $id
 * @property string $uuid
 * @property string|null $username
 * @property string|null $email
 * @property string $password
 * @property Carbon|null $birth_date
 * @property string $language
 * @property string $timezone
 * @property string $status
 * @property Carbon|null $email_verified_at
 * @property Carbon|null $phone_verified_at
 * @property Carbon|null $last_login_at
 * @property Carbon|null $last_seen_at
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection|OtpCode[] $otpCodes
 * @property-read Collection|UserDevice[] $devices
 * @property-read Collection|UserSession[] $sessions
 * @property-read NotificationPreference|null $notificationPreference
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'last_seen_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the OTP codes for the user.
     */
    public function otpCodes(): HasMany
    {
        return $this->hasMany(OtpCode::class);
    }

    /**
     * Get the devices for the user.
     */
    public function devices(): HasMany
    {
        return $this->hasMany(UserDevice::class);
    }

    protected static function booted(): void
    {
        static::creating(function (User $user) {
            if (empty($user->uuid)) {
                $user->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * Get the sessions for the user.
     */
    public function sessions(): HasMany
    {
        return $this->hasMany(UserSession::class);
    }

    /**
     * Get the notification preference associated with the user.
     */
    public function notificationPreference(): HasOne
    {
        return $this->hasOne(NotificationPreference::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(UserNotification::class);
    }

    public function notificationLogs(): HasMany
    {
        return $this->hasMany(NotificationLog::class);
    }

    public function searchHistories(): HasMany
    {
        return $this->hasMany(SearchHistory::class);
    }

    public function followSuggestions(): HasMany
    {
        return $this->hasMany(UserFollowSuggestion::class);
    }

    public function favoriteLeagues()
    {
        return $this->belongsToMany(Leagues::class, 'favourite_leagues')
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

    public function favoriteTeams()
    {
        return $this->belongsToMany(Teams::class, 'favourite_teams')
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

    public function favoriteFixtures()
    {
        return $this->belongsToMany(Fixtures::class, 'favourite_fixtures')
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
}
