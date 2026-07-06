<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class UserDevice
 *
 * @property int $id
 * @property int $user_id
 * @property string $device_uuid
 * @property string|null $device_name
 * @property string|null $device_model
 * @property string $platform
 * @property string|null $os_version
 * @property string|null $app_version
 * @property string|null $device_language
 * @property string|null $fcm_token
 * @property bool $notification_enabled
 * @property \Illuminate\Support\Carbon|null $last_used_at
 * @property string|null $last_ip
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserSession[] $sessions
 */
class UserDevice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'device_uuid',
        'device_name',
        'device_model',
        'platform',
        'os_version',
        'app_version',
        'device_language',
        'fcm_token',
        'notification_enabled',
        'last_used_at',
        'last_ip',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'notification_enabled' => 'boolean',
            'last_used_at' => 'datetime',
        ];
    }

    /**
     * Get the user that owns the device.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the sessions for the device.
     */
    public function sessions(): HasMany
    {
        return $this->hasMany(UserSession::class);
    }
}
