<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FixtureEvents extends Model
{
    protected $table = 'fixture_events';

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
