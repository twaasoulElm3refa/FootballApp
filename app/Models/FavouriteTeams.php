<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavouriteTeams extends Model
{
    protected $table = 'favourite_teams';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function team()
    {
        return $this->belongsTo(Teams::class);
    }
}
