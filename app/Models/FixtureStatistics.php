<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FixtureStatistics extends Model
{
    protected $table = 'fixture_statistics';

    protected $guarded = [];

    public function fixture()
    {
        return $this->belongsTo(Fixtures::class, 'fixture_id');
    }

    public function team()
    {
        return $this->belongsTo(Teams::class, 'team_id');
    }
}
