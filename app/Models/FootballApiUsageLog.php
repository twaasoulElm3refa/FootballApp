<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FootballApiUsageLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider',
        'endpoint',
        'method',
        'query_params',
        'status_code',
        'success',
        'response_count',
        'duration_ms',
        'error_message',
        'requests_limit',
        'requests_remaining',
        'requested_at',
    ];

    protected function casts(): array
    {
        return [
            'query_params' => 'array',
            'success' => 'boolean',
            'requested_at' => 'datetime',
        ];
    }
}
