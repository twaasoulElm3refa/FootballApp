<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavouriteLeagues extends Model
{
    protected $table = 'favourite_leagues';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function league()
    {
        return $this->belongsTo(Leagues::class);
    }
}
